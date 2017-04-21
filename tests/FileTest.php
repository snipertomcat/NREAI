<?php
error_reporting(E_ALL);
include __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../lib/autoload.php';
/*include __DIR__.'/../helpers/processSettings.php';
include __DIR__.'/../helpers/OptionsPage.php';*/
//include 'lib/calcNaav.php';

class FileTest extends PHPUnit_Framework_TestCase
{
    public function testGetApiRateJobScript()
    {

        $dayRate = File::getLastLines(__DIR__ . '/../lib/' . CurlApiEngine::getOutputFilename(), 5);

        $rateArray = [];

        foreach ($dayRate as $idx => $rate) {
            $dayRate = explode(',', $rate)[1];
            $rateArray[$idx] = $dayRate;
        }

        $this->assertCount(5, $rateArray);

    }
}