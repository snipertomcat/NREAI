<?php

include __DIR__.'/../vendor/autoload.php';
include __DIR__.'/../lib/autoload.php';
/*include __DIR__.'/../helpers/processSettings.php';
include __DIR__.'/../helpers/OptionsPage.php';*/
//include 'lib/calcNaav.php';

class YahooFinanceAPITest extends PHPUnit_Framework_TestCase
{
    public function testCanBeInstantiated()
    {
        $yahoo = new \YahooFinanceAPI();

        $this->assertInstanceOf('YahooFinanceAPI', $yahoo);
    }

    public function testApiCallReturnsData()
    {
        $yahoo = new \YahooFinanceAPI();

        $result = $yahoo->api(['^TNX'])[0];

        print_r($result);

        $this->assertArrayHasKey('LastTradePriceOnly', $result, 'Data returned from API is not valid');
    }
}