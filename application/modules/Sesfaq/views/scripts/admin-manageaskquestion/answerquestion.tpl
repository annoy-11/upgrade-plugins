<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: answerquestion.tpl  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<div class="settings sesfaq_popup_form">
  <?php echo $this->form->render($this) ?>
</div>
<style type="text/css">
.sesfaq_popup_form{
	margin:15px 0 0 15px;
}
.sesfaq_popup_form form > div > div{
	width:600px;
}
.sesfaq_popup_form form > div > div .form-element input[type="text"],
.sesfaq_popup_form form > div > div .form-element textarea{
	min-width:0;
	max-width:100%;
	width:100%;
	box-sizing:border-box;
}
</style>