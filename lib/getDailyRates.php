<?php
//error_reporting(E_ALL);
require_once 'autoload.php';

//call api & save response to file:
CurlApiEngine::saveRatesDaily();
$dayRate = File::getLastLine(CurlApiEngine::getOutputFilename());
$dayRate = array_reverse(explode(',', $dayRate))[0];
return $dayRate;
