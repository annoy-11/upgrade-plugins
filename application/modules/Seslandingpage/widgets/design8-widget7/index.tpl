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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template8.css'); ?>

<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des8wid7_wrapper">

  <div class="seslp_des8wid7_listing sesbasic_clearfix">
    <?php foreach($this->paginator as $user) { ?>
      <?php if(!empty($user->photo_id)): ?>
        <?php $photo = Engine_Api::_()->storage()->get($user->photo_id, '');
        if($photo)
        $photo_url = $photo->getPhotoUrl(); ?>
      <?php else: ?>
        <?php $photo_url = 'application/modules/User/externals/images/nophoto_user_thumb_profile.png'; ?>
      <?php endif; ?>
      <div class="seslp_des8wid7_list_item">
        <a href="<?php echo $user->getHref(); ?>" title="<?php echo $user->getTitle(); ?>">
          <span class="seslp_des8wid7_list_item_img seslp_animation" style="background-image:url(<?php echo $photo_url ?>);"></span>
          <span class="seslp_des8wid7_list_item_thumb_overlay seslp_animation"></span>
        </a>
      </div>
    <?php } ?>
  </div>
</div>