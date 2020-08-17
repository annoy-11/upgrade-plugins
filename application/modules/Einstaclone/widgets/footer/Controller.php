<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Einstaclone_Widget_FooterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $menuApis = Engine_Api::_()->getApi('menus', 'core');
    $this->view->navigation = $menuApis->getNavigation('core_footer');
    $this->view->socialnavigation = $menuApis->getNavigation('core_social_sites');
    $this->view->einstaclone_extra_menu = $menuApis->getNavigation('einstaclone_extra_menu');
    $einstaclone_browse = Zend_Registry::isRegistered('einstaclone_browse') ? Zend_Registry::get('einstaclone_browse') : null;
    if(empty($einstaclone_browse))
      return $this->setNoRender();
    $this->view->languageNameList = Engine_Api::_()->einstaclone()->getLanguages();
  }
}
