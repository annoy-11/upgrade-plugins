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

class Eclassroom_Widget_ReviewBreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.review', 1))
      return $this->setNoRender();
    $this->view->title = $this->_getParam('showTitle', 1);
    if (Engine_Api::_()->core()->hasSubject('eclassroom_review'))
      $item = Engine_Api::_()->core()->getSubject('eclassroom_review');
    $this->view->subject = $item;
    if (!$item)
      return $this->setNoRender();
  }

}
