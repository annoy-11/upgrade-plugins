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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template9.css'); ?>
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
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des9wid3_wrapper">
	<div class="seslp_des9wid3_bg" style="background-image:url(<?php echo $backgroundimage ?>);"></div>
	<div class="seslp_blocks_container">
  	<div class="seslp_des9wid3_row sesbasic_clearfix">
  	
    	<div class="seslp_des9wid3_column seslp_des9wid3_column_l wow slideInLeft"  data-wow-duration="1.5s">
        <?php if($this->leftsideheading) { ?>
          <h2><?php echo $this->leftsideheading; ?></h2>
      	<?php } ?>
      	<?php if($this->leftsidedescription) { ?>
          <p>
            <?php echo $this->leftsidedescription; ?>
          </p>
        <?php } ?>
        <div class="seslp_des9wid3_cont_list sesbasic_clearfix">
          <?php foreach($this->leftsideresults as $result) { ?>
            <div class="seslp_des9wid3_cont_list_item">
              <a href="<?php echo $result->getHref(); ?>" class="sesbasic_clearfix">
                <div class="seslp_des9wid3_cont_list_item_img">
                  <img src="<?php echo $result->getPhotoUrl('thumb.icon'); ?>" />
                </div>
                <?php if($this->leftsidefonticon) { ?>
                  <div class="seslp_des9wid3_cont_list_item_icon">
                    <i class="fa <?php echo $this->leftsidefonticon; ?> seslp_animation"></i>
                  </div>
                <?php } ?>
                <div class="seslp_des9wid3_cont_list_item_cont">
                  <h3 class="seslp_animation"><?php echo $result->getTitle(); ?></h3>
                  <?php if(isset($result->owner_id)) { ?>
                    <?php $user = Engine_Api::_()->getItem('user', $result->owner_id); ?>
                    <p><?php echo $user->getTitle(); ?></p>
                  <?php } else if(isset($result->user_id)) { ?>
                    <?php $user = Engine_Api::_()->getItem('user', $result->user_id); ?>
                    <p><?php echo $user->getTitle(); ?></p>
                  <?php } ?>
                </div>
              </a>  
            </div>
          <?php } ?>
        </div>
        <?php if($this-leftsideseeallbuttontext && $this->leftsideseeallbuttonurl) { ?>
          <div class="seslp_des9wid3_cont_more">
            <a href="<?php echo $this->leftsideseeallbuttonurl; ?>" class="seslp_animation"><?php echo $this->leftsideseeallbuttontext; ?></a>
          </div>
        <?php } ?>
      </div>
      
      
    	<div class="seslp_des9wid3_column seslp_des9wid3_column_r wow slideInRight"  data-wow-duration="1.5s">
        <?php if($this->rightsideheading) { ?>
          <h2><?php echo $this->rightsideheading; ?></h2>
      	<?php } ?>
      	<?php if($this->rightsidedescription) { ?>
          <p><?php echo $this->rightsidedescription; ?></p>
        <?php } ?>
        <div class="seslp_des9wid3_cont_grid sesbasic_clearfix">
          <?php foreach($this->rightsideresults as $rightsideresult) { ?>
            <div class="seslp_des9wid3_cont_grid_item">
              <a title="<?php echo $result->getTitle(); ?>" href="<?php echo $rightsideresult->getHref(); ?>">
                <span class="seslp_des9wid3_cont_grid_item_img seslp_animation" style="background-image:url(<?php echo $rightsideresult->getPhotoUrl() ?>);"></span>
                <?php if($this->rightsidefonticon) { ?>
                  <span class="seslp_des9wid3_cont_grid_item_overlay seslp_animation"><i class="fa <?php echo $this->rightsidefonticon; ?> seslp_animation"></i></span>
                <?php } ?>
              </a>
            </div>
          <?php } ?>
        </div>
        <?php if($this->rightsideseeallbuttontext && $this->rightsideseeallbuttonurl) { ?>
          <div class="seslp_des9wid3_cont_more">
            <a href="<?php echo $this->rightsideseeallbuttonurl; ?>" class="seslp_animation"><?php echo $this->rightsideseeallbuttontext; ?></a>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
