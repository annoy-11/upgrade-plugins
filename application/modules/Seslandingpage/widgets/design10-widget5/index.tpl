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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template10.css'); ?>

<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des10wid5_wrapper">
	<div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <div class="seslp_des10_head sesbasic_clearfix">
        <h2><?php echo $this->title; ?></h2>
      </div>
    <?php } ?>
    <?php if($this->description) { ?>
      <p class="seslp_des10wid5_des"><?php echo $this->description; ?></p>
    <?php } ?>
    <div class="seslp_des10wid5_row sesbasic_clearfix">
      <?php foreach($this->paginator as $user) { ?>
        <?php if(!empty($user->photo_id)): ?>
          <?php $photo = Engine_Api::_()->storage()->get($user->photo_id, '');
          if($photo)
          $photo_url = $photo->getPhotoUrl(); ?>
        <?php else: ?>
          <?php $photo_url = 'application/modules/User/externals/images/nophoto_user_thumb_profile.png'; ?>
        <?php endif; ?>
        <div class="seslp_des10wid5_list_item">
          <div class="seslp_des10wid5_list_item_inner">
            <div class="seslp_des10wid5_list_item_thumb">
              <a href="<?php echo $user->getHref(); ?>"><span class="seslp_animation" style="background-image:url(<?php echo $photo_url ?>);"></span></a>
            </div>
            <div class="seslp_des10wid5_list_item_name">
              <a href="<?php echo $user->getHref() ?>"><?php echo $user->getTitle(); ?></a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
	</div>
</div>