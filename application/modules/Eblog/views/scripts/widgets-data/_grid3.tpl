<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _advgridView.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<li class="eblog_grid_three sesbasic_bxs <?php if((isset($this->my_blogs) && $this->my_blogs)){ ?>isoptions<?php } ?>" style="width:<?php echo is_numeric($allParams['width_advgrid2']) ? $allParams['width_advgrid2'].'px' : $allParams['width_advgrid2'] ?>;">
  <div class="eblog_grid_inner">
		<div class="eblog_grid_thumb eblog_thumb" style="height:<?php echo is_numeric($allParams['height_advgrid2']) ? $allParams['height_advgrid2'].'px' : $allParams['height_advgrid2'] ?>;">
			<a href="<?php echo $item->getHref(); ?>" data-url = "<?php echo $item->getType() ?>" class="eblog_thumb_img"><span style="background-image:url(<?php echo $item->getPhotoUrl(); ?>);"></span></a>
			
			<?php echo $this->partial('widgets-data/_labels.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams)); ?>
			
			<?php echo $this->partial('widgets-data/_buttons.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'plusicon' => $allParams['socialshare_enable_gridview3plusicon'], 'sharelimit' => $allParams['socialshare_icon_gridview3limit']));?>
		</div>
		<div class="eblog_grid_info clear clearfix sesbm">
			<div class="eblog_grid_meta_block">
        <div class="eblog_gird-top_blog">
          <?php echo $this->partial('widgets-data/_posted_by.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'viewType' => 3)); ?>
          
          <?php echo $this->partial('widgets-data/_date.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'viewType' => 5));?>
          
          <?php echo $this->partial('widgets-data/_category.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams)); ?>
        
          <?php echo $this->partial('widgets-data/_readTime.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams)); ?>
        </div>
			</div>
			
			<?php if(Engine_Api::_()->getApi('core', 'eblog')->allowReviewRating() && in_array('ratingStar', $allParams['show_criteria'])):?>
        <?php echo $this->partial('_blogRating.tpl', 'eblog', array('rating' => $item->rating, 'class' => 'eblog_list_rating eblog_list_view_ratting floatR'));?>
      <?php endif;?>
				
      <?php echo $this->partial('widgets-data/_title.tpl', 'eblog', array('item' => $item, 'truncation' => $allParams['title_truncation_advgrid'], 'allParams' => $allParams, 'divclass' => 'eblog_grid_three_info_title'));?>
			
			<?php echo $this->partial('widgets-data/_description.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'truncation' => $allParams['description_truncation_supergrid'], 'showDes' => 'descriptionsupergrid')); ?>
			
			<?php echo $this->partial('widgets-data/_readmore.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams));?>

      <div class="eblog_grid_three_footer">
        <div class="eblog_list_stats sesbasic_text_light">
          <?php echo $this->partial('widgets-data/_stats.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'readtime' => 1));?>
        </div>
        <?php echo $this->partial('widgets-data/_buttons.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'plusicon' => $allParams['socialshare_enable_gridview3plusicon'], 'sharelimit' => $allParams['socialshare_icon_gridview3limit']));?>
      </div>
		</div>
	</div>
</li>
