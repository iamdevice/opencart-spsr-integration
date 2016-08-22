<?php

class ModelShippingSpsr extends Model
{
    public function getQuote($address)
    {
        $this->language->load('shipping/spsr');

        $weight = $this->cart->getWeight();

        $data = array(
            'tariff' => 'zebon',
            'type_id' => 1,
            'weight' => $weight,
            'city' => $address['city']
        );
        $tariffs = $this->getTariff($data);

        if (count($tariffs) > 0) {
            $status = true;

        } else {
            $status = false;
        }

        $method_data = array();

        if ($status) {
            $quote_data = array();

            foreach ($tariffs as $tariff) {
                $type_id = (int)$tariff['tariff_type'];

                switch ($type_id) {
                    case 1:
                        $type = $this->language->get('text_to_courier');
                        break;
                    case 2:
                        $type = $this->language->get('text_to_pvz');
                        break;
                    case 3:
                        $type = $this->language->get('text_to_postomat');
                        break;
                    default:
                        $type = $this->language->get('text_to_courier');
                        break;
                }

                $data = array(
                    'tariff' => 'zebon',
                    'type_id' => $type_id,
                    'total' => $this->cart->getSubTotal(),
                    'geo_zones' => $this->getGeoZones($address['country_id'], $address['zone_id'])
                );
                $discount = $this->getDiscounts($data);
                $code = $tariff['tariff'].$type_id;
                $title = $this->language->get('text_title') . ' ' . $type . '<br />' . $this->language->get('text_delivery_days') . $tariff['days'] . $this->language->get('text_work_days');

                $price = $tariff['price'];

                if (is_array($discount)) {
                    if ($discount['prefix'] == '+') {
                        $price += $discount['discount'];
                    } else {
                        $price -= $discount['discount'];
                    }
                    // В случае если сумма скидки оказывается больше, чем стоимость доставки - ставим цену доставки в 0
                    if ($price < 0) {
                        $price = 0;
                    }
                }

                $quote_data[$code] = array(
                    'code' => 'spsr.' . $code,
                    'title' => $title,
                    'cost' => $price,
                    'tax_class_id' => 0,
                    'text' => $this->currency->format($price)
                );

                if ($type_id == 2 && !empty($address['city'])) {
                    $html = '<br /><span id="pvz"></span>'.chr(13).chr(10);
                    $html .= '<select name="spsr_office_id" id="spsr_office_id">'.chr(13).chr(10);
                    foreach ($this->getSpsrOffices($address['city']) as $office) {
                        $html .= '<option value="' . $office['office_id'] . '">' . $office['address'] . '</option>'.chr(13).chr(10);
                    }
                    $html .= '</select>';
                    $this->log->write($html);

                    $quote_data[$code]['sub'] = $html;
                }

                if ($type_id == 3) {
                    $html = '<br /><span id="address"></span>'.chr(13).chr(10);
                    $html .= '<a class="button btn" onclick="PickPoint.open(pickpoint_choose);return false;">Выберите</a>'.chr(13).chr(10);
                    $html .= '<input type="hidden" id="pickpoint_id" name="pickpoint_id" value="" />';
                    $html .= '<script type="text/javascript" src="catalog/view/javascript/spsr.js"></script>';

                    $quote_data[$code]['sub'] = $html;
                }
            }

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
        $weight = (float)$data['weight'] + 0.5;
        $weight = (int)round($weight, 0, PHP_ROUND_HALF_DOWN);
        $city = $this->db->escape(preg_replace('/^\s*г\.?\s+/isu', '', $data['city']));

        $sql = "SELECT * FROM `" . DB_PREFIX . "spsr_tariff`".chr(13).chr(10);
        $sql .= "WHERE tariff = '" . $tariff . "' AND weight = '" . $weight . "' AND city_to LIKE '%" . $city . "%'".chr(13).chr(10);
        $sql .= "ORDER BY tariff_type";
        $query = $this->db->query($sql);

        return $query->rows;
    }

    private function getSpsrOffices($city)
    {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "spsr_offices` WHERE LOWER(`city_name`) LIKE LOWER('%" . $this->db->escape($city) . "%')");
        return $query->rows;
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
        $type_id = $data['type_id'];
        $total = $data['total'];

        $discounts = array();
        $spsr_shipping_discounts = $this->config->get('spsr_shipping_discount');

        foreach ($spsr_shipping_discounts as $discount) {
            $tariff_info = $this->getTariffAndTypeFromString($discount['tariff']);if ($tariff == $tariff_info['name'] && in_array($discount['geo_zone'], array_column($data['geo_zones'], 'geo_zone_id')) && (int)$total >= (int)$discount['sum'] && ($tariff_info['type_id'] == $type_id || $tariff_info['type_id'] == 0)) {
                $discounts[] = array(
                    'sum' => $discount['sum'],
                    'tariff' => $tariff_info['name'],
                    'tariff_type' => $tariff_info['type_id'],
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

        if (count($discounts) > 0) {
            return $discounts[0];
        } else {
            return false;
        }
    }

    private function getTariffAndTypeFromString($tariff)
    {
        $name = mb_substr($tariff, 0, strlen($tariff)-2, 'UTF-8');
        $type = mb_substr($tariff, strlen($tariff)-1, 1, 'UTF-8');
        return array(
            'name' => $name,
            'type_id' => (int)$type
        );
    }
}

?>