<?php

?>
<script type="text/javascript">

  window.addEvent('domready', function() {
    checkUpload("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.uploadoption', 'myComputer'); ?>");
  });
  
  function showPopUp() {
    Smoothbox.open('<?php echo $this->escape($this->url(array('module' =>'seseventmusic', 'controller' => 'admin-settings', 'action'=>'showpopup', 'format' => 'smoothbox'), 'default' , true)); ?>');
    parent.Smoothbox.close;
  }
  
  function checkUpload(value) {
    if (value == 'both' || value == 'soundCloud') {
      if ($('seseventmusic_scclientid-wrapper'))
        $('seseventmusic_scclientid-wrapper').style.display = 'block';
      if ($('seseventmusic_scclientscreatid-wrapper'))
        $('seseventmusic_scclientscreatid-wrapper').style.display = 'block';
    } else {
      if ($('seseventmusic_scclientid-wrapper'))
        $('seseventmusic_scclientid-wrapper').style.display = 'none';
      if ($('seseventmusic_scclientscreatid-wrapper'))
        $('seseventmusic_scclientscreatid-wrapper').style.display = 'none';
    }
  }
</script>
<?php include APPLICATION_PATH .  '/application/modules/Seseventmusic/views/scripts/dismiss_message.tpl';?>

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

<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.pluginactivated',0)): 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php endif; ?>