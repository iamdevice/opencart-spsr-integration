<?php

class ModelShippingSpsr extends Model
{
    public function getQuote($address)
    {
        $this->language->load('shipping/spsr');

        $weight = $this->cart->getWeight();
        $data = array(
            'tariff' => 'zebon',
            'total' => $this->cart->getSubTotal(),
            'geo_zones' => $this->getGeoZones($address['country_id'], $address['zone_id'])
        );
        $discounts = $this->getDiscounts($data);

        $data = array(
            'tariff' => 'zebon',
            'type_id' => 1,
            'weight' => $weight,
            'city' => $address['city']
        );
        $tariff = $this->getTariff($data);

        if (count($tariff) > 0) {
            $status = true;
        } else {
            $status = false;
        }

        $method_data = array();

        if ($status) {
            if ($discounts[0]['prefix'] == '+') {
                $price = $tariff['price'] + $discounts[0]['discount'];
            } else {
                $price = $tariff['price'] - $discounts[0]['discount'];
            }

            $method_title = $this->language->get('text_title') . ' ' . $this->language->get('text_to_courier') . '<br />' . $this->language->get('text_delivery_days') . ' ' . $tariff['days'] . ' ' . $this->language->get('text_work_days');

            $quote_data = array();
            $quote_data['spsr'] = array(
                'code' => 'spsr.zebon1',
                'title' => $method_title,
                'cost' => $price,
                'tax_class_id' => 0,
                'text' => $this->currency->format($price)
            );

            $method_data = array(
                'code' => 'spsr',
                'title' => $this->language->get('text_title'),
                'quote' => $quote_data,
                'sort_order' => $this->config->get('spsr_sort_order'),
                'error' => false
            );
        }

        return $method_data;
    }

    private function getTariff($data)
    {
        $tariff = $this->db->escape($data['tariff']);
        $type_id = (int)$data['type_id'];
        $weight = (float)$data['weight'] + 0.5;
        $weight = (int)round($weight, 0, PHP_ROUND_HALF_DOWN);
        $city = $this->db->escape(preg_replace('/^\s*г\.?\s+/isu', '', $data['city']));

        $sql = "SELECT * FROM `" . DB_PREFIX . "spsr_tariff`".chr(13).chr(10);
        $sql .= "WHERE tariff = '" . $tariff . "' AND tariff_type = '" . $type_id . "' AND weight = '" . $weight . "' AND city_to LIKE '%" . $city . "%'";
        $query = $this->db->query($sql);

        return $query->row;
    }

    private function getGeoZones($country_id, $zone_id)
    {
        $query = $this->db->query("SELECT DISTINCT geo_zone_id FROM `" . DB_PREFIX . "zone_to_geo_zone` WHERE country_id = '" . (int)$country_id . "' AND (zone_id = '" . (int)$zone_id . "' OR zone_id = '0')");
        $result = $query->rows;
        $result[] = array(
            'geo_zone_id' => '0'
        );
        return $result;
    }

    private function getDiscounts($data)
    {
        $tariff = $data['tariff'];
        $total = $data['total'];

        $discounts = array();
        $spsr_shipping_discounts = $this->config->get('spsr_shipping_discount');

        foreach ($spsr_shipping_discounts as $discount) {
            if ($discount['tariff'] == $tariff && in_array($discount['geo_zone'], array_column($data['geo_zones'], 'geo_zone_id')) && (int)$total >= (int)$discount['sum']) {
                $discounts[] = array(
                    'sum' => $discount['sum'],
                    'tariff' => $discount['tariff'],
                    'geo_zone' => $discount['geo_zone'],
                    'prefix' => $discount['prefix'],
                    'discount' => $discount['discount'],
                    'sort_order' => $discount['sort_order']
                );
            }
        }

        usort($discounts, function($a, $b) {
            return ($a['sort_order'] - $b['sort_order']);
        });

        return $discounts;
    }
}

?>