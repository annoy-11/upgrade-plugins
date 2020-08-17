<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
$year = date("Y"); 
$newYear = $year+1; 
$finalNewYear = "$newYear-01-01 12:00:00";
?>
<?php if(!empty($this->showcountdown)): ?>
  <?php $exp_date = strtotime($finalNewYear); ?>
  <?php $text = $this->translate("Untill Happy New Year");?>
<?php else: ?>
  <?php $exp_date = strtotime("$year-12-25 12:00:00"); ?>
  <?php $text = $this->translate("Until Christmas");?>
<?php endif; ?>
<div id="clock_countdown" class="seschristmas_countdown"></div>
<div class="seschristmas_countdown_txt"><?php echo $text; ?></div>
<script>
  //time to Happy New year and Christmas
var server_end = <?php echo $exp_date; ?> * 1000;
var server_now = <?php echo $this->start_time; ?> * 1000;
var client_now = new Date().getTime();
var end = server_end + (server_now - client_now);
var _second = 1000;
var _minute = _second * 60;
var _hour = _minute * 60;
var _day = _hour *24
var timer;
function showRemaining()
{

    var now = new Date();
 now.setTime(now.getTime() + 1000 * 600);
    var distance = end - now;
    if (distance < 0 ) {
   //window.location.reload();
     return;
    }
    var days = Math.floor(distance / _day);
    var hours = Math.floor( (distance % _day ) / _hour );
    var minutes = Math.floor( (distance % _hour) / _minute );
    var seconds = Math.floor( (distance % _minute) / _second );

    var clock_countdown = document.getElementById('clock_countdown');
    clock_countdown.innerHTML = '';
     clock_countdown.innerHTML += '<div class="counterbox"><span class="counterbox_number">' + days + '</span><span class="counterbox_name">Days</span></div>';
     clock_countdown.innerHTML += '<div class="counterbox"><span class="counterbox_number">' + hours+ '</span><span class="counterbox_name">Hours</span></div>';
     clock_countdown.innerHTML += '<div class="counterbox"><span class="counterbox_number">' + minutes+ '</span><span class="counterbox_name">Minutes</span></div>';
     clock_countdown.innerHTML += '<div class="counterbox"><span class="counterbox_number">' + seconds+ '</span><span class="counterbox_name">Seconds</span></div>';
}

timer = setInterval(showRemaining, 1000);
</script>
<?php date_default_timezone_set($this->oldTz); ?>