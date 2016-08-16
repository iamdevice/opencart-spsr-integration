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
        'order_rules'
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

        $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
        $this->data['spsr_statuses'] = $this->model_module_spsr->getSpsrStatuses();

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

        $this->load->model('module/spsr');

        $this->data['orders'] = $this->model_module_spsr->getUploadDataByStatusId($this->config->get('spsr_intgr_upload_order_status'));

        $this->template = 'module/spsr/prepare_to_send.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
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