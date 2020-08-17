<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmusic
 * @package    Sesmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmusic_Installer extends Engine_Package_Installer_Module {

//   public function onPreinstall() {
//
//     $db = $this->getDb();
//     $plugin_currentversion = '4.10.3p21';
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

  public function onInstall() {
    $db = $this->getDb();

    //SE mobile menu
    $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("mobi_main_sesmusic", "sesmusic", "Music", "", \'{"route":"sesmusic_general","action":"home"}\', "mobi_browse", "", 100);');
    $db->query("UPDATE `engine4_core_menuitems` SET `enabled` = '0' WHERE `engine4_core_menuitems`.`name` = 'core_main_music';");

    $db->query('INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES
    ("sesmusic_album_addnew", "sesmusic", \'{item:$subject} added new song(s) to album {item:$object}:\', "1", "5", "1", "3", "1", 1);');

    //Check SE Mobile Plugin Enabled
    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_modules')
            ->where('name = ?', 'mobi')
            ->where('enabled = ?', 1);
    $moduleEnabled = $select->query()->fetchObject();
    if (!empty($moduleEnabled)) {
      //Add Player in footer
      $select = new Zend_Db_Select($db);
      $select
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'footer_mobi')
              ->limit(1);
      $page_id = $select->query()->fetch();
      if ($page_id) {
        //Add Player in footer
        $select = new Zend_Db_Select($db);
        $select
                ->from('engine4_core_content', 'content_id')
                ->where('page_id = ?', $page_id['page_id'])
                ->where('name = ?', 'main')
                ->limit(1);
        $info = $select->query()->fetch();
        if ($info) {
          $select = new Zend_Db_Select($db);
          $select
                  ->from('engine4_core_content', 'content_id')
                  ->where('type = ?', 'widget')
                  ->where('name = ?', 'sesmusic.player')
                  ->limit(1);
          $welcome = $select->query()->fetch();
          if ($info) {
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'sesmusic.player',
                'parent_content_id' => $info['content_id'],
                'page_id' => $page_id['page_id'],
                'order' => 1,
            ));
          }
        }
      }
    }

    //Artist View Page
    $page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sesmusic_artist_view')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if (!$page_id) {
      $widgetOrder = 1;
      $db->insert('engine4_core_pages', array(
          'name' => 'sesmusic_artist_view',
          'displayname' => 'Advanced Music - Artist View Page',
          'title' => 'View Artist',
          'description' => 'This page displays a artist.',
          'custom' => 0,
      ));
      $page_id = $db->lastInsertId();
      $db->insert('engine4_core_content', array(
          'type' => 'container',
          'name' => 'main',
          'page_id' => $page_id,
      ));
      $main_id = $db->lastInsertId();
      $db->insert('engine4_core_content', array(
          'type' => 'container',
          'name' => 'middle',
          'page_id' => $page_id,
          'parent_content_id' => $main_id,
      ));
      $middle_id = $db->lastInsertId();
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusic.breadcrumb',
          'page_id' => $page_id,
          'parent_content_id' => $middle_id,
          'order' => $widgetOrder++,
          'params' => '{"viewPageType":"artist"}',
      ));
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusic.profile-artist',
          'page_id' => $page_id,
          'parent_content_id' => $middle_id,
          'order' => 1,
          'params' => '{"informationArtist":["favouriteCountAr","ratingCountAr","description","ratingStarsAr","addFavouriteButtonAr"],"information":["featured","sponsored","hot","postedBy","downloadCount","commentCount","viewCount","likeCount","ratingStars","favouriteCount","playCount","addplaylist","share","report","downloadButton","artists","addFavouriteButton","category"],"title":"","nomobile":"0","name":"sesmusic.profile-artist"}',
      ));
    }

    $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("sesmusic_admin_main_managepages", "sesmusic", "Manage Widgetize Page", "", \'{"route":"admin_default","module":"sesmusic","controller":"settings", "action":"manage-widgetize-page"}\', "sesmusic_admin_main", "", 999);');


    //Music Welcome Page
     $page_id = $db->select()
             ->from('engine4_core_pages', 'page_id')
             ->where('name = ?', 'sesmusic_index_welcome')
            ->limit(1)
            ->query()
             ->fetchColumn();
     if (!$page_id) {
       $widgetOrder = 1;
       $db->insert('engine4_core_pages', array(
          'name' => 'sesmusic_index_welcome',
           'displayname' => 'Advanced Music - Welcome Page',
           'title' => 'Music Welcome Page',
           'description' => 'This page is the music welcome page.',
           'custom' => 0,
       ));
       $page_id = $db->lastInsertId();

      // Insert top
      $db->insert('engine4_core_content', array(
         'type' => 'container',
         'name' => 'top',
         'page_id' => $page_id,
        'order' => 1,
      ));
      $top_id = $db->lastInsertId();

      // Insert main
      $db->insert('engine4_core_content', array(
         'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
        'order' => 2,
      ));
       $main_id = $db->lastInsertId();

      // Insert top-middle
       $db->insert('engine4_core_content', array(
         'type' => 'container',
         'name' => 'middle',
        'page_id' => $page_id,
         'parent_content_id' => $top_id,
       ));
       $top_middle_id = $db->lastInsertId();

       // Insert main-middle
       $db->insert('engine4_core_content', array(
         'type' => 'container',
         'name' => 'middle',
         'page_id' => $page_id,
         'parent_content_id' => $main_id,
         'order' => 2,
       ));
       $main_middle_id = $db->lastInsertId();
     }
    parent::onInstall();
  }

  public function onEnable() {

    $db = $this->getDb();
    $sesModules = array('sesbasic');
    $base_url = Zend_Controller_Front::getInstance()->getBaseUrl();
    foreach ($sesModules as $sesModule) {
      $select = new Zend_Db_Select($db);
      $select->from('engine4_core_modules')
              ->where('name = ?', $sesModule)
              ->where('enabled = ?', 1);
      $moduleEnabled = $select->query()->fetchObject();
      if (empty($moduleEnabled)) {
        $errorMsg .= '<div class="global_form"><div><div><p style="color:red;">The SocialEngineSolutions Basic Required Plugin is installed but not enabled on your website. So, please first enable it from the "<a href="' . $base_url . '"/manage">Manage Packages</a>" section.</p></div></div></div>';
      }
    }
    if ($errorMsg) {
      echo $errorMsg;
      die;
    }
    parent::onEnable();
  }

}
