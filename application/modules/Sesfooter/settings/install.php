<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfooter_Installer extends Engine_Package_Installer_Module {

//   public function onPreinstall() {
//
//     $db = $this->getDb();
//     $plugin_currentversion = '4.10.3p8';
//
//     //Check: Basic Required Plugin
//     $select = new Zend_Db_Select($db);
//     $select->from('engine4_core_modules')
//             ->where('name = ?', 'sesbasic');
//     $results = $select->query()->fetchObject();
//     if (empty($results)) {
//       return $this->_error('<div class="global_form"><div><div><p style="color:red;">The required SocialEngineSolutions Basic Required Plugin is not installed on your website. Please download the latest version of this FREE plugin from <a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions.com</a> website.</p></div></div></div>');
//     } else {
//       $error = include APPLICATION_PATH . "/application/modules/Sesbasic/controllers/checkPluginVersion.php";
//       if($error != '1') {
//         return $this->_error($error);
//       }
// 		}
//     parent::onPreinstall();
//   }

  public function onInstall()
  {
    parent::onInstall();
  }

  function onEnable() {

    $db = $this->getDb();

    //Footer Work
    $select = new Zend_Db_Select($db);
    $select
            ->from('engine4_core_content', 'name')
            ->where('page_id = ?', 2)
            ->where('name LIKE ?', '%menu-footer%')
            ->limit(1);
    $info = $select->query()->fetch();
    if (!empty($info)) {
      $db->update('engine4_core_content', array(
          'name' => 'sesfooter.footer',
              ), array(
          'name = ?' => $info['name'],
      ));
    }

    parent::onEnable();
  }

  public function onDisable() {

    $db = $this->getDb();
	  //Footer Work
    $db->query("UPDATE  `engine4_core_content` SET  `name` =  'core.menu-footer' WHERE  `engine4_core_content`.`name` ='sesfooter.footer' LIMIT 1");

    parent::onDisable();
  }


  public function onPostInstall() {

    $db = $this->getDb();

    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_modules')
            ->where('name = ?', 'sesfooter');
    $results = $select->query()->fetchObject();

    if (!empty($results)) {

      //WORK FOR GOOGLE FONT LOAD AND WRITE IN TO XML FILE
      //Taken this code from here: /application/modules/Activity/controllers/NotificationsController.php
      $front = Zend_Controller_Front::getInstance();
      $action = $front->getRequest()->getActionName();
      $controller = $front->getRequest()->getControllerName();
      if ($controller == 'manage' && ($action == 'query' || $action == 'install')) {
        $view = new Zend_View();
        $installURL =(!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on' ? "https://" : 'http://') . $_SERVER['HTTP_HOST'] . str_replace('install/', '', $view->url(array(), 'default', true));
        $redirectorHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
        if ($action != 'install')
          $redirectorHelper->gotoUrl($installURL . 'admin/sesfooter/manage/constantxml/referralurl/query');
        else
          $redirectorHelper->gotoUrl($installURL . 'admin/sesfooter/manage/constantxml/referralurl/install');
      }
    }
  }
}
