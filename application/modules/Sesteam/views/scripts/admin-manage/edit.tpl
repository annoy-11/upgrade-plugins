<?php

/**
* SocialEngineSolutions
*
* @category   Application_Sesteam
* @package    Sesteam
* @copyright  Copyright 2015-2016 SocialEngineSolutions
* @license    http://www.socialenginesolutions.com/license/
* @version    $Id: edit.tpl 2015-02-20 00:00:00 SocialEngineSolutions $
* @author     SocialEngineSolutions
*/

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesteam/views/scripts/dismiss_message.tpl';?>
<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesteam', 'controller' => 'manage', 'action' => 'index'), $this->translate("Back to Manage Site Team"), array('class'=>'sesbasic_icon_back buttonlink')) ?>
<br class="clear" /><br />

<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?>
  <?php $this->headScript()->appendFile('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' . Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.mapApiKey', '')); ?>
  <script type="text/javascript">
    en4.core.runonce.add(function() {
      if (document.getElementById('location')) {
        new google.maps.places.Autocomplete(document.getElementById('location'));
      }
    });
  </script>
<?php } ?>

<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script type="application/javascript">
window.addEvent('load', function(){
	tinymce.execCommand('mceRemoveEditor',true, 'description');
	var desVal = document.getElementById('description').value;
	document.getElementById('description').value = desVal.match(/[^<p>].*[^</p>]/g)[0];
});
</script>
