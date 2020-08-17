<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _customDiscountStartdates.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/jquery.timepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
<style>
#sesproduct_discount_start_date{display:block !important;}
</style>
<div class="sesproduct_choose_date">
  <div id="discount_start_date-wrapper" class="form-wrapper">
    <div id="discount_start_date-label" class="form-label">
      <label for="discount_start_date" class="optional"><?php echo $this->translate('Discount Start Date') ?></label>
    </div>
    <div id="discount_start_date-element" class="form-element">
      <span class="sesproduct-date-field"><input type="text" class="displayF" name="discount_start_date" id="sesproduct_discount_start_date" value="<?php echo isset($this->start_date) ? ($this->start_date) : ''  ?>" autocomplete="off"></span>
      <span class="sesproduct-time-field"><input type="text" name="discount_start_date_time" id="sesproduct_discount_start_time" value="<?php echo isset($this->start_time) ? ($this->start_time) : ''  ?>" class="ui-timepicker-input" autocomplete="off"></span>
    </div>
  </div>
</div>
<div id="event_end_start_time-wrapper" class="form-wrapper" style="display:none;">
  <div class="form-element tip"><span id="sesproduct_discount_error_start_time-element"></span></div>
</div>
<script type="application/javascript">

 en4.core.runonce.add(function() {
	 <?php if(isset($this->subject) && $this->subject != ''){ ?>
		var sesstartCalanderDiscountStartDate = new Date('<?php echo date("m/d/Y",strtotime($this->subject->publish_date));  ?>');
	<?php }else{ ?>
		var sesstartCalanderDiscountStartDate = new Date('<?php echo date("m/d/Y");  ?>');
	<?php } ?>
	var sesselectedDiscountStartDate =  new Date(sesJqueryObject('#sesproduct_discount_start_date').val());
	var sesFromEndDate;
	sesBasicAutoScroll('#sesproduct_discount_start_time').timepicker({
			'showDuration': true,
			'timeFormat': 'g:ia',
	}).on('changeTime',function(){
		var lastTwoDigitStart = sesBasicAutoScroll('#sesproduct_discount_start_time').val().slice('-2');
		var startDate = new Date(sesBasicAutoScroll('#sesproduct_discount_start_date').val()+' '+sesBasicAutoScroll('#sesproduct_discount_start_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
		var error = checkDiscountSTartDateTime(startDate);
		if(error != ''){
			sesBasicAutoScroll('#event_end_start_time-wrapper').show();
			sesBasicAutoScroll('#sesproduct_discount_error_start_time-element').text(error);
		}else{
			sesBasicAutoScroll('#event_end_start_time-wrapper').hide();
		}
	});
	sesBasicAutoScroll('#sesproduct_discount_start_date').datepicker({
			format: 'm/d/yyyy',
			weekStart: 1,
			autoclose: true,
			startDate: sesstartCalanderDiscountStartDate,
	}).on('changeDate', function(ev){
		sesselectedDiscountStartDate = ev.date;
		var lastTwoDigitStart = sesBasicAutoScroll('#sesproduct_discount_start_time').val().slice('-2');
		var startDate = new Date(sesBasicAutoScroll('#sesproduct_discount_start_date').val()+' '+sesBasicAutoScroll('#sesproduct_discount_start_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
		var error = checkDiscountSTartDateTime(startDate);
		if(error != ''){
			sesBasicAutoScroll('#event_end_start_time-wrapper').show();
			sesBasicAutoScroll('#sesproduct_discount_error_start_time-element').text(error);
		}else{
			sesBasicAutoScroll('#event_end_start_time-wrapper').hide();
		}
	});
});
function checkDiscountSTartDateTime(startdate){
  return "";
	}
</script>
