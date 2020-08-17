<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _dataStatics.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(isset($this->likeActive)):?>
  <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $business->like_count), $this->locale()->toNumber($business->like_count)) ?>"><?php echo $this->translate(array('%s Like', '%s Likes', $business->like_count), $this->locale()->toNumber($business->like_count)) ?></span>
<?php endif;?>
<?php if(isset($this->commentActive)):?>
  <span title="<?php echo $this->translate(array('%s Comment', '%s Comments', $business->comment_count), $this->locale()->toNumber($business->comment_count)) ?>"><?php echo $this->translate(array('%s Comment', '%s Comments', $business->comment_count), $this->locale()->toNumber($business->comment_count)) ?></span>
<?php endif;?>
<?php if(isset($this->viewActive)):?>
  <span title="<?php echo $this->translate(array('%s View', '%s Views', $business->view_count), $this->locale()->toNumber($business->view_count)) ?>"><?php echo $this->translate(array('%s View', '%s Views', $business->view_count), $this->locale()->toNumber($business->view_count)) ?></span>
<?php endif;?>
<?php if(isset($this->favouriteActive)):?>
  <span title="<?php echo $this->translate(array('%s Favourite', '%s Favourites', $business->favourite_count), $this->locale()->toNumber($business->favourite_count)) ?>"><?php echo $this->translate(array('%s Favourite', '%s Favourites', $business->favourite_count), $this->locale()->toNumber($business->favourite_count)) ?></span>
<?php endif;?>
<?php if(isset($this->followActive) && isset($business->follow_count)):?>
  <span title="<?php echo $this->translate(array('%s Follower', '%s Followers', $business->follow_count), $this->locale()->toNumber($business->follow_count)) ?>"><?php echo $this->translate(array('%s Follower', '%s Followers', $business->follow_count), $this->locale()->toNumber($business->follow_count)) ?></span>
<?php endif;?>
<?php if(isset($this->memberActive) && isset($business->member_count)):?>
  <span title="<?php echo $this->translate(array('%s Member', '%s Members', $business->member_count), $this->locale()->toNumber($business->member_count)) ?>"><?php echo $this->translate(array('%s Member', '%s Members', $business->member_count), $this->locale()->toNumber($business->member_count)) ?></span>
<?php endif;?>
<?php if(isset($this->reviewActive) && Engine_Api::_()->sesbasic()->getViewerPrivacy('businessreview', 'view') && Engine_Api::_()->getApi('core', 'sesbusinessreview')->allowReviewRating()):?>
  <span title="<?php echo $this->translate(array('%s Review', '%s Reviews', $business->review_count), $this->locale()->toNumber($business->review_count)) ?>"><?php echo $this->translate(array('%s Review', '%s Reviews', $business->review_count), $this->locale()->toNumber($business->review_count)) ?></span>
<?php endif;?>

