<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add-accordion.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sespagebuilder/views/scripts/dismiss_message.tpl';?>

<?php echo $this->htmlLink(array('action' => 'manage-accordions', 'reset' => false), $this->translate("Back to Manage Accordion Menus Items"), array('class'=>'sesbasic_icon_back buttonlink')) ?>
<br /><br />
<div class='clear sesbasic_admin_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>
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