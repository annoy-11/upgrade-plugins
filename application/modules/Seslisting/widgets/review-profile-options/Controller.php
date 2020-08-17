<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seslisting_Widget_ReviewProfileOptionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewType = $this->_getParam('viewType', 'vertical');
    $coreMenuApi = Engine_Api::_()->getApi('menus', 'core');
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();

    if (!Engine_Api::_()->core()->hasSubject('seslistingreview') || !$viewerId)
    return $this->setNoRender();

    $review = Engine_Api::_()->core()->getSubject('seslistingreview');
    $this->view->content_item = Engine_Api::_()->getItem('seslisting', $review->listing_id);
    $this->view->navigation = $coreMenuApi->getNavigation('seslistingreview_profile');
  }

}
