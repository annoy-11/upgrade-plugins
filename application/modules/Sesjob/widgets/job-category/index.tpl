<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesjob/externals/styles/styles.css'); ?> 
<div class="sesjob_category_grid sesbasic_clearfix sesbasic_bxs">
	<ul>
	  <?php foreach( $this->paginator as $item ):?>
			<li style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width?>;">
				<div  <?php if(($this->show_criterias != '')){ ?> class="sesjob_thumb_contant" <?php } ?> style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height?>;">
					<a href="<?php echo $item->getHref(); ?>" class="link_img img_animate">
					  <?php if($item->thumbnail != '' && !is_null($item->thumbnail) && intval($item->thumbnail)): ?>
							<img class="list_main_img" src="<?php echo  Engine_Api::_()->storage()->get($item->thumbnail)->getPhotoUrl('thumb.thumb'); ?>">
						<?php endif;?>
						<div <?php if(($this->show_criterias != '')){ ?> class="animate_contant" <?php } ?>>
            	<div>
                <?php if(isset($this->icon) && $item->cat_icon != '' && !is_null($item->cat_icon) && intval($item->cat_icon)): ?>
                  <img src="<?php echo  Engine_Api::_()->storage()->get($item->cat_icon)->getPhotoUrl('thumb.icon'); ?>" />
                <?php endif;?>
                <?php if(isset($this->title)):?>
                  <p class="title"><?php echo $this->translate($item->category_name); ?></p>
                <?php endif;?>
                <?php if($this->countJobs):?>
                  <p class="count"><?php echo $this->translate(array('%s job', '%s jobs', $item->total_jobs_categories), $this->locale()->toNumber($item->total_jobs_categories))?></p>
                <?php endif;?>
              </div>
						</div>
					</a>
				</div>
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
