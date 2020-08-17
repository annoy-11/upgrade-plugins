<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>	
	
	<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>
<?php include APPLICATION_PATH .  '/application/modules/Emailtemplates/views/scripts/dismiss_message.tpl';?>	
<div>
<?php echo $this->htmlLink(array('action' => 'index', 'reset' => false), $this->translate("Return to manage Templates"),array('class' => 'buttonlink sesbasic_icon_back')) ?>
</div>
<br/>
<div class='clear'>
	<div class='settings sesbasic_admin_form emailtemplates_create_form'>
		<?php echo $this->form->render($this); ?>
	</div>
</div>
<br />	
<script type="text/javascript">
	window.addEvent('domready',function() {
    showemail(jqueryObjectOfSes("input[name='header_emailphone_show']:checked").val()); 
    emilinput(jqueryObjectOfSes("input[name='test_email_check']:checked").val()); 
	});
	function emilinput(value){
		if (jqueryObjectOfSes(value).is(":checked")) {
			if($('test_email-wrapper'))
				$('test_email-wrapper').setStyle('display','block');
		}else{
			if($('test_email-wrapper'))
				$('test_email-wrapper').setStyle('display','none');
		}
	}
	function showemail(value){
		if(value == '1'){
			if($('header_mail-wrapper'))
				$('header_mail-wrapper').setStyle('display','block');
			if($('header_phone-wrapper'))
				$('header_phone-wrapper').setStyle('display','block');
			if($('header_emailphone_align-wrapper'))
				$('header_emailphone_align-wrapper').setStyle('display','block');
			if($('font_color_textemailphone-wrapper'))
				$('font_color_textemailphone-wrapper').setStyle('display','block');
		}else{
			if($('header_mail-wrapper'))
				$('header_mail-wrapper').setStyle('display','none');
			if($('header_phone-wrapper'))
				$('header_phone-wrapper').setStyle('display','none');
			if($('header_emailphone_align-wrapper'))
				$('header_emailphone_align-wrapper').setStyle('display','none');
			if($('font_color_textemailphone-wrapper'))
				$('font_color_textemailphone-wrapper').setStyle('display','none');
		}
		
	}
</script>
	
