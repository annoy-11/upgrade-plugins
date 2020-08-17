<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusinessreview_Widget_ReviewProfileOptionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $this->view->viewType = $this->_getParam('viewType', 'vertical');
    $coreMenuApi = Engine_Api::_()->getApi('menus', 'core');

    if (!Engine_Api::_()->core()->hasSubject('businessreview'))
      return $this->setNoRender();

    $review = Engine_Api::_()->core()->getSubject('businessreview');
    $this->view->content_item = $event = Engine_Api::_()->getItem('businesses', $review->business_id);
    $this->view->navigation = $coreMenuApi->getNavigation('sesbusinessreview_reviewprofile');
  }

}
