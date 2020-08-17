<?php

class Sespagepackage_Widget_PageRenewButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $page_id = $this->_getParam('page_id', false);
    if ((!Engine_Api::_()->core()->hasSubject() && !$page_id ) || !Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sespagepackage')) {
      return $this->setNoRender();
    }
    if ($page_id)
      $page = $this->view->page = Engine_Api::_()->getItem('sespage_page', $page_id);
    else
      $page = $this->view->page = Engine_Api::_()->core()->getSubject();

    $this->view->transaction = Engine_Api::_()->getDbTable('transactions', 'sespagepackage')->getItemTransaction(array('order_package_id' => $page->orderspackage_id, 'page' => $page));
    $this->view->package = Engine_Api::_()->getItem('sespagepackage_package', $page->package_id);
    if (!$this->view->package)
      return $this->setNoRender();
  }

}
