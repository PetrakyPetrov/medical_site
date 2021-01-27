<?php
/**
 * Created by PhpStorm.
 * User: ppetrov
 * Date: 24.04.18
 * Time: 15:52
 */

require_once("Scrapper.php");

class Fetcher {

    protected $_rates = [];
    protected $_ratesFetched = false;

    /**
     * @param array $rates
     */
    public function setRates($rates, $buyKey, $sellKey) {
        $currencies = [];

        foreach ($rates as $key => $rate) {
            $currencies[$key] = (object) [
                'buy' => $rate->$buyKey,
                'sell' => $rate->$sellKey
            ];
        }

        $this->_rates = $currencies;
    }

    public function getRates() {
        if(!$this->_ratesFetched) {
            $this->_fetchRates();
        }
        return $this->_rates;
    }

    public function getData(Array $value) {
        $rates = $this->getRates();
        $specificArray = [];

        if(empty($value)) {
            return $rates;
        }

        for($i = 0; $i < count($value); $i++) {
            if(array_key_exists($value[$i], $rates)) {
                $specificArray[$value[$i]] = $rates[$value[$i]] ;
            }
        }

        return $specificArray;
    }

    protected function _fetchRates() {}
}