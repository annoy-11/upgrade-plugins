<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Widget_BrowseMenuQuickController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Get quick navigation
    if (!Engine_Api::_()->user()->getViewer()->getIdentity())
      return $this->setNoRender();
    $this->view->popup = $this->_getParam('popup', 1);
    $this->view->quickNavigation = $quickNavigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesgroup_quick');
  }

}
