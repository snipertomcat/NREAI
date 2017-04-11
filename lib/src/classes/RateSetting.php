<?php

class RateSetting
{
	public $wpdb;

	public static $file = 'nreai_rate.txt';
	public static $yahooFile = 'nreai_yahoo_rate.txt';

	public function __construct($wpdb)
	{
		$this->wpdb = $wpdb;
	}

	public function get()
	{
		//grab existing entry for nreai_rate in wp_options table:
		$qry = "select option_value from wp_options where option_name = 'nreai_rate'";
		$results = $this->wpdb->get_results($qry);
		if (empty($results)) {
			//sets default value to 1.5%:
			$val = .015 * 100;
			return $val;
		} else {
			//returns converted saved rate:
			return $results[0]->option_value * 100;
		}
		//print_r($results);exit;
	}

	public function getYahooRates($records)
	{
		//grab the last $records records in yahoo_rates table:
		$qry = "select trade_time, trade_date, trade_price from yahoo_rates order by updated_at DESC LIMIT ".$records;
		return $this->wpdb->get_results($qry);
	}


	public function getUpdateInterval()
	{
		//grab the existing entry for yahoo_update_interval:
		$qry = "select option_value from wp_options where option_name = 'yahoo_update_interval'";
		$results = $this->wpdb->get_results($qry);
		if (empty($results)) {
			//return default - 60 seconds:
			return '60';
		} else {
			return $results[0]->option_value;
		}
	}

	public function set($irate)
	{
		//delete any previously saved record with an option_name of 'nreai_rate'
		$this->wpdb->delete('wp_options', ['option_name' => 'nreai_rate']);
		//insert new record:
		$this->wpdb->insert('wp_options', ['option_id' => NULL, 'option_name' => 'nreai_rate', 'option_value' => $irate, 'autoload' => 'yes']);

		return true;
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

	public function setUpdateInterval($updateInterval)
	{
		//delete any previously saved record with an option_name of 'yahoo_update_interval'
		$this->wpdb->delete('wp_options', ['option_name' => 'yahoo_update_interval']);
		//insert new record:
		$this->wpdb->insert('wp_options', ['option_id' => NULL, 'option_name' => 'yahoo_update_interval', 'option_value' => $updateInterval, 'autoload' => 'yes']);

		return true;
	}

	public function saveToFile($irate)
	{
		$fh = fopen(static::$file, 'w+');
		fwrite($fh, $irate);
		fclose($fh);
	}

	public function yahooSaveToFile($updateInterval)
	{
		$fh = fopen(static::$yahooFile, 'w+');
		fwrite($fh, $updateInterval);
		fclose($fh);
	}

    public static function getFilename()
    {
        return static::$file;
    }

	private function optionExists()
	{
		$qry = "select option_id from wp_options where option_name = 'nreai_rate'";
		$results = $this->wpdb->get_results($qry);
		if (!empty($results)) {
			return true;
		}
		return false;
	}
	
	private function getOptionId()
	{
		$qry = "select option_id from wp_options where option_name = 'nreai_rate'";
		$results = $this->wpdb->get_results($qry);
		return $results[0]->option_id;
	}
}