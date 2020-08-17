<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  public function __construct($application) {
    parent::__construct($application);
    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Sesgroup_Plugin_Core);
    $baseURL = Zend_Registry::get('StaticBaseUrl');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $this->initViewHelperPath();
    $headScript = new Zend_View_Helper_HeadScript();
    define('SESGROUPSHOWUSERDETAIL', Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.show.userdetail', 1));
    $isSesgroupurlEnable = 0;
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesgroupurl')) {
      $isSesgroupurlEnable = 1;
    }
    define('SESGROUPURLENABLED', $isSesgroupurlEnable);
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup_enable_location', 1))
      $headScript->appendFile('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' . Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.mapApiKey', ''));

    if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '', $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {

      $headScript = new Zend_View_Helper_HeadScript();
      $headScript->appendFile($baseURL . 'application/modules/Sesbasic/externals/scripts/flexcroll.js');
      $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.flex-images.js');
    }

    if (!class_exists('Core_Model_Like', false))
      include_once APPLICATION_PATH . '/application/modules/Core/Model/Like.php';
    Engine_Api::_()->getDbTable('likes', 'core')->setRowClass('Sesgroup_Model_Like');

    if (!class_exists('Core_Model_Comment', false))
      include_once APPLICATION_PATH . '/application/modules/Core/Model/Comment.php';
    Engine_Api::_()->getDbTable('comments', 'core')->setRowClass('Sesgroup_Model_Comment');
  }

  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesgroup/controllers/Checklicense.php';
    $this->initActionHelperPath();
    Zend_Controller_Action_HelperBroker::addHelper(new Sesgroup_Controller_Action_Helper_ShowDetailsSesgroup());
  }

}
