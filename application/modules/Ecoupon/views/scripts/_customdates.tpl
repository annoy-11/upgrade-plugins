<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Courses
 * @package    Courses
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _customdates.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
 <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/jquery.timepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>

<style>
#ecoupon_schedule_date{display:block !important;}
</style>
<div class="ecoupon_choose_date">
  <div id="ecoupon_start_time-wrapper" class="form-wrapper">
    <div id="ecoupon_start_time-label" class="form-label">
      <label for="ecoupon_start_time" class="optional"><?php echo $this->translate('Start Time') ?></label>
    </div>
    <div id="ecoupon_start_time-element" class="form-element">
      <span class="ecoupon-date-field"><input type="text" class="displayF" name="start_date" id="ecoupon_schedule_date" value="<?php echo isset($this->start_date) ? ($this->start_date) : ''  ?>"></span>
      <span class="ecoupon-time-field"><input type="text" name="start_date_time" id="ecoupon_schedule_time" value="<?php echo isset($this->start_time) ? ($this->start_time) : ''  ?>" class="ui-timepicker-input" autocomplete="off"></span>
    </div>
  </div>
</div>
<div id="ecoupon_error_time-wrapper" class="form-wrapper" style="display:none;">
  <div class="form-element tip"><span id="ecoupon_schedule_error_time-element"></span></div>
</div>
<script type="application/javascript">

 en4.core.runonce.add(function() {
	 <?php if(isset($this->subject) && $this->subject != ''){ ?>
		var sesstartCalanderDate = new Date('<?php echo date("m/d/Y",strtotime($this->subject->publish_date));  ?>');
	<?php }else{ ?>
		var sesstartCalanderDate = new Date('<?php echo date("m/d/Y");  ?>');
	<?php } ?>
	var sesselectedDate =  new Date(sesJqueryObject('#ecoupon_schedule_date').val());
	var sesFromEndDate;
	sesBasicAutoScroll('#ecoupon_schedule_time').timepicker({
			'showDuration': true,
			'timeFormat': 'g:ia',
	}).on('changeTime',function(){
		var lastTwoDigitStart = sesBasicAutoScroll('#ecoupon_schedule_time').val().slice('-2');
		var startDate = new Date(sesBasicAutoScroll('#ecoupon_schedule_date').val()+' '+sesBasicAutoScroll('#ecoupon_schedule_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
		var error = checkDateTime(startDate);
		if(error != ''){
			sesBasicAutoScroll('#ecoupon_error_time-wrapper').show();
			sesBasicAutoScroll('#ecoupon_schedule_error_time-element').text(error);
		}else{
			sesBasicAutoScroll('#ecoupon_error_time-wrapper').hide();
		}
	});
	sesBasicAutoScroll('#ecoupon_schedule_date').datepicker({
			format: 'm/d/yyyy',
			weekStart: 1,
			autoclose: true,
			startDate: sesstartCalanderDate,
	}).on('changeDate', function(ev){
		sesselectedDate = ev.date;
		var lastTwoDigitStart = sesBasicAutoScroll('#ecoupon_schedule_time').val().slice('-2');
		var startDate = new Date(sesBasicAutoScroll('#ecoupon_schedule_date').val()+' '+sesBasicAutoScroll('#ecoupon_schedule_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
		var error = checkDateTime(startDate);
		if(error != ''){
			sesBasicAutoScroll('#ecoupon_error_time-wrapper').show();
			sesBasicAutoScroll('#ecoupon_schedule_error_time-element').text(error);
		}else{
			sesBasicAutoScroll('#ecoupon_error_time-wrapper').hide();
		}
	});
});
function checkDateTime(startdate){
        return "";
	}
</script>
