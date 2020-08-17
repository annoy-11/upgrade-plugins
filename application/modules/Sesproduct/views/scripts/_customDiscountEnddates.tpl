<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _customDiscountEnddates.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/jquery.timepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
<style>
#sesproduct_discount_end_date{display:block !important;}
</style>
<div class="sesproduct_choose_date">
  <div id="discount_end_date-wrapper" class="form-wrapper">
    <div id="discount_start_date-label" class="form-label">
      <label for="discount_end_date" class="optional"><?php echo $this->translate('') ?></label>
    </div>
    <div id="discount_end_date-element" class="form-element">
      <span class="sesproduct-date-field"><input type="text" class="displayF" name="discount_end_date" id="sesproduct_discount_end_date" value="<?php echo isset($this->end_date) ? ($this->end_date) : ''  ?>" autocomplete="off"></span>
      <span class="sesproduct-time-field"><input type="text" name="discount_end_date_time" id="sesproduct_discount_end_time" value="<?php echo isset($this->end_time) ? ($this->end_time) : ''  ?>" class="ui-timepicker-input" autocomplete="off"></span>
    </div>
  </div>
</div>
<div id="event_end_end_time-wrapper" class="form-wrapper" style="display:none;">
  <div class="form-element tip"><span id="sesproduct_discount_error_end_time-element"></span></div>
</div>
<script type="application/javascript">

 en4.core.runonce.add(function() {
	 <?php if(isset($this->subject) && $this->subject != ''){ ?>
		var sesstartCalanderDiscountEndDate = new Date('<?php echo date("m/d/Y",strtotime($this->subject->discount_end_date));  ?>');
	<?php }else{ ?>
		var sesstartCalanderDiscountEndDate = new Date('<?php echo date("m/d/Y");  ?>');
	<?php } ?>
	var sesselectedDiscountEndDate =  new Date(sesJqueryObject('#sesproduct_discount_end_date').val());
	var sesFromEndDate;
	sesBasicAutoScroll('#sesproduct_discount_end_time').timepicker({
			'showDuration': true,
			'timeFormat': 'g:ia',
	}).on('changeTime',function(){
		var lastTwoDigitStart = sesBasicAutoScroll('#sesproduct_discount_end_time').val().slice('-2');
		var startDate = new Date(sesBasicAutoScroll('#sesproduct_discount_end_date').val()+' '+sesBasicAutoScroll('#sesproduct_discount_end_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
		var error = checkDiscountEndDateTime(startDate);
		if(error != ''){
			sesBasicAutoScroll('#event_end_end_time-wrapper').show();
			sesBasicAutoScroll('#sesproduct_discount_error_end_time-element').text(error);
		}else{
			sesBasicAutoScroll('#event_end_end_time-wrapper').hide();
		}
	});
	sesBasicAutoScroll('#sesproduct_discount_end_date').datepicker({
			format: 'm/d/yyyy',
			weekStart: 1,
			autoclose: true,
			startDate: sesstartCalanderDiscountEndDate,
	}).on('changeDate', function(ev){
		sesselectedDiscountEndDate = ev.date;
		var lastTwoDigitStart = sesBasicAutoScroll('#sesproduct_discount_end_time').val().slice('-2');
		var startDate = new Date(sesBasicAutoScroll('#sesproduct_discount_end_date').val()+' '+sesBasicAutoScroll('#sesproduct_discount_end_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
		var error = checkDiscountEndDateTime(startDate);
		if(error != ''){
			sesBasicAutoScroll('#event_end_end_time-wrapper').show();
			sesBasicAutoScroll('#sesproduct_discount_error_end_time-element').text(error);
		}else{
			sesBasicAutoScroll('#event_end_end_time-wrapper').hide();
		}
	});
});
function checkDiscountEndDateTime(startdate){
  return "";  
}
</script>
