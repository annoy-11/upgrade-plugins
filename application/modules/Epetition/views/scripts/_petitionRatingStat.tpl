<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _petitionRatingStat.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('epetition_signature', 'view')):?>
	<?php if(isset($this->ratingActive) && isset($item->rating)): ?>
		<span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($item->rating,1)), $this->locale()->toNumber(round($item->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($item->rating,1).'/5';?></span>
	<?php endif; ?>
<?php endif;?>
