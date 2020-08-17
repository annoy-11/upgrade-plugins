<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eclassroom/externals/styles/styles.css'); ?>
<?php if($this->viewer()->getIdentity()):?>
 <?php $showFollowButton = 1;?>
<?php endif;?>
<?php if($this->params['viewType'] ==  'icon') {  ?>
  <ul class="eclassroom_cat_iconlist_container sesbasic_clearfix clear sesbasic_bxs <?php echo ($this->params['alignContent'] == 'left' ? 'gridleft' : ($this->params['alignContent'] == 'right' ? 'gridright' : '')) ?>">
    <li class="eclassroom_cat_iconlist_head"><?php echo $this->translate($this->params['titleC']); ?></li>
    <?php foreach( $this->paginator as $item ): ?>
      <?php if($showFollowButton):?>
        <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'courses')->isFollow(array('resource_id' => $item->category_id,'resource_type' => 'eclassroom_category')); ?>
        <?php $followClass = (!$followStatus) ? 'fa-check' : 'fa-times' ;?>
        <?php $followText = ($followStatus) ?  $this->translate('Unfollow') : $this->translate('Follow');?>
      <?php endif;?>
      <li class="eclassroom_cat_iconlist <?php if($this->params['shapeType'] == 'circle'){?>_isround<?php } ?>" style="height:<?php echo is_numeric($this->params['height']) ? $this->params['height'].'px' : $this->params['height'] ?>;width:<?php echo is_numeric($this->params['width']) ? $this->params['width'].'px' : $this->params['width'] ?>;">
          <a href="<?php echo $item->getHref(); ?>">        
          <span class="eclassroom_cat_iconlist_icon" style="background-color:<?php if($this->params['show_bg_color'] == '2'){?><?php echo $item->color ? '#'.$item->color : '#fff'; ?><?php } ?><?php if($this->params['show_bg_color'] == '1'){ ?><?php echo $this->params['bgColor']; ?><?php }?>;">
            <?php if($item->colored_icon != '' && !is_null($item->colored_icon) && intval($item->colored_icon)){ ?>
              <img src="<?php echo  Engine_Api::_()->storage()->get($item->colored_icon)->getPhotoUrl(); ?>" />
            <?php }else{ ?>
              <img src="application/modules/Eclassroom/externals/images/classroom-category-icon.png" />
            <?php } ?>
          </span>
        <?php if($this->title){ ?>
          <span class="eclassroom_cat_iconlist_title"><?php echo $this->translate($item->category_name); ?></span>
        <?php } ?>
        <?php if(isset($this->countClassrooms)){ ?>
          <span class="eclassroom_cat_iconlist_count"><?php echo $this->translate(array('%s classroom', '%s classrooms', $item->total_classroom_categories), $this->locale()->toNumber($item->total_classroom_categories))?></span>
        <?php } ?>
      </a>
        <?php if(isset($this->followButton)):?>
          <span class="eclassroom_cat_iconlist_btn sesbasic_animation">
            <a href="javascript:void(0);" data-type='eclassroom_category_follow' data-url='<?php echo $item->category_id; ?>'  data-status='<?php echo $followStatus;?>' class="sesbasic_animation courses_link_btn eclassroom_likefavfollow eclassroom_category_follow_<?php echo $item->category_id;?>"><i class="fa <?php echo $followClass; ?>"></i><span><?php echo $followText; ?></span></a>
          </span>
        <?php endif;?>
      </li>
    <?php endforeach; ?>
    <?php  if(  count($this->paginator) == 0){  ?>
      <div class="tip"> <span> <?php echo $this->translate('No categories found.');?> </span> </div>
    <?php } ?>
  </ul>
<?php } else if($this->params['viewType'] ==  'image') { ?>
<ul class="eclassroom_category_grid_listing sesbasic_clearfix clear sesbasic_bxs <?php echo ($this->params['alignContent'] == 'left' ? 'gridleft' : ($this->params['alignContent'] == 'right' ? 'gridright' : '')) ?>">
  <li class="eclassroom_cat_iconlist_head sesbm"><?php echo $this->params['titleC']; ?></li>
  <?php foreach( $this->paginator as $item ): ?>
  <li class="eclassroom_category_grid sesbm <?php if($this->params['shapeType'] == 'circle'){?>_isround<?php } ?>" style="height:<?php echo is_numeric($this->params['height']) ? $this->params['height'].'px' : $this->params['height'] ?>;width:<?php echo is_numeric($this->params['width']) ? $this->params['width'].'px' : $this->params['width'] ?>;">
  	<a href="<?php echo $item->getHref(); ?>">
      <div class="eclassroom_category_grid_img">
        <?php if($item->thumbnail != '' && !is_null($item->thumbnail) && intval($item->thumbnail)){ ?>
        <span class="eclassroom_animation" style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($item->thumbnail)->getPhotoUrl('thumb.thumb'); ?>);"></span>
        <?php } ?>
      </div>
      <div class="eclassroom_category_grid_overlay courses_animation"></div>
      <div class="eclassroom_category_grid_info">
        <div>
          <div class="eclassroom_category_grid_details sesbasic_animation">
            <?php if($this->title){ ?>
              <span><?php echo $this->translate($item->category_name); ?></span>
            <?php } ?>
            <?php if($this->countClassrooms){ ?>
              <span class="eclassroom_category_grid_stats"><?php echo $this->translate(array('%s classroom', '%s classrooms', $item->total_classroom_categories), $this->locale()->toNumber($item->total_classroom_categories))?></span>
            <?php } ?>
          </div>
        </div>
      </div>
    </a>
    <?php if($showFollowButton && isset($this->followButton)):?>
      <span class="eclassroom_category_grid_btn sesbasic_animation">
        <a href='javascript:;' data-type='cls_category_follow'  data-url='<?php echo $item->category_id; ?>'  data-status='<?php echo $followStatus;?>' class="sesbasic_animation courses_likefavfollow cls_category_follow_<?php echo $item->category_id; ?>"><i class='fa <?php echo $followClass ; ?>'></i><span><?php echo $followText; ?></span></a>
      </span>
    <?php endif;?>
  </li>
  <?php endforeach; ?>
  <?php  if(  count($this->paginator) == 0){  ?>
  	<div class="tip"> <span> <?php echo $this->translate('No categories found.');?> </span> </div>
  <?php } ?>
</ul>
<?php } else if($this->params['viewType'] ==  'both') { ?>
<ul class="eclassroom_category_grid_listing sesbasic_clearfix clear sesbasic_bxs <?php echo ($this->params['alignContent'] == 'left' ? 'gridleft' : ($this->params['alignContent'] == 'right' ? 'gridright' : '')) ?>">
  <li class="eclassroom_cat_iconlist_head sesbm"><?php echo $this->params['titleC']; ?></li>
  <?php foreach( $this->paginator as $item ): ?>
  <li class="eclassroom_category_grid sesbm <?php if($this->params['shapeType'] == 'circle'){?>_isround<?php } ?>" style="height:<?php echo is_numeric($this->params['height']) ? $this->params['height'].'px' : $this->params['height'] ?>;width:<?php echo is_numeric($this->params['width']) ? $this->params['width'].'px' : $this->params['width'] ?>;">
  	<a href="<?php echo $item->getHref(); ?>">
      <div class="eclassroom_category_grid_img">
         <span class="eclassroom_cat_iconlist_icon" style="background-color:<?php if($this->params['show_bg_color'] == '2'){?><?php echo $item->color ? '#'.$item->color : '#999'; ?><?php } ?><?php if($this->params['show_bg_color'] == '1'){ ?><?php echo $this->params['bgColor']; ?><?php }?>;">
            <?php if($item->colored_icon != '' && !is_null($item->colored_icon) && intval($item->colored_icon)){ ?>
              <img src="<?php echo  Engine_Api::_()->storage()->get($item->colored_icon)->getPhotoUrl(); ?>" />
            <?php }else{ ?>
              <img src="application/modules/Courses/externals/images/classroom-icon-big.png" />
            <?php } ?>
          </span>
        <?php if($item->thumbnail != '' && !is_null($item->thumbnail) && intval($item->thumbnail)){ ?>
        <span class="eclassroom_animation" style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($item->thumbnail)->getPhotoUrl('thumb.thumb'); ?>);"></span>
        <?php } ?>
      </div>
      <div class="eclassroom_category_grid_overlay courses_animation"></div>
      <div class="eclassroom_category_grid_info">
        <div>
          <div class="eclassroom_category_grid_details sesbasic_animation">
            <?php if($this->title){ ?>
              <span><?php echo $this->translate($item->category_name); ?></span>
            <?php } ?>
            <?php if($this->countClassrooms){ ?>
              <span class="eclassroom_category_grid_stats"><?php echo $this->translate(array('%s classroom', '%s classrooms', $item->total_classroom_categories), $this->locale()->toNumber($item->total_classroom_categories))?></span>
            <?php } ?>
          </div>
        </div>
      </div>
    </a>
    <?php if($showFollowButton && isset($this->followButton)):?>
      <span class="eclassroom_category_grid_btn sesbasic_animation">
        <a href='javascript:;'  data-type='cls_category_follow' data-url='<?php echo $item->category_id; ?>'  data-status='<?php echo $followStatus;?>' class="sesbasic_animation courses_likefavfollow cls_category_follow_<?php echo $item->category_id; ?>"><i class='fa <?php echo $followClass ; ?>'></i><span><?php echo $followText; ?></span></a>
      </span>
    <?php endif;?>
  </li>
  <?php endforeach; ?>
  <?php  if(  count($this->paginator) == 0){  ?>
  	<div class="tip"> <span> <?php echo $this->translate('No categories found.');?> </span> </div>
  <?php } ?>
</ul>
<?php } ?>
