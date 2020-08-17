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
<?php if($this->backgroundimage): ?>
  <?php 
    $photoUrl = $this->baseUrl() . '/' . $this->backgroundimage;
    $backgroundimage = $photoUrl;
  ?>
<?php else: ?>
  <?php 
    $photoUrl = $this->baseUrl() . '/application/modules/Sesspectromedia/externals/images/paralex-background.jpg';
    $backgroundimage = $photoUrl;
  ?>
<?php endif; ?>
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des8wid5_wrapper">
	<div class="seslp_des8wid5_bg" style="background-image:url(<?php echo $backgroundimage ?>)"></div>
  <div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <div class="seslp_des8_head">
        <h2><?php echo $this->title; ?></h2>
      </div>
    <?php } ?>
    <div class="seslp_des8wid5_row">
    	<div class="seslp_des8wid5_col">
        <?php $leftSide = 0; ?>
        <?php foreach($this->results as $result) { ?>
          <?php if($leftSide < 2) { ?>
            <div class="seslp_des8wid5_item">
              <div class="seslp_des8wid5_item_thumb">
                <a href="<?php echo $result->getHref(); ?>"><span class="seslp_des8wid5_item_thumb_img seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span></a>
              </div>
              <div class="seslp_des8wid5_item_cont">
                <?php if(in_array('title', $this->showstats)) { ?>
                  <h3><a href="<?php echo $result->getHref() ?>"><?php echo $result->getTitle(); ?></a></h3>
                <?php } ?>
                <p class="seslp_des8wid5_item_stat">
                  <?php if(isset($result->owner_id) && in_array('ownername', $this->showstats)) { ?>
                    <?php $user = Engine_Api::_()->getItem('user', $result->owner_id); ?>
                    <span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>" ><?php echo $user->getTitle(); ?></a></span></span>
                  <?php } else if(isset($result->user_id) && in_array('ownername', $this->showstats)) { ?>
                    <?php $user = Engine_Api::_()->getItem('user', $result->user_id); ?>
                    <span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>" ><?php echo $user->getTitle(); ?></a></span></span>
                  <?php } ?>
                  <?php if(in_array('creationdate', $this->showstats)) { ?>
                    <span><i class="fa fa-calendar"></i><span><?php echo date('M d, Y',strtotime($result->creation_date));?></span></span>
                  <?php } ?>
                </p>
                <?php if(in_array('readmorebutton', $this->showstats) && $this->readmorebuttontext) { ?>
                  <p class="seslp_des8wid5_item_btn">
                    <a href="<?php echo $result->getHref(); ?>" class="seslp_animation"><?php echo $this->readmorebuttontext; ?></a>
                  </p>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        <?php $leftSide++; } ?>
      </div>
      <div class="seslp_des8wid5_col seslp_des8wid5_col_big">
        <?php $midddle = 0; ?>
        <?php foreach($this->results as $result) { ?>
          <?php if($midddle == 2) { ?>
            <div class="seslp_des8wid5_item">
              <div class="seslp_des8wid5_item_thumb">
                <a href="<?php echo $result->getHref(); ?>"><span class="seslp_des8wid5_item_thumb_img seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span></a>
              </div>
              <div class="seslp_des8wid5_item_cont">
                <?php if(in_array('title', $this->showstats)) { ?>
                  <h3><a href="<?php echo $result->getHref() ?>"><?php echo $result->getTitle(); ?></a></h3>
                <?php } ?>
                <?php if(in_array('description', $this->showstats)) { ?>
                  <p class="seslp_des8wid5_item_des">
                    <?php
                      if(isset($result->description) && !empty($result->description)) {
                        $description = $result->description;
                      } else if(isset($result->body) && !empty($result->body)) {
                        $description = $result->body;
                      }
                      if(strlen(strip_tags($description)) > $this->descriptiontruncation)
                        $description = $this->string()->truncate($this->string()->stripTags(strip_tags($description)), ($this->descriptiontruncation - 3)).'...';
                      else
                        $description = strip_tags($description);
                      echo $description;
                    ?>
                  </p>
                <?php } ?>
                <div class="seslp_des8wid5_item_footer">
                  <p class="seslp_des8wid5_item_big_stats">
                    <?php if(isset($result->owner_id) && in_array('ownername', $this->showstats)) { ?>
                      <?php $user = Engine_Api::_()->getItem('user', $result->owner_id); ?>
                      <span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>" ><?php echo $user->getTitle(); ?></a></span></span>
                    <?php } else if(isset($result->user_id) && in_array('ownername', $this->showstats)) { ?>
                      <?php $user = Engine_Api::_()->getItem('user', $result->user_id); ?>
                      <span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>" ><?php echo $user->getTitle(); ?></a></span></span>
                    <?php } ?>
                    <?php if(in_array('creationdate', $this->showstats)) { ?>
                      <span><i class="fa fa-calendar"></i><span><?php echo date('M d, Y',strtotime($result->creation_date));?></span></span>
                    <?php } ?>
                  </p>
                  <?php if(in_array('readmorebutton', $this->showstats) && $this->readmorebuttontext) { ?>
                    <p class="seslp_des8wid5_item_btn">
                      <a href="<?php echo $result->getHref(); ?>" class="seslp_animation"><?php echo $this->readmorebuttontext; ?></a>
                    </p>
                  <?php } ?>
                </div>  
              </div>
            </div>
          <?php } ?>
        <?php $midddle++; } ?>
      </div>
      <div class="seslp_des8wid5_col">
        <?php $rightSide = 0; ?>
        <?php foreach($this->results as $result) { ?>
          <?php if($rightSide > 2) { ?>
            <div class="seslp_des8wid5_item">
              <div class="seslp_des8wid5_item_thumb">
                <a href="<?php echo $result->getHref(); ?>"><span class="seslp_des8wid5_item_thumb_img seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span></a>
              </div>
              <div class="seslp_des8wid5_item_cont">
                <?php if(in_array('title', $this->showstats)) { ?>
                  <h3><a href="<?php echo $result->getHref() ?>"><?php echo $result->getTitle(); ?></a></h3>
                <?php } ?>
                <p class="seslp_des8wid5_item_stat">
                  <?php if(isset($result->owner_id) && in_array('ownername', $this->showstats)) { ?>
                    <?php $user = Engine_Api::_()->getItem('user', $result->owner_id); ?>
                    <span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>" ><?php echo $user->getTitle(); ?></a></span></span>
                  <?php } else if(isset($result->user_id) && in_array('ownername', $this->showstats)) { ?>
                    <?php $user = Engine_Api::_()->getItem('user', $result->user_id); ?>
                    <span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>" ><?php echo $user->getTitle(); ?></a></span></span>
                  <?php } ?>
                  <?php if(in_array('creationdate', $this->showstats)) { ?>
                    <span><i class="fa fa-calendar"></i><span><?php echo date('M d, Y',strtotime($result->creation_date));?></span></span>
                  <?php } ?>
                </p>
                <?php if(in_array('readmorebutton', $this->showstats) && $this->readmorebuttontext) { ?>
                  <p class="seslp_des8wid5_item_btn">
                    <a href="<?php echo $result->getHref(); ?>" class="seslp_animation"><?php echo $this->readmorebuttontext; ?></a>
                  </p>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        <?php $rightSide++; } ?>
      </div>
    </div>
	</div>
</div>