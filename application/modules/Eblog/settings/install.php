<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_Installer extends Engine_Package_Installer_Module {

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

    //Blog Contributors depadent on Advanced Members Plugin
    $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("eblog_main_contributors", "eblog", "Browse Contributors", "Eblog_Plugin_Menus::canBlogsContributors", \'{"route":"eblog_general","action":"contributors"}\', "eblog_main", "", 6);');

    //Browse Blog Contributors Page
    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'eblog_index_contributors')
      ->limit(1)
      ->query()
      ->fetchColumn();
    if( !$page_id ) {
      $widgetOrder = 1;
      $db->insert('engine4_core_pages', array(
        'name' => 'eblog_index_contributors',
        'displayname' => 'SES - Advanced Blog - Browse Blog Contributors Page',
        'title' => 'Browse Blog Contributors',
        'description' => 'This page show all blog contributors of your site.',
        'custom' => 0,
      ));
      $page_id = $db->lastInsertId();
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'top',
        'page_id' => $page_id,
        'order' => 1,
      ));
      $top_id = $db->lastInsertId();
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
        'order' => 2,
      ));
      $main_id = $db->lastInsertId();
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $top_id,
      ));
      $top_middle_id = $db->lastInsertId();

      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 2,
      ));
      $main_middle_id = $db->lastInsertId();

      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'eblog.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
      ));

      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesmember.browse-search',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
        'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPrated","featured","sponsored","verified"],"view":["0","1","3","week","month"],"default_search_type":"creation_date ASC","show_advanced_search":"1","network":"yes","alphabet":"yes","friend_show":"yes","search_title":"yes","browse_by":"yes","location":"yes","kilometer_miles":"yes","country":"yes","state":"yes","city":"yes","zip":"yes","member_type":"yes","has_photo":"yes","is_online":"yes","is_vip":"yes","title":"","nomobile":"0","name":"sesmember.browse-search"}'
      ));

      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesmember.browse-members',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
        'params' => '{"enableTabs":["list","advlist","grid","advgrid","pinboard","map"],"openViewType":"advlist","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","vipLabel","message","friendButton","followButton","likeButton","likemainButton","socialSharing","like","location","rating","view","title","friendCount","mutualFriendCount","profileType","age","profileField","heading","labelBold","pinboardSlideshow"],"limit_data":"12","profileFieldCount":"5","pagging":"button","order":"mostSPviewed","show_item_count":"1","list_title_truncation":"45","grid_title_truncation":"45","advgrid_title_truncation":"45","pinboard_title_truncation":"45","main_height":"350","main_width":"585","height":"200","width":"250","photo_height":"250","photo_width":"284","info_height":"315","advgrid_height":"322","advgrid_width":"382","pinboard_width":"350","title":"","nomobile":"0","name":"sesmember.browse-members"}',
      ));
    }

    $this->_addUserProfileContent();
    parent::onInstall();
  }

  protected function _addUserProfileContent() {

    $db = $this->getDb();

    $select = new Zend_Db_Select($db);
    // profile page
    $select
      ->from('engine4_core_pages')
      ->where('name = ?', 'user_profile_index')
      ->limit(1);
    $page_id = $select->query()->fetchObject()->page_id;

    // Check if it's already been placed
    $select = new Zend_Db_Select($db);
    $select
      ->from('engine4_core_content')
      ->where('page_id = ?', $page_id)
      ->where('type = ?', 'widget')
      ->where('name = ?', 'eblog.profile-eblogs')
      ;
    $info = $select->query()->fetch();

    if( empty($info) ) {

      // container_id (will always be there)
      $select = new Zend_Db_Select($db);
      $select
        ->from('engine4_core_content')
        ->where('page_id = ?', $page_id)
        ->where('type = ?', 'container')
        ->limit(1);
      $container_id = $select->query()->fetchObject()->content_id;

      // middle_id (will always be there)
      $select = new Zend_Db_Select($db);
      $select
        ->from('engine4_core_content')
        ->where('parent_content_id = ?', $container_id)
        ->where('type = ?', 'container')
        ->where('name = ?', 'middle')
        ->limit(1);
      $middle_id = $select->query()->fetchObject()->content_id;

      // tab_id (tab container) may not always be there
      $select
        ->reset('where')
        ->where('type = ?', 'widget')
        ->where('name = ?', 'core.container-tabs')
        ->where('page_id = ?', $page_id)
        ->limit(1);
      $tab_id = $select->query()->fetchObject();
      if( $tab_id && @$tab_id->content_id ) {
          $tab_id = $tab_id->content_id;
      } else {
        $tab_id = null;
      }

      // tab on profile
      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type'    => 'widget',
        'name'    => 'eblog.profile-eblogs',
        'parent_content_id' => ($tab_id ? $tab_id : $middle_id),
        'order'   => 6,
        'params'  => '{"title":"Eblogs","titleCount":true}',
      ));

    }
  }

  public function onPostInstall() {

    if (!class_exists('Engine_Translate_Parser_Csv')) {
      include APPLICATION_PATH . "/application/libraries/Engine/Translate/Parser/Csv.php";
      include APPLICATION_PATH . "/application/libraries/Engine/Translate/Writer/Csv.php";
		}

		//START TEXT CHNAGE WORK IN CSV FILE
		$db = $this->getDb();
    $singularWord = $db->select()
                      ->from('engine4_core_settings', 'value')
                      ->where('name = ?', 'eblog.text.singular')
                      ->limit(1)
                      ->query()
                      ->fetchColumn();
	  if(!$singularWord)
      $singularWord = 'blog';

		$pluralWord = $db->select()
                    ->from('engine4_core_settings', 'value')
                    ->where('name = ?', 'eblog.text.plural')
                    ->limit(1)
                    ->query()
                    ->fetchColumn();
	  if(!$pluralWord)
      $pluralWord = 'blogs';

		$oldSigularWord = 'blog';
		$oldPluralWord = 'blogs';
		$newSigularWord = $singularWord;
		$newPluralWord = $pluralWord;
		$newSigularWordUpper = ucfirst($newSigularWord);
		$newPluralWordUpper = ucfirst($newPluralWord);

		$tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/eblog.csv', 'null', array('delimiter' => ';','enclosure' => '"',));

		if( !empty($tmp['null']) && is_array($tmp['null']) )
      $inputData = $tmp['null'];
		else
      $inputData = array();

		$OutputData = array();
		$chnagedData = array();
		foreach($inputData as $key => $input) {
			$chnagedData = str_replace(array($oldSigularWord,$oldPluralWord,ucfirst($oldSigularWord),ucfirst($oldPluralWord),strtoupper($oldSigularWord),strtoupper($oldPluralWord)), array($newSigularWord, $newPluralWord, ucfirst($newSigularWord), ucfirst($newPluralWord), strtoupper($newSigularWord), strtoupper($newPluralWord)), $input);
			$OutputData[$key] = $chnagedData;
		}

		$targetFile = APPLICATION_PATH . '/application/languages/en/eblog.csv';
		if (file_exists($targetFile))
      @unlink($targetFile);

		touch($targetFile);
		chmod($targetFile, 0777);

		$writer = new Engine_Translate_Writer_Csv($targetFile);
		$writer->setTranslations($OutputData);
		$writer->write();
		//END CSV FILE WORK
  }
}
