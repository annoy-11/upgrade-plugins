<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Widget_ReviewProfileOptionsController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.allow.review', 1))
      return $this->setNoRender();
    $this->view->viewType = $this->_getParam('viewType', 'vertical');
    $coreMenuApi = Engine_Api::_()->getApi('menus', 'core');

    if (!Engine_Api::_()->core()->hasSubject('sesproductreview'))
      return $this->setNoRender();

    $review = Engine_Api::_()->core()->getSubject('sesproductreview');
    $this->view->content_item = $event = Engine_Api::_()->getItem('sesproduct', $review->product_id);
    $this->view->navigation = $coreMenuApi->getNavigation('sesproductreview_profile');
  }
}