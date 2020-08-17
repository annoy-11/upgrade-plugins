<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: testemail.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
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