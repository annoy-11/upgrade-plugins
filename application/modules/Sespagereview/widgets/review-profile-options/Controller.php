<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagereview_Widget_ReviewProfileOptionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $this->view->viewType = $this->_getParam('viewType', 'vertical');
    $coreMenuApi = Engine_Api::_()->getApi('menus', 'core');

    if (!Engine_Api::_()->core()->hasSubject('pagereview'))
      return $this->setNoRender();

    $review = Engine_Api::_()->core()->getSubject('pagereview');
    $this->view->content_item = $event = Engine_Api::_()->getItem('sespage_page', $review->page_id);
    $this->view->navigation = $coreMenuApi->getNavigation('sespagereview_reviewprofile');
  }

}
