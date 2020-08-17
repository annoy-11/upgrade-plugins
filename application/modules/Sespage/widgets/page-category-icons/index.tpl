<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/styles.css'); ?>
<?php if($this->viewer()->getIdentity()):?>
 <?php $showFollowButton = 1;?>
<?php endif;?>
<?php if($this->params['viewType'] ==  'icon'):?>
  <ul class="sespage_cat_iconlist_container sesbasic_clearfix clear sesbasic_bxs <?php echo ($this->params['alignContent'] == 'left' ? 'gridleft' : ($this->params['alignContent'] == 'right' ? 'gridright' : '')) ?>">
    <li class="sespage_cat_iconlist_head"><?php echo $this->translate($this->params['titleC']); ?></li>
    <?php foreach( $this->paginator as $item ): ?>
      <?php if($showFollowButton):?>
        <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'sespage')->isFollow(array('resource_id' => $item->category_id,'resource_type' => 'sespage_category')); ?>
        <?php $followClass = (!$followStatus) ? 'fa-check' : 'fa-times' ;?>
        <?php $followText = ($followStatus) ?  $this->translate('Unfollow') : $this->translate('Follow');?>
      <?php endif;?>
      <li class="sespage_cat_iconlist <?php if($this->params['shapeType'] == 'circle'){?>_isround<?php } ?>" style="height:<?php echo is_numeric($this->params['height']) ? $this->params['height'].'px' : $this->params['height'] ?>;width:<?php echo is_numeric($this->params['width']) ? $this->params['width'].'px' : $this->params['width'] ?>;">
          <a href="<?php echo $item->getHref(); ?>">        
          <span class="sespage_cat_iconlist_icon" style="background-color:<?php if($this->params['show_bg_color'] == '2'){?><?php echo $item->color ? '#'.$item->color : '#999'; ?><?php } ?><?php if($this->params['show_bg_color'] == '1'){ ?><?php echo $this->params['bgColor']; ?><?php }?>;">
            <?php if($item->colored_icon != '' && !is_null($item->colored_icon) && intval($item->colored_icon)){ ?>
              <img src="<?php echo  Engine_Api::_()->storage()->get($item->colored_icon)->getPhotoUrl(); ?>" />
            <?php }else{ ?>
              <img src="application/modules/Sespage/externals/images/page-icon-big.png" />
            <?php } ?>
          </span>
        <?php if(isset($this->params['title'])){ ?>
          <span class="sespage_cat_iconlist_title"><?php echo $this->translate($item->category_name); ?></span>
        <?php } ?>
        <?php if(isset($this->params['countPages'])){ ?>
          <span class="sespage_cat_iconlist_count"><?php echo $this->translate(array('%s page', '%s pages', $item->total_page_categories), $this->locale()->toNumber($item->total_page_categories))?></span>
        <?php } ?>
      </a>
        <?php if(isset($this->followButtonActive)):?>
          <span class="sespage_cat_iconlist_btn sesbasic_animation">
            <a href="" class="sesbasic_link_btn"><i class="fa fa-check"></i><span>Follow</span></a>
          </span>
        <?php endif;?>
      </li>
    <?php endforeach; ?>
    <?php  if(  count($this->paginator) == 0){  ?>
      <div class="tip"> <span> <?php echo $this->translate('No categories found.');?> </span> </div>
    <?php } ?>
  </ul>
<?php else:?>
<ul class="sespage_category_grid_listing sesbasic_clearfix clear sesbasic_bxs <?php echo ($this->params['alignContent'] == 'left' ? 'gridleft' : ($this->params['alignContent'] == 'right' ? 'gridright' : '')) ?>">
  <li class="sespage_cat_iconlist_head sesbm"><?php echo $this->params['titleC']; ?></li>
  <?php foreach( $this->paginator as $item ): ?>
  <li class="sespage_category_grid sesbm <?php if($this->params['shapeType'] == 'circle'){?>_isround<?php } ?>" style="height:<?php echo is_numeric($this->params['height']) ? $this->params['height'].'px' : $this->params['height'] ?>;width:<?php echo is_numeric($this->params['width']) ? $this->params['width'].'px' : $this->params['width'] ?>;">
  	<a href="<?php echo $item->getHref(); ?>">
      <div class="sespage_category_grid_img">
        <?php if($item->thumbnail != '' && !is_null($item->thumbnail) && intval($item->thumbnail)){ ?>
        <span class="sespage_animation" style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($item->thumbnail)->getPhotoUrl('thumb.thumb'); ?>);"></span>
        <?php } ?>
      </div>
      <div class="sespage_category_grid_overlay sespage_animation"></div>
      <div class="sespage_category_grid_info">
        <div>
          <div class="sespage_category_grid_details sesbasic_animation">
            <?php if(isset($this->params['title'])){ ?>
              <span><?php echo $this->translate($item->category_name); ?></span>
            <?php } ?>
            <?php if(isset($this->params['countPages'])){ ?>
              <span class="sespage_category_grid_stats"><?php echo $this->translate(array('%s page', '%s pages', $item->total_page_categories), $this->locale()->toNumber($item->total_page_categories))?></span>
            <?php } ?>
          </div>
        </div>
      </div>
    </a>
    <?php if($showFollowButton && isset($this->followButtonActive)):?>
      <span class="sespage_category_grid_btn sesbasic_animation">
        <a href='javascript:;' data-url='<?php echo $item->category_id; ?>'  data-status='<?php echo $followStatus;?>' class="sesbasic_animation sesbasic_link_btn sespage_category_follow sespage_category_follow_<?php echo $item->category_id; ?>"><i class='fa <?php echo $followClass ; ?>'></i><span><?php echo $followText; ?></span></a>
      </span>
    <?php endif;?>
  </li>
  <?php endforeach; ?>
  <?php  if(  count($this->paginator) == 0){  ?>
  	<div class="tip"> <span> <?php echo $this->translate('No categories found.');?> </span> </div>
  <?php } ?>
</ul>
<?php endif;?>
