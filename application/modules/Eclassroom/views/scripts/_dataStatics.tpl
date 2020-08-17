<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _dataStatics.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
 <?php if(isset($this->likeActive)):?>
<span class="sesbasic_text_light eclassroom_like_count_<?php echo $classroom->classroom_id; ?>" title="<?php echo $this->translate(array('%s Like', '%s Likes', $classroom->like_count), $this->locale()->toNumber($classroom->like_count)) ?>"><i class="sesbasic_icon_like_o"></i><?php echo $classroom->like_count; ?></span>
 <?php endif;?>
 <?php if(isset($this->commentActive)):?>
<span class="sesbasic_text_light"  title="<?php echo $this->translate(array('%s Comment', '%s Comments', $classroom->comment_count), $this->locale()->toNumber($classroom->comment_count)) ?>"><i class="sesbasic_icon_comment_o"></i><?php echo $classroom->comment_count; ?></span>
<?php endif;?>
<?php if(isset($this->viewActive)):?>
<span class="sesbasic_text_light" title="<?php echo $this->translate(array('%s View', '%s Views', $classroom->view_count), $this->locale()->toNumber($classroom->view_count)) ?>"><i class="sesbasic_icon_view"></i><?php echo $classroom->view_count; ?></span>
<?php endif;?>
<?php if(isset($this->favouriteActive)):?>
<span class="sesbasic_text_light eclassroom_favourite_count_<?php echo $classroom->classroom_id; ?>" title="<?php echo $this->translate(array('%s Favourite', '%s Favourites', $classroom->favourite_count), $this->locale()->toNumber($classroom->favourite_count)) ?>"><i class="sesbasic_icon_favourite_o"></i> <?php echo $classroom->favourite_count; ?></span>
<?php endif;?>
<?php if(isset($this->followActive)):?>
<span class="sesbasic_text_light eclassroom_follow_count_<?php echo $classroom->classroom_id; ?>" title="<?php echo $this->translate(array('%s Follow', '%s Follows', $classroom->follow_count), $this->locale()->toNumber($classroom->follow_count)) ?>"><i class="sesbasic_icon_follow"></i><?php echo $classroom->follow_count; ?></span>
<?php endif;?>
<?php if(isset($this->courseCountActive)):?>
  <span class="sesbasic_text_light" title="<?php echo $this->translate(array('%s Course', '%s Courses', $classroom->course_count), $this->locale()->toNumber($classroom->course_count)) ?>"><i class="fa fa-list"></i> <?php echo $classroom->course_count; ?></span>
<?php endif;?>
<?php if(isset($this->memberActive)):?>
    <?php  
        $viewer = Engine_Api::_()->user()->getViewer();
        if ($viewer->getIdentity() && ( $classroom->isOwner($viewer))) {
            $waitingMembers = Zend_Paginator::factory($classroom->membership()->getMembersSelect(false));
        }
        $select = $classroom->membership()->getMembersObjectSelect();
        if ($search) {
        $select->where('displayname LIKE ?', '%' . $search . '%');
        }
        if (@$limit_data) {
        $select->limit($limit_data);
        }
        $fullMembers = $fullMembers = Zend_Paginator::factory($select);
        // if showing waiting members, or no full members
        if (($viewer->getIdentity() && ( $classroom->isOwner($viewer))) && (@$waiting || ($fullMembers->getTotalItemCount() <= 0 && $search == ''))) {
            $members = $paginator = $waitingMembers;
        } else {
            $members = $paginator = $fullMembers;
        } 
    ?>
	<span  class="sesbasic_text_light" title="<?php echo $this->translate(array('%s Member', '%s Member', $members->getTotalItemCount()), $this->locale()->toNumber($members->getTotalItemCount())) ?>"><i class="fa fa-user"></i> <?php echo $members->getTotalItemCount(); ?></span>
<?php endif;?>
