<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecometchatapi
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminSettingsController.php 2019-12-18 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Ecometchatapi_AdminSettingsController extends Core_Controller_Action_Admin
{

    public function sinkUserAction(){
        $userSink = Engine_Api::_()->getApi('settings', 'core')->getSetting('ecometchatapi.user.sink', 0);
        $table = Engine_Api::_()->getDbTable("users",'user');
        $select = $table->select();
        if($userSink){
            $select->where("user_id < ?",$userSink);
        }
        $select->order("user_id DESC");
        $select->limit(500);
        $result = $table->fetchAll($select);
        foreach($result as $user){
            $chatData['url'] = "https://api-".Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.region', 'us').".cometchat.io/v2.0/users";
            $chatData['postData']['uid'] = $user->getIdentity();
            $chatData['postData']['name'] = $user->getTitle();
            $chatData['postData']['avatar'] = Engine_Api::_()->ecometchatapi()->getUserPhotoUrl($user);
            $chatData['postData']['link'] = Engine_Api::_()->ecometchatapi()->getUserProfileUrl($user);;
            $chatData['postData']['role'] = $user->level_id;
            Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatData);
            Engine_Api::_()->getApi('settings', 'core')->setSetting('ecometchatapi.user.sink', $user->getIdentity());
        }
        header("Location:".Engine_Api::_()->ecometchatapi()->getBaseUrl("/admin/ecometchatapi/settings"));
        exit();
    }
    public function sinkFriendsAction(){
        $userSink = Engine_Api::_()->getApi('settings', 'core')->getSetting('ecometchatapi.friends.sink', 0);
        $table = Engine_Api::_()->getDbTable("users",'user');
        $select = $table->select();
        if($userSink){
            $select->where("user_id < ?",$userSink);
        }
        $select->order("user_id DESC");
        $select->limit(500);
        $result = $table->fetchAll($select);
        foreach($result as $user){
            $chatData['url'] = "https://api-".Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.region', 'us').".cometchat.io/v2.0/users/".$user->getIdentity().'/friends';
            $membership = $user->membership()->getMembershipsOfIds();
            $chatData['postData']['accepted'] = $membership;
            Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatData);
            Engine_Api::_()->getApi('settings', 'core')->setSetting('ecometchatapi.friends.sink', $user->getIdentity());
        }
        header("Location:".Engine_Api::_()->ecometchatapi()->getBaseUrl("/admin/ecometchatapi/settings"));
        exit();
    }


    public function levelsAction(){
        $table = Engine_Api::_()->getDbtable('levels', 'authorization');
        $select = $table->select();
        $select->order("level_id DESC");
        $results = Zend_Paginator::factory($select);
        foreach ($results as $result) {
            $chatData['url'] = "https://api-".Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.region', 'us').".cometchat.io/v2.0/roles";
            $chatData['postData']['name'] = $result->getTitle();
            $chatData['postData']['description'] = $result->description;
            $chatData['postData']['role'] = $result->getIdentity();
            Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatData);
            Engine_Api::_()->getApi('settings', 'core')->setSetting('ecometchatapi.levels.sink', $result->getIdentity());
        }
        header("Location:".Engine_Api::_()->ecometchatapi()->getBaseUrl("/admin/ecometchatapi/settings"));
        exit();
    }
    
    public function indexAction() {
      $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('ecometchatapi_admin_main', array(), 'ecometchatapi_admin_main_settings');
      $this->view->form = $form = new Ecometchatapi_Form_Admin_Settings();
      if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
          $values = $form->getValues();
          include_once APPLICATION_PATH . "/application/modules/Ecometchatapi/controllers/License.php";
          if (Engine_Api::_()->getApi('settings', 'core')->getSetting('ecometchatapi.pluginactivated')) {
              foreach ($values as $key => $value) {
                if($value != '')
                  Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
              }
              $form->addNotice('Your changes have been saved.');
              if($error)
              $this->_helper->redirector->gotoRoute(array());
          }
      }
    }
}
