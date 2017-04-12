<?php
require_once 'autoload.php';
error_reporting(E_ALL);

define( 'SHORTINIT', true );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );



if (!function_exists('calcNaav')) {

    function calcNaav($loanAmount)
    {
        global $wpdb;
        //create the return array:
        $return = [];

        //grab current api rate from database:
        /*$yahooResults = include __DIR__.'/getApiRateJob.php';
        $currentApiRate = $yahooResults->lastTradePriceOnly / 100;*/
        $yahooRepository = new YahooFinanceRepository($wpdb);
        $yahooResults = $yahooRepository->getYahooRates(1);
        $currentApiRate = $yahooResults->trade_price / 100;

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

        return $return;
    }
}

//get loan amount from form on homepage
if (isset($_POST['amount']) && $_POST['amount'] !== '') {
    $loanAmount = $_POST['amount'];
} else {
    $loanAmount = 0;
}

//return the result from calcNaav()
print_r(json_encode(calcNaav($loanAmount)));