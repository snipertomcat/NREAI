<?php

use RateSetting;

class OptionsPage {

    protected $rateSetting;

    function admin_menu() {
        add_options_page(
            'NREAI Plugin Options',
            'NREAI Plugin',
            'manage_options',
            'nreai',
            array(
                $this,
                'settings_page'
            )
        );
    }

    public function settings_page() {
        $iRateSetting = $this->rateSetting->get();
        $updateInterval = $this->rateSetting->getUpdateInterval();
        echo '<div class="wrap">';
        echo '<div id="updateMessage"></div>';
        echo '<p><form name="irateForm" action="processSettings.php" method="post">
                 <label for="irate">Additional Interest Rate (%)</label>
                 <input name="irate" type="text" value="'.$iRateSetting.'"/><br />
                 <i>The additional rate (in %) that is added to the current ticker rate for calculating the NAAV. Default is 1.5%</i><br />
                 <label for="updateInterval">Update Interval (seconds)</label>
                 <input name="updateInterval" type="text" value="'.$updateInterval.'"/><br />
                 <i>The interval of time at which the ticker will update the chart on front page. Default is 60 seconds.</i>
                 <input type="submit" value="Submit" />
              </form></p>
              <p><button id="updateRatesNow" class="uk-button uk-button-danger">Update Rates Now</button>
              </p>';
        echo '</div>';
        echo '<script>
                 var hostname = window.location.hostname;

                 jQuery("#updateRatesNow").click(function() {
                      jQuery.ajax({
                            url: "http://"+hostname+"/wp-content/plugins/nreai/lib/getApiRateJob.php",
                            success: function(data) {
                                jQuery("#updateMessage").addClass("uk-alert-success uk-alert").innerHTML = "Rates Updated Successfully";
                            }
                      });
                 });
              </script>';
    }

    public function setRateSetting(RateSetting $rateSetting)
    {
        $this->rateSetting = $rateSetting;
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }
}
