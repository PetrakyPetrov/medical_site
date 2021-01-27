<?php
require_once(APPPATH.'libraries/CurrencyFetcher/Fetcher.php');

class Marketwatch extends Fetcher {

    protected function _fetchRates() {
        $domData  = new Scrapper("https://www.marketwatch.com/investing/currencies/tools");

        $currencyRow = [];
        $currencies = [];

        $keys = $domData->pathObj->query("//table[@id='rates']//tr")->item(0)->nodeValue;
        $keys = explode(';',preg_replace('/\s+/', ';', $keys));
        unset($keys[sizeof($keys) - 1]);

        $values = $domData->pathObj->query("//table[@id='rates']//tr");

        for($i = 0; $i < $values->length; $i++) {
            if($i !== 0) {
                $row = $values->item($i)->textContent;
                $row = explode(';',preg_replace('/\s+/', ';', $row));
                unset($row[sizeof($row) - 1]);

                for($j = 0; $j < count($row); $j++) {

                    $currencyName = substr($row[$j], 0, 3).'/'.substr($row[$j], 3, 3);
                    $currencyRow[strtolower($keys[$j])] = $j === 0 ? $currencyName : $row[$j];
                }

                $currencies[$currencyRow['symbol']] = (object) $currencyRow;
            }
        }

        $this->setRates($currencies, 'bid', 'ask');
    }
}