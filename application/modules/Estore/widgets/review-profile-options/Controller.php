<?php

class Estore_Widget_ReviewProfileOptionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.review', 1))
      return $this->setNoRender();
    $this->view->viewType = $this->_getParam('viewType', 'vertical');
    $coreMenuApi = Engine_Api::_()->getApi('menus', 'core');

    if (!Engine_Api::_()->core()->hasSubject('estore_review'))
      return $this->setNoRender();

    $review = Engine_Api::_()->core()->getSubject('estore_review');
    $this->view->content_item = $event = Engine_Api::_()->getItem('stores', $review->store_id);
    $this->view->navigation = $coreMenuApi->getNavigation('estore_reviewprofile');
  }

}
