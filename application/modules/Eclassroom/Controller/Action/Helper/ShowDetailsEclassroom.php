<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: ShowDetailsEclassroom.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Controller_Action_Helper_ShowDetailsClassroom extends Zend_Controller_Action_Helper_Abstract {
  public function preDispatch() {
    $front = Zend_Controller_Front::getInstance();
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    $contactDetail = 1;
    if (!$viewerId) {
      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.enable.contact.details', 0))
        $contactDetail = 0;
    }
    define('ECLASSROOMSHOWCONTACTDETAIL', $contactDetail);
  }
}
