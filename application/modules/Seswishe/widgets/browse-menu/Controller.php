<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seswishe_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('seswishe_main');
    $seswishe_browsemenu = Zend_Registry::isRegistered('seswishe_browsemenu') ? Zend_Registry::get('seswishe_browsemenu') : null;
    if(empty($seswishe_browsemenu)) {
      return $this->setNoRender();
    }
    if( count($this->view->navigation) == 1 ) {
      $this->view->navigation = null;
    }
  }
}
