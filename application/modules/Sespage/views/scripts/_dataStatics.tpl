<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _dataStatics.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(isset($this->likeActive)):?>
  <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $page->like_count), $this->locale()->toNumber($page->like_count)) ?>"><?php echo $this->translate(array('%s Like', '%s Likes', $page->like_count), $this->locale()->toNumber($page->like_count)) ?></span>
<?php endif;?>
<?php if(isset($this->commentActive)):?>
  <span title="<?php echo $this->translate(array('%s Comment', '%s Comments', $page->comment_count), $this->locale()->toNumber($page->comment_count)) ?>"><?php echo $this->translate(array('%s Comment', '%s Comments', $page->comment_count), $this->locale()->toNumber($page->comment_count)) ?></span>
<?php endif;?>
<?php if(isset($this->viewActive)):?>
  <span title="<?php echo $this->translate(array('%s View', '%s Views', $page->view_count), $this->locale()->toNumber($page->view_count)) ?>"><?php echo $this->translate(array('%s View', '%s Views', $page->view_count), $this->locale()->toNumber($page->view_count)) ?></span>
<?php endif;?>
<?php if(isset($this->favouriteActive)):?>
  <span title="<?php echo $this->translate(array('%s Favourite', '%s Favourites', $page->favourite_count), $this->locale()->toNumber($page->favourite_count)) ?>"><?php echo $this->translate(array('%s Favourite', '%s Favourites', $page->favourite_count), $this->locale()->toNumber($page->favourite_count)) ?></span>
<?php endif;?>
<?php if(isset($this->followActive) && isset($page->follow_count)):?>
  <span title="<?php echo $this->translate(array('%s Follower', '%s Followers', $page->follow_count), $this->locale()->toNumber($page->follow_count)) ?>"><?php echo $this->translate(array('%s Follower', '%s Followers', $page->follow_count), $this->locale()->toNumber($page->follow_count)) ?></span>
<?php endif;?>
<?php if(isset($this->memberActive) && isset($page->member_count)):?>
  <span title="<?php echo $this->translate(array('%s Member', '%s Members', $page->member_count), $this->locale()->toNumber($page->member_count)) ?>"><?php echo $this->translate(array('%s Member', '%s Members', $page->member_count), $this->locale()->toNumber($page->member_count)) ?></span>
<?php endif;?>
<?php if(isset($this->reviewActive) && Engine_Api::_()->sesbasic()->getViewerPrivacy('pagereview', 'view') && Engine_Api::_()->getApi('core', 'sespagereview')->allowReviewRating()):?>
  <span title="<?php echo $this->translate(array('%s Review', '%s Reviews', $page->review_count), $this->locale()->toNumber($page->review_count)) ?>"><?php echo $this->translate(array('%s Review', '%s Reviews', $page->review_count), $this->locale()->toNumber($page->review_count)) ?></span>
<?php endif;?>
