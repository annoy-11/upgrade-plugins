<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _blogRatingStat.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('eblog_review', 'view')):?>
	<?php if(isset($this->ratingActive) && isset($item->rating)): ?>
		<span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($item->rating,1)), $this->locale()->toNumber(round($item->rating,1)))?>"><i class="fa fa-star-o"></i><?php echo round($item->rating,1).'/5';?></span>
	<?php endif; ?>
<?php endif;?>