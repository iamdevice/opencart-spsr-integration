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

    public function __construct($registry)
    {
        $this->config = $registry->get('config');
        $this->db = $registry->get('db');
        $this->request = $registry->get('request');
        $this->session = $registry->get('session');
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
        curl_setopt($ch, CURLOPT_HEADER, $header);

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
            $attr[] = 'Phone="' . $order['shipper_phone'] . '"';
            $attr[] = 'Email="' . $order['shipper_email'] . '"';
            $data[] = '<Shipper ' . implode(' ', $attr) . ' />';

            // Данные получателя
            $attr = array();
            $attr[] = 'PostCode="' . $order['shipping_postcode'] . '"';
            $attr[] = 'Region="' . $order['shipping_region'] . '"';
            $attr[] = 'City="' . $order['shipping_city'] . '"';
            $attr[] = 'Address="' . $order['shipping_address'] . '"';
            $attr[] = 'ContactName="' . $order['shipping_customer'] . '"';
            $attr[] = 'Phone="' . $order['shipping_phone'] . '"';
            $attr[] = 'Comment=""';
            $attr[] = 'Email="' . $order['shipping_email'] . '"';
            $data[] = '<Receiver ' . implode(' ', $attr) . ' />';

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
            $attr[] = 'Weight="0"';
            $attr[] = 'Length="0"';
            $attr[] = 'Width="0"';
            $attr[] = 'Depth="0"';
            $data[] = '<Piece ' . implode(' ', $attr) . '>';

            foreach ($order['product'] as $product) {
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

}

?>