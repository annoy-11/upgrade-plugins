<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _recipeRatingStat.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('sesrecipe_review', 'view')):?>
	<?php if(isset($this->ratingActive) && isset($item->rating)): ?>
		<span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($item->rating,1)), $this->locale()->toNumber(round($item->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($item->rating,1).'/5';?></span>
	<?php endif; ?>
<?php endif;?>