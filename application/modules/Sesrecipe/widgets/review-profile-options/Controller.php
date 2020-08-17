<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesrecipe_Widget_ReviewProfileOptionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewType = $this->_getParam('viewType', 'vertical');
    $coreMenuApi = Engine_Api::_()->getApi('menus', 'core');
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();

    if (!Engine_Api::_()->core()->hasSubject('sesrecipe_review') || !$viewerId)
    return $this->setNoRender();
    
    $review = Engine_Api::_()->core()->getSubject('sesrecipe_review');
    $this->view->content_item = Engine_Api::_()->getItem('sesrecipe_recipe', $review->recipe_id);
    $this->view->navigation = $coreMenuApi->getNavigation('sesrecipereview_profile');
  }

}
