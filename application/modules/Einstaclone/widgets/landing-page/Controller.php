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

class Einstaclone_Widget_LandingPageController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->landingpagelogo = $settings->getSetting('einstaclone.landingpagelogo', '');
    $this->view->headerlogo = $settings->getSetting('einstaclone.headerlogo', '');
    $this->view->textblock1 = $settings->getSetting('einstaclone.textblock1', 'Search your Interests.');
    $this->view->textblock2 = $settings->getSetting('einstaclone.textblock2', 'Share your Ideas with others.');
    $this->view->siteTitle = $settings->getSetting('core.general.site.title', 'My Community');
    $this->view->rightheading = $settings->getSetting('einstaclone.rightheading', 'Explore what\'s going on around in the outside world!');
    $einstaclone_browse = Zend_Registry::isRegistered('einstaclone_browse') ? Zend_Registry::get('einstaclone_browse') : null;
    if(empty($einstaclone_browse))
      return $this->setNoRender();
    $this->view->ioslink = $settings->getSetting('einstaclone.ioslink', '');
    $this->view->androidlink = $settings->getSetting('einstaclone.androidlink', '');

  }
}
