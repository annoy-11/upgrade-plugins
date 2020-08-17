<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Plugin_Core
{
  public function onStatistics($event)
  {
    $table  = Engine_Api::_()->getDbTable('topics', 'sesforum');
    $select = new Zend_Db_Select($table->getAdapter());
    $select->from($table->info('name'), 'COUNT(*) AS count');
    $event->addResponse($select->query()->fetchColumn(0), 'sesforum topic');
  }

  public function onRenderLayoutDefault($event, $mode = null) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $view->headScript()->appendFile($view->layout()->staticBaseUrl . 'application/modules/Sesforum/externals/scripts/core.js');
  }

  public function onUserDeleteAfter($event)
  {
    $payload = $event->getPayload();
    $user_id = $payload['identity'];

    // Signatures
    $table = Engine_Api::_()->getDbTable('signatures', 'sesforum');
    $table->delete(array(
      'user_id = ?' => $user_id,
    ));

    // Moderators
    $table = Engine_Api::_()->getDbTable('listItems', 'sesforum');
    $select = $table->select()->where('child_id = ?', $user_id);
    $rows = $table->fetchAll($select);
    foreach( $rows as $row ) {
      $row->delete();
    }

    // Topics
    $table = Engine_Api::_()->getDbTable('topics', 'sesforum');
    $select = $table->select()->where('user_id = ?', $user_id);
    $rows = $table->fetchAll($select);
    foreach( $rows as $row ) {
      //$row->delete();
    }

    // Posts
    $table = Engine_Api::_()->getDbTable('posts', 'sesforum');
    $select = $table->select()->where('user_id = ?', $user_id);
    $rows = $table->fetchAll($select);
    foreach ($rows as $row)
    {
      //$row->delete();
    }

    // Topic views
    $table = Engine_Api::_()->getDbTable('topicviews', 'sesforum');
    $table->delete(array(
      'user_id = ?' => $user_id,
    ));
  }

  public function addActivity($event)
  {
    $payload = $event->getPayload();
    $object  = $payload['object'];

    // Only for object=sesforum
    $innerObject = null;
    if( $object instanceof Sesforum_Model_Sesforum ) {
      $innerObject = $object;
    } else if( $object instanceof Sesforum_Model_Topic ) {
      $innerObject = $object->getParent();
    } else if( $object instanceof Sesforum_Model_Post ) {
      $innerObject = $object->getParent()->getParent();
    }

    if( $innerObject ) {
      $content    = Engine_Api::_()->getApi('settings', 'core')->getSetting('activity.content', 'everyone');
      $allowTable = Engine_Api::_()->getDbtable('allow', 'authorization');

      // Sesforum
      $event->addResponse(array(
        'type' => 'sesforum',
        'identity' => $object->forum_id
      ));

      // Everyone
      if( $content == 'everyone' && $allowTable->isAllowed($object->getAuthorizationItem(), 'everyone', 'view') ) {
        $event->addResponse(array(
          'type' => 'everyone',
          'identity' => 0,
        ));
      }
    }
  }

  public function getActivity($event)
  {
    // Detect viewer and subject
    $payload = $event->getPayload();
    $user = null;
    $subject = null;
    if( $payload instanceof User_Model_User ) {
      $user = $payload;
    } else if( is_array($payload) ) {
      if( isset($payload['for']) && $payload['for'] instanceof User_Model_User ) {
        $user = $payload['for'];
      }
      if( isset($payload['about']) && $payload['about'] instanceof Core_Model_Item_Abstract ) {
        $subject = $payload['about'];
      }
    }
    if( null === $user ) {
      $viewer = Engine_Api::_()->user()->getViewer();
      if( $viewer->getIdentity() ) {
        $user = $viewer;
      }
    }
    if( null === $subject && Engine_Api::_()->core()->hasSubject() ) {
      $subject = Engine_Api::_()->core()->getSubject();
    }

    // Get sesforum
    if( $user ) {
      $authTable = Engine_Api::_()->getDbtable('allow', 'authorization');
      $perms = $authTable->select()
          ->where('resource_type = ?', 'sesforum')
          ->where('action = ?', 'view')
          ->query()
          ->fetchAll();
      $sesforumIds = array();
      foreach( $perms as $perm ) {
        if( $perm['role'] == 'everyone' ) {
          $sesforumIds[] = $perm['resource_id'];
        } else if( $user &&
            $user->getIdentity() &&
            $perm['role'] == 'authorization_level' &&
            $perm['role_id'] == $user->level_id ) {
          $sesforumIds[] = $perm['resource_id'];
        }
      }
      if( !empty($sesforumIds) ) {
        $event->addResponse(array(
          'type' => 'sesforum',
          'data' => $sesforumIds,
        ));
      }
    } else {
      $authTable = Engine_Api::_()->getDbtable('allow', 'authorization');
      $perms = $authTable->select()
          ->where('resource_type = ?', 'sesforum')
          ->where('action = ?', 'view')
          ->query()
          ->fetchAll();
      $sesforumIds = array();
      foreach( $perms as $perm ) {
        if( $perm['role'] == 'everyone' ) {
          $sesforumIds[] = $perm['resource_id'];
        }
      }
      if( !empty($sesforumIds) ) {
        $event->addResponse(array(
          'type' => 'sesforum',
          'data' => $sesforumIds,
        ));
      }
    }
  }
}
