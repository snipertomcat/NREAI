<?php


class YahooFinanceRepository
{
    private $wpdb;

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
    }

    public function getYahooRates($records)
    {
        //grab the last $records records in yahoo_rates table:
        $qry = "select trade_time, trade_date, trade_price from yahoo_rates order by updated_at DESC LIMIT ".$records;
        $results = $this->wpdb->get_results($qry);
        $yahooResults = new YahooApiResults($results[0]);
        return $yahooResults;
    }

    public function setYahooRates(YahooApiResults $results)
    {
        //add a row to the yahoo_rates table:
        $this->wpdb->insert('yahoo_rates', [
            'trade_time' => $results->lastTradeTime,
            'trade_date' => $results->lastTradeDate,
            'trade_price' => $results->lastTradePriceOnly,
            'updated_at' => (new DateTime('now'))->format('YYYY-MM-DD')
        ]);

        return true;
    }
}