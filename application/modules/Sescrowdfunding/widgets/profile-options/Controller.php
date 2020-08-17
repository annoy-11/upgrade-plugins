<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Widget_ProfileOptionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewType = $this->_getParam('viewType', 'vertical');
    $coreMenuApi = Engine_Api::_()->getApi('menus', 'core');
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();

    if (!Engine_Api::_()->core()->hasSubject('crowdfunding') || !$viewerId)
      return $this->setNoRender();

    $crowdfunding = Engine_Api::_()->core()->getSubject('crowdfunding');
    $this->view->content_item = Engine_Api::_()->getItem('crowdfunding', $crowdfunding->crowdfunding_id);
    $this->view->navigation = $coreMenuApi->getNavigation('sescrowdfunding_gutter');
  }

}
