<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eblog/externals/styles/styles.css');
  $allParams = $this->allParams; 
?>

<div class="eblog_category_grid sesbasic_clearfix sesbasic_bxs">
	<ul>
	  <?php foreach( $this->paginator as $item ):?>
			<li style="width:<?php echo is_numeric($allParams['width']) ? $allParams['width'].'px' : $allParams['width']?>;">
				<div <?php if(($allParams['show_criteria'] != '')) { ?> class="eblog_thumb_contant" <?php } ?> style="height:<?php echo is_numeric($allParams['height']) ? $allParams['height'].'px' : $allParams['height'] ?>;">
					<a href="<?php echo $item->getHref(); ?>" class="link_img img_animate">
					  <?php if($item->thumbnail != '' && !is_null($item->thumbnail) && intval($item->thumbnail)): ?>
							<img class="list_main_img" src="<?php echo  Engine_Api::_()->storage()->get($item->thumbnail)->getPhotoUrl('thumb.thumb'); ?>">
						<?php endif;?>
						<div <?php if(($allParams['show_criteria'] != '')){ ?> class="eblog_category_hover" <?php } ?>>
            	<div>
                <?php if(in_array('icon', $allParams['show_criteria']) && $item->cat_icon != '' && !is_null($item->cat_icon) && intval($item->cat_icon)): ?>
                  <?php $icon = Engine_Api::_()->storage()->get($item->cat_icon); ?>
                  <?php if($icon) { ?>
                    <div class="eblog_square_icon">
                      <img src="<?php echo $icon->getPhotoUrl('thumb.icon'); ?>" />
                    </div>
                  <?php } ?>
                <?php endif;?>
                <?php if(in_array('title', $allParams['show_criteria'])):?>
                  <p class="title"><?php echo $this->translate($item->category_name); ?></p>
                <?php endif;?>
                <?php if(in_array('countBlogs', $allParams['show_criteria'])):?>
                  <p class="count"><?php echo $this->translate(array('%s blog', '%s blogs', $item->total_blogs_categories), $this->locale()->toNumber($item->total_blogs_categories))?></p>
                <?php endif;?>
              </div>
						</div>
					</a>
				</div>
			</li>
		<?php endforeach;?>
	</ul>
</div>
