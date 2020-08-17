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


<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des5wid6_wrapper">
	<div class="seslp_blocks_container">
  	<div class="seslp_des5wid_head sesbasic_clearfix">
      <?php if($this->title) { ?>
        <h2><?php echo $this->title; ?></h2>
  		<?php } ?>
  		<?php if($this->seeallbuttontext && $this->seeallbuttonurl) { ?>
        <span class="seslp_des5wid_head_btn"><a href="<?php echo $this->seeallbuttonurl; ?>" class="seslp_animation"><?php echo $this->seeallbuttontext; ?></a></span>
    	<?php } ?>
    </div>
    <div class="seslp_des5wid6_listing sesbasic_clearfix">
    	<?php foreach($this->paginator as $user) { ?>
        <?php if(!empty($user->photo_id)): ?>
          <?php $photo = Engine_Api::_()->storage()->get($user->photo_id, '');
          if($photo)
          $photo_url = $photo->getPhotoUrl(); ?>
        <?php else: ?>
          <?php $photo_url = 'application/modules/User/externals/images/nophoto_user_thumb_profile.png'; ?>
        <?php endif; ?>
        <div class="seslp_des5wid6_list_item">
          <article>
            <div class="seslp_des5wid6_list_item_thumb">
              <a class="seslp_des5wid6_list_item_thumb_img" href="<?php echo $user->getHref(); ?>">
                <span class="seslp_animation" style="background-image:url(<?php echo $photo_url ?>);"></span>
              </a>
            </div>
            <div class="seslp_des5wid6_list_item_info">
              <div class="seslp_des5wid6_list_item_title">
                <a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a>
              </div>
            </div>
          </article>
        </div>
      <?php } ?>
    </div>
  </div>
</div>