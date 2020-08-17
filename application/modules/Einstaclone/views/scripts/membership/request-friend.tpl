<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: request-friend.tpl 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<?php
  $row = $this->row;
  $subject = $this->subject;
  // two-way mode
  if( null === $row ) {
    echo "<a href='javascript:void(0);' class='einstaclone_btn einstaclone_add_btn einstaclone_member_addfriend_request' data-tokenname='".$this->tokenName."' data-tokenvalue='".$this->tokenValue."' data-src = '".$subject->user_id."'><i class='fa fa-user-plus'></i><span><i class='fa fa-caret-down'></i>".$this->translate('Add Friend')."</span></a>";
  } else if( $row->user_approved == 0 ) {
    echo "<a href='javascript:void(0);' class='einstaclone_btn einstaclone_cancel_request_btn einstaclone_member_cancelfriend_request' data-tokenname='".$this->tokenName."' data-tokenvalue='".$this->tokenValue."' data-src = '".$subject->user_id."'><i class='fa fa-user-times'></i><span><i class='fa fa-caret-down'></i>".$this->translate('Cancel Friend Request')."</span></a>";
  } else if( $row->resource_approved == 0 ) {
    echo "<a href='javascript:void(0);' class='einstaclone_btn einstaclone_actapt_request_btn einstaclone_member_acceptfriend_request' data-tokenname='".$this->tokenName."' data-tokenvalue='".$this->tokenValue."' data-src = '".$subject->user_id."'><i class='fa fa-user-plus'></i><span><i class='fa fa-caret-down'></i>".$this->translate('Accept Friend Request')."</span></a>";
  } else if( $row->active ) {
    echo "<a href='javascript:void(0);' class='einstaclone_btn einstaclone_remove_friend_btn einstaclone_member_removefriend_request' data-tokenname='".$this->tokenName."' data-tokenvalue='".$this->tokenValue."' data-src = '".$subject->user_id."'><i class='fa fa-user-times'></i><span><i class='fa fa-caret-down'></i>".$this->translate('Remove Friend')."</span></a>";
  }

?>
