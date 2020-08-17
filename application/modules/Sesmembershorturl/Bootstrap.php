<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershorturl
 * @package    Sesmembershorturl
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmembershorturl_Bootstrap extends Engine_Application_Bootstrap_Abstract {
  public function __construct($application) {
    parent::__construct($application);
    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Sesmembershorturl_Plugin_Core);


    if(_ENGINE_R_BASE != '/') {
      $layout = Zend_Layout::getMvcInstance();
      $layout->getView()
              ->addFilterPath(APPLICATION_PATH . "/application/modules/Sesmembershorturl/View/Filter", 'Sesmembershorturl_View_Filter_')
              ->addFilter('Bodyclass');
    }

    $enablecustomurl_member = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembershorturl.enablecustomurl', 1);
    if(empty($enablecustomurl_member)) {
      if(!class_exists('User_Model_DbTable_Users', false))
        include_once APPLICATION_PATH .'/application/modules/User/Model/DbTable/Users.php';
      Engine_Api::_()->getDbTable('users', 'user')->setRowClass('Sesmembershorturl_Model_User');
    }
  }

  protected function _initRouter() {
    //Memebr level based work
    $router = Zend_Controller_Front::getInstance()->getRouter();
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembershorturl.pluginactivated')) {
      $enablecustomurl_member = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembershorturl.enablecustomurl', 1);
      if($enablecustomurl_member && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembershorturl.enableglobalurl', 0)){
        $customTect = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembershorturl.customurltext', '');
        $router->addRoute('sesmembershorturl_profile_custom', new Zend_Controller_Router_Route($customTect.'/:id/*', array('module' => 'user', 'controller' => 'profile', 'action' => 'index')));
      }
      if(empty($enablecustomurl_member)) {

        foreach( Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level ) {
            if( $level->type == 'public' ) {
              continue;
          }
          $enablecustomurl = Engine_Api::_()->sesmembershorturl()->getLevelValue($level->level_id, 'enablecustomurl', 'value');
          $customurltext = Engine_Api::_()->sesmembershorturl()->getLevelValue($level->level_id, 'customurltext', 'params');
          if($enablecustomurl == 1) {
            if(!empty($enablecustomurl_member))
              $customurltext = $customurltext.'/:sesmembershorturl_level/:id/*';
            else
             $customurltext = $customurltext.'/:id/*';
            $router->addRoute('sesmembershorturl_profile_' . $level->level_id, new Zend_Controller_Router_Route($customurltext, array('module' => 'user', 'controller' => 'profile', 'action' => 'index')));
          }
        }
        $router->addRoute('user_profile_level', new Zend_Controller_Router_Route($customurltext, array('module' => 'user', 'controller' => 'profile', 'action' => 'index')));
        $router->addRoute('user_profilelevel', new Zend_Controller_Router_Route('FAZXCA88RTYUJHFERCFG455DTR/:id/*', array('module' => 'user', 'controller' => 'profile', 'action' => 'index')));
        return $router;
      }
    }
  }
}
