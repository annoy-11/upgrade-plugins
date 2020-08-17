<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: testmail.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
 ?>

<div class='global_form_popup'>
    <?php echo $this->form->render($this); ?>
</div>

<script type="application/javascript">
$('send_test_email').addEvent('submit', function(e){
   var email = document.getElementById('email').value;
	 if(email){
		parent.sesJqueryObject('#testemailval').val(email);
		parent.sesJqueryObject('.global_form_box').trigger('submit');
		parent.Smoothbox.close;
		return false;
	 }
});

</script>