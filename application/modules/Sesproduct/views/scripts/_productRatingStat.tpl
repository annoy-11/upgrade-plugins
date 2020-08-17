<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _productRatingStat.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<!--RATING, REVIEWS, STATS-->
<?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('sesproductreview', 'view')):?>
	<?php if(isset($this->ratingActive) && isset($item->rating)): ?>
	<?php include "application/modules/Sesproduct/views/scripts/_rating.tpl"; ?>
	<?php endif; ?>
	<?php endif;?>
	<!--REVIEW SECTION-->
 	<!--STAT SECTION-->
 	<div class="sesproduct_static_list_group sesbasic_clearfix sesbasic_bxs">
		<div class="sesproduct_desc_stats sesbasic_text_light">
			<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
			<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
			<?php } ?>
			<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
			<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
			<?php } ?>
			<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)) { ?>
			<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
			<?php } ?>
			<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
			<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
			<?php } ?>			
		</div>
	</div>
	<!--/STAT SECTION-->
<!--/RATING, REVIEWS, STATS-->
