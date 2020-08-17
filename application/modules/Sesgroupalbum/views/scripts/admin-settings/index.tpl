<?php

?>

<h2>
  <?php echo $this->translate("Group Albums Extension") ?>
</h2>
<div class="sesbasic_nav_btns">
  <a href="<?php echo $this->url(array('module' => 'sesbasic', 'controller' => 'settings', 'action' => 'contact-us'),'admin_default',true); ?>" class="request-btn">Feature Request</a>
</div>
<?php if( count($this->navigation) ): ?>
  <div class='sesbasic-admin-navgation'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render() ?>
  </div>
<?php endif; ?>
<?php if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupalbum.pluginactivated')) { ?>
<?php $flushData = Engine_Api::_()->sesgroupalbum()->getFlushPhotoData();
   if($flushData >0){ ?>
  <div class="sesgroupalbum_warning">
      You have <?php echo $flushData; ?> unmapped photos <a href="<?php echo $this->url(array('module' => 'sesgroupalbum', 'controller' => 'settings', 'action' => 'flush-photo'),'admin_default',true); ?>">click here</a> to remove them.
  </div>
<?php  } } ?>
<div class="settings sesbasic_admin_form">
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupalbum.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>


<script type="text/javascript">
function confirmChangeLandingPage(value){
	if(value == 1 && !confirm('Are you sure want to set the default Welcome page of this plugin as the Landing page of your website. Your old landing page will not be recoverable after changing it using this setting.')){
		document.getElementById('sesgroupalbum_set_landingpage-0').checked = true;
	}
}
function rating_album(value){
		if(value == 1){
			document.getElementById('sesgroupalbum_ratealbum_own-wrapper').style.display = 'block';		
			document.getElementById('sesgroupalbum_ratealbum_again-wrapper').style.display = 'block';
			document.getElementById('sesgroupalbum_ratealbum_show-wrapper').style.display = 'none';	
		}else{
			document.getElementById('sesgroupalbum_ratealbum_show-wrapper').style.display = 'block';
			document.getElementById('sesgroupalbum_ratealbum_own-wrapper').style.display = 'none';
			document.getElementById('sesgroupalbum_ratealbum_again-wrapper').style.display = 'none';
		}
}
function show_position(value){
	if(value == 1){
			document.getElementById('sesgroupalbum_position_watermark-wrapper').style.display = 'block';
	}else{
			document.getElementById('sesgroupalbum_position_watermark-wrapper').style.display = 'none';		
	}
}
if(document.querySelector('[name="sesgroupalbum_watermark_enable"]:checked').value == 0){
	document.getElementById('sesgroupalbum_position_watermark-wrapper').style.display = 'none';	
}else{
		document.getElementById('sesgroupalbum_position_watermark-wrapper').style.display = 'block';
}
function rating_photo(value){
		if(value == 1){
			document.getElementById('sesgroupalbum_ratephoto_show-wrapper').style.display = 'none';
			document.getElementById('sesgroupalbum_ratephoto_own-wrapper').style.display = 'block';
			document.getElementById('sesgroupalbum_ratephoto_again-wrapper').style.display = 'block';			
		}else{
			document.getElementById('sesgroupalbum_ratephoto_show-wrapper').style.display = 'block';
			document.getElementById('sesgroupalbum_ratephoto_own-wrapper').style.display = 'none';
			document.getElementById('sesgroupalbum_ratephoto_again-wrapper').style.display = 'none';	
		}
}
if(document.querySelector('[name="sesgroupalbum_album_rating"]:checked').value == 0){
	document.getElementById('sesgroupalbum_ratealbum_own-wrapper').style.display = 'none';		
	document.getElementById('sesgroupalbum_ratealbum_again-wrapper').style.display = 'none';
	document.getElementById('sesgroupalbum_ratealbum_show-wrapper').style.display = 'block';
}else{
	document.getElementById('sesgroupalbum_ratealbum_show-wrapper').style.display = 'none';
}
if(document.querySelector('[name="sesgroupalbum_photo_rating"]:checked').value == 0){
			document.getElementById('sesgroupalbum_ratephoto_own-wrapper').style.display = 'none';	
			document.getElementById('sesgroupalbum_ratephoto_again-wrapper').style.display = 'none';	
			document.getElementById('sesgroupalbum_ratephoto_show-wrapper').style.display = 'block';	
}else{
			document.getElementById('sesgroupalbum_ratephoto_show-wrapper').style.display = 'none';	
}
</script>