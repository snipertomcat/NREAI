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
			return true;
        }
		return false;
    }
}
extract($_POST);

$return = process($irate);

if ($return) { ?> 
	<script>window.location.href = 'http://nreai.acuwebservices.com/wp-admin/options-general.php?page=nreai';</script>
	<?
}
?>