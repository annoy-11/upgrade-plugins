<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _dataStatics.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(isset($this->likeActive)):?>
  <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $group->like_count), $this->locale()->toNumber($group->like_count)) ?>"><?php echo $this->translate(array('%s Like', '%s Likes', $group->like_count), $this->locale()->toNumber($group->like_count)) ?></span>
<?php endif;?>
<?php if(isset($this->commentActive)):?>
  <span title="<?php echo $this->translate(array('%s Comment', '%s Comments', $group->comment_count), $this->locale()->toNumber($group->comment_count)) ?>"><?php echo $this->translate(array('%s Comment', '%s Comments', $group->comment_count), $this->locale()->toNumber($group->comment_count)) ?></span>
<?php endif;?>
<?php if(isset($this->viewActive)):?>
  <span title="<?php echo $this->translate(array('%s View', '%s Views', $group->view_count), $this->locale()->toNumber($group->view_count)) ?>"><?php echo $this->translate(array('%s View', '%s Views', $group->view_count), $this->locale()->toNumber($group->view_count)) ?></span>
<?php endif;?>
<?php if(isset($this->favouriteActive)):?>
  <span title="<?php echo $this->translate(array('%s Favourite', '%s Favourites', $group->favourite_count), $this->locale()->toNumber($group->favourite_count)) ?>"><?php echo $this->translate(array('%s Favourite', '%s Favourites', $group->favourite_count), $this->locale()->toNumber($group->favourite_count)) ?></span>
<?php endif;?>
<?php if(isset($this->followActive) && isset($group->follow_count)):?>
  <span title="<?php echo $this->translate(array('%s Follower', '%s Followers', $group->follow_count), $this->locale()->toNumber($group->follow_count)) ?>"><?php echo $this->translate(array('%s Follower', '%s Followers', $group->follow_count), $this->locale()->toNumber($group->follow_count)) ?></span>
<?php endif;?>
<?php if(isset($this->memberActive) && isset($group->member_count)):?>
  <span title="<?php echo $this->translate(array('%s Member', '%s Members', $group->member_count), $this->locale()->toNumber($group->member_count)) ?>"><?php echo $this->translate(array('%s Member', '%s Members', $group->member_count), $this->locale()->toNumber($group->member_count)) ?></span>
<?php endif;?>

