<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespoke_IndexController extends Core_Controller_Action_Standard {

  public function indexAction() {
    $this->_helper->content->setEnabled();
  }

  public function pokeAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $id = $this->_getParam('id', null);
    $manageaction_id = $this->_getParam('manageaction_id', null);
    $this->view->manageaction = $manageActions = Engine_Api::_()->getItem('sespoke_manageaction', $manageaction_id);
    $this->view->action = $action = $manageActions->action;
    $name = strtolower(str_replace(' ', '_', @$manageActions->name));

    $this->view->item = $item = Engine_Api::_()->getItem('user', $id);

    $this->view->isPoke = $isPoke = Engine_Api::_()->getDbtable('pokes', 'sespoke')->isPoke(array('poster_id' => $viewer_id, 'receiver_id' => $id, 'manageaction_id' => $manageaction_id));

    $userinfoResult = Engine_Api::_()->getDbtable('userinfos', 'sespoke')->isUser(array('user_id' => $viewer_id));

    $pokeTable = Engine_Api::_()->getDbtable('pokes', 'sespoke');

    $userinfosTable = Engine_Api::_()->getDbtable('userinfos', 'sespoke');

    if ($this->getRequest()->isPost()) {
      $values = array();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $values['poster_id'] = $viewer_id;
        $values['receiver_id'] = $id;
        if ($manageaction_id)
          $values['manageaction_id'] = $manageaction_id;
        $row = $pokeTable->createRow();
        $row->setFromArray($values);
        $row->save();

        $count = $name . "_count";
        if (!$userinfoResult) {
          $pokeinfos = $userinfosTable->createRow();
          $pokeinfos->user_id = $viewer_id;
          $pokeinfos->$count++;
          $pokeinfos->save();
        } else {
          $userinfos = Engine_Api::_()->getItem('sespoke_userinfo', $userinfoResult);
          $userinfos->$count++;
          $userinfos->save();
        }
        $db->commit();

        //Poke to User
        $pokeRoute = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespoke.urlmanifest', 'pokes');
        if ($action == 'action') {
          $pokePageLink = '<a href="' . $pokeRoute . '">' . ucfirst($manageActions->name) . " Back" . '</a>';
        } else {
          $pokePageLink = '<a href="' . $pokeRoute . '">' . "Send Back" . '</a>';
        }

        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($item, $viewer, $viewer, 'sespoke_' . $name, array("pokedPageLink" => $pokePageLink));

        //Activity Feed
        if ($manageActions->enable_activity) {
          $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
          $activityTable->delete(array('type =?' => "sespoke_" . $name, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));

          $action = $activityTable->addActivity($viewer, $item, "sespoke_" . $name, '', array());
          
          //Attachement of image only
          if($action && $manageActions->image) {
            Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $row);
          }
        }

        if ($action == 'action') {
          $SUBJECT = $viewer->getTitle() . ' ' . $manageActions->verb . ' you.';
          $BODY = $viewer->getTitle() . ' ' . $manageActions->verb . ' you.';
        } else {
          $SUBJECT = $viewer->getTitle() . ' send you ' . lcfirst($manageActions->name) . '.';
          $BODY = $viewer->getTitle() . ' send you ' . lcfirst($manageActions->name) . '.';
        }
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($item->email, 'SESPOKE_POKE', array(
            'subject' => $SUBJECT,
            'body' => $BODY,
            'queue' => true
        ));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
                  'smoothboxClose' => 10,
                  'messages' => array('You have successfully poked.')
      ));
    }
  }

  public function backRequestAction() {

    $id = $this->_getParam('id', null);
    $pokes = Engine_Api::_()->getItem('sespoke_poke', $id);
    $manageActions = Engine_Api::_()->getItem('sespoke_manageaction', $pokes->manageaction_id);

    $viewer = Engine_Api::_()->user()->getViewer();
    $name = strtolower(str_replace(' ', '_', $manageActions->name));

    $item = Engine_Api::_()->getItem('user', $pokes->poster_id);

    Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($item, $viewer, $viewer, 'sespoke_back_' . $name);
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->query("DELETE FROM `engine4_sespoke_pokes` WHERE `engine4_sespoke_pokes`.`poke_id` = $id LIMIT 1");
  }

  public function cancelRequestAction() {
    $id = $this->_getParam('id', null);
    $manageActions = Engine_Api::_()->getItem('sespoke_poke', $id);
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->query("DELETE FROM `engine4_sespoke_pokes` WHERE `engine4_sespoke_pokes`.`poke_id` = $id LIMIT 1");
  }

}
