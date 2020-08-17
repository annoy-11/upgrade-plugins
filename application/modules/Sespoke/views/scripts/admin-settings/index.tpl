<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sespoke/views/scripts/dismiss_message.tpl';?>

<div class='clear'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script type="text/javascript">
  <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespoke.icon')): ?>
  window.addEvent('domready', function () {
    if ($('sespoke_icon_preview-wrapper'))
      $('sespoke_icon_preview-wrapper').style.display = 'none';
  });
  <?php endif; ?>
  //Show choose image 
  function showReadImage(input, id) {
    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG')) {
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