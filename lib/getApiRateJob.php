<?php

/*
 * script to fetch the current rate from yahoo finance api--set this to run at the interval set in plugin settings
 */

require_once 'autoload.php';

$yahoo = new YahooFinanceAPI();

$results = $yahoo->api(['^TNX'])[0];

$yahooApiResults = new YahooApiResults($results);

