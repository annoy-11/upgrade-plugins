<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _listingRatingStat.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('seslistingreview', 'view')):?>
	<?php if(isset($this->ratingActive) && isset($item->rating)): ?>
		<span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($item->rating,1)), $this->locale()->toNumber(round($item->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($item->rating,1).'/5';?></span>
	<?php endif; ?>
<?php endif;?>
