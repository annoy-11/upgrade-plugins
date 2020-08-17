
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Booking/externals/styles/styles.css'); ?>

<div class="layout_middle">
	<div class="generic_layout_container generic_layout_core_content">
  	<div class="sesapmt_booking_details_form sesbasic_bxs">
      <form class="sesbasic_clearfix" name="ticket" id="ticketDtEvn" method="post" action="<?php echo $this->url(array('professional_id' => $this->professional_id,'controller'=>'order','order_id'=>$this->order->order_id,'action'=>'checkout'), 'booking_order', true); ?>">
      	<div class="_details sesapmt_booking_order_info_box">
          <div class="sesapmt_booking_order_info_summary">
            <div class="_title"><?php echo $this->translate("Order Summary"); ?></div>
            <div class="sesapmt_booking_order_info_field sesbasic_clearfix">
            	<?php $counter = count($this->appointmentDetails); ?>
              <span><?php echo $this->translate(array('Total service', 'Total services', $counter)) ?></span>
            	<span><?php echo $this->locale()->toNumber($counter); ?></span>
            </div>
            <?php foreach($this->appointmentDetails as $appointmentDetails){ ?>
              <div class="sesapmt_booking_order_info_field sesbasic_clearfix">
                <span><?php $servicename = Engine_Api::_()->getItem('booking_service', $appointmentDetails->service_id); echo $servicename->name; ?></span>
                <span><?php echo Engine_Api::_()->booking()->getCurrencyPrice($servicename->price);?></span>
              </div>
            <?php } ?>
            <?php if($this->order->total_service_tax+$this->order->total_entertainment_tax > 0){ ?>
              <div class="sesapmt_booking_order_info_field sesbasic_clearfix">
                <span><?php echo $this->translate("Total Tax"); ?></span>
                <span><?php echo Engine_Api::_()->booking()->getCurrencyPrice(($this->order->total_service_tax+$this->order->total_entertainment_tax)); ?></span>
              </div>
            <?php } ?>
            <div class="sesapmt_booking_order_info_field sesbasic_clearfix">
              <span><?php echo $this->translate("Service Durations"); ?></span>
              <span><?php echo Engine_Api::_()->booking()->convertToHoursMins($this->order->durations, '%02d hours %02d minutes'); ?></span>
            </div>
            <div class="sesapmt_booking_order_info_field sesbasic_clearfix _total">  
              <span><?php echo $this->translate("Grand Total"); ?></span>
              <span><?php echo Engine_Api::_()->booking()->getCurrencyPrice(($this->order->total_service_tax+$this->order->total_entertainment_tax+$this->order->total_amount)); ?></span>
            </div>
          </div>
        </div>
      	<div class="_form">
          <div class="_title"><?php echo $this->translate("Service order Details"); ?></div>
          <div class="sesapmt_booking_details_form_field sesbasic_clearfix">
            <div class="_label">
              <label for="fname_owner"><?php echo $this->translate("First Name"); ?> <span class="required">*</span></label>
            </div>
            <div class="_element">
              <input id="fname_owner" type="text" name="fname_owner" value="<?php echo isset($this->fnamelname['first_name']) ? $this->fnamelname['first_name'] : '' ?>" />
            </div>
          </div>
          <div class="sesapmt_booking_details_form_field sesbasic_clearfix">
            <div class="_label">
              <label for="lname_owner"><?php echo $this->translate("Last Name"); ?> <span class="required">*</span></label>
            </div>
            <div class="_element">
              <input id="lname_owner" type="text" name="lname_owner" value="<?php echo isset($this->fnamelname['last_name']) ? $this->fnamelname['last_name'] : '' ?>" />
            </div>
          </div>
          <div class="sesapmt_booking_details_form_field sesbasic_clearfix">
            <div class="_label">
              <label for="mobile_owner"><?php echo $this->translate("Mobile"); ?> <span class="required">*</span></label>
            </div>
            <div class="_element">
              <input id="mobile_owner" type="text" name="mobile_owner" value="" />
            </div>
          </div>
          <div class="sesapmt_booking_details_form_field sesbasic_clearfix">
            <div class="_label">
              <label for="email_owner"><?php echo $this->translate("Email"); ?> <span class="required">*</span></label>
            </div>
            <div class="_element">
              <input id="email_owner" type="text" name="email_owner" value="<?php echo $this->viewer->email; ?>" />
            </div>
          </div>
          <div class="sesapmt_booking_details_form_field _btn sesbasic_clearfix">
          	<div class="_label">&nbsp;</div>		
          	<div class="_element"><button type="submit" name="submit" value="submit" id="sbtBtn"><?php echo $this->translate("Continue"); ?></button></div>
        	</div>
        </div>
      </form>
    </div>
	</div>
</div>

<script type="application/javascript">
/*function validateForm(){
	valid = true;
	sesJqueryObject('#ticketDtEvn').find(':input[type=text]').each(function(){
			if(!sesJqueryObject(this).val() || (sesJqueryObject(this).hasClass('ticket_owner_email') && !validateEmail(sesJqueryObject(this).val()))){
				valid = false;
				sesJqueryObject(this).parent().find('span').show();
			}else{
				sesJqueryObject(this).parent().find('span').hide();
			}
	});
	return valid;
}
sesJqueryObject('#ticketDtEvn').submit(function(e){
	valid = validateForm();
	if(!valid){
			//e.preventDefault();
			return false;
	}
	sesJqueryObject('#fname_owner').val(sesJqueryObject('#ownerFname').val());
	sesJqueryObject('#lname_owner').val(sesJqueryObject('#ownerLname').val());
	sesJqueryObject('#email_owner').val(sesJqueryObject('#ownerEmail').val());
	sesJqueryObject('#mobile_owner').val(sesJqueryObject('#ownerMobile').val());
	sesJqueryObject('#cdetails_owner').val(sesJqueryObject('#ownerCdetail').val());
		return true;
});
function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}
sesJqueryObject('#fillDt').bind('change', function () {
	if(sesJqueryObject("#fillDt").is(':checked')){
		sesJqueryObject('#ticketDtEvn').find(':input').each(function(){
			if(sesJqueryObject(this).hasClass('ticket_owner_fname'))
				sesJqueryObject(this).val(sesJqueryObject('#ownerFname').val());
			if(sesJqueryObject(this).hasClass('ticket_owner_lname'))
				sesJqueryObject(this).val(sesJqueryObject('#ownerLname').val());
			if(sesJqueryObject(this).hasClass('ticket_owner_email'))
				sesJqueryObject(this).val(sesJqueryObject('#ownerEmail').val());
			if(sesJqueryObject(this).hasClass('ticket_owner_mobile'))
				sesJqueryObject(this).val(sesJqueryObject('#ownerMobile').val());
		})
	}else{
		sesJqueryObject('#ticketDtEvn').find(':input').each(function(){
			sesJqueryObject(this).val('');
		});
	}
}).trigger('change');*/
</script>