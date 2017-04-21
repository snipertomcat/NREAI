<?php
error_reporting(E_ALL);

include __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../lib/autoload.php';


class CalcTest extends PHPUnit_Framework_TestCase
{
    public function testCalcNaav()
    {

        //grab current api rate
        $currentApiRate = include __DIR__ . '/../lib/getWeeklyRates.php';

        //get the additional rate set in admin:
        $filename = __DIR__ . '/../' . RateSetting::getFilename();
        $handle = fopen($filename, 'r');
        $adminRateAdditional = fread($handle, 5);
        fclose($handle);

        //$adminRateAdditional = File::getAdminSetting($filename);

        //setup static values:
        $years = 10;
        $payments = 12;

        $loanAmount = 200000;

        foreach ($currentApiRate as $idx => $rate) {
            $naav = (new NaavCalculator($rate, $adminRateAdditional, $years, $payments, $loanAmount))->calc();
                $return[$idx] = [
                    'naav' => $naav,
                    'cmr' => $rate * 100,
                    'amr' => $adminRateAdditional * 100
                ];
        }

        self::assertCount(5, $return);
        foreach ($return as $array) {
            $this->assertArrayHasKey('naav', $array, 'naav key not found in array' . print_r($array));
            $this->assertArrayHasKey('cmr', $array, 'naav key not found in array' . print_r($array));
            $this->assertArrayHasKey('amr', $array, 'naav key not found in array' . print_r($array));
        }

    }
}