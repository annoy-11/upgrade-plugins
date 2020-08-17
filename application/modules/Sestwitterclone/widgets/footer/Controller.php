<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sestwitterclone_Widget_FooterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_footer');

    $this->view->socialnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_social_sites');

    $this->view->sestwitterclone_extra_menu = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestwitterclone_extra_menu');

    //Call function from sesbasic
    $this->view->languageNameList = Engine_Api::_()->sesbasic()->getLanguages();
  }
}
