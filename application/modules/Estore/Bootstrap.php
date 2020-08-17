<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  public function __construct($application) {
    parent::__construct($application);
    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Estore_Plugin_Core);
    $baseURL = Zend_Registry::get('StaticBaseUrl');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $this->initViewHelperPath();
    $headScript = new Zend_View_Helper_HeadScript();
    define('ESTORESHOWUSERDETAIL', Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.show.userdetail', 1));
    $isEstoreurlEnable = 0;
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('estoreurl')) {
      $isEstoreurlEnable = 1;
    }
    define('ESTOREURLENABLED', $isEstoreurlEnable);

    if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '', $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {

      $headScript = new Zend_View_Helper_HeadScript();
      $headScript->appendFile($baseURL . 'application/modules/Sesbasic/externals/scripts/flexcroll.js');
      $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.flex-images.js');
    }

    if (!class_exists('Core_Model_Like', false))
      include_once APPLICATION_PATH . '/application/modules/Core/Model/Like.php';
    Engine_Api::_()->getDbTable('likes', 'core')->setRowClass('Estore_Model_Like');

    if (!class_exists('Core_Model_Comment', false))
      include_once APPLICATION_PATH . '/application/modules/Core/Model/Comment.php';
    Engine_Api::_()->getDbTable('comments', 'core')->setRowClass('Estore_Model_Comment');
  }

  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Estore/controllers/Checklicense.php';
    $this->initActionHelperPath();
    Zend_Controller_Action_HelperBroker::addHelper(new Estore_Controller_Action_Helper_ShowDetailsEstore());
  }

}
