<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _customEnddates.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<style>
#courses_schedule_end_date{display:block !important;}
</style>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/jquery.timepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>

<div class="courses_choose_date">
  <div id="courses_end_time-wrapper" class="form-wrapper">
    <div id="courses_end_time-label" class="form-label">
      <label for="courses_end_time" class="optional"><?php echo $this->translate('End Time') ?></label>
    </div>
    <div id="courses_end_time-element" class="form-element">
      <span class="courses-date-field"><input type="text" class="displayF" name="end_date" id="courses_schedule_end_date" value="<?php echo isset($this->end_date) ? ($this->end_date) : ''  ?>" autocomplete="off"></span>
      <span class="courses-time-field"><input type="text" name="end_date_time" id="courses_schedule_end_time" value="<?php echo isset($this->end_time) ? ($this->end_time) : ''  ?>" class="ui-timepicker-input" autocomplete="off"></span>
    </div>
  </div>
</div>
<div id="courses_end_error_time-wrapper" class="form-wrapper" style="display:none;">
  <div class="form-element tip"><span id="courses_schedule_error_end_time-element"></span></div>
</div>
<script type="application/javascript">
<?php if(isset($this->subject) && $this->subject != ''){ ?>
		var sesstartCalanderEndDate = new Date('<?php echo date("m/d/Y",strtotime($this->subject->publish_date));  ?>');
	<?php }else{ ?>
		var sesstartCalanderEndDate = new Date('<?php echo date("m/d/Y");  ?>');
	<?php } ?>
	var sesselectedEndDate =  new Date(sesJqueryObject('#courses_schedule_end_date').val());
	var sesFromEndDate;
 en4.core.runonce.add(function() {
	 
	
	sesBasicAutoScroll('#courses_schedule_end_time').timepicker({
			'showDuration': true,
			'timeFormat': 'g:ia',
	}).on('changeTime',function(){
		var lastTwoDigitStart = sesBasicAutoScroll('#courses_schedule_end_time').val().slice('-2');
		var startDate = new Date(sesBasicAutoScroll('#courses_schedule_end_date').val()+' '+sesBasicAutoScroll('#courses_schedule_end_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
		var error = checkEndDateTime(startDate);
		if(error != ''){
			sesBasicAutoScroll('#courses_end_error_time-wrapper').show();
			sesBasicAutoScroll('#courses_schedule_error_end_time-element').text(error);
		}else{
			sesBasicAutoScroll('#courses_end_error_time-wrapper').hide();
		}
	}); 
	sesBasicAutoScroll('#courses_schedule_end_date').datepicker({
			format: 'm/d/yyyy',
			weekStart: 1,
			autoclose: true,
			 dynamic: true,
			startDate: sesstartCalanderEndDate,
	}).on('changeDate', function(ev){
		sesselectedEndDate = ev.date;
		var lastTwoDigitStart = sesBasicAutoScroll('#courses_schedule_end_time').val().slice('-2');
		var startDate = new Date(sesBasicAutoScroll('#courses_schedule_end_date').val()+' '+sesBasicAutoScroll('#courses_schedule_end_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
		var error = checkEndDateTime(startDate);
		if(error != ''){
			sesBasicAutoScroll('#courses_end_error_time-wrapper').show();
			sesBasicAutoScroll('#courses_schedule_error_end_time-element').text(error);
		}else{
			sesBasicAutoScroll('#courses_end_error_time-wrapper').hide();
		}
	});
});
function checkEndDateTime(startdate){
  return "";
	}
</script>
