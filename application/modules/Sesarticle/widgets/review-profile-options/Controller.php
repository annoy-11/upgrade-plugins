<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesarticle_Widget_ReviewProfileOptionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewType = $this->_getParam('viewType', 'vertical');
    $coreMenuApi = Engine_Api::_()->getApi('menus', 'core');
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();

    if (!Engine_Api::_()->core()->hasSubject('sesarticlereview') || !$viewerId)
    return $this->setNoRender();
    
    $review = Engine_Api::_()->core()->getSubject('sesarticlereview');
    $this->view->content_item = Engine_Api::_()->getItem('sesarticle', $review->article_id);
    $this->view->navigation = $coreMenuApi->getNavigation('sesarticlereview_profile');
  }

}
