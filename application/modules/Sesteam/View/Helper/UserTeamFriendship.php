<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: UserTeamFriendship.php 2015-03-10 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesteam_View_Helper_UserTeamFriendship extends Zend_View_Helper_Abstract {

  public function userTeamFriendship($user, $viewer = null) {

    if (null === $viewer) {
      $viewer = Engine_Api::_()->user()->getViewer();
    }

    if (!$viewer || !$viewer->getIdentity() || $user->isSelf($viewer)) {
      return '';
    }

    $direction = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('user.friends.direction', 1);

    // Get data
    if (!$direction) {
      $row = $user->membership()->getRow($viewer);
    }
    else
      $row = $viewer->membership()->getRow($user);

    // Render
    // Check if friendship is allowed in the network
    $eligible = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('user.friends.eligible', 2);
    if ($eligible == 0) {
      return '';
    }

    // check admin level setting if you can befriend people in your network
    else if ($eligible == 1) {

      $networkMembershipTable = Engine_Api::_()->getDbtable('membership', 'network');
      $networkMembershipName = $networkMembershipTable->info('name');

      $select = new Zend_Db_Select($networkMembershipTable->getAdapter());
      $select
              ->from($networkMembershipName, 'user_id')
              ->join($networkMembershipName, "`{$networkMembershipName}`.`resource_id`=`{$networkMembershipName}_2`.resource_id", null)
              ->where("`{$networkMembershipName}`.user_id = ?", $viewer->getIdentity())
              ->where("`{$networkMembershipName}_2`.user_id = ?", $user->getIdentity())
      ;

      $data = $select->query()->fetch();

      if (empty($data)) {
        return '';
      }
    }

    if (!$direction) {
      // one-way mode
      if (null === $row) {
        return $this->view->htmlLink(array('route' => 'user_extended', 'controller' => 'friends', 'action' => 'add', 'user_id' => $user->user_id), $this->view->translate(''), array('class' => 'buttonlink smoothbox icon_friend_add', 'title' => $this->view->translate('Follow')));
      } else if ($row->resource_approved == 0) {
        return $this->view->htmlLink(array('route' => 'user_extended', 'controller' => 'friends', 'action' => 'cancel', 'user_id' => $user->user_id), $this->view->translate(''), array(
                    'class' => 'buttonlink smoothbox icon_friend_cancel', 'title' => $this->view->translate('Cancel Follow Request')
        ));
      } else {
        return $this->view->htmlLink(array('route' => 'user_extended', 'controller' => 'friends', 'action' => 'remove', 'user_id' => $user->user_id), $this->view->translate(''), array(
                    'class' => 'buttonlink smoothbox icon_friend_remove', 'title' => $this->view->translate('Unfollow')
        ));
      }
    } else {
      // two-way mode
      if (null === $row) {
        return $this->view->htmlLink(array('route' => 'user_extended', 'controller' => 'friends', 'action' => 'add', 'user_id' => $user->user_id), $this->view->translate(''), array(
                    'class' => 'buttonlink smoothbox icon_friend_add', 'title' => $this->view->translate('Add Friend')
        ));
      } else if ($row->user_approved == 0) {
        return $this->view->htmlLink(array('route' => 'user_extended', 'controller' => 'friends', 'action' => 'cancel', 'user_id' => $user->user_id), $this->view->translate(''), array(
                    'class' => 'buttonlink smoothbox icon_friend_cancel', 'title' => $this->view->translate('Cancel Request')
        ));
      } else if ($row->resource_approved == 0) {
        return $this->view->htmlLink(array('route' => 'user_extended', 'controller' => 'friends', 'action' => 'confirm', 'user_id' => $user->user_id), $this->view->translate(''), array(
                    'class' => 'buttonlink smoothbox icon_friend_add', 'title' => $this->view->translate('Accept Request')
        ));
      } else if ($row->active) {
        return $this->view->htmlLink(array('route' => 'user_extended', 'controller' => 'friends', 'action' => 'remove', 'user_id' => $user->user_id), $this->view->translate(''), array(
                    'class' => 'buttonlink smoothbox icon_friend_remove', 'title' => $this->view->translate('Remove Friend')
        ));
      }
    }

    return '';
  }

}