<?php
require_once 'autoload.php';
error_reporting(E_ALL);

if (!function_exists('calcNaav') && !function_exists('calcNaavWeekly')) {

    function calcNaavWeekly($loanAmount)
    {
        //grab current api rate
        $currentApiRate = include 'getWeeklyRates.php';

        //get the additional rate set in admin:
        $filename = '/home/acuweb/public_html/nreai/' . RateSetting::getFilename();
        $handle = fopen($filename, 'r');
        $adminRateAdditional = fread($handle, 5);
        fclose($handle);

        //$adminRateAdditional = File::getAdminSetting($filename);

        //setup static values:
        $years = 10;
        $payments = 12;

        $differenceArray = [];

        foreach ($currentApiRate as $idx => $rate) {
            if ($idx !== 0) { //skip 1st element
                $yesterdayRate = $currentApiRate[$idx-1];
                if ($rate == $yesterdayRate) {
                    $difference = null;
                } else {
                    $difference = ($rate > $yesterdayRate) ? 'positive' : 'negative';
                }
                $differenceArray[$idx] = $difference;
            }
        }

        foreach ($currentApiRate as $idx => $rate) {
            $naav = (new NaavCalculator($rate, $adminRateAdditional, $years, $payments, $loanAmount))->calc();
            $return[$idx] = [
                'naav' => $naav,
                'cmr' => $rate * 100,
                'amr' => $adminRateAdditional * 100,
                'direction' => ($idx == 0 ? null : $differenceArray[$idx])
            ];
        }

        return $return;
    }

    function calcNaav($loanAmount)
    {
        //create the return array:
        $return = [];

        //grab current api rate
        $currentApiRate = include 'getDailyRates.php';

        //get the additional rate set in admin:
        $filename = '/home/acuweb/public_html/nreai/' . RateSetting::getFilename();
        $adminRateAdditional = File::getAdminSetting($filename);

        //setup static values:
        $years = 10;
        $payments = 12;

        if ($loanAmount !== 0) {
            //register calculator w/these params:
            $calc = new NaavCalculator($currentApiRate, $adminRateAdditional, $years, $payments, $loanAmount);
            $naav = $calc->calc();
            //set the result in return array:
            $return['naav'] = $naav;
        }

        //set default values in return array:
        $return['cmr'] = $currentApiRate * 100;
        $return['amr'] = $adminRateAdditional * 100;
        $return['weekly'] = calcNaavWeekly($loanAmount);

        return $return;
    }
}

//get loan amount from form on homepage
if (isset($_POST['amount']) && $_POST['amount'] !== '') {
    $loanAmount = $_POST['amount'];
} else {
    $loanAmount = 200000;
}

//return the result from calcNaav()
print_r(json_encode(calcNaav($loanAmount)));