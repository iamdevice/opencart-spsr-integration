<?php

class ControllerShippingSPSR extends Controller
{
    public function index()
    {
        if ($this->isAjax()) {
            $status = 'error';
            if (isset($this->request->get['type_id'])) {
                $type_id = $this->request->get['type_id'];
                $parts = explode('.', $type_id);
                $code = $type_id . '_' . $this->request->get['postamat_id'];

                $quote_info = $this->session->data['shipping_methods'][$parts[0]]['quote'][$parts[1]];
                $quote_info['code'] = $code;
                $quote_info['title'] = $this->request->get['postamat_addr'];

                $this->session->data['shipping_methods'][$parts[0]]['quote'][$code] = $quote_info;

                $status = 'ok';
            }
            $this->response->setOutput(json_encode(['status' => $status]));
        } else {
            $this->request->get['route'] = 'error/not_found';
            return $this->forward($this->request->get['route']);
        }
    }

    private function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
}

?>