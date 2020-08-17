<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _gridView2.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<li class="eblog_grid_two" style="width:<?php echo is_numeric($allParams['width_advgrid']) ? $allParams['width_advgrid'].'px' : $allParams['width_advgrid'] ?>;">
  <article>
    <div class="eblog_grid_two_inner eblog_thumb">
      <div class="eblog_grid_thumb" style="height:<?php echo is_numeric($allParams['height_advgrid']) ? $allParams['height_advgrid'].'px' : $allParams['height_advgrid'] ?>;">
        <a href="<?php echo $item->getHref(); ?>" data-url = "<?php echo $item->getType() ?>" class="eblog_thumb_img"><img src="<?php echo $item->getPhotoUrl(); ?>" alt="" align="left" /></a>
        
        <?php echo $this->partial('widgets-data/_labels.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams)); ?>
        
        <?php echo $this->partial('widgets-data/_buttons.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'plusicon' => $allParams['socialshare_enable_gridview2plusicon'], 'sharelimit' => $allParams['socialshare_icon_gridview2limit']));?>
      
      </div>
    </div>
    <div class="eblog_grid_info">
      <div class="eblog_grid_two_header">
      
        <?php echo $this->partial('widgets-data/_category.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'showin' => 1)); ?>

        <?php echo $this->partial('widgets-data/_readTime.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams));?>     
      </div>
     
      <?php echo $this->partial('widgets-data/_title.tpl', 'eblog', array('item' => $item, 'truncation' => $allParams['title_truncation_advgrid2'], 'allParams' => $allParams, 'divclass' => 'eblog_gird_title'));?>

      <?php if(Engine_Api::_()->getApi('core', 'eblog')->allowReviewRating() && in_array('ratingStar', $allParams['show_criteria'])):?>
      
        <?php echo $this->partial('_blogRating.tpl', 'eblog', array('rating' => $item->rating, 'class' => 'eblog_list_rating eblog_list_view_ratting'));?>
      <?php endif;?>
      <div class="eblog_grid_meta_tegs">
        <ul>
          <?php echo $this->partial('widgets-data/_posted_by.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'viewType' => 2)); ?>
          <?php echo $this->partial('widgets-data/_date.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'viewType' => 4));?>
        </ul>
      </div>
    
      <?php echo $this->partial('widgets-data/_description.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'truncation' => $allParams['description_truncation_advgrid'], 'showDes' => 'descriptionadvgrid')); ?>
      
      <div class="eblog_list_stats sesbasic_text_light">
        <?php echo $this->partial('widgets-data/_stats.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'readtime' => 1));?>
      </div>
      
      <?php echo $this->partial('widgets-data/_buttons.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'plusicon' => $allParams['socialshare_enable_gridview2plusicon'], 'sharelimit' => $allParams['socialshare_icon_gridview2limit']));?>
    </div>
  </article>
</li>
