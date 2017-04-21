<?php

/*
 * script to fetch the current rate from yahoo finance api--set this to run at the interval set in plugin settings
 */

require_once 'autoload.php';

define( 'SHORTINIT', true );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );

global $wpdb;

//create new yahoo object
$yahoo = new YahooFinanceAPI();
//call the api method with the ticker symbol
$results = $yahoo->api(['^TNX'])[0];
//create new yahoo results object
$yahooApiResults = new YahooApiResults($results);
//create new yahoo repository object & pass results in
$yahooRepository = new YahooFinanceRepository($wpdb);
$yahooRepository->setYahooRates($yahooApiResults);

print_r($yahooApiResults);