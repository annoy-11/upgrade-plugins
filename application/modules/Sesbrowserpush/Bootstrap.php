<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbrowserpush_Bootstrap extends Engine_Application_Bootstrap_Abstract {

   public function __construct($application) {
   
    parent::__construct($application);
    $this->initViewHelperPath();
    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Sesbrowserpush_Plugin_Core);
    
    $headScript = new Zend_View_Helper_HeadScript();
    if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '', $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {
      $headScript->prependFile(Zend_Registry::get('StaticBaseUrl'). 'externals/ses-scripts/sesJquery.js');
    }
  }
  
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesbrowserpush/controllers/Checklicense.php';
  }
}
