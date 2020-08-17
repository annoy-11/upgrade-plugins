<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesmember/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<?php 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
 ?>
<script type="application/javascript">
sesJqueryObject('.global_form_box').submit(function(){
		parent.Smoothbox.close;
	sesJqueryObject('#submit').click();
})
window.addEvent('domready',function(){
	
	var valueEnable = document.getElementById('sesmember_birthday_enable').value;
	enableContent(valueEnable);
});
function enableContent(value){
	if(value == 1){
		document.getElementById('sesmember_birthday_subject-wrapper').style.display = 'block';
		document.getElementById('sesmember_birthday_content-wrapper').style.display = 'block';
	}else{
		document.getElementById('sesmember_birthday_subject-wrapper').style.display = 'none';	
		document.getElementById('sesmember_birthday_content-wrapper').style.display = 'none';
	}
}

$('testemail').addEvent('click',function(){
	var url = 'admin/sesmember/birthday/testemail/';
	Smoothbox.open(url);
	parent.Smoothbox.close;
	return false;
});
</script>