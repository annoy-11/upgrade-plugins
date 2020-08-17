<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _customEnddates.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/jquery.timepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
<style>
#sesproduct_schedule_end_date{display:block !important;}
</style>
<div class="sesproduct_choose_date">
  <div id="event_end_time-wrapper" class="form-wrapper">
    <div id="event_end_time-label" class="form-label">
      <label for="event_end_time" class="optional"><?php echo $this->translate('End Time') ?></label>
    </div>
    <div id="event_end_time-element" class="form-element">
      <span class="sesproduct-date-field"><input type="text" class="displayF" name="end_date" id="sesproduct_schedule_end_date" value="<?php echo isset($this->end_date) ? ($this->end_date) : ''  ?>" autocomplete="off"></span>
      <span class="sesproduct-time-field"><input type="text" name="end_date_time" id="sesproduct_schedule_end_time" value="<?php echo isset($this->end_time) ? ($this->end_time) : ''  ?>" class="ui-timepicker-input" autocomplete="off"></span>
    </div>
  </div>
</div>
<div id="event_end_error_time-wrapper" class="form-wrapper" style="display:none;">
  <div class="form-element tip"><span id="sesproduct_schedule_error_end_time-element"></span></div>
</div>
<script type="application/javascript">

 en4.core.runonce.add(function() {
	 <?php if(isset($this->subject) && $this->subject != ''){ ?>
		var sesstartCalanderEndDate = new Date('<?php echo date("m/d/Y",strtotime($this->subject->publish_date));  ?>');
	<?php }else{ ?>
		var sesstartCalanderEndDate = new Date('<?php echo date("m/d/Y");  ?>');
	<?php } ?>
	var sesselectedEndDate =  new Date(sesJqueryObject('#sesproduct_schedule_end_date').val());
	var sesFromEndDate;
	sesBasicAutoScroll('#sesproduct_schedule_end_time').timepicker({
			'showDuration': true,
			'timeFormat': 'g:ia',
	}).on('changeTime',function(){
		var lastTwoDigitStart = sesBasicAutoScroll('#sesproduct_schedule_end_time').val().slice('-2');
		var startDate = new Date(sesBasicAutoScroll('#sesproduct_schedule_end_date').val()+' '+sesBasicAutoScroll('#sesproduct_schedule_end_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
		var error = checkEndDateTime(startDate);
		if(error != ''){
			sesBasicAutoScroll('#event_end_error_time-wrapper').show();
			sesBasicAutoScroll('#sesproduct_schedule_error_end_time-element').text(error);
		}else{
			sesBasicAutoScroll('#event_end_error_time-wrapper').hide();
		}
	});
	sesBasicAutoScroll('#sesproduct_schedule_end_date').datepicker({
			format: 'm/d/yyyy',
			weekStart: 1,
			autoclose: true,
			startDate: sesstartCalanderEndDate,
	}).on('changeDate', function(ev){
		sesselectedEndDate = ev.date;
		var lastTwoDigitStart = sesBasicAutoScroll('#sesproduct_schedule_end_time').val().slice('-2');
		var startDate = new Date(sesBasicAutoScroll('#sesproduct_schedule_end_date').val()+' '+sesBasicAutoScroll('#sesproduct_schedule_end_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
		var error = checkEndDateTime(startDate);
		if(error != ''){
			sesBasicAutoScroll('#event_end_error_time-wrapper').show();
			sesBasicAutoScroll('#sesproduct_schedule_error_end_time-element').text(error);
		}else{
			sesBasicAutoScroll('#event_end_error_time-wrapper').hide();
		}
	});
});
function checkEndDateTime(startdate){
  return "";
	}
</script>
