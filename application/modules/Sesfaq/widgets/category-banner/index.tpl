<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesfaq/externals/styles/styles.css'); ?>

<div class="sesfaq_category_banner sesfaq_bxs">

  <?php 
  if($this->subject->colored_icon) {
    $banner = Engine_Api::_()->storage()->get($this->subject->colored_icon);
    if($banner) {
      $banner = $banner->getPhotoUrl();
  ?>
  <?php } } ?>
	<span class="sesfaq_category_banner_img" <?php if($banner) { ?> style="background-image:url(<?php echo $banner; ?>);" <?php } ?>></span>
  <div class="sesfaq_category_banner_cont">
  	<div>
      <div class="sesfaq_category_banner_cont_inner">
        <div class="sesfaq_category_banner_title"><?php echo $this->subject->title; ?></div>
        <div class="sesfaq_category_banner_des"><?php echo $this->subject->description; ?></div>
      </div>
    </div>
  </div>
</div>