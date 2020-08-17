<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sescf_category_grid sesbasic_clearfix sesbasic_bxs">
	<ul class="sesbasic_clearfix centerT">
	  <?php foreach( $this->paginator as $item ):?>
			<li style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width?>;">
        <a href="<?php echo $item->getHref(); ?>" class="link_img img_animate" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height?>;">
          <?php if($item->colored_icon != '' && !is_null($item->colored_icon) && intval($item->colored_icon)): ?>
            <img class="sescf_category_grid_img sesbasic_animation" src="<?php echo  Engine_Api::_()->storage()->get($item->colored_icon)->getPhotoUrl(); ?>">
          <?php endif;?>
          <div class="sescf_category_grid_cont sesbasic_animation">
            <div class="sescf_category_grid_cont_inner">
            	<div class="centerT">
                <?php if(isset($this->icon) && $item->cat_icon != '' && !is_null($item->cat_icon) && intval($item->cat_icon)): ?>
                  <img src="<?php echo  Engine_Api::_()->storage()->get($item->cat_icon)->getPhotoUrl('thumb.icon'); ?>" class="sescf_category_grid_icon" />
                <?php else: ?>
                  <img class="sescf_category_grid_icon" src="<?php echo  'application/modules/Sescrowdfunding/externals/images/category-icon.png' ?>" />
                <?php endif;?>
                <?php if(isset($this->title)):?>
                  <p class="sescf_category_grid_title"><?php echo $this->translate($item->category_name); ?></p>
                <?php endif;?>
                <?php if($this->countCrowdfundings):?>
                  <p class="sescf_category_grid_count"><?php echo $this->translate(array('%s crowdfunding', '%s crowdfundings', $item->total_crowdfundings_categories), $this->locale()->toNumber($item->total_crowdfundings_categories))?></p>
                <?php endif;?>
              </div>  
            </div>
          </div>
        </a>
			</li>
		<?php endforeach;?>
		<?php  if( count($this->paginator) == 0):?>
			<div class="tip">
				<span>
					<?php echo $this->translate('No category found.');?>
				</span>
			</div>
		<?php endif; ?>
	</ul>
</div>
