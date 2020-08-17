<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seschristmas_Widget_BannerTemplate1Controller extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $timezone = Engine_Api::_()->getApi('settings', 'core')->core_locale_timezone;
    if ($viewer->getIdentity()) {
      $timezone = $viewer->timezone;
    }

    $this->view->oldTz = date_default_timezone_get();
    date_default_timezone_set($timezone);

    $starttime = date("Y-m-d h:i:s");
    $this->view->start_time = strtotime($starttime);
    $this->view->designType = $this->_getParam('designType', 'circel');
    $this->view->viewType = $this->_getParam('viewType', 'vertical');
    $this->view->showcountdown = $this->_getParam('showcountdown', 0);
    $this->view->showtext1 = $this->_getParam('showtext1', 1);
    $this->view->text1 = $this->_getParam('text1', '');
    $this->view->showtext2 = $this->_getParam('showtext2', 1);
    $this->view->text2 = $this->_getParam('text2', '');

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.welcomechristmas')) {
      return $this->setNoRender();
    }

    if (empty($this->view->showtext1) && empty($this->view->showtext2)) {
      return $this->setNoRender();
    }

    if (empty($this->view->text1) && empty($this->view->text2)) {
      return $this->setNoRender();
    }
  }

}