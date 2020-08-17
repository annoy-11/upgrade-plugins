<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sespage_Widget_ProfileOptionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject()) {
      return $this->setNoRender();
    }
    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('sespage_page');
    $this->view->navigation = Engine_Api::_()
            ->getApi('menus', 'core')
            ->getNavigation('sespage_profile');
    $paramsg = $this->_getParam('optionsG', 0);
    if ($paramsg) {
      $this->getElement()->removeDecorator('Container');
    }
  }

}
