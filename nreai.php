<?php
/*
    Plugin Name: NREAI Plugin
    Author: Jesse Griffin
*/
global $wpdb;

include 'lib/autoload.php';
include 'helpers/processSettings.php';
include 'helpers/OptionsPage.php';
//include 'lib/calcNaav.php';

$rateSetting = new RateSetting($wpdb);
$optionsPage = new OptionsPage();
$optionsPage->setRateSetting($rateSetting);

