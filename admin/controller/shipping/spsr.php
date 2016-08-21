<?php

class ControllerShippingSPSR extends Controller
{
    private $error = array();
    private $var_prefix = 'spsr_shipping_';
    private $config_keys = array(
        'status',
        'sort_order',
        'city_id',
        'city_owner_id',
        'city',
        'courier',
        'pvz',
        'postomat',
        'discount',
        'debug'
    );

    public function install()
    {
        $this->load->model('shipping/spsr');
        $this->model_shipping_spsr->install();
        $this->redirect($this->url->link('shipping/spsr', 'token=' . $this->session->data['token'], 'SSL'));
    }

    public function index()
    {
        foreach ($this->language->load('shipping/spsr') as $key => $value) {
            $this->data[$key] = $value;
        }
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
            $this->model_setting_setting->editSetting('spsr_shipping', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
        }

        if ($this->error) {
            $this->data['error_warning'] = $this->error;
        } else {
            $this->data['error_warning'] = '';
        }

        foreach ($this->config_keys as $key) {
            if (in_array($key, (['sort_order','status']))) {
                $current = 'spsr_' . $key;
            } else {
                $current = $this->var_prefix . $key;
            }
            if (isset($this->request->post[$current])) {
                $this->data[$current] = $this->request->post[$current];
            } else {
                $this->data[$current] = $this->config->get($current);
            }
        }

        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_shipping'),
            'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('shipping/spsr', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('shipping/spsr', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['upload_action'] = $this->url->link('shipping/spsr/uploadTariff', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['token'] = $this->session->data['token'];

        $this->load->model('localisation/geo_zone');
        $this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $this->data['tariffs'] = array(
            'zebon-0' => $this->language->get('t_zebon') . ' - ' . $this->language->get('text_all_method'),
            'zebon-1' => $this->language->get('t_zebon') . ' - ' . $this->language->get('checkbox_courier'),
            'zebon-2' => $this->language->get('t_zebon') . ' - ' . $this->language->get('checkbox_pvz'),
            'zebon-3' => $this->language->get('t_zebon') . ' - ' . $this->language->get('checkbox_postomat'),
            'gepon-0' => $this->language->get('t_gepon') . ' - ' . $this->language->get('text_all_method'),
            'gepon-1' => $this->language->get('t_gepon') . ' - ' . $this->language->get('checkbox_courier'),
            'gepon-2' => $this->language->get('t_gepon') . ' - ' . $this->language->get('checkbox_pvz'),
            'gepon-3' => $this->language->get('t_gepon') . ' - ' . $this->language->get('checkbox_postomat')
        );

        $this->template = 'shipping/spsr.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

    public function uploadTariff()
    {
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
            $loaded = false;

            if (is_uploaded_file($this->request->files['tariff-file']['tmp_name'])) {
                try {
                    $fn = $this->request->files['tariff-file']['tmp_name'];
                    $fn_type = PHPExcel_IOFactory::identify($fn);

                    $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
                    $cacheSettings = ['memoryCacheSize' => '8M'];
                    PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

                    $reader = PHPExcel_IOFactory::createReader($fn_type);
                    $reader->setReadDataOnly(true);
                    $sheetData = $reader->listWorksheetInfo($fn);
                    $hRow = $sheetData[0]['totalRows'];
                    $hCol = $sheetData[0]['totalColumns'];
                    $xls = $reader->load($fn);

                    $loaded = true;
                } catch (Exception $e) {
                    $this->log->write("Ошибка загрузки файла '" . pathinfo($this->request->files['tariff-file']['name'],PATHINFO_BASENAME) . "': " . $e->getMessage());
                }

                if ($loaded) {
                    $sheet = $xls->getSheet(0);
                    $this->load->model('shipping/spsr');
                    $tariff = $this->request->post['tariff'];
                    $tariff_type = $this->request->post['tariff-type'];

                    // Увеличиваем время работы скрипта, потому что обработка больших файлов занимает продолжительное время
                    set_time_limit(240);

                    $tariff_part = array();
                    for ($row = 2; $row <= $hRow; $row ++) {
                        $data = array();
                        $data[] = "'" . $tariff . "'";
                        $data[] = "'" . $tariff_type . "'";
                        for ($col = 0; $col < $hCol; $col++) {
                            if ($tariff_type == 2 || $tariff_type == 3) {
                                if (in_array($col,[5,6,7,8,9,10,13])) {
                                    continue;
                                }
                            }
                            $data[] = "'" . $this->db->escape($sheet->getCellByColumnAndRow($col, $row)->getValue()) . "'";
                        }
                        $tariff_part[] = implode(',', $data);
                    }
                    $this->model_shipping_spsr->addTariff($tariff_part);
                }

                $xls->disconnectWorksheets();
                unset($sheet);
                unset($xls);
            }
        }

        $this->redirect($this->url->link('shipping/spsr', 'token=' . $this->session->data['token'], 'SSL'));
    }

    // Заливка по частям
    public function uploadTariffByParts()
    {
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
            $loaded = false;

            if (is_uploaded_file($this->request->files['tariff-file']['tmp_name'])) {
                try {
                    $fn = $this->request->files['tariff-file']['tmp_name'];
                    $fn_type = PHPExcel_IOFactory::identify($fn);

                    $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
                    $cacheSettings = ['memoryCacheSize' => '8M'];
                    PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

                    $reader = PHPExcel_IOFactory::createReader($fn_type);
                    $reader->setReadDataOnly(true);
                    $sheetData = $reader->listWorksheetInfo($fn);
                    $hRow = $sheetData[0]['totalRows'];
                    $hCol = $sheetData[0]['totalColumns'];

                    $loaded = true;
                } catch (Exception $e) {
                    $this->log->write("Ошибка загрузки файла '" . pathinfo($this->request->files['tariff-file']['name'],PATHINFO_BASENAME) . "': " . $e->getMessage());
                }

                if ($loaded) {
                    $this->load->model('shipping/spsr');
                    $tariff = $this->request->post['tariff'];
                    $tariff_type = $this->request->post['tariff-type'];

                    // Увеличиваем время работы скрипта, потому что обработка больших файлов занимает продолжительное время
                    set_time_limit(240);

                    $size = 10000;
                    for ($row = 2; $row <= $hRow; $row += $size) {
                        $filter = new ReadFilter($row, $size);
                        $reader->setReadFilter($filter);
                        $xls = $reader->load($fn);
                        $sheet = $xls->getSheet(0);

                        $f_data = $sheet->toArray(null, true, true, true);

                        $tariff_part = array();
                        foreach ($f_data as $f_row) {
                            if (empty($f_row['A'])) {
                                continue;
                            }
                            $data = array();
                            $data[] = $tariff;
                            $data[] = $tariff_type;
                            $data = $data + $f_row;
                            if ($tariff_type == 2 || $tariff_type == 3) {
                                unset($data['F']);
                                unset($data['G']);
                                unset($data['H']);
                                unset($data['I']);
                                unset($data['J']);
                                unset($data['K']);
                                unset($data['N']);
                            }
                            $tariff_part[] = "'" . implode("','", $data) . "'";
                        }
                        $this->model_shipping_spsr->addTariff($tariff_part);
                    }
                }

                $xls->disconnectWorksheets();
                unset($sheet);
                unset($xls);
            }
        }

        $this->redirect($this->url->link('shipping/spsr', 'token=' . $this->session->data['token'], 'SSL'));
    }

    public function getSpsrCitiesAutocomplete()
    {
        $json = array();
        $this->load->model('shipping/spsr');
        $filter = array(
            'filter_name' => $this->request->get['filter_name']
        );
        $cities = $this->model_shipping_spsr->getSpsrCities($filter);
        foreach ($cities as $city) {
            $json[] = array(
                'city_name' => $city['city_name'],
                'city_id' => $city['city_id'],
                'city_owner_id' => $city['city_owner_id']
            );
        }
        $this->response->setOutput(json_encode($json));
    }

    private function validate()
    {
        if (!$this->user->hasPermission('modify','shipping/spsr')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}

class ReadFilter implements PHPExcel_Reader_IReadFilter
{
    private $sRow = 0;
    private $eRow = 0;

    public function __construct($startRow, $size)
    {
        $this->sRow = $startRow;
        $this->eRow = $startRow + $size;
    }

    public function readCell($column, $row, $worksheetName = '')
    {
        if ($row >= $this->sRow && $row < $this->eRow) {
            if (in_array($column, range('A', 'Z'))) {
                return true;
            }
        }

        return false;
    }
}

?>