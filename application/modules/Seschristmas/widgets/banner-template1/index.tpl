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

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seschristmas/externals/styles/style_banner.css'); ?>

<?php if($this->designType == 'tree'): ?>
	<?php if($this->viewType == 'horizontal'): ?>
  	<div class="seschristmas_banner1_container">
  <?php else: ?>
  	<div class="seschristmas_banner1_container seschristmas_banner1_container_vertical">
  <?php endif; ?>
  	<?php if($this->showtext1): ?>
      <div class="seschristmas_banner_block">
        <div class="seschristmas_banner_msgbox">
        	<div>
        		<?php echo $this->text1; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?php if($this->showtext2): ?>
    	<div class="seschristmas_banner_block">
        <div class="seschristmas_banner_tree">
          <div class="seschristmas_banner_tree_row">
            <span class="seschristmas_banner_item seschristmas_banner_tree_item_img">
              <img alt="Bell" src="application/modules/Seschristmas/externals/images/banner-elements/icon-bell.png">
            </span>
          </div>
          <div class="seschristmas_banner_tree_row">
            <span class="seschristmas_banner_item seschristmas_banner_tree_item_img">
              <img alt="Angel" src="application/modules/Seschristmas/externals/images/banner-elements/icon-angel1.png">
            </span>
            <span class="seschristmas_banner_item seschristmas_banner_tree_item_img">
              <img alt="Angel" src="application/modules/Seschristmas/externals/images/banner-elements/icon-angel2.png">
            </span>
          </div>
          <div class="seschristmas_banner_tree_row">
            <span class="seschristmas_banner_item seschristmas_banner_tree_item_img">
              <img alt="Snowflake" src="application/modules/Seschristmas/externals/images/banner-elements/icon-snowflake.png">
            </span>
            <span class="seschristmas_banner_item">
              <span class="line-text1"><?php echo $this->text2; ?></span>
            </span>
            <span class="seschristmas_banner_item seschristmas_banner_tree_item_img">
              <img alt="Candy" src="application/modules/Seschristmas/externals/images/banner-elements/icon-candy.png">
            </span>
          </div>
          <?php $year = date("Y"); 
$newYear = $year+1; 
$finalNewYear = "$newYear-01-01 12:00:00";
?>
          <?php if(!empty($this->showcountdown)): ?>
            <?php $exp_date = strtotime($finalNewYear); ?>
          <?php else: ?>
            <?php $exp_date = strtotime("$year-12-25 12:00:00"); ?>
          <?php endif; ?>
          <div id="banner_countdown" class="seschristmas_banner_tree_row seschristmas_banner_tree_countdown_row"></div> 
        </div>
      </div>
    <?php endif; ?>
  </div>
<?php elseif($this->designType == 'circel'): ?>
	<?php if($this->viewType == 'horizontal'): ?>
  	<div class="seschristmas_banner2_container">
  <?php else: ?>
  	<div class="seschristmas_banner2_container seschristmas_banner2_container_vertical">
  <?php endif; ?>
  	<?php if($this->showtext1): ?>
      <div class="seschristmas_banner_block">
				<div class="seschristmas_banner_msgbox">
        	<div>
        		<?php echo $this->text1; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?php if($this->showtext2): ?>
    	<div class="seschristmas_banner_block">
        <div class="seschristmas_banner_tree">
          <div class="seschristmas_banner_wreath">
            <span class="line-text1"><?php echo $this->text2; ?></span>
          </div>
          <?php $year = date("Y"); 
$newYear = $year+1; 
$finalNewYear = "$newYear-01-01 12:00:00";
?>
          <?php if(!empty($this->showcountdown)): ?>
            <?php $exp_date = strtotime($finalNewYear); ?>
          <?php else: ?>
            <?php $exp_date = strtotime("$year-12-25 12:00:00"); ?>
          <?php endif; ?>
          <div id="banner_countdown" class="seschristmas_banner_circel_row"></div> 
        </div>
      </div>
    <?php endif; ?>
  </div>
<?php endif; ?>

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

    var banner_countdown = document.getElementById('banner_countdown');
    banner_countdown.innerHTML = '';
     banner_countdown.innerHTML += '<span class="seschristmas_banner_item"><span class="seschristmas_banner_countdown_amount">' + days + '</span><br />Days</span>';
     banner_countdown.innerHTML += '<span class="seschristmas_banner_item"><span class="seschristmas_banner_countdown_amount">' + hours+ '</span><br />Hours</span>';
    banner_countdown.innerHTML += '<span class="seschristmas_banner_item"><span class="seschristmas_banner_countdown_amount">' + minutes+ '</span><br />Minutes<br />';
    banner_countdown.innerHTML += '<span class="seschristmas_banner_item"><span class="seschristmas_banner_countdown_amount">' + seconds+ '</span><br />Seconds</span>';
}

timer = setInterval(showRemaining, 1000);
</script>
<?php date_default_timezone_set($this->oldTz); ?>