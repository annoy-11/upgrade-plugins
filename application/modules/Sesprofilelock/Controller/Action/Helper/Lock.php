<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Lock.php 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesprofilelock_Controller_Action_Helper_Lock extends Zend_Controller_Action_Helper_Abstract {

  function postDispatch() {

    $front = Zend_Controller_Front::getInstance();
    $module = $front->getRequest()->getModuleName();
    $action = $front->getRequest()->getActionName();
    $controller = $front->getRequest()->getControllerName();
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    if (!empty($viewer_id) && $module == 'user' && $controller == 'profile' && $action == 'index') {

      $subject = Engine_Api::_()->core()->getSubject();
      $subject_id = $subject->getIdentity();

      $searchTable = Engine_Api::_()->fields()->getTable('user', 'search');
      $profile_type = $searchTable->select()
              ->from($searchTable, 'profile_type')
              ->where('item_id = ?', $viewer_id)
              ->query()
              ->fetchColumn();

      if ($viewer_id != $subject_id) {

        //Block Members Code according to levels.
        $sesproflelock_levelsvalue = unserialize($subject->blocked_levels);
        if (!empty($sesproflelock_levelsvalue) && in_array($profile_type, $sesproflelock_levelsvalue)) {
          Zend_Controller_Action_HelperBroker::getStaticHelper('redirector')->gotoSimple('requireauth', 'error', 'core');
        }

        //Block Members Code according to networks.
        $select = Engine_Api::_()->getDbtable('membership', 'network')->getMembershipsOfSelect($viewer)->where('hide = ?', 0);
        $networks = Engine_Api::_()->getDbtable('networks', 'network')->fetchAll($select);
        $blocked_networks = unserialize($subject->blocked_networks);
        foreach ($networks as $value) {
          if (!empty($blocked_networks) && in_array($value->network_id, $blocked_networks)) {
            Zend_Controller_Action_HelperBroker::getStaticHelper('redirector')->gotoSimple('requireauth', 'error', 'core');
          }
        }
        //End Blocked Member code
      }
    }

    $request = $this->getActionController()->getRequest();
    if (isset($_SESSION['sesuserlocked']) && $module == 'core' && $controller == 'error' && ($action == 'requireauth' || $action == 'requiresubject')) {
      $request->setModuleName('sesprofilelock');
      $request->setControllerName('index');
      $request->setActionName('index');
    } elseif (isset($_SESSION['sesuserlocked']) && $module == 'core' && $controller == 'error' && $action == 'notfound') {
      $request->setModuleName('sesprofilelock');
      $request->setControllerName('index');
      $request->setActionName('index');
    }
  }

}
