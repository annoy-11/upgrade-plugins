<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _customDiscountEnddates.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/jquery.timepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
<style>
#ecoupon_discount_end_date{display:block !important;}
</style>
<div class="courses_choose_date">
  <div id="discount_end_date-wrapper" class="form-wrapper">
    <div id="discount_start_date-label" class="form-label">
      <label for="discount_end_date" class="optional"><?php echo $this->translate('') ?></label>
    </div>
    <div id="discount_end_date-element" class="form-element">
      <span class="courses-date-field"><input type="text" class="displayF" name="discount_end_date" id="ecoupon_discount_end_date" value="<?php echo isset($this->end_date) ? ($this->end_date) : ''  ?>" autocomplete="off"></span>
      <span class="courses-time-field"><input type="text" name="discount_end_date_time" id="ecoupon_discount_end_time" value="<?php echo isset($this->end_time) ? ($this->end_time) : ''  ?>" class="ui-timepicker-input" autocomplete="off"></span>
    </div>
  </div>
</div>
<div id="courses_end_end_time-wrapper" class="form-wrapper" style="display:none;">
  <div class="form-element tip"><span id="courses_discount_error_end_time-element"></span></div>
</div>
<script type="application/javascript">

 en4.core.runonce.add(function() {
	 <?php if(isset($this->subject) && $this->subject != ''){ ?>
		var sesstartCalanderDiscountEndDate = new Date('<?php echo date("m/d/Y",strtotime($this->subject->discount_end_date));  ?>');
	<?php }else{ ?>
		var sesstartCalanderDiscountEndDate = new Date('<?php echo date("m/d/Y");  ?>');
	<?php } ?>
	var sesselectedDiscountEndDate =  new Date(sesJqueryObject('#ecoupon_discount_end_date').val());
	var sesFromEndDate;
	sesBasicAutoScroll('#ecoupon_discount_end_time').timepicker({
			'showDuration': true,
			'timeFormat': 'g:ia',
	}).on('changeTime',function(){
		var lastTwoDigitStart = sesBasicAutoScroll('#ecoupon_discount_end_time').val().slice('-2');
		var startDate = new Date(sesBasicAutoScroll('#ecoupon_discount_end_date').val()+' '+sesBasicAutoScroll('#ecoupon_discount_end_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
		var error = checkDiscountEndDateTime(startDate);
		if(error != ''){
			sesBasicAutoScroll('#courses_end_end_time-wrapper').show();
			sesBasicAutoScroll('#courses_discount_error_end_time-element').text(error);
		}else{
			sesBasicAutoScroll('#courses_end_end_time-wrapper').hide();
		}
	});
	sesBasicAutoScroll('#ecoupon_discount_end_date').datepicker({
			format: 'm/d/yyyy',
			weekStart: 1,
			autoclose: true,
			startDate: sesstartCalanderDiscountEndDate,
	}).on('changeDate', function(ev){
		sesselectedDiscountEndDate = ev.date;
		var lastTwoDigitStart = sesBasicAutoScroll('#ecoupon_discount_end_time').val().slice('-2');
		var startDate = new Date(sesBasicAutoScroll('#ecoupon_discount_end_date').val()+' '+sesBasicAutoScroll('#ecoupon_discount_end_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
		var error = checkDiscountEndDateTime(startDate);
		if(error != ''){
			sesBasicAutoScroll('#courses_end_end_time-wrapper').show();
			sesBasicAutoScroll('#courses_discount_error_end_time-element').text(error);
		}else{
			sesBasicAutoScroll('#courses_end_end_time-wrapper').hide();
		}
	});
});
function checkDiscountEndDateTime(startdate){
  return "";  
}
</script>
