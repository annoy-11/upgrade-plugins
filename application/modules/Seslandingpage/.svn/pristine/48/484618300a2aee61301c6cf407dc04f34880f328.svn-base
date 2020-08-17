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

<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des10wid4_wrapper">
	<div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <div class="seslp_des10_head sesbasic_clearfix">
        <h2><?php echo $this->title; ?></h2>
      </div>
    <?php } ?>
    <?php if($this->description) { ?>
      <p class="seslp_des10wid4_des"><?php echo $this->description; ?></p>
    <?php } ?>
    <div class="seslp_des10wid4_row sesbasic_clearfix">
    	<div class="seslp_des10wid4_column">
        <?php $leftside = 0; ?>
        <?php foreach($this->results as $result) { ?>
          <?php if($leftside < 3) { ?>
            <div class="seslp_des10wid4_list_item sesbasic_clearfix seslp_animation wow slideInLeft" data-wow-duration="1.5s">
              <div class="seslp_des10wid4_list_item_thumb">
                <a href="<?php echo $result->getHref(); ?>"><span class="seslp_animation seslp_des10wid4_list_item_thumb_img" style="background-image:url(<?php echo $result->getPhotoUrl(); ?>);"></span></a>
              </div>
              <div class="seslp_des10wid4_list_item_cont">
                <p class="seslp_des10wid4_list_item_stats">
                  <?php if(in_array('creationdate', $this->showstats)) { ?>
                    <span><i class="fa fa-calendar"></i><span><?php echo date('M d, Y',strtotime($result->creation_date));?></span></span>
                  <?php } ?>
                  <?php if(isset($result->location) && $result->location && in_array('location', $this->showstats)) { ?>
                    <span><i class="fa fa-map-marker"></i><span><a href="javascript:void(0);"><?php echo $result->location; ?></a></span></span>
                  <?php } ?>
                </p>
                <?php if(in_array('title', $this->showstats)) { ?>
                  <h3><a href="<?php echo $result->getHref(); ?>"><?php echo $result->getTitle(); ?></a></h3>
                <?php } ?>
              </div>
            </div>
          <?php  } ?>
        <?php $leftside++; } ?>
      </div>
      <div class="seslp_des10wid4_column">
        <?php $rightSide = 0; ?>
        <?php foreach($this->results as $result) { ?>
          <?php if($rightSide == 3) { ?>
            <div class="seslp_des10wid4_sigl_item wow slideInRight" data-wow-duration="1.7s">
              <div class="seslp_des10wid4_sigl_item_thumb">
                <a href="<?php echo $result->getHref(); ?>"><span class="seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span></a>
              </div>
              <div class="seslp_des10wid4_sigl_item_cont">
                <p class="seslp_des10wid4_sigl_item_date">
                  <?php if(in_array('creationdate', $this->showstats)) { ?><span><?php echo date('M d, Y',strtotime($result->creation_date));?></span>&nbsp;&nbsp;<?php } ?><?php if(in_array('creationdate', $this->showstats) && in_array('category', $this->showstats)) { ?><?php } ?><?php if(isset($result->category_id) && in_array('category', $this->showstats)) {  ?>
                  <?php 
                  $resourceType = explode('_', $this->resourcetype);
                  if($resourceType[0]) {
                  $category = Engine_Api::_()->getItem($resourceType[0].'_category', $result->category_id); ?>
                  <?php if($category) { ?>/&nbsp;&nbsp;<a href="javascript:void(0);"><?php echo $category->getTitle(); ?></a><?php } } } ?>
                </p>
                <?php if(in_array('title', $this->showstats)) { ?>
                  <h3><a href="<?php echo $result->getHref(); ?>"><?php echo $result->getTitle(); ?></a></h3>
                <?php } ?>
                <?php if(isset($result->location) && $result->location && in_array('location', $this->showstats)) { ?>
                  <p class="seslp_des10wid4_sigl_item_stats">
                    <span><i class="fa fa-map-marker"></i><span><?php echo $result->location; ?></span></span>
                  </p>
                <?php } ?>
                <?php if(in_array('description', $this->showstats)) { ?>
                  <p class="seslp_des10wid4_sigl_item_des">
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
              </div>
            </div>
        <?php } $rightSide++;  } ?>
      </div>
    </div>
  </div>
</div>
