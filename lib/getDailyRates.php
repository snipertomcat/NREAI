<?php
//error_reporting(E_ALL);
require_once 'vendor/autoload.php';

use App\Api\CurlApiEngine;
use App\IO\File;

//call api & save response to file:
CurlApiEngine::saveRatesDaily();
$dayRate = File::getLastLine(CurlApiEngine::getOutputFilename());

