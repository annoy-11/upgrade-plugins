<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seseventmusic/externals/styles/styles.css'); ?>
<script type="text/javascript">
window.addEvent('domready', function() {
  <?php if(empty($this->albumsong->photo_id)): ?>
  if($('song_mainphoto_preview-wrapper'))
  $('song_mainphoto_preview-wrapper').style.display = 'none';
  <?php endif; ?>
  <?php if(empty($this->albumsong->song_cover)): ?>
  if($('song_cover_preview-wrapper'))
  $('song_cover_preview-wrapper').style.display = 'none';
  <?php endif; ?>
});

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
</script>
<div class="seseventmusic_editsong_form">
  <?php echo $this->form->render(); ?>
</div>
<script type="text/javascript">
  $$('.core_main_seseventmusic').getParent().addClass('active');
</script>