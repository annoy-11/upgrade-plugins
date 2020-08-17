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
class Sescrowdfunding_Widget_BrowseMenuQuickController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Get quick navigation
    if (!Engine_Api::_()->user()->getViewer()->getIdentity())
      return $this->setNoRender();
    $this->view->quickNavigation = $quickNavigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sescrowdfunding_quick');
  }

}
