<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Widget_ProfileOptionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject()) {
      return $this->setNoRender();
    }
    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('classroom');
    $this->view->navigation = Engine_Api::_()
            ->getApi('menus', 'core')
            ->getNavigation('eclassroom_profile');
    $paramsg = $this->_getParam('optionsG', 0);
    if ($paramsg) {
      $this->getElement()->removeDecorator('Container');
    }
  }

}
