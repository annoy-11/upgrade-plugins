<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Booking
 * @package    Booking
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create-professional.tpl  2019-03-19 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Booking/externals/styles/styles.css'); ?>
<div class="sesapmt_professional_form">
	<?php echo $this->form->render($this);?>
</div>
<script type="text/javascript">
  en4.core.runonce.add(function() {
    mapLoad = false;
    initializeSesBookingMapList();
  });
</script>