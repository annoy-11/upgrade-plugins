<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _customdates.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/jquery.timepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
<style>
#sesarticle_schedule_date{display:block !important;}
</style>
<div class="sesarticle_choose_date">
  <div id="event_start_time-wrapper" class="form-wrapper">
    <div id="event_start_time-label" class="form-label">
      <label for="event_start_time" class="optional"><?php echo $this->translate('Start Time') ?></label>
    </div>
    <div id="event_start_time-element" class="form-element">
      <span class="sesarticle-date-field"><input type="text" class="displayF" name="start_date" id="sesarticle_schedule_date" value="<?php echo isset($this->start_date) ? ($this->start_date) : ''  ?>"></span>
      <span class="sesarticle-time-field"><input type="text" name="start_time" id="sesarticle_schedule_time" value="<?php echo isset($this->start_time) ? ($this->start_time) : ''  ?>" class="ui-timepicker-input" autocomplete="off"></span>
    </div>
  </div>
</div>
<div id="event_error_time-wrapper" class="form-wrapper" style="display:none;">
  <div class="form-element tip"><span id="sesarticle_schedule_error_time-element"></span></div>
</div>
<script type="application/javascript">

 en4.core.runonce.add(function() {
	 <?php if(isset($this->subject) && $this->subject != ''){ ?>
		var sesstartCalanderDate = new Date('<?php echo date("m/d/Y",strtotime($this->subject->publish_date));  ?>');
	<?php }else{ ?>
		var sesstartCalanderDate = new Date('<?php echo date("m/d/Y");  ?>');
	<?php } ?>
	var sesselectedDate =  new Date(sesJqueryObject('#sesarticle_schedule_date').val());
	var sesFromEndDate;
	sesBasicAutoScroll('#sesarticle_schedule_time').timepicker({
			'showDuration': true,
			'timeFormat': 'g:ia',
	}).on('changeTime',function(){
		var lastTwoDigitStart = sesBasicAutoScroll('#sesarticle_schedule_time').val().slice('-2');
		var startDate = new Date(sesBasicAutoScroll('#sesarticle_schedule_date').val()+' '+sesBasicAutoScroll('#sesarticle_schedule_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
		var error = checkDateTime(startDate);
		if(error != ''){
			sesBasicAutoScroll('#event_error_time-wrapper').show();
			sesBasicAutoScroll('#sesarticle_schedule_error_time-element').text(error);
		}else{
			sesBasicAutoScroll('#event_error_time-wrapper').hide();
		}
	});
	sesBasicAutoScroll('#sesarticle_schedule_date').datepicker({
			format: 'm/d/yyyy',
			weekStart: 1,
			autoclose: true,
			startDate: sesstartCalanderDate,
	}).on('changeDate', function(ev){
		sesselectedDate = ev.date;
		var lastTwoDigitStart = sesBasicAutoScroll('#sesarticle_schedule_time').val().slice('-2');
		var startDate = new Date(sesBasicAutoScroll('#sesarticle_schedule_date').val()+' '+sesBasicAutoScroll('#sesarticle_schedule_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
		var error = checkDateTime(startDate);
		if(error != ''){
			sesBasicAutoScroll('#event_error_time-wrapper').show();
			sesBasicAutoScroll('#sesarticle_schedule_error_time-element').text(error);
		}else{
			sesBasicAutoScroll('#event_error_time-wrapper').hide();
		}
	});
});
function checkDateTime(startdate){
        if(jqueryObjectOfSes('input[name="show_start_time"]:checked').val() == '1')
        return '';
	var errorMessage = '';
	var checkdate = true;
	var currentTime =  new Date();
	if(<?php echo $this->subject ? 1 : 0 ?> == 0 && currentTime.valueOf() > startdate.valueOf() && sesBasicAutoScroll('#sesarticle_schedule_date').val() && 1 == '<?php echo $this->start_time_check; ?>'){
		errorMessage = "<?php echo $this->translate('Article Schedule date is in the past. Please enter an article scheduled date greater than or equal to today\'s date.')?>";	
	}
	return errorMessage;
	}
</script>