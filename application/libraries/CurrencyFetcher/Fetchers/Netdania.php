<?php
require_once(APPPATH.'libraries/CurrencyFetcher/Fetcher.php');

class Netdania extends Fetcher {

    protected function _fetchRates() {
        $domData  = new Scrapper("http://www.netdania.com/quotes/forex-euro");
        $keys = $domData->pathObj->query("//div[@class='nd-ql-tbl-results']//table//tr")->item(0)->nodeValue;
        $keys = explode(';',preg_replace('/\s+/', ';', $keys));
        array_splice($keys, 3, sizeof($keys) - 3);

        $currencyRow = [];
        $currencies = [];
        $values = $domData->pathObj->query("//div[@class='nd-ql-tbl-results']//table//tr");

        for($i = 1; $i < $values->length; $i++) {

            $row = $values->item($i)->textContent;
            $row = explode(';',preg_replace('/\s+/', ';', $row));

            array_splice($row, 0, 1);
            array_splice($row, 3, sizeof($row) - 3);

            for ($j = 0; $j < count($row); $j++) {
                $currencyRow[strtolower($keys[$j])] = $j === 0 ? substr($row[$j], 4, 3) : $row[$j];
            }

            $currencies[$currencyRow['name']] = (object) $currencyRow;
        }

        $this->setRates($currencies, 'bid', 'ask');
    }
}