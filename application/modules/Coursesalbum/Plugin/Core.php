<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursesalbum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Core.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Coursesalbum_Plugin_Core extends Zend_Controller_Plugin_Abstract  {
  public function onRenderLayoutDefaultSimple($event) {
    return $this->onRenderLayoutDefault($event, 'simple');
  }
  public function onRenderLayoutDefault($event) {
     $settings =  Engine_Api::_()->getApi('settings', 'core');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

    $headScript = new Zend_View_Helper_HeadScript();
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') .'application/modules/Coursesalbum/externals/scripts/core.js');

  }
}
