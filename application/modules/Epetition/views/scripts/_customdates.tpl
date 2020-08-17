<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _customdates.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/jquery.timepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
<style>
#epetition_schedule_date{display:block !important;}
</style>
<div class="epetition_choose_date form-wrapper">
  <div id="epetition_start_time-wrapper">
    <div id="epetition_start_time-label" class="form-label">
      <label for="epetition_start_time" class="optional"><?php echo $this->translate('Start Time') ?></label>
    </div>
    <div id="epetition_start_time-element" class="form-element">
      <span class="epetition-date-field"><input type="text" class="displayF" name="start_date" id="epetition_schedule_date" value="<?php echo isset($this->start_date) ? ($this->start_date) : ''  ?>"></span>
      <span class="epetition-time-field"><input type="text" name="start_time" id="epetition_schedule_time" value="<?php echo isset($this->start_time) ? ($this->start_time) : ''  ?>" class="ui-timepicker-input" autocomplete="off"></span>
    </div>
  </div>
</div>
<div id="epetition_error_time-wrapper" class="form-wrapper" style="display:none;">
  <div class="form-element tip"><span id="epetition_schedule_error_time-element"></span></div>
</div>
<script type="application/javascript">

 en4.core.runonce.add(function() {
	 <?php if(isset($this->subject) && $this->subject != ''){ ?>
		var sesstartCalanderDate = new Date('<?php echo date("m/d/Y",strtotime($this->subject->publish_date));  ?>');
	<?php }else{ ?>
		var sesstartCalanderDate = new Date('<?php echo date("m/d/Y");  ?>');
	<?php } ?>
	var sesselectedDate =  new Date(sesJqueryObject('#epetition_schedule_date').val());
	var sesFromEndDate;
	sesBasicAutoScroll('#epetition_schedule_time').timepicker({
			'showDuration': true,
			'timeFormat': 'g:ia',
	}).on('changeTime',function(){
		var lastTwoDigitStart = sesBasicAutoScroll('#epetition_schedule_time').val().slice('-2');
		var startDate = new Date(sesBasicAutoScroll('#epetition_schedule_date').val()+' '+sesBasicAutoScroll('#epetition_schedule_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
		var error = checkDateTime(startDate);
		if(error != ''){
			sesBasicAutoScroll('#epetition_error_time-wrapper').show();
			sesBasicAutoScroll('#epetition_schedule_error_time-element').text(error);
		}else{
			sesBasicAutoScroll('#epetition_error_time-wrapper').hide();
		}
	});
	sesBasicAutoScroll('#epetition_schedule_date').datepicker({
			format: 'm/d/yyyy',
			weekStart: 1,
			autoclose: true,
			startDate: sesstartCalanderDate,
	}).on('changeDate', function(ev){
		sesselectedDate = ev.date;
		var lastTwoDigitStart = sesBasicAutoScroll('#epetition_schedule_time').val().slice('-2');
		var startDate = new Date(sesBasicAutoScroll('#epetition_schedule_date').val()+' '+sesBasicAutoScroll('#epetition_schedule_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
		var error = checkDateTime(startDate);
		if(error != ''){
			sesBasicAutoScroll('#epetition_error_time-wrapper').show();
			sesBasicAutoScroll('#epetition_schedule_error_time-element').text(error);
		}else{
			sesBasicAutoScroll('#epetition_error_time-wrapper').hide();
		}
	});
});
function checkDateTime(startdate){
        if(jqueryObjectOfSes('input[name="show_start_time"]:checked').val() == '1')
        return '';
	var errorMessage = '';
	var checkdate = true;
	var currentTime =  new Date();
	if(<?php echo $this->subject ? 1 : 0 ?> == 0 && currentTime.valueOf() > startdate.valueOf() && sesBasicAutoScroll('#epetition_schedule_date').val() && 1 == '<?php echo $this->start_time_check; ?>'){
		errorMessage = "<?php echo $this->translate('Blog Schedule date is in the past. Please enter an blog scheduled date greater than or equal to today\'s date.')?>";	
	}
	return errorMessage;
	}
</script>
 