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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template1.css'); ?>
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des1wid6_wrapper">
  <?php if($this->title) { ?>
    <h2 class="seslp_des1wid6_head"><?php echo $this->title; ?></h2>
  <?php } ?>
  <div class="sesbasic_clearfix seslp_des1wid6_members">
  	<div class="seslp_des1wid6_members_container">
      <?php foreach($this->paginator as $user) { ?>
        <?php if(!empty($user->photo_id)): ?>
          <?php $photo = Engine_Api::_()->storage()->get($user->photo_id, '');
          if($photo)
          $photo = $photo->getPhotoUrl(); ?>
        <?php else: ?>
          <?php $photo = 'application/modules/User/externals/images/nophoto_user_thumb_profile.png'; ?>
        <?php endif; ?>
        <a title="<?php echo $user->getTitle(); ?>" href="<?php echo $user->getHref(); ?>" class="seslp_des1wid6_members_thumb"><img src="<?php echo $photo ;?>" /></a>
    	<?php } ?>
    </div>
  </div>
</div>