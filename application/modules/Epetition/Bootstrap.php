<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Bootstrap.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  public function __construct($application) {
    parent::__construct($application);

    if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '', $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {
      $baseURL = Zend_Registry::get('StaticBaseUrl');
      $headScript = new Zend_View_Helper_HeadScript();  //head script for
      if(Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition_enable_location', 1))
        $headScript->appendFile('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' . Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.mapApiKey', ''));
    }
  }

  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Epetition/controllers/Checklicense.php';
  }
}
