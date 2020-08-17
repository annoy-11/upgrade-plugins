<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestutorial
 * @package    Sestutorial
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: answerquestion.tpl  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<div class="settings sestutorial_popup_form">
  <?php echo $this->form->render($this) ?>
</div>
<style type="text/css">
.sestutorial_popup_form{
	margin:15px 0 0 15px;
}
.sestutorial_popup_form form > div > div{
	width:600px;
}
.sestutorial_popup_form form > div > div .form-element input[type="text"],
.sestutorial_popup_form form > div > div .form-element textarea{
	min-width:0;
	max-width:100%;
	width:100%;
	box-sizing:border-box;
}
</style>