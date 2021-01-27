<?php
/**
 * Created by PhpStorm.
 * User: ppetrov
 * Date: 25.04.18
 * Time: 16:21
 */

require_once(APPPATH.'libraries/CurrencyFetcher/Fetcher.php');

class Marketswatch extends Fetcher {

    protected function _fetchRates() {
        $currencies = [];

        $response = json_decode(file_get_contents("https://api-v2.markets.com/quotesv2?key=1&q=usdjpy,usdchf,gbpusd,eurusd,audusd,usdcad,eurchf,eurjpy,nzdjpy,audchf,audnzd,cadjpy"));
//        $response = file_get_contents("https://api-v2.markets.com/quotesv2?key=1&q=eurusd,usdjpy,gbpusd,usdchf,gbpjpy,eurjpy,eurgbp,usdcad,audusd,eurchf,nzdusd,audjpy,gbpchf");

        foreach ($response as $res) {
            $currencies[$res->name] = $res;
        }

        $this->setRates($currencies, 'buy', 'sell');
    }
}