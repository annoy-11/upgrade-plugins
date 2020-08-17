<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/styles.css'); ?>

<div class="sesqa_category_banner sesbasic_bxs">

  <?php 
  if($this->subject->thumbnail) {
    $banner = Engine_Api::_()->storage()->get($this->subject->thumbnail);
    if($banner) {
      $banner = $banner->getPhotoUrl();
  ?>
  <?php } } ?>
	<span class="sesqa_category_banner_img" <?php if($banner) { ?> style="background-image:url(<?php echo $banner; ?>);" <?php } ?>></span>
  <div class="sesqa_category_banner_cont">
  	<div>
      <div class="sesqa_category_banner_cont_inner">
        <div class="sesqa_category_banner_title"><?php echo $this->subject->title; ?></div>
        <div class="sesqa_category_banner_des"><?php echo $this->subject->description; ?></div>
      </div>
    </div>
  </div>
</div>