<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _addfriend.tpl 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Einstaclone/externals/scripts/member/membership.js'); ?>
<?php
  if(empty($subject))
    $subject = $this->subject;
    
  $table = Engine_Api::_()->getDbtable('block', 'user');
  $viewer = Engine_Api::_()->user()->getViewer();
  $select = $table->select()
                  ->where('user_id = ?', $subject->getIdentity())
                  ->where('blocked_user_id = ?', $viewer->getIdentity())
                  ->limit(1);
  $row = $table->fetchRow($select); 
?>
<?php if( $row == NULL ): ?>
	<?php if( $this->viewer()->getIdentity() ): ?>
    <?php 
    if( null === $viewer ) {
      $viewer = Engine_Api::_()->user()->getViewer();
    }

    if( !$viewer || !$viewer->getIdentity() || $subject->isSelf($viewer) ) {
      return '';
    }

    $direction = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('user.friends.direction', 1);

    // Get data
    if( !$direction ) {
      $row = Engine_Api::_()->einstaclone()->getRow($subject, $viewer);
     // $row = $subject->membership()->getRow($viewer);
    }
    else {
      $row = Engine_Api::_()->einstaclone()->getRow($viewer, $subject);
      //$row = $viewer->membership()->getRow($subject);
    }
        // Check if friendship is allowed in the network
    $eligible =  (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('user.friends.eligible', 2);
    if($eligible == 0){
      return '';
    }
   
    // check admin level setting if you can befriend people in your network
    else if( $eligible == 1 ) {

      $networkMembershipTable = Engine_Api::_()->getDbtable('membership', 'network');
      $networkMembershipName = $networkMembershipTable->info('name');

      $select = new Zend_Db_Select($networkMembershipTable->getAdapter());
      $select
        ->from($networkMembershipName, 'user_id')
        ->join($networkMembershipName, "`{$networkMembershipName}`.`resource_id`=`{$networkMembershipName}_2`.resource_id", null)
        ->where("`{$networkMembershipName}`.user_id = ?", $viewer->getIdentity())
        ->where("`{$networkMembershipName}_2`.user_id = ?", $subject->getIdentity())
        ;

      $data = $select->query()->fetch();

      if(empty($data)){
        return '';
      }
    }

    if( !$direction ) {
      // one-way mode
      if( null === $row ) { ?>
        <a class="follow_btn smoothbox" href="<?php echo $this->escape($this->url(array('controller' => 'friends', 'action' =>  'add', 'user_id' => $subject->user_id, 'format' => 'smoothbox'), 'user_extended' , true)); ?>"><?php echo $this->translate("Follow");?></a>
      <?php } else if( $row->resource_approved == 0 ) { ?>
        <a class="request_btn smoothbox" href="<?php echo $this->escape($this->url(array('controller' => 'friends', 'action' => 'cancel', 'user_id' => $subject->user_id, 'format' => 'smoothbox'), 'user_extended' , true)); ?>"><?php echo $this->translate("Requested");?></a>
      <?php  } else { ?>
        <a class="follow_btn smoothbox" href="<?php echo $this->escape($this->url(array('controller' => 'friends', 'action' => 'remove', 'user_id' => $subject->user_id, 'format' => 'smoothbox'), 'user_extended' , true)); ?>"><?php echo $this->translate("Unfollow");?></a>
      <?php }
    } else {
      echo $this->action('request-friend', 'membership', 'einstaclone', array('subject' => $subject,'row'=>$row));
    }
    ?>
	<?php endif; ?>
<?php endif; ?>
