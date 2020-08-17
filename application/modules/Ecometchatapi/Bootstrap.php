<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecometchatapi
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Bootstrap.php 2019-12-18 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Ecometchatapi_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
    public function __construct($application)
    {
        parent::__construct($application);
        $frontController = Zend_Controller_Front::getInstance();
        $frontController->registerPlugin( new Ecometchatapi_Plugin_Loader() );
    }
    
    protected function _initFrontController() {
      include APPLICATION_PATH . '/application/modules/Ecometchatapi/controllers/Checklicense.php';
    }
}
