<?php

class ControllerModuleSPSR extends Controller
{
    private $error = array();
    private $var_prefix = 'spsr_intgr_';
    private $config_keys = array(
        'login',
        'passwd',
        'company',
        'ikn',
        'server',
        'product_type',
        'partdelivery',
        'returndoc',
        'returndoctype',
        'checkcontents',
        'verify',
        'tryon',
        'byhand',
        'paidbyreceiver',
        'agreeddelivery',
        'idc',
        'eveningdelivery',
        'saturdaydelivery',
        'plandeliverydate',
        'russianpost',
        'smstoshipper',
        'smsnumbershipper',
        'smstoreceiver',
        'paid_order_status',
        'upload_order_status',
        'shipper_info',
        'order_rules',
        'cities_upd',
        'offices_upd'
    );

    public function install()
    {
        $this->load->model('module/spsr');
        $this->model_module_spsr->install();
        $this->redirect($this->url->link('module/spsr', 'token=' . $this->session->data['token'], 'SSL'));
    }

    public function index()
    {
        $this->load->model('setting/setting');

        foreach ($this->language->load('module/spsr') as $key => $value) {
            $this->data[$key] = $value;
        }

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
            $this->model_setting_setting->editSetting('spsr_integration', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }

        if ($this->error) {
            $this->data['error_warning'] = $this->error;
        } else {
            $this->data['error_warning'] = '';
        }

        foreach ($this->config_keys as $key) {
            if (isset($this->request->post[$this->var_prefix . $key])) {
                $this->data[$this->var_prefix . $key] = $this->request->post[$this->var_prefix . $key];
            } else {
                $this->data[$this->var_prefix . $key] = $this->config->get($this->var_prefix . $key);
            }
        }

        $this->load->model('localisation/order_status');
        $this->load->model('module/spsr');

        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/spsr', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('module/spsr', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['prepare_orders'] = $this->url->link('module/spsr/preparetosend', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['load_spsr_cities'] = $this->url->link('module/spsr/loadspsrcities', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['load_spsr_offices'] = $this->url->link('module/spsr/loadspsroffices', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
        $this->data['spsr_statuses'] = $this->model_module_spsr->getSpsrStatuses();
        $this->data['spsr_product_types'] = $this->model_module_spsr->getSpsrProductTypes();
        $this->data['spsr_servers'] = $this->spsr->getSpsrServers();

        $this->template = 'module/spsr/spsr.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function prepareToSend()
    {
        foreach ($this->language->load('module/spsr') as $key => $value) {
            $this->data[$key] = $value;
        }

        $this->document->setTitle($this->language->get('heading_prepare_orders'));

        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/spsr', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_prepare_orders'),
            'href' => $this->url->link('module/spsr/preparetosend', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('module/spsr/sendxml', 'token=' . $this->session->data['token'], 'SSL');

        foreach ($this->config_keys as $key) {
            if (isset($this->request->post[$this->var_prefix . $key])) {
                $this->data[$this->var_prefix . $key] = $this->request->post[$this->var_prefix . $key];
            } else {
                $this->data[$this->var_prefix . $key] = $this->config->get($this->var_prefix . $key);
            }
        }

        $this->load->model('module/spsr');

        $this->data['orders'] = $this->model_module_spsr->getUploadDataByStatusId($this->config->get('spsr_intgr_upload_order_status'));
        $this->data['spsr_product_types'] = $this->model_module_spsr->getSpsrProductTypes();
        $this->data['countries'] = $this->model_module_spsr->getCountries();
        $this->data['zones'] = $this->model_module_spsr->getZones();

        $this->template = 'module/spsr/prepare_to_send.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

    public function sendXml()
    {
        $this->spsr->selectServer($this->config->get('spsr_intgr_server'));
        $this->spsr->setAuth();
        $this->spsr->openSession();
        $this->load->model('module/spsr');
        $shipper = $this->config->get('spsr_intgr_shipper_info');

        $orders = array();
        foreach ($this->request->post['order'] as $order_id => $order) {
            $receiver_city = $this->model_module_spsr->getSpsrCityByName($order['shipping_city']);
            $shipper_city = $this->model_module_spsr->getSpsrCityByName($shipper['city']);

            $orders[] = array(
                'action'                => $order['action'],
                'order_id'              => $order['order_id'],
                'pickup_type'           => $order['pickup_type'],
                'order_total'           => $order['order_total'],
                'products_cost'         => $order['products_cost'],
                'shipping_cost'         => $order['shipping_cost'],
                'weight'                => $order['weight'],
                'tariff'                => $order['tariff'],
                'shipper_postcode'      => $shipper['postcode'],
                'shipper_region'        => $shipper_city['region_name'],
                'shipper_city'          => $shipper_city['city_name'],
                'shipper_address'       => $shipper['address'],
                'shipper_contact'       => $shipper['contact'],
                'shipper_telephone'     => $shipper['telephone'],
                'shipper_email'         => $shipper['email'],
                'shipping_postcode'     => $order['shipping_postcode'],
                'shipping_region'       => $receiver_city['region_name'],
                'shipping_city'         => $receiver_city['city_name'],
                'shipping_address'      => $order['shipping_address'],
                'shipping_customer'     => $order['shipping_customer'],
                'shipping_telephone'    => $order['telephone'],
                'shipping_email'        => $order['email'],
                'shipping_comment'      => $order['comment'],
                'cod'                   => $order['cod'],
                'partdelivery'          => $order['partdelivery'],
				'returndoc'             => $order['returndoc'],
				'returndoctype'         => $order['returndoctype'],
				'checkcontents'         => $order['checkcontents'],
				'verify'                => $order['verify'],
				'tryon'                 => $order['tryon'],
				'byhand'                => $order['byhand'],
				'paidbyreceiver'        => $order['paidbyreceiver'],
				'agreeddelivery'        => $order['agreeddelivery'],
				'idc'                   => $order['idc'],
				'eveningdelivery'       => $order['eveningdelivery'],
				'saturdaydelivery'      => $order['saturdaydelivery'],
				'plandeliverydate'      => $order['plandeliverydate'],
				'russianpost'           => $order['russianpost'],
				'smstoshipper'          => $this->config->get('spsr_intgr_smstoshipper'),
				'smsnumbershipper'      => $this->config->get('spsr_intgr_smsnumbershipper'),
				'smstoreceiver'         => $order['smstoreceiver'],
				'smsnumberreceiver'     => $order['telephone'],
                'products_type'         => $order['products_type'],
				'products'              => $order['products']
            );
        }
        $xml = $this->spsr->prepareOrders($orders);
        $result = $this->spsr->sendRequest($xml);
        $this->spsr->closeSession();
        $tracks = $this->spsr->parseXmlOrders($result);
        $this->model_module_spsr->setTrackNumbers($tracks);

        $filename = "spsr_" . date("d-m-Y") . ".xml";
        $this->response->addheader ("Expires: 0");
        $this->response->addheader ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT+4");
        $this->response->addheader ("Cache-Control: no-cache, must-revalidate");
        $this->response->addheader ("Pragma: no-cache");
        $this->response->addheader ("Content-type: application/xml");
        $this->response->addheader ("Content-Disposition: attachment; filename=" . $filename);
        $this->response->addheader ("Content-Transfer-Encoding: Binary");

        $this->response->setOutput($result);
    }

    public function loadSpsrCities()
    {
        $this->spsr->selectServer($this->config->get('spsr_intgr_server'));
        $cities = $this->spsr->WAGetCities(false);
        $this->load->model('module/spsr');
        $this->model_module_spsr->setSpsrCities($cities);

        $this->load->model('setting/setting');
        $save = array(
            $this->var_prefix . 'cities_upd' => date("Y-m-d")
        );
        $this->model_setting_setting->editSetting('spsr_integration_cities', $save);

        $this->redirect($this->url->link('module/spsr', 'token=' . $this->session->data['token'], 'SSL'));
    }

    public function loadSpsrOffices()
    {
        $this->load->model('module/spsr');
        $this->spsr->selectServer($this->config->get('spsr_intgr_server'));
        $this->spsr->setAuth();
        $this->spsr->openSession();
        $cities = $this->model_module_spsr->getSpsrCities();
        $offices = $this->spsr->WAGetSpsrOffices($cities);
        $this->spsr->closeSession();

        $this->model_module_spsr->setSpsrOffices($offices);

        $this->load->model('setting/setting');
        $save = array(
            $this->var_prefix . 'offices_upd' => date("Y-m-d")
        );
        $this->model_setting_setting->editSetting('spsr_integration_offices', $save);

        $this->redirect($this->url->link('module/spsr', 'token=' . $this->session->data['token'], 'SSL'));
    }

    private function validate()
    {
        if (!$this->user->hasPermission('modify', 'module/spsr')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}