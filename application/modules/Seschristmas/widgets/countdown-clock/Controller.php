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
class Seschristmas_Widget_CountdownClockController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->showcountdown = $this->_getParam('showcountdown', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $timezone = Engine_Api::_()->getApi('settings', 'core')->core_locale_timezone;
    if ($viewer->getIdentity()) {
      $timezone = $viewer->timezone;
    }

    $this->view->oldTz = date_default_timezone_get();
    date_default_timezone_set($timezone);

    $starttime = date("Y-m-d h:i:s");    
    $this->view->start_time = strtotime($starttime);
  }

}

