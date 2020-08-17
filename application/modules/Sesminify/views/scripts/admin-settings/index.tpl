<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesminify
 * @package    Sesminify
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sesminify/views/scripts/dismiss_message.tpl';
?>
<div class="clear">
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
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesminify.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>
<script type="application/javascript">
  function disableDependednt(value,type){
      if(type == 'js'){
        if(value == 1){
          document.getElementById('sesminify_jslength-wrapper').style.display = "block";  
        }else
          document.getElementById('sesminify_jslength-wrapper').style.display = "none";
      }else{
        if(value == 1){
          document.getElementById('sesminify_csslength-wrapper').style.display = "block";  
        }else
          document.getElementById('sesminify_csslength-wrapper').style.display = "none";  
      }
  }
  disableDependednt(document.querySelector('[name="sesminify_enablecss"]:checked').value,'css');
  disableDependednt(document.querySelector('[name="sesminify_enablejs"]:checked').value,'js');
</script>
