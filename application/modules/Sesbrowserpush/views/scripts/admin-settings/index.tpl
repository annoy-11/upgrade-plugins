<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesbrowserpush/views/scripts/dismiss_message.tpl';
?>
<div class="clear">
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbrowserpush.pluginactivated',0)) {
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>

<?php $notificationpush = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbrowserpush.notificationpush', 1);?>

<script type="text/javascript">
 
  window.addEvent('domready',function() {
    showHide('<?php echo $notificationpush;?>');
    //showHideOptions('<?php //echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbrowserpush.type',0) ;?>');
  });
  
  function showHide(value) {
    if(value == 1) {
      document.getElementById('sesbrowserpush_type-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_title-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_descr-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_logo-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_bellalways-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_days-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_height-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_width-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_percontainer-wrapper').style.display = 'block';
      showHideOptions('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbrowserpush.type',0) ;?>');
      showperHide('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbrowserpush.percontainer',1) ;?>');
    } else {
      document.getElementById('sesbrowserpush_type-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_title-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_descr-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_logo-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_bellalways-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_days-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_height-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_width-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_percontainer-wrapper').style.display = 'none';
      showHideOptions(0);
      showperHide(0);
    }
  }
  
  function showperHide(value) {
    if(value == 1) {
      document.getElementById('sesbrowserpush_textpercontai-wrapper').style.display = 'block';
    } else {
      document.getElementById('sesbrowserpush_textpercontai-wrapper').style.display = 'none';
    }
  }
  
  function showHideOptions(value) {
    if(value == 1) {
      //document.getElementById('sesbrowserpush_type-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_title-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_descr-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_logo-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_bellalways-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_days-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_height-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_width-wrapper').style.display = 'none';
    } else if(value == 2) {
      //document.getElementById('sesbrowserpush_type-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_title-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_descr-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_logo-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_bellalways-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_days-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_height-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_width-wrapper').style.display = 'none';
    } else if(value == 3) {
      //document.getElementById('sesbrowserpush_type-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_title-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_descr-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_logo-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_bellalways-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_days-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_height-wrapper').style.display = 'block';
      document.getElementById('sesbrowserpush_width-wrapper').style.display = 'block';
    } 
    
    else {
      //document.getElementById('sesbrowserpush_type-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_title-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_descr-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_logo-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_bellalways-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_days-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_height-wrapper').style.display = 'none';
      document.getElementById('sesbrowserpush_width-wrapper').style.display = 'none';
    }
  }
</script>
