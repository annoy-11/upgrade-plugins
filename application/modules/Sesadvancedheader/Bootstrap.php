<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvancedheader_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
  public function __construct($application) {
    parent::__construct($application);
    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Sesadvancedheader_Plugin_Core);
    if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '', $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {
      $baseURL = Zend_Registry::get('StaticBaseUrl');
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $headScript = new Zend_View_Helper_HeadScript();
      $headScript->appendFile($baseURL . 'application/modules/Sesadvancedheader/externals/scripts/core.js');    }

    $this->initViewHelperPath();
    $layout = Zend_Layout::getMvcInstance();
    $layout->getView()
            ->addFilterPath(APPLICATION_PATH . "/application/modules/Sesadvancedheader/View/Filter", 'Sesadvancedheader_View_Filter_')
            ->addFilter('AdvancedHeaderBodyclass');
  }
  
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesadvancedheader/controllers/Checklicense.php';
  }
}
