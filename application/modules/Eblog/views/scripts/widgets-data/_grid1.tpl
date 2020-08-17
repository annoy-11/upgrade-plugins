<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _gridView.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<li class="eblog_grid sesbasic_bxs <?php if((isset($this->my_blogs) && $this->my_blogs)){ ?>isoptions<?php } ?>" style="width:<?php echo is_numeric($allParams['width_grid']) ? $allParams['width_grid'].'px' : $allParams['width_grid'] ?>;">
  <article>
    <div class="eblog_grid_inner eblog_thumb">
      <div class="eblog_grid_thumb" style="height:<?php echo is_numeric($allParams['height_grid']) ? $this->height_grid.'px' : $allParams['height_grid'] ?>;">
        <a href="<?php echo $item->getHref(); ?>" data-url = "<?php echo $item->getType() ?>" class="eblog_thumb_img"> <span style="background-image:url(<?php echo $item->getPhotoUrl(); ?>);"></span> </a>
        
        <?php echo $this->partial('widgets-data/_labels.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams)); ?>
      </div>
      <div>
        <div class="eblog_grid_info clear clearfix sesbm">
          <div class="eblog_grid_one_header">
            <?php echo $this->partial('widgets-data/_category.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'showin' => 1)); ?>
              
            <?php echo $this->partial('widgets-data/_readTime.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams));?>
          </div>
          <?php echo $this->partial('widgets-data/_title.tpl', 'eblog', array('item' => $item, 'truncation' => $allParams['title_truncation_grid'], 'allParams' => $allParams, 'divclass' => 'eblog_grid_info_title'));?>

          <?php if(Engine_Api::_()->getApi('core', 'eblog')->allowReviewRating() && in_array('ratingStar', $allParams['show_criteria'])):?>
            <?php echo $this->partial('_blogRating.tpl', 'eblog', array('rating' => $item->rating, 'class' => 'eblog_list_rating eblog_list_view_ratting', 'style' => ''));?>
          <?php endif;?>
          
          <div class="eblog_grid_meta_block">
            <?php echo $this->partial('widgets-data/_posted_by.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'viewType' => 2)); ?>
          </div>
        </div>
        <div class="eblog_grid_one_footer">
          <?php echo $this->partial('widgets-data/_date.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'viewType' => 4));?>
        
          <div class="eblog_list_stats sesbasic_text_light">
            <?php echo $this->partial('widgets-data/_stats.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'readtime' => 1));?>
          </div>
        </div>
      
        <?php echo $this->partial('widgets-data/_buttons.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'plusicon' => $allParams['socialshare_enable_gridview1plusicon'], 'sharelimit' => $allParams['socialshare_icon_gridview1limit']));?>
      </div>
  </article>
</li>
