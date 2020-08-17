<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercovervideo
 * @package    Sesusercovervideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: upload-icon.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesusercovervideo/externals/styles/styles.css'); ?>
<div class="sesusercovervideo_video_upload">
  <?php echo $this->form->render($this) ?>
</div>
<script>
  function ValidateSize(file) {
    var FileSize = file.files[0].size / 1024 / 1024; // in MB
    if (FileSize > 20) {
      alert('File size exceeds 20 MB. Please choose another video.');
      $('submit').style.display = 'none';
    } else {
      $('submit').style.display = 'inline-block';
    }
  }
</script>
