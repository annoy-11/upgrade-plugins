<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Booking
 * @package    Booking
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-19 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Booking/externals/styles/styles.css'); ?>

<div class="sesapmt_search_form sesbasic_bxs <?php echo $this->view_type=='horizontal' ? 'sespage_browse_search_horizontal' : 'sespage_browse_search_vertical'; ?>">
	<?php echo $this->form->render($this);  ?>
</div>