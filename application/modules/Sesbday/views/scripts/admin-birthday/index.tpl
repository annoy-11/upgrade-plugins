<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbday
 * @package    Sesbday
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
 
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<?php include APPLICATION_PATH .  '/application/modules/Sesbday/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbday_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<?php 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbday/externals/scripts/sesJquery.js');
 ?>
<script type="application/javascript">
sesJqueryObject('.global_form_box').submit(function(){
		parent.Smoothbox.close;
	sesJqueryObject('#submit').click();
})
window.addEvent('domready',function(){
	
	var valueEnable = document.getElementById('sesbday_birthday_enable').value;
	enableContent(valueEnable);
});
function enableContent(value){
	if(value == 1){
		document.getElementById('sesbday_birthday_subject-wrapper').style.display = 'block';
		document.getElementById('sesbday_birthday_content-wrapper').style.display = 'block';
	}else{
		document.getElementById('sesbday_birthday_subject-wrapper').style.display = 'none';	
		document.getElementById('sesbday_birthday_content-wrapper').style.display = 'none';
	}
}

$('testemail').addEvent('click',function(){
	var url = 'admin/sesbday/birthday/testemail/';
	Smoothbox.open(url);
	parent.Smoothbox.close;
	return false;
});
</script>
