<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursespackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Coursespackage_Widget_PaymentRenewButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $classroom_id = $this->_getParam('classroom_id', false);
    if ((!Engine_Api::_()->core()->hasSubject() && !$classroom_id ) || !Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('coursespackage')) {
      return $this->setNoRender();
    }
    if ($classroom_id)
      $classroom = $this->view->classroom = Engine_Api::_()->getItem('classroom', $classroom_id);
    else
      $classroom = $this->view->classroom = Engine_Api::_()->core()->getSubject();

    $this->view->transaction = Engine_Api::_()->getDbTable('transactions', 'coursespackage')->getItemTransaction(array('order_package_id' => $classroom->orderspackage_id, 'classroom' => $classroom_));
    $this->view->package = Engine_Api::_()->getItem('coursespackage_package', $classroom->package_id);
    if (!$this->view->package)
      return $this->setNoRender();
  }

}
