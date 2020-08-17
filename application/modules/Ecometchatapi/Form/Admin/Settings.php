<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecometchatapi
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Settings.php 2019-12-18 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Ecometchatapi_Form_Admin_Settings extends Engine_Form {
  
  public function init() {
    
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
        ->setDescription('These settings affect all members in your community. Read FAQ, how to create CometChat Key and ID here.');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);
    $this->addElement('Text', "ecometchatapi_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('ecometchatapi.licensekey'),
    ));
    $this->getElement('ecometchatapi_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $site = '<a href="https://app.cometchat.io/" target="_blank">here</a>';
    $descKey = sprintf('Enter the API key of Comet Chat below. You can get CometChat API key from Comect Chat site %s.',$site);


    if ($settings->getSetting('ecometchatapi.pluginactivated')) {
      $this->addElement('Text', 'commetchatapi_key', array(
          'label' => 'Cometchat API Key',
          'description' => $descKey,
          'value'=>$settings->getSetting('commetchatapi.key', ''),
      ));
      $this->getElement('commetchatapi_key')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

      $descId = sprintf('Enter the Comet Chat ID below. You can get CometChat ID from CometChat site %s.',$site);


      $this->addElement('Text', 'commetchatapi_id', array(
          'label' => 'Cometchat ID',
          'description' => $descId,
          'value'=>$settings->getSetting('commetchatapi.id', ''),
      ));
      $this->getElement('commetchatapi_id')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));


      $descRegion = sprintf('Choose the Comet Chat region below. Choose the same region which you have chosen for your CometChat App from CometChat site %s.',$site);


      $this->addElement('Select', 'commetchatapi_region', array(
          'label' => 'Cometchat Region',
          'description' => $descRegion,
          'multiOptions' => array('us'=>'USA','eu'=>'Europe'),
          'value'=>$settings->getSetting('commetchatapi.region', ''),
      ));
      $this->getElement('commetchatapi_region')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

      //

      $syncLevels = "1. Sync Existing Member Levels";
      $syncLevelsImage = "<img src=\"application/modules/Ecometchatapi/externals/images/check-disable.png\" />";


      $syncUsers = '2. Sync Existing Users';
      $syncUsersImage = "<img src=\"application/modules/Ecometchatapi/externals/images/check-disable.png\" />";


      $syncFriends = "3. Sync Existing Friendships";
      $syncFriendsImage = "<img src=\"application/modules/Ecometchatapi/externals/images/check-disable.png\" />";


      $levelSink = Engine_Api::_()->getApi('settings', 'core')->getSetting('ecometchatapi.levels.sink', 0);

      $table = Engine_Api::_()->getDbTable("levels",'authorization');
      $select = $table->select()->from($table->info("name"),'COUNT(level_id) as count');
      if($levelSink){
          $select->where("level_id < ?",$levelSink);
      }
      $select->order("level_id DESC");
      $result = $table->fetchRow($select);
      $data = $result->toArray();
      if($data['count']){
          $syncLevels = "1. <a class='activate' href='admin/ecometchatapi/settings/levels'>Sync Existing Member Levels</a>";
      }else{
          $syncLevelsImage = "<img src=\"application/modules/Sesbasic/externals/images/icons/check.png\" />";
          $userSink = Engine_Api::_()->getApi('settings', 'core')->getSetting('ecometchatapi.user.sink', 0);
          $table = Engine_Api::_()->getDbTable("users",'user');
          $select = $table->select()->from($table->info("name"),'COUNT(user_id) as count');
          if($userSink){
              $select->where("user_id < ?",$userSink);
          }
          $select->order("level_id DESC");
          $result = $table->fetchRow($select);
          $data = $result->toArray();
          if($data['count']){
              $syncUsers = "2. <a class='activate' href='admin/ecometchatapi/settings/sink-user'>Sync Existing Users</a>";
          }else{
              $syncUsersImage = "<img src=\"application/modules/Sesbasic/externals/images/icons/check.png\" />";
              $userSink = Engine_Api::_()->getApi('settings', 'core')->getSetting('ecometchatapi.friends.sink', 0);
              $table = Engine_Api::_()->getDbTable("users",'user');
              $select = $table->select()->from($table->info("name"),'COUNT(user_id) as count');
              if($userSink){
                  $select->where("user_id < ?",$userSink);
              }
              $select->order("level_id DESC");
              $result = $table->fetchRow($select);
              $data = $result->toArray();
              if($data['count']){
                  $syncFriends = "3. <a class='activate' href='admin/ecometchatapi/settings/sink-friends'>Sync Existing Friendships</a>";
              }else{
                  $syncFriendsImage = "<img src=\"application/modules/Sesbasic/externals/images/icons/check.png\" />";
              }
          }
      }

      $this->addElement('Dummy','syncsettings', array(
          'label'=>'Sync Settings',
          'description' => 'To start using Cometchat integration, click on sync settings to start syncing in below sequence only: ',
          'content' => '<ul><li>'.$syncLevels.'&nbsp;'.$syncLevelsImage.'</li><li>'.$syncUsers.'&nbsp;'.$syncUsersImage.'</li><li>'.$syncFriends.'&nbsp;'.$syncFriendsImage.'</li></ul>',
      ));

      $this->addElement('Button', 'submit', array(
          'label' => 'Save Settings',
          'type' => 'submit',
          'ignore' => true
      ));
    } else {
        //Add submit button
        $this->addElement('Button', 'submit', array(
            'label' => 'Activate your plugin',
            'type' => 'submit',
            'ignore' => true
        ));
    }
  }
}
