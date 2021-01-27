<?php
/**
 * Created by PhpStorm.
 * User: ppetrov
 * Date: 26.04.18
 * Time: 08:26
 */

require_once 'application/core/UI_Admin.php';

class Ratesconfig extends UI_Admin {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Rate_Config_model');
        $this->load->model('Rate_model');
        $this->load->model('Office_model');
    }

    public function index() {}

    public function all() {

        $crud = new grocery_CRUD();
        $crud->set_table('up_rates');
        $crud->columns('currency_id','location_id','office_id', 'buy', 'sell', 'default_value');
        $crud
            ->display_as('currency_id','Валута')
            ->display_as('location_id','Местоположение')
            ->display_as('office_id','Офис')
            ->display_as('buy','Купува')
            ->display_as('sell','Продава');

        $crud->set_relation('currency_id','up_currencies','code');
        $crud->set_relation('location_id','up_locations','name');
        $crud->set_relation('office_id','up_offices','name');
        $crud->required_fields('currency_id','location_id','office_id', 'buy', 'sell', 'default_value');

        $this->additionalConfig($crud);

        $output = $crud->render();
        $this->groceryOutput($output);
    }

    public function fetchers(){
        $crud = new grocery_CRUD();
        $crud->set_table('up_fetchers');
        $crud->columns('name','currency_index');
        $crud->required_fields('name','currency_index');

        $output = $crud->render();
        $this->groceryOutput($output);
    }

    public function getRates($id = 0) { //office id

        $offices = $this->Office_model->getAll();
        $rates = null;
        $officeId = null;

        if($this->input->post() || $id != 0) {

            $officeId = $id == 0 ? $this->input->post()['office_id'] : $id;
            $office = $this->Office_model->getOfficeById2($officeId);
            $rates = $officeId == 0 ? $rates : $this->Rate_Config_model->getRatesConfig($office);
        }

        $fetchers = $this->Rate_Config_model->getFetchers();
        $this->viewParams['rates'] = $rates;
        $this->viewParams['fetchers'] = $fetchers;
        $this->viewParams['offices'] = $offices;
        $this->viewParams['officeId'] = $officeId;

        $this->layout('admin/rates_config');
    }

    public function getratesbyoffice($id = 0){

        $rates = [];
        $office = [];
        $readOnly = true;

        if ($id != 0) {
            $readOnly = false;
            $office = $this->Office_model->getOfficeById2($id);
            $rates = $this->Rate_model->getRatesByOfficeId($office->office);
        } else {
            $offices = $this->Office_model->getAll2();
            $rates = $this->Rate_model->getDefaultRates();

            for ($i = 0; $i < count($offices); $i++) {
                $ratesByOfficeId = $this->Rate_model->getRatesByOfficeId($offices[$i]->office);
                for ($j = 0; $j < count($ratesByOfficeId); $j++) {
                    $rates[] = $ratesByOfficeId[$j];
                }
            }
        }

        $this->viewParams['rates'] = $rates;
        $this->viewParams['showId'] = $id;
        $this->viewParams['office'] = $office;
        $this->viewParams['readOnly'] = $readOnly;
        $this->layout('admin/rates');
    }

    public function updaterates($id = 0, $action = null) {
        //rc.buy = ?, rc.sell = ?, rc.office_id and rc.currency_id,
        if (isset($action)) {
            $this->Rate_model->resetRates($id);
            $url = $id === 0 ? '/admin/ratesconfig/getratesbyoffice' : '/admin/ratesconfig/getratesbyoffice/'.$id;
            redirect($url, 'refresh');
        }

        $rates = $this->input->post();
        $rowData = $this->relationStringToArray($rates, ['office', 'currency']);

        foreach ($rowData as $configurationProperties) {

            if ($configurationProperties['affected'] == 1) {

                $configurationPropertiesByRate = new stdClass();
                $configurationPropertiesByRate->buy = $configurationProperties['buy'];
                $configurationPropertiesByRate->sell = $configurationProperties['sell'];
                $configurationPropertiesByRate->officeId = $configurationProperties['office'][0];
                $configurationPropertiesByRate->currencyId = $configurationProperties['currency'][0];
                $configurationPropertiesByRate->isNew = $configurationProperties['isNew'];

                if ($this->Rate_model->updateRates($configurationPropertiesByRate)) {
                    continue;
                }
            }
        }

        $url = $id === 0 ? '/admin/ratesconfig/getratesbyoffice' : '/admin/ratesconfig/getratesbyoffice/'.$id;
        redirect($url, 'refresh');
    }

    public function updateRatesConfig() {
        //rc.fetcher_id = ?, rc.buy = ?, rc.sell = ?, rc.currency_id and rc.office_id
        $rates = $this->input->post();
        $rowData = $this->relationStringToArray($rates, ['office', 'fetcher_id', 'currency']);

        foreach ($rowData as $configurationProperties) {
            if ($configurationProperties['affected'] == 1 && $configurationProperties['fetcher_id'][0] != 0) {

                $externalRates = null;
                //if ($configurationProperties['fetcher_id'][0] != 0) {

                    $Fetcher = $configurationProperties['fetcher_id'][1];
                    require_once(APPPATH.'libraries/CurrencyFetcher/Fetchers/'.$Fetcher.'.php');
                    $fetcher = new $Fetcher();
                    $externalRates = $fetcher->getData([$configurationProperties['currency'][1]]);

                    if ($configurationProperties['currency'][1] === 'EUR' || empty($externalRates)) {
//                    if ($configurationProperties['currency'][1] === 'EUR')) {
                        $externalRates[$configurationProperties['currency'][1]] = (object)[
                            'buy' => $configurationProperties['fetcher_id'][2],
                            'sell' => $configurationProperties['fetcher_id'][2]
                        ];
                    }
                //}

                $rate = new stdClass();
                $rate->fetcher = $configurationProperties['fetcher_id'];
                $rate->buy = $configurationProperties['buy'];
                $rate->sell = $configurationProperties['sell'];
                $rate->currency = $configurationProperties['currency'];
                $rate->office = $configurationProperties['office'];

                $this->Rate_Config_model->updateRows($rate, (bool)$configurationProperties['isNew'], $externalRates);
            }

            if ($configurationProperties['affected'] == 1 && $configurationProperties['fetcher_id'][0] == 0) {
                $this->Rate_Config_model->unsetFetcher($configurationProperties['office'][0], $configurationProperties['currency'][0]);
            }
        }

        redirect('/admin/ratesconfig/getRates/' . $rowData[0]['office'][0], 'refresh');
    }

    private function relationStringToArray(Array $rates, Array $keys) {
        $rowData = [];
        foreach ($rates as $key => $value) {
            foreach ($value as $vKey => $vRow) {
                foreach ($keys as $rateKey) {
                    if ($key === $rateKey) {
                        $value[$vKey] = $value[$vKey] !== 0 ? explode(',', $value[$vKey]) : $value[$vKey];
                    }
                }
                $rowData[$vKey][$key] = $value[$vKey];
            }
        }
        return $rowData;
    }
}