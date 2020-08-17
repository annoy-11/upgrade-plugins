<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_Plugin_Core
{
  public function onStatistics($event)
  {
    $table  = Engine_Api::_()->getDbTable('topics', 'sesgroupforum');
    $select = new Zend_Db_Select($table->getAdapter());
    $select->from($table->info('name'), 'COUNT(*) AS count');
    $event->addResponse($select->query()->fetchColumn(0), 'sesgroupforum topic');
  }

  public function onRenderLayoutDefault($event, $mode = null) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $view->headScript()->appendFile($view->layout()->staticBaseUrl . 'application/modules/Sesgroupforum/externals/scripts/core.js');
  }

  public function onUserDeleteAfter($event)
  {
    $payload = $event->getPayload();
    $user_id = $payload['identity'];

    // Signatures
    $table = Engine_Api::_()->getDbTable('signatures', 'sesgroupforum');
    $table->delete(array(
      'user_id = ?' => $user_id,
    ));

    // Moderators
    $table = Engine_Api::_()->getDbTable('listItems', 'sesgroupforum');
    $select = $table->select()->where('child_id = ?', $user_id);
    $rows = $table->fetchAll($select);
    foreach( $rows as $row ) {
      $row->delete();
    }

    // Topics
    $table = Engine_Api::_()->getDbTable('topics', 'sesgroupforum');
    $select = $table->select()->where('user_id = ?', $user_id);
    $rows = $table->fetchAll($select);
    foreach( $rows as $row ) {
      //$row->delete();
    }

    // Posts
    $table = Engine_Api::_()->getDbTable('posts', 'sesgroupforum');
    $select = $table->select()->where('user_id = ?', $user_id);
    $rows = $table->fetchAll($select);
    foreach ($rows as $row)
    {
      //$row->delete();
    }

    // Topic views
    $table = Engine_Api::_()->getDbTable('topicviews', 'sesgroupforum');
    $table->delete(array(
      'user_id = ?' => $user_id,
    ));
  }

  public function addActivity($event)
  {
//     $payload = $event->getPayload();
//     $object  = $payload['object'];
// 
//     // Only for object=sesgroupforum
//     $innerObject = null;
//     if( $object instanceof Sesgroupforum_Model_Sesgroupforum ) {
//       $innerObject = $object;
//     } else if( $object instanceof Sesgroupforum_Model_Topic ) {
//       $innerObject = $object->getParent();
//     } else if( $object instanceof Sesgroupforum_Model_Post ) {
//       $innerObject = $object->getParent()->getParent();
//     }
// 
//     if( $innerObject ) {
//       $content    = Engine_Api::_()->getApi('settings', 'core')->getSetting('activity.content', 'everyone');
//       $allowTable = Engine_Api::_()->getDbtable('allow', 'authorization');
// 
//       // Sesgroupforum
//       $event->addResponse(array(
//         'type' => 'sesgroupforum',
//         'identity' => $object->forum_id
//       ));
// 
//       // Everyone
//       if( $content == 'everyone' && $allowTable->isAllowed($object->getAuthorizationItem(), 'everyone', 'view') ) {
//         $event->addResponse(array(
//           'type' => 'everyone',
//           'identity' => 0,
//         ));
//       }
//     }
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

    // Get sesgroupforum
    if( $user ) {
      $authTable = Engine_Api::_()->getDbtable('allow', 'authorization');
      $perms = $authTable->select()
          ->where('resource_type = ?', 'sesgroupforum')
          ->where('action = ?', 'view')
          ->query()
          ->fetchAll();
      $sesgroupforumIds = array();
      foreach( $perms as $perm ) {
        if( $perm['role'] == 'everyone' ) {
          $sesgroupforumIds[] = $perm['resource_id'];
        } else if( $user &&
            $user->getIdentity() &&
            $perm['role'] == 'authorization_level' &&
            $perm['role_id'] == $user->level_id ) {
          $sesgroupforumIds[] = $perm['resource_id'];
        }
      }
      if( !empty($sesgroupforumIds) ) {
        $event->addResponse(array(
          'type' => 'sesgroupforum',
          'data' => $sesgroupforumIds,
        ));
      }
    } else {
      $authTable = Engine_Api::_()->getDbtable('allow', 'authorization');
      $perms = $authTable->select()
          ->where('resource_type = ?', 'sesgroupforum')
          ->where('action = ?', 'view')
          ->query()
          ->fetchAll();
      $sesgroupforumIds = array();
      foreach( $perms as $perm ) {
        if( $perm['role'] == 'everyone' ) {
          $sesgroupforumIds[] = $perm['resource_id'];
        }
      }
      if( !empty($sesgroupforumIds) ) {
        $event->addResponse(array(
          'type' => 'sesgroupforum',
          'data' => $sesgroupforumIds,
        ));
      }
    }
  }
}
