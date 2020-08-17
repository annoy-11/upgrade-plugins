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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template4.css'); ?>


<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des4wid5_wrapper">
	<div class="seslp_des4wid5_container">
    <div class="seslp_des4wid5_members_listings">
      <?php foreach($this->paginator as $user) { ?>
        <?php if(!empty($user->photo_id)): ?>
          <?php $photo = Engine_Api::_()->storage()->get($user->photo_id, '');
          if($photo)
          $photo = $photo->getPhotoUrl(); ?>
        <?php else: ?>
          <?php $photo_url = 'application/modules/User/externals/images/nophoto_user_thumb_profile.png'; ?>
        <?php endif; ?>
        <a title="<?php echo $user->getTitle(); ?>" href="<?php echo $user->getHref(); ?>" class="seslp_animation"><img src="<?php echo $photo ;?>" /></a>
			<?php } ?>
    </div>
    <div class="seslp_des4wid5_content">
      <?php if($this->title): ?>
        <h2><?php echo $this->title; ?></h2>
      <?php endif; ?>
      <p class="seslp_des4wid5_btns">
        <?php if($this->loginbutton) { ?>
          <a href="login" class="seslp_animation"><?php echo $this->translate("Log In") ;?></a>
        <?php } ?>
        <?php if($this->signupbutton) { ?>
          <a href="signup" class="seslp_animation"><?php echo $this->translate("Sign Up"); ?></a>
        <?php } ?>
      </p>
    </div>
  </div>
</div>