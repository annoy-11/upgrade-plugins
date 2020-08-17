<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmusic
 * @package    Sesmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $settings = Engine_Api::_()->getApi('settings', 'core');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>
<script type="text/javascript">

  window.addEvent('domready', function() {
    if($('sesmusic_uploadoption-wrapper'))
      $('sesmusic_uploadoption-wrapper').style.display = 'none';
    checkUpload("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmusic.uploadoption', 'myComputer'); ?>");
  });
  
  function showPopUp() {
    Smoothbox.open('<?php echo $this->escape($this->url(array('module' =>'sesmusic', 'controller' => 'admin-settings', 'action'=>'showpopup', 'format' => 'smoothbox'), 'default' , true)); ?>');
    parent.Smoothbox.close;
  }
  
	
  function confirmChangeLandingPage(value){
      if(value == 1 && !confirm('Are you sure want to set the default Welcome page of this plugin as the Landing page of your website. for old landing page you will have to manually make changes in the Landing page from Layout Editor. Back up page of your current landing page will get created with the name “LP backup from SES Advanced Music”.')){
          sesJqueryObject('#sesmusic_changelanding-0').prop('checked',true);
      }else if(value == 0){
          //silence
      }else{
          sesJqueryObject('#sesmusic_changelanding-0').removeAttr('checked');
          sesJqueryObject('#sesmusic_changelanding-0').prop('checked',false);	
      }
}


	
  function checkUpload(value) {
    if (value == 'both' || value == 'soundCloud') {
      if ($('sesmusic_scclientid-wrapper'))
        $('sesmusic_scclientid-wrapper').style.display = 'block';
      if ($('sesmusic_scclientscreatid-wrapper'))
        $('sesmusic_scclientscreatid-wrapper').style.display = 'block';
    } else {
      if ($('sesmusic_scclientid-wrapper'))
        $('sesmusic_scclientid-wrapper').style.display = 'none';
      if ($('sesmusic_scclientscreatid-wrapper'))
        $('sesmusic_scclientscreatid-wrapper').style.display = 'none';
    }
  }
</script>
<?php include APPLICATION_PATH .  '/application/modules/Sesmusic/views/scripts/dismiss_message.tpl';?>

<div class="sesbasic-form">
  <div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php
        echo $this->navigation()->menu()->setContainer($this->subNavigation)->render()
        ?>
      </div>
    <?php endif; ?>
    <div class='sesbasic-form-cont'>
      <div class='settings sesbasic_admin_form'>
        <?php echo $this->form->render($this); ?>
      </div>
    </div>
  </div>
</div>

<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>

<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmusic.pluginactivated',0)): 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php endif; ?>