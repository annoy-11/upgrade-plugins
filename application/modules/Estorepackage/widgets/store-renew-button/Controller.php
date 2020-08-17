<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Estorepackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Estorepackage_Widget_StoreRenewButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $store_id = $this->_getParam('store_id', false);
    if ((!Engine_Api::_()->core()->hasSubject() && !$store_id ) || !Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('estorepackage')) {
      return $this->setNoRender();
    }
    if ($store_id)
        $store = $this->view->page = Engine_Api::_()->getItem('stores', $store_id);
    else
        $store = $this->view->page = Engine_Api::_()->core()->getSubject();

    $this->view->transaction = Engine_Api::_()->getDbTable('transactions', 'estorepackage')->getItemTransaction(array('order_package_id' => $store->orderspackage_id, 'page' => $store));
    $this->view->package = Engine_Api::_()->getItem('estorepackage_package', $store->package_id);
    if (!$this->view->package)
      return $this->setNoRender();
  }

}
