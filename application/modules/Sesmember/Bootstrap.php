<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  protected function _initRouter() {
    $router = Zend_Controller_Front::getInstance()->getRouter();
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.pluginactivated')) {
      $homepagesTable = Engine_Api::_()->getDbTable('homepages', 'sesmember');
      $select = $homepagesTable->select()->where('type = ?', 'browse');
      $homePages = $homepagesTable->fetchAll($select);
      foreach ($homePages as $homePage) {
        $router->addRoute('sesmember_index_' . $homePage->homepage_id, new Zend_Controller_Router_Route('member/profiletype/profiletype_id/'.$homePage->homepage_id, array('module' => 'sesmember', 'controller' => 'index', 'action' => 'profiletype', 'homepage_id' => $homePage->homepage_id, 'profiletype_id' => $homePage->homepage_id)));
      }
      return $router;
    }
  }

  public function __construct($application) {
    parent::__construct($application);

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$view->headTranslate(array('Location'));

    $this->initViewHelperPath();
    if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '', $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {
      $headScript = new Zend_View_Helper_HeadScript();
      $headScript->appendFile(Zend_Registry::get('StaticBaseUrl')
              . 'application/modules/Sesmember/externals/scripts/core.js');
    }
    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Sesmember_Plugin_Core);

    //Overwrite User Model forPhoto URL function
    if(!class_exists('User_Model_DbTable_Users', false))
        include_once APPLICATION_PATH .'/application/modules/User/Model/DbTable/Users.php';
      Engine_Api::_()->getDbTable('users', 'user')->setRowClass('Sesmember_Model_User');
  }

  protected function _initFrontController() {
    $this->initActionHelperPath();
    include APPLICATION_PATH . '/application/modules/Sesmember/controllers/Checklicense.php';
    Zend_Controller_Action_HelperBroker::addHelper(new Sesmember_Controller_Action_Helper_MemberLocation());
  }

}
