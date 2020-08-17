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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template7.css'); ?>
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
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des7wid5_wrapper">
	<div class="seslp_des7wid5_bg" style="background-image:url(<?php echo $backgroundimage ?>);"></div>
	<div class="seslp_blocks_container">
    <div class="seslp_des7wid5_row sesbasic_clearfix">
      <div class="seslp_des7wid5_column seslp_des7wid5_middle">
        <?php if($this->firstblockheading) { ?>
          <h2><?php echo $this->firstblockheading; ?></h2>
        <?php } ?>
        <?php foreach($this->firstblockresults as $firstblockresult) { ?>
          <div class="seslp_des7wid5_list_item sesbasic_clearfix">
            <div class="seslp_des7wid5_list_item_img">
              <a href="<?php echo $firstblockresult->getHref(); ?>"><span class="seslp_animation" style="background-image:url(<?php echo $firstblockresult->getPhotoUrl('thumb.icon'); ?>"></span></a>
            </div>
            <?php if($this->firstblockfonticon) { ?>
              <div class="seslp_des7wid5_list_item_icon"><i class="fa <?php echo $this->firstblockfonticon; ?>"></i></div>
            <?php } ?>
            <?php if($this->firstblockshowstats) { ?>
              <div class="seslp_des7wid5_list_item_cont">
                <?php if(in_array('title', $this->firstblockshowstats)) { ?>
                  <h3><a href="<?php echo $firstblockresult->getHref(); ?>"><?php echo $firstblockresult->getTitle(); ?></a></h3>
                <?php } ?>
                <p><?php echo $this->translate("by "); ?>
                  <?php if(isset($firstblockresult->owner_id) && in_array('ownername', $this->firstblockshowstats)) { ?>
                    <?php $user = Engine_Api::_()->getItem('user', $firstblockresult->owner_id); ?>
                    <a href="<?php echo $user->getHref(); ?>" class="sesbasic_linkinherit"><?php echo $user->getTitle(); ?></a>
                  <?php } else if(isset($firstblockresult->user_id) && in_array('ownername', $this->firstblockshowstats)) { ?>
                    <?php $user = Engine_Api::_()->getItem('user', $firstblockresult->user_id); ?>
                    <a href="<?php echo $user->getHref(); ?>" class="sesbasic_linkinherit"><?php echo $user->getTitle(); ?></a>
                  <?php } ?>
                </p>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
      
      <div class="seslp_des7wid5_column seslp_des7wid5_middle">
        <?php if($this->secondblockheading) { ?>
          <h2><?php echo $this->secondblockheading; ?></h2>
        <?php } ?>
        <?php foreach($this->secondblockresults as $secondblockresult) { ?>
          <div class="seslp_des7wid5_list_item sesbasic_clearfix">
            <div class="seslp_des7wid5_list_item_img">
              <a href="<?php echo $secondblockresult->getHref(); ?>"><span class="seslp_animation" style="background-image:url(<?php echo $secondblockresult->getPhotoUrl('thumb.icon'); ?>"></span></a>
            </div>
            <?php if($this->secondblockfonticon) { ?>
              <div class="seslp_des7wid5_list_item_icon"><i class="fa <?php echo $this->secondblockfonticon; ?>"></i></div>
            <?php } ?>
            <?php if($this->secondblockshowstats) { ?>
              <div class="seslp_des7wid5_list_item_cont">
                <?php if(in_array('title', $this->secondblockshowstats)) { ?>
                  <h3><a href="<?php echo $secondblockresult->getHref(); ?>"><?php echo $secondblockresult->getTitle(); ?></a></h3>
                <?php } ?>
                <p><?php echo $this->translate("by "); ?>
                  <?php if(isset($secondblockresult->owner_id) && in_array('ownername', $this->secondblockshowstats)) { ?>
                    <?php $user = Engine_Api::_()->getItem('user', $secondblockresult->owner_id); ?>
                    <a href="<?php echo $user->getHref(); ?>" class="sesbasic_linkinherit"><?php echo $user->getTitle(); ?></a>
                  <?php } else if(isset($secondblockresult->user_id) && in_array('ownername', $this->secondblockshowstats)) { ?>
                    <?php $user = Engine_Api::_()->getItem('user', $secondblockresult->user_id); ?>
                    <a href="<?php echo $user->getHref(); ?>" class="sesbasic_linkinherit"><?php echo $user->getTitle(); ?></a>
                  <?php } ?>
                </p>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
      
      <div class="seslp_des7wid5_column seslp_des7wid5_middle">
        <?php if($this->thirdblockheading) { ?>
          <h2><?php echo $this->thirdblockheading; ?></h2>
        <?php } ?>
        <?php foreach($this->thirdblockresults as $thirdblockresult) { ?>
          <div class="seslp_des7wid5_list_item sesbasic_clearfix">
            <div class="seslp_des7wid5_list_item_img">
              <a href="<?php echo $thirdblockresult->getHref(); ?>"><span class="seslp_animation" style="background-image:url(<?php echo $thirdblockresult->getPhotoUrl('thumb.icon'); ?>"></span></a>
            </div>
            <?php if($this->thirdblockfonticon) { ?>
              <div class="seslp_des7wid5_list_item_icon"><i class="fa <?php echo $this->thirdblockfonticon; ?>"></i></div>
            <?php } ?>
            <?php if($this->thirdblockshowstats) { ?>
              <div class="seslp_des7wid5_list_item_cont">
                <?php if(in_array('title', $this->thirdblockshowstats)) { ?>
                  <h3><a href="<?php echo $thirdblockresult->getHref(); ?>"><?php echo $thirdblockresult->getTitle(); ?></a></h3>
                <?php } ?>
                <p><?php echo $this->translate("by "); ?>
                  <?php if(isset($thirdblockresult->owner_id) && in_array('ownername', $this->thirdblockshowstats)) { ?>
                    <?php $user = Engine_Api::_()->getItem('user', $thirdblockresult->owner_id); ?>
                    <a href="<?php echo $user->getHref(); ?>" class="sesbasic_linkinherit"><?php echo $user->getTitle(); ?></a>
                  <?php } else if(isset($thirdblockresult->user_id) && in_array('ownername', $this->thirdblockshowstats)) { ?>
                    <?php $user = Engine_Api::_()->getItem('user', $thirdblockresult->user_id); ?>
                    <a href="<?php echo $user->getHref(); ?>" class="sesbasic_linkinherit"><?php echo $user->getTitle(); ?></a>
                  <?php } ?>
                </p>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>

    </div>
  </div>
</div>
