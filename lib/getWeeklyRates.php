<?php
/**
 * Created by: Jesse Griffin
 * Date: 4/20/2017
 *
 * Get the past weeks rates
 */

require_once 'autoload.php';

//call api & save response to file:
//CurlApiEngine::pullRatesCsv();

$dayRate = File::getLastLines(CurlApiEngine::getOutputFilename(), 10);

$rateArray = [];

foreach ($dayRate as $idx => $rate) {
    $dayRate = explode(',', $rate)[1];
    $rateArray[$idx] = $dayRate / 100;
}

return $rateArray;