<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontentcoverphoto
 * @package    Sescontentcoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-06-020 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
$typeArray = Engine_Api::_()->sescontentcoverphoto()->getResourceTypeData($this->resource_type, $this->subject);
$photo_id = $typeArray['photo_id'];
$user_id = $typeArray['user_id'];
$subject = $this->subject;
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontentcoverphoto/externals/styles/styles.css'); ?>
<?php
if(isset($this->can_edit)){
	$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/jquery.drag-n-crop.css');
  //First, include the Webcam.js JavaScript Library 
  $base_url = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($base_url . 'application/modules/Sesbasic/externals/scripts/webcam.js');
  $this->headScript()->appendFile($base_url . 'application/modules/Sesbasic/externals/scripts/jquery-ui.min.js'); 
  $this->headScript()->appendFile($base_url . 'application/modules/Sesbasic/externals/scripts/imagesloaded.pkgd.js');
  $this->headScript()->appendFile($base_url . 'application/modules/Sesbasic/externals/scripts/jquery.drag-n-crop.js');
}
?>
<?php if($this->type == 1) { ?>
  <?php include APPLICATION_PATH . '/application/modules/Sescontentcoverphoto/widgets/sescontentcoverphoto-cover/_type1.tpl'; ?>
<?php } else if($this->type == 2) { ?>
  <?php include APPLICATION_PATH . '/application/modules/Sescontentcoverphoto/widgets/sescontentcoverphoto-cover/_type2.tpl'; ?>
<?php } else if($this->type == 4) { ?>
  <?php include APPLICATION_PATH . '/application/modules/Sescontentcoverphoto/widgets/sescontentcoverphoto-cover/_type3.tpl'; ?>
<?php } ?>
<?php if($this->is_fullwidth){ ?>
  <script type="application/javascript">
  sesJqueryObject(document).ready(function(){
    var htmlElement = document.getElementsByTagName("body")[0];
    htmlElement.addClass('sescontentcoverphoto_cover_full');
    sesJqueryObject('#global_content').css('padding-top',0);
    sesJqueryObject('#global_wrapper').css('padding-top',0);	
  });
  </script>
<?php } ?>