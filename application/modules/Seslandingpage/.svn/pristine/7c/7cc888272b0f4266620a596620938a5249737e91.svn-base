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
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des10wid6_wrapper">
	<div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <div class="seslp_des10_head sesbasic_clearfix">
        <h2><?php echo $this->title; ?></h2>
      </div>
    <?php } ?>
    <?php if($this->description) { ?>
      <p class="seslp_des10wid6_des"><?php echo $this->description; ?></p>
    <?php } ?>
    <div class="seslp_des10wid6_row sesbasic_clearfix">
      <?php foreach($this->results as $result) { ?>
        <?php if(isset($result->owner_id)) { ?>
          <?php $user = Engine_Api::_()->getItem('user', $result->owner_id); ?>
        <?php } else if(isset($result->user_id)) { ?>
          <?php $user = Engine_Api::_()->getItem('user', $result->user_id); ?>
        <?php } ?>
        <div class="seslp_des10wid6_list_item">
          <article>
            <div class="seslp_des10wid6_list_item_thumb">
              <a href="<?php echo $result->getHref(); ?>"><span class="seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span></a>
            </div>
            <div class="seslp_des10wid6_list_item_cont sesbasic_clearfix">
              <div class="seslp_des10wid6_list_item_owner_photo">
                <a href="<?php echo $user->getHref(); ?>"><img src="<?php echo $user->getPhotoUrl(); ?>" alt="" /></a>
              </div>
              <div class="seslp_des10wid6_list_item_info">  
                <?php if(in_array('title', $this->showstats)) { ?>
                  <h3><a href="<?php echo $result->getHref(); ?>"><?php echo $result->getTitle(); ?></a></h3>
                <?php } ?>
                <p class="seslp_des10wid6_list_item_stats">
                  <?php if(in_array('creationdate', $this->showstats)) { ?>
                    <span><i class="fa fa-calendar"></i><span><?php echo date('M d, Y',strtotime($result->creation_date));?></span></span>
                  <?php } ?>
                  <?php if(isset($result->location) && $result->location && in_array('location', $this->showstats)) { ?>
                    <span><i class="fa fa-map-marker"></i><span><?php echo $result->location; ?></span></span>
                  <?php } ?>
                </p>
                <?php if(in_array('description', $this->showstats)) { ?>
                  <p class="seslp_des10wid6_list_item_des">
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
          </article>
        </div>
      <?php } ?>
    </div>
	</div>    
</div>