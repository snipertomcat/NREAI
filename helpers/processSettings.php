<?php
/**
 * Created by: Jesse Griffin
 * Date: 4/5/2017
 */
use RateSetting;
if (!function_exists('process')) {

    function process($irate)
    {
        global $wpdb;
        $rateSetting = new \RateSetting($wpdb);
        if (isset($irate) && $irate !== '') {
            $irate = (float)($irate / 100);
            $rateSetting->set($irate);
            $rateSetting->saveToFile($irate);
			return true;
        }
		return false;
    }
}
if (!function_exists('processUpdateInterval')) {
    function processUpdateInterval($updateInterval)
    {
        global $wpdb;
        $rateSetting = new \RateSetting($wpdb);
        $rateSetting->setUpdateInterval($updateInterval);
        $rateSetting->yahooSaveToFile($updateInterval);
        return true;
    }
}

extract($_POST);

if (isset($irate) && $irate !== '') {
    $return = process($irate);
}

if (isset($updateInterval) && $updateInterval !== '') {
    $return = processUpdateInterval($updateInterval);
}

if ($return) { ?> 
	<script>window.location.href = 'http://nreai.acuwebservices.com/wp-admin/options-general.php?page=nreai';</script>
	<?
}
?>