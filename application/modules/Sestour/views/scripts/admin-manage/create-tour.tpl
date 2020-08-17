<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create-tour.tpl  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sestour_create_popup settings">
  <?php echo $this->form->render($this) ?>
</div>
<style type="text/css">
.sestour_create_popup{
	width:500px;
}
.sestour_create_popup .form-wrapper{
	padding:5px 0;
}
.sestour_create_popup .form-label{
	display:none;
}
.sestour_create_popup #placement-label{
	display:block;
	margin-bottom:5px;
}
.sestour_create_popup .form-label,
.sestour_create_popup .form-element{
	width:100%;
	clear:both;
}
.sestour_create_popup .form-element input[type="text"],
.sestour_create_popup .form-element select{
	max-width:100%;
}
</style>