<?php

class spsr
{
    // Боевые сервера СПСР
    protected $spsr_srv = "http://api.spsr.ru/waExec/WAExec";
    protected $spsr_srv_ssl = "https://api.spsr.ru";

    // Тестовые сервера СПСР
    protected $test_srv = "http://api.spsr.ru:8020/waExec/WAExec";
    protected $test_srv_ssl = "https://api.spsr.ru/test";

    private $spsr_login;
    private $spsr_passwd;
    private $spsr_company;
    private $spsr_sid;
    private $spsr_ikn;
    private $spsr_shipper;
    private $spsr_use_srv;
    private $error = array();

    public function __construct($registry)
    {
        $this->config = $registry->get('config');
        $this->db = $registry->get('db');
        $this->request = $registry->get('request');
        $this->session = $registry->get('session');
        // При создании всегда выбираем тестовый HTTP сервер
        $this->selectServer(3);
    }

    // Установка значений переменных
    public function setAuth()
    {
        $this->spsr_login = $this->config->get('spsr_intgr_login');
        $this->spsr_passwd = $this->config->get('spsr_intgr_passwd');
        $this->spsr_company = $this->config->get('spsr_intgr_company');
        $this->spsr_ikn = $this->config->get('spsr_intgr_ikn');
        $this->spsr_shipper = $this->config->get('spsr_intgr_shipper');
    }

    // Выбор рабочего сервера
    public function selectServer($server_id)
    {
        $server_id = (int)$server_id;
        switch ($server_id) {
            case 1:
                $this->spsr_use_srv = $this->spsr_srv;
                break;
            case 2:
                $this->spsr_use_srv = $this->spsr_srv_ssl;
                break;
            case 3:
                $this->spsr_use_srv = $this->test_srv;
                break;
            case 4:
                $this->spsr_use_srv = $this->test_srv_ssl;
                break;
            default:
                $this->spsr_use_srv = $this->spsr_use_srv;
                break;
        }

        return "selected server {$this->spsr_use_srv}";
    }

    // Отправка запроса
    public function sendRequest($request)
    {
        $header = array('Content-Type: application/xml; charset=utf-8');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->spsr_use_srv);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($ch);
        curl_close($ch);

        // Смена заголовка на корректную кодировку файла
        // спср зачем-то сделали заголовок файла со ссылкой на кодировку win1251
        $result = preg_replace('/windows-1251/', 'utf-8', $result);

        return $result;
    }

    // Открытие сессии
    public function openSession()
    {
        $req = '
            <root xmlns="http://spsr.ru/webapi/usermanagment/login/1.0">
                <p:Params Name="WALogin" Ver="1.0" xmlns:p="http://spsr.ru/webapi/WA/1.0" />
                <Login Login="' . $this->spsr_login . '" Pass="' . $this->spsr_passwd . '" UserAgent="' . $this->spsr_company . '" />
            </root>
		';

        $result = $this->sendRequest($req);

        if (isset($result) && !empty($result)) {
            $xml = simplexml_load_string($result);
            $this->spsr_sid = $xml->Login['SID'];
            return true;
        } else {
            return false;
        }
    }

    // Закрытие сессии
    public function closeSession()
    {
        $req = '
		<root xmlns="http://spsr.ru/webapi/usermanagment/logout/1.0" >
			<p:Params Name="WALogout" Ver="1.0" xmlns:p="http://spsr.ru/webapi/WA/1.0" />
				<Logout Login="' . $this->spsr_login . '" SID="' . $this->spsr_sid . '" />
		</root>
		';

        $result = $this->sendRequest($req);

        if (isset($result) && !empty($result)) {
            $xml = simplexml_load_string($result);
            if ($xml->Logout['RC'] == 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Получение городов
    public function WAGetCities($data)
    {
        if (is_bool($data) && $data == false) {
            $request = '
			<root xmlns="http://spsr.ru/webapi/Info/GetCities/1.0">
				<p:Params Name="WAGetCities" Ver="1.0" xmlns:p="http://spsr.ru/webapi/WA/1.0" />
					<GetCities CityName="" CountryName="россия" />
			</root>
			';
        } else {
            $city_name = preg_replace('/^\s*г\.?\s+/isu', '', $data);
            $request = '
			<root xmlns="http://spsr.ru/webapi/Info/GetCities/1.0">
				<p:Params Name="WAGetCities" Ver="1.0" xmlns:p="http://spsr.ru/webapi/WA/1.0" />
					<GetCities CityName="' . $city_name . '" CountryName="" />
			</root>
			';
        }

        $result = $this->sendRequest($request);
        $cities = array();

        if (isset($result) && !empty($result)) {
            $xml = simplexml_load_string($result);
            foreach ($xml->City->Cities as $city) {
                $cities[] = array(
                    'region_id' => (string)$city['Region_ID'],
                    'region_owner_id' => (string)($city['Region_Owner_ID'] == 0 ? '0' : $city['Region_Ownder_ID']),
                    'region_name' => (string)$city['RegionName'],
                    'city_id' => (string)$city['City_ID'],
                    'city_owner_id' => (string)($city['City_Owner_ID'] == 0?'0':$city['City_Ownder_ID']),
                    'city_name' => (string)$city['CityName'],
                    'country_id' => (string)$city['Country_ID'],
                    'country_owner_id' => (string)($city['Country_Owner_ID'] == 0?'0':$city['Country_Owner_ID']),
                    'cod' => (string)($city['COD'] == 0?'0':$city['COD'])
                );
            }

            if (count($cities) > 0) {
                return $cities;
            }
        }

        return false;
    }

    // Получение офисов
    public function WAGetSpsrOffices($data)
    {
        $offices = array();
        foreach ($data as $city) {
            $request = '
			<root xmlns="http://spsr.ru/webapi/Info/GetSpsrOffices/1.0">
			<p:Params Name="WAGetSpsrOffices" Ver="1.0" xmlns:p="http://spsr.ru/webapi/WA/1.0" />
				<Login SID="' . $this->spsr_sid . '" />
				<GetSpsrOffices CityId="' . $city['city_id'] . '" CityOwnerId="' . $city['city_owner_id'] . '" />
			</root>
			';
            $result = $this->sendRequest($request);

            if (isset($result) && !empty($result)) {
                $xml = simplexml_load_string($result);
                if (isset($xml->Result['RC']) && $xml->Result['RC'] == "0" && isset($xml->SPSROffices)) {
                    foreach ($xml->SPSROffices->Office as $office) {
                        $phones = array();
                        foreach ($office->Phone as $phone) {
                            $phones[] = array(
                                'phone' => (string)$phone['Phone'],
                                'comment' => (string)$phone['Comment']
                            );
                        }

                        $offices[] = array(
                            'office_id' => (int)$office['id'],
                            'office_owner_id' => (int)$office['office_owner_id'],
                            'city_name' => (string)$office['CityName'],
                            'region' => (string)$office['Region'],
                            'address' => (string)$office['Address'],
                            'comment' => (string)$office['Comment'],
                            'phone' => (string)$office['Phone'],
                            'timezone_msk' => (string)$office['TimeZoneMsk'],
                            'worktime' => (string)$office['WorkTime'],
                            'email' => (string)$office['Email'],
                            'latitude' => (string)$office['Latitude'],
                            'longitude' => (string)$office['Longitude'],
                            'phones' => serialize($phones)
                        );
                    }
                }
            }
        }

        if (count($offices) > 0) {
            return $offices;
        } else {
            return false;
        }
    }

    // Получение SID (Session ID)
    public function getSID()
    {
        return $this->spsr_sid;
    }

    // Получение списка серверов
    public function getSpsrServers()
    {
        return array(
            1 => 'Боевой HTTP',
            2 => 'Боевой HTTPS',
            3 => 'Тестовый HTTP',
            4 => 'Тестовый HTTPS'
        );
    }

    // Подготовка заказов к отправке
    public function prepareOrders($orders)
    {
        $data = array();
        $data[] = '<root xmlns="http://spsr.ru/webapi/xmlconverter/1.3">';

        $attr = array();
        $attr[] = 'Name="WAXmlConverter"';
        $attr[] = 'Ver="1.3"';
        $attr[] = 'xmlns="http://spsr.ru/webapi/WA/1.0"';
        $data[] = '<Params ' . implode(' ', $attr) . ' />';
        $data[] = '<Login SID="' . $this->spsr_sid . '" />';

        $data[] = '<XmlConverter>';
        $data[] = '<GeneralInfo ContractNumber="' . $this->spsr_ikn . '">';

        foreach ($orders as $order) {
            // Общие данные заказа
            $attr = array();
            $attr[] = 'Action="' . $order['action'] . '"';
            $attr[] = 'ShipRefNum="' . $order['order_id'] . '"';
            $attr[] = 'PickUpType="' . $order['pickup_type'] . '"';
            $attr[] = 'ProductCode="' . $order['tariff'] . '"';
            $attr[] = 'PiecesCount="1"';
            $attr[] = 'InsuranceType="' . ($order['cod'] == 0?"INS":"VAL") . '"';
            $attr[] = 'InsuranceSum="' . ($order['cod'] == 0?"0.00":(float)$order['order_total']) . '"';
            $attr[] = 'CODGoodsSum="' . ($order['cod'] == 0?"0.00":(float)$order['order_total']) . '"';
            $attr[] = 'CODDeliverySum="0.00"';
            $data[] = '<Invoice ' . implode(' ', $attr) . '>';

            // Данные отправителя
            $attr = array();
            $attr[] = 'PostCode="' . $order['shipper_postcode'] . '"';
            $attr[] = 'Region="' . $order['shipper_region'] . '"';
            $attr[] = 'City="' . $order['shipper_city'] . '"';
            $attr[] = 'Address="' . $order['shipper_address'] . '"';
            $attr[] = 'CompanyName="' . $this->spsr_company . '"';
            $attr[] = 'ContactName="' . $order['shipper_contact'] . '"';
            $attr[] = 'Phone="' . $order['shipper_telephone'] . '"';
            $attr[] = 'Email="' . $order['shipper_email'] . '"';
            $data[] = '<Shipper ' . implode(' ', $attr) . ' />';

            // Данные получателя
            /*$attr = array();
            $attr[] = 'PostCode="' . $order['shipping_postcode'] . '"';
            $attr[] = 'Region="' . $order['shipping_region'] . '"';
            $attr[] = 'City="' . $order['shipping_city'] . '"';
            $attr[] = 'Address="' . $order['shipping_address'] . '"';
            $attr[] = 'ContactName="' . $order['shipping_customer'] . '"';
            $attr[] = 'Phone="' . $order['shipping_telephone'] . '"';
            $attr[] = 'Comment=""';
            $attr[] = 'ConsigneeCollect=""';
            $attr[] = 'Email="' . $order['shipping_email'] . '"';
            $data[] = '<Receiver ' . implode(' ', $attr) . ' />';*/
            //$shipping_info = $this->getShippingInfo($order);
            $data[] = $this->getRecieverInfo($order);

            // Дополнительная информация
            $attr = array();
            $attr[] = 'Info1=""';
            $attr[] = 'Info2=""';
            $attr[] = 'Info3=""';
            $attr[] = 'Info4=""';
            $attr[] = 'Info5=""';
            $attr[] = 'Info6=""';
            $attr[] = 'Info7=""';
            $data[] = '<CustomerInfo ' . implode(' ', $attr) . ' />';

            // Услуги
            $attr = array();
            $attr[] = 'COD="' . $order['cod'] . '"';
            $attr[] = 'PartDelivery="' . $order['partdelivery'] . '"';
            $attr[] = 'ReturnDoc="' . $order['returndoc'] . '"';
            $attr[] = 'ReturnDocType="' . $order['returndoctype'] . '"';
            $attr[] = 'CheckContents="' . $order['checkcontents'] . '"';
            $attr[] = 'Verify="' . $order['verify'] . '"';
            $attr[] = 'TryOn="' . $order['tryon'] . '"';
            $attr[] = 'ByHand="' . $order['byhand'] . '"';
            $attr[] = 'PaidByReceiver="' . $order['paidbyreceiver'] . '"';
            $attr[] = 'AgreedDelivery="' . $order['agreeddelivery'] . '"';
            $attr[] = 'IDC="' . $order['idc'] . '"';
            $attr[] = 'EveningDelivery="' . $order['eveningdelivery'] . '"';
            $attr[] = 'SaturdayDelivery="' . $order['saturdaydelivery'] . '"';
            $attr[] = 'PlanDeliveryDate="' . $order['plandeliverydate'] . '"';
            $attr[] = 'RussianPost="' . $order['russianpost'] . '"';
            $data[] = '<AdditionalServices ' . implode(' ', $attr) . ' />';

            // SMS
            $attr = array();
            $attr[] = 'SMStoShipper="' . $order['smstoshipper'] . '"';
            $attr[] = 'SMSNumberShipper="' . $order['smsnumbershipper'] . '"';
            $attr[] = 'SMStoReceiver="' . $order['smstoreceiver'] . '"';
            $attr[] = 'SMSNumberReceiver="' . $order['smsnumberreceiver'] . '"';
            $data[] = '<SMS ' . implode(' ', $attr) . ' />';

            // Товары
            $data[] = '<Pieces>';

            $attr = array();
            $attr[] = 'Description="' . $order['products_type'] . '"';
            $attr[] = 'Weight="' . $order['weight'] . '"';
            $attr[] = 'Length="0"';
            $attr[] = 'Width="0"';
            $attr[] = 'Depth="0"';
            $data[] = '<Piece ' . implode(' ', $attr) . '>';

            foreach ($order['products'] as $product) {
                $attr = array();
                $attr[] = 'Description="' . $product['name'] . ' / Код позиции: ' . $product['order_product_id'] . '"';
                $attr[] = 'Cost="' . (float)$product['price'] . '"';
                $attr[] = 'Quantity="' . (int)$product['quantity'] . '"';
                $data[] = '<SubPiece ' . implode(' ', $attr) . ' />';
            }

            $data[] = '</Piece>';
            $data[] = '</Pieces>';
            $data[] = '</Invoice>';
        }

        $data[] = '</GeneralInfo>';
        $data[] = '</XmlConverter>';
        $data[] = '</root>';

        $xml = implode(chr(13).chr(10), $data);

        return $xml;
    }

    // Парсинг ответа на выгрузку накладных
    public function parseXmlOrders($orders)
    {
        $xml = simplexml_load_string($orders);

        $data = array();
        foreach ($xml->Invoice as $inv) {
            if ($inv['Status'] == 'Created' || $inv['Status'] == 'Updated') {
                $data[] = array(
                    'order_id' => (string)$inv['GCNumber'],
                    'track' => (string)$inv['InvoiceNumber'],
                    'status' => (string)$inv['Status'],
                    'barcodes' => (string)$inv['Barcodes'],
                    'client_barcodes' => (string)$inv['ClientBarcodes'],
                    'messages' => array()
                );
            }

            if ($inv['Status'] == 'Rejected') {
                $msgs = array();
                foreach ($inv->Message as $inv_msg) {
                    $msgs[] = array(
                        'code' => (string)$inv_msg['MessageCode'],
                        'text' => (string)$inv_msg['Text']
                    );
                }
                $data[] = array(
                    'order_id' => (string)$inv['GCNumber'],
                    'track' => '',
                    'status' => (string)$inv['Status'],
                    'barcodes' => '',
                    'client_barcodes' => '',
                    'messages' => $msgs
                );
            }
        }

        return $data;
    }

    public function getInvoicesInfo($orders)
    {
        $request = '<root xmlns="http://spsr.ru/webapi/DataEditManagment/GetInvoiceInfo/1.1">'.chr(13).chr(10);
        $request .= '<p:Params Name="WAGetInvoiceInfo" xmlns:p="http://spsr.ru/webapi/WA/1.0" Ver="1.1"/>';
        $request .= '<Login SID="' . $this->spsr_sid . '" Login="' . $this->spsr_login . '" ICN="' . $this->spsr_ikn . '"/>'.chr(13).chr(10);
        foreach ($orders as $order) {
            $request .= '<InvoiceInfo InvoiceNumber="' . $order['track_number'] . '"/>'.chr(13).chr(10);
        }
        $request .= '</root>';
        $xml = $this->sendRequest($request);
        $xml = simplexml_load_string($xml);

        $invoices = array();
        $invoice = new spsr_invoice();
        foreach ($xml->GetInvoiceInfo->Invoice as $inv) {
            $invoice->setData($inv);
            $invoices[] = $invoice->getData();
        }
        unset($invoice);
        return $invoices;
    }

    public function checkStatus($status_id)
    {
        $invoice = new spsr_invoice();
        return $invoice->checkStatus($status_id);
    }

    // Получаем подготовленные данные получателя
    protected function getRecieverInfo($shipping_info)
    {
        $data = '';
        if ($shipping_info['tariff_type_id'] == 2) {
            $attr = array();
            $attr[] = 'PostCode=""';
            $attr[] = 'Region="' . $shipping_info['shipping_region'] . '"';
            $attr[] = 'City="' . $shipping_info['shipping_city'] . '"';
            $attr[] = 'Address="' . $shipping_info['shipping_address'] . '"';
            $attr[] = 'ContactName="' . $shipping_info['shipping_customer'] . '"';
            $attr[] = 'Phone="' . $shipping_info['shipping_telephone'] . '"';
            $attr[] = 'Comment=""';
            $attr[] = 'ConsigneeCollect="Y"';
            $attr[] = 'Email="' . $shipping_info['shipping_email'] . '"';
            $data = '<Receiver ' . implode(' ', $attr) . ' />';
        } elseif ($shipping_info['tariff_type_id'] == 3) {
            $postamat_address = explode(',', $shipping_info['spsr_postamat_address']);

            $attr = array();
            $attr[] = 'PostCode="' . $shipping_info['shipping_postcode'] . '"';
            $attr[] = 'Region="' . $shipping_info['shipping_region'] . '"';
            $attr[] = 'City="' . $shipping_info['shipping_city'] . '"';
            $attr[] = 'Address="' . $shipping_info['shipping_address'] . '"';
            $attr[] = 'ContactName="' . $shipping_info['shipping_customer'] . '"';
            $attr[] = 'Phone="' . $shipping_info['shipping_telephone'] . '"';
            $attr[] = 'Comment="' . $shipping_info['shipping_comment'] . '"';
            $attr[] = 'ConsigneeCollect=""';
            $attr[] = 'Email="' . $shipping_info['shipping_email'] . '"';
            $data = '<Receiver ' . implode(' ', $attr) . ' />';
        } else {
            // Данные получателя
            $attr = array();
            $attr[] = 'PostCode="' . $shipping_info['shipping_postcode'] . '"';
            $attr[] = 'Region="' . $shipping_info['shipping_region'] . '"';
            $attr[] = 'City="' . $shipping_info['shipping_city'] . '"';
            $attr[] = 'Address="' . $shipping_info['shipping_address'] . '"';
            $attr[] = 'ContactName="' . $shipping_info['shipping_customer'] . '"';
            $attr[] = 'Phone="' . $shipping_info['shipping_telephone'] . '"';
            $attr[] = 'Comment=""';
            $attr[] = 'ConsigneeCollect=""';
            $attr[] = 'Email="' . $shipping_info['shipping_email'] . '"';
            $data = '<Receiver ' . implode(' ', $attr) . ' />';
        }

        return $data;
    }

    // Логирование
    protected function logging($data)
    {
        $fn = DIR_SYSTEM . "logs/spsr.log";
        file_put_contents($fn, print_r($data, true), FILE_APPEND|LOCK_EX);
    }
}

?>