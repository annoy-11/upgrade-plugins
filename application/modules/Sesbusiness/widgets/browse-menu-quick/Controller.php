<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Widget_BrowseMenuQuickController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Get quick navigation
    if (!Engine_Api::_()->user()->getViewer()->getIdentity())
      return $this->setNoRender();
    $this->view->popup = $this->_getParam('popup', 1);
    $this->view->quickNavigation = $quickNavigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesbusiness_quick');
  }

}
