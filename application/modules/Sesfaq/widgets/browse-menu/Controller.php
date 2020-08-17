<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfaq_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->browsenavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesfaq_main');
    $sesfaq_browsemenu = Zend_Registry::isRegistered('sesfaq_browsemenu') ? Zend_Registry::get('sesfaq_browsemenu') : null;
    if(empty($sesfaq_browsemenu)) {
      return $this->setNoRender();
    }
  }
}