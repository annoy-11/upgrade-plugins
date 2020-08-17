<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: welcome.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesbrowserpush/views/scripts/dismiss_message.tpl';
?>
<div class="settings">
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<?php $file = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbrowserpush.welcomeicon',''); ?>
<script type="text/javascript">
  <?php if(empty($file)) { ?>
  window.addEvent('domready', function() {
    if($('cat_icon_preview-wrapper'))
    $('cat_icon_preview-wrapper').style.display = 'none';
  });
  <?php } ?>
//Show choose image 
function showReadImage(input,id) {
  var url = input.value; 
  var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
  if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG')){
    var reader = new FileReader();
    reader.onload = function (e) {
      $(id+'-wrapper').style.display = 'block';
      $(id).setAttribute('src', e.target.result);
    }
    $(id+'-wrapper').style.display = 'block';
    reader.readAsDataURL(input.files[0]);
  }
}

function welcomeSettings(value){
  if(value == 0){
    document.getElementById('sesbrowserpush_welcometitle-wrapper').style.display = 'none';
    document.getElementById('sesbrowserpush_welcomedescription-wrapper').style.display = 'none';
    document.getElementById('sesbrowserpush_welcomelink-wrapper').style.display = 'none';
    document.getElementById('icon-wrapper').style.display = 'none';
    if(document.getElementById('cat_icon_preview-wrapper'))
      document.getElementById('cat_icon_preview-wrapper').style.display = 'none';
    if(document.getElementById('remove_icon_icon-wrapper'))
      document.getElementById('remove_icon_icon-wrapper').style.display = 'none';
  }else{
    document.getElementById('sesbrowserpush_welcometitle-wrapper').style.display = 'block';
    document.getElementById('sesbrowserpush_welcomedescription-wrapper').style.display = 'block';
    document.getElementById('sesbrowserpush_welcomelink-wrapper').style.display = 'block';
    document.getElementById('icon-wrapper').style.display = 'block';  
    if(document.getElementById('cat_icon_preview-wrapper'))
      document.getElementById('cat_icon_preview-wrapper').style.display = 'block';
    if(document.getElementById('remove_icon_icon-wrapper'))
      document.getElementById('remove_icon_icon-wrapper').style.display = 'block';
  }
}
welcomeSettings(<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbrowserpush.welcomeenable','1'); ?>);
</script>
