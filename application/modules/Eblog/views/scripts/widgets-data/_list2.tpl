<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _simplelistView.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<li class="eblog_list_second_blog sesbasic_clearfix clear">
	<div class="eblog_list_thumb eblog_thumb" style="height:<?php echo is_numeric($allParams['height_simplelist']) ? $allParams['height_simplelist'].'px' : $allParams['height_simplelist'] ?>;width:<?php echo is_numeric($allParams['width_simplelist']) ? $allParams['width_simplelist'].'px' : $allParams['width_simplelist'] ?>;">
    
    <a href="<?php echo $item->getHref(); ?>" data-url = "<?php echo $item->getType() ?>" class="eblog_thumb_img"><span style="background-image:url(<?php echo $item->getPhotoUrl(); ?>);"></span></a>
    
    <?php echo $this->partial('widgets-data/_date.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'viewType' => 2));?>
		
		<?php echo $this->partial('widgets-data/_labels.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams)); ?>
  </div>
	<div class="eblog_list_info">
	  <?php if(Engine_Api::_()->getApi('core', 'eblog')->allowReviewRating() && in_array('ratingStar', $allParams['show_criteria'])):?>
    	<?php echo $this->partial('_blogRating.tpl', 'eblog', array('rating' => $item->rating, 'class' => 'eblog_list_rating eblog_list_view_ratting floatR', 'style' => ''));?>
    <?php endif;?>
    
    <?php echo $this->partial('widgets-data/_title.tpl', 'eblog', array('item' => $item, 'truncation' => $allParams['title_truncation_simplelist'], 'allParams' => $allParams));?>

    <div class="eblog_admin_list">
    
      <?php echo $this->partial('widgets-data/_posted_by.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'viewType' => 2)); ?>
			
			<?php echo $this->partial('widgets-data/_readTime.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams));?>
			
			<?php echo $this->partial('widgets-data/_category.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'withIcon' => 1)); ?>

      <?php echo $this->partial('widgets-data/_location.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams)); ?>
			
      <div class="eblog_stats_list sesbasic_text_light eblog_list_stats">
        <?php echo $this->partial('widgets-data/_stats.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'readtime' => 1));?>
      </div>
    
		</div>
		
		<?php echo $this->partial('widgets-data/_description.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'truncation' => $allParams['description_truncation_simplelist'], 'showDes' => 'descriptionsimplelist')); ?>
		
    <div class="eblog_list_second_blog_footer">
      <?php echo $this->partial('widgets-data/_readmore.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams));?>
      <?php echo $this->partial('widgets-data/_buttons.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'plusicon' => $allParams['socialshare_enable_listview2plusicon'], 'sharelimit' => $allParams['socialshare_icon_listview2limit']));?>
    </div>
    <?php echo $this->partial('widgets-data/_editdelete_options.tpl', 'eblog', array('item' => $item, 'allParams' => $allParams, 'my_blogs' => $this->my_blogs, 'can_edit' => $this->can_edit, 'can_delete' => $this->can_delete));?>
	</div>
</li>
