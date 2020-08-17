<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template5.css'); ?>
  <?php if($this->backgroundimage): ?>
    <?php 
      $photoUrl = Engine_Api::_()->seslandingpage()->getFileUrl($this->backgroundimage);
      $backgroundimage = $photoUrl;
    ?>
  <?php else: ?>
    <?php 
      $photoUrl = $this->baseUrl() . '/application/modules/Sesspectromedia/externals/images/paralex-background.jpg';
      $backgroundimage = $photoUrl;
    ?>
  <?php endif; ?>
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des5wid5_wrapper">
	<div class="seslp_des5wid5_bg" style="background-image:url(<?php echo $backgroundimage ?>)"></div>
	<div class="seslp_blocks_container">
  	<div class="seslp_des5wid_head sesbasic_clearfix">
      <?php if($this->title) { ?>
  		<h2><?php echo $this->title; ?></h2>
  		<?php } ?>
  		<?php if($this->seeallbuttontext && $this->seeallbuttonurl) { ?>
        <span class="seslp_des5wid_head_btn"><a href="<?php echo $this->seeallbuttonurl; ?>" class="seslp_animation"><?php echo $this->seeallbuttontext; ?></a></span>
    	<?php } ?>
    </div>
    <div class="seslp_des5wid5_listings sesbasic_clearfix">
      <?php foreach($this->results as $result) { ?>
        <div class="seslp_des5wid5_list_item sesbasic_clearfix">
          <article>
            <div class="seslp_des5wid5_list_item_thumb">
              <span class="seslp_des5wid5_list_item_thumb_img seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span>
              <a href="<?php echo $result->getHref(); ?>" class="seslp_des5wid5_list_item_thunb_overlay seslp_animation">
                <?php if($this->fonticon) { ?>
                  <i class="fa <?php echo $this->fonticon ?> seslp_animation"></i>
                <?php } ?>
              </a>
            </div>
          </article>	
        </div>
      <?php } ?>
    </div>
  </div>
</div>
