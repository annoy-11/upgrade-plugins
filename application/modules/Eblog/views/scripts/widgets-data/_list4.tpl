<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _advlistView2.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<li class="eblog_list_fourth_blog sesbasic_clearfix clear">
  <div class="eblog_list_full_thumb eblog_list_thumb eblog_thumb">
    <a href="<?php echo $item->getHref(); ?>" data-url = "<?php echo $item->getType() ?>" class="<?php echo $item->getType() != 'eblog_chanel' ? 'eblog_thumb_img' : 'eblog_thumb_nolightbox' ?>">
      <img src="<?php echo $item->getPhotoUrl(); ?>" alt="" align="left" style="max-height:350px;" /></a>
      
      <?php echo $this->partial('widgets-data/_labels.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams)); ?>
    </div>
    <div class="eblog_list_full_view_info">
    <div class="eblog_list_fourth_blog_meta">
      <ul>
        <?php echo $this->partial('widgets-data/_posted_by.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'viewType' => 2)); ?>
        
        <?php echo $this->partial('widgets-data/_category.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'withIcon' => 1)); ?>
        
        <?php echo $this->partial('widgets-data/_location.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams)); ?>
        
        <?php echo $this->partial('widgets-data/_readTime.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams));?>
      </ul>
    </div>
    
    <?php echo $this->partial('widgets-data/_title.tpl', 'eblog', array('item' => $item, 'truncation' => $allParams['title_truncation_list'], 'allParams' => $allParams));?>
    
    <?php if(Engine_Api::_()->getApi('core', 'eblog')->allowReviewRating() && in_array('rating', $allParams['show_criteria'])):?>
			<?php echo $this->partial('_blogRating.tpl', 'eblog', array('rating' => $item->rating, 'class' => 'eblog_list_rating eblog_list_view_ratting', 'style' => ''));?>
		<?php endif;?> 
		
    <div class="eblog_list_stats eblog_list_four_stats sesbasic_text_light">
      <?php echo $this->partial('widgets-data/_stats.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'readtime' => 1));?>
		</div>
		
		<?php echo $this->partial('widgets-data/_description.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'truncation' => $allParams['description_truncation_list'], 'showDes' => 'descriptionlist')); ?>
    
    <?php echo $this->partial('widgets-data/_readmore.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams));?>
    
		<?php echo $this->partial('widgets-data/_buttons.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'plusicon' => $allParams['socialshare_enable_listview4plusicon'], 'sharelimit' => $allParams['socialshare_icon_listview4limit']));?>
		
  </div>
</li>
