<?php
require_once 'autoload.php';
error_reporting(E_ALL);

if (!function_exists('calcNaav')) {

    function calcNaav($loanAmount)
    {
        //grab current api rate
        $currentApiRate = include 'getDailyRates.php';

        //get the additional rate set in admin:
        $filename = "/home/acuweb/public_html/nreai/" . RateSetting::getFilename();
        $adminRateAdditional = File::getAdminSetting($filename);

        //setup static values:
        $years = 10;
        $payments = 12;

        //register calculator w/these params:
        $calc = new NaavCalculator($currentApiRate, $adminRateAdditional, $years, $payments, $loanAmount);
        return $calc->calc();
    }
}

//get loan amount from form on homepage
$loanAmount = $_POST['amount'];

if ($loanAmount !== '' && $loanAmount !== 0) {
    $return = calcNaav($loanAmount);
    ?>
    <script>
        window.location.href = 'http://nreai.acuwebservices.com?naav=<? echo $return; ?>';
    </script>
<? } ?>