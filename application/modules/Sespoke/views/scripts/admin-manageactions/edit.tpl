<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sespoke/views/scripts/dismiss_message.tpl';?>

<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespoke', 'controller' => 'manageactions', 'action' => 'index'), $this->translate("Back to Manage Actions & Gifts"), array('class'=>'buttonlink sespoke_icon_back')) ?>
<br style="clear:both;" /><br />
<div class='clear'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>	
<script>
   //Show choose image 
  function showReadImage(input, id) {
    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG' || ext == 'gif')) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $(id + '-wrapper').style.display = 'block';
        $(id).setAttribute('src', e.target.result);
      }
      $(id + '-wrapper').style.display = 'block';
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>