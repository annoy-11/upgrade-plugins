<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Installer extends Engine_Package_Installer_Module {

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

    $this->_addUserProfileContent();
    $this->_addHashtagSearchContent();
    parent::onInstall();
  }
  
  protected function _addHashtagSearchContent() {

    $db = $this->getDb();
    $select = new Zend_Db_Select($db);

    // hashtag search page
    $select
        ->from('engine4_core_pages')
        ->where('name = ?', 'core_hashtag_index')
        ->limit(1);
    $pageId = $select->query()->fetchObject()->page_id;

    // Check if it's already been placed
    $select = new Zend_Db_Select($db);
    $select
        ->from('engine4_core_content')
        ->where('page_id = ?', $pageId)
        ->where('type = ?', 'widget')
        ->where('name = ?', 'sesarticle.browse-articles');
    $info = $select->query()->fetch();

    if( empty($info) ) {

        // container_id (will always be there)
        $select = new Zend_Db_Select($db);
        $select
            ->from('engine4_core_content')
            ->where('page_id = ?', $pageId)
            ->where('type = ?', 'container')
            ->limit(1);
        $containerId = $select->query()->fetchObject()->content_id;

        // middle_id (will always be there)
        $select = new Zend_Db_Select($db);
        $select
            ->from('engine4_core_content')
            ->where('parent_content_id = ?', $containerId)
            ->where('type = ?', 'container')
            ->where('name = ?', 'middle')
            ->limit(1);
        $middleId = $select->query()->fetchObject()->content_id;

        // tab_id (tab container) may not always be there
        $select
            ->reset('where')
            ->where('type = ?', 'widget')
            ->where('name = ?', 'core.container-tabs')
            ->where('page_id = ?', $pageId)
            ->limit(1);
        $tabId = $select->query()->fetchObject();
        if( $tabId && @$tabId->content_id ) {
            $tabId = $tabId->content_id;
        } else {
            $tabId = null;
        }
        
        $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesarticle.browse-articles',
          'page_id' => $pageId,
          'parent_content_id' => ($tabId ? $tabId : $middleId),
          'order' => 100,
          'params' => '{"enableTabs":["list","simplelist","advlist","grid","advgrid","supergrid","pinboard","map"],"openViewType":"advgrid","show_criteria":["verifiedLabel","favouriteButton","likeButton","socialSharing","like","favourite","comment","ratingStar","rating","view","title","category","by","readmore","creationDate","location","descriptionlist","descriptiongrid","descriptionpinboard","descriptionsimplelist","descriptionadvlist","descriptionadvgrid","descriptionsupergrid","enableCommentPinboard"],"sort":"recentlySPcreated","show_item_count":"1","title_truncation_list":"100","title_truncation_grid":"100","title_truncation_pinboard":"30","title_truncation_simplelist":"45","title_truncation_advlist":"45","title_truncation_advgrid":"45","title_truncation_supergrid":"45","description_truncation_list":"300","description_truncation_grid":"150","description_truncation_pinboard":"150","description_truncation_simplelist":"150","description_truncation_advlist":"150","description_truncation_advgrid":"150","description_truncation_supergrid":"200","height_list":"230","width_list":"461","height_grid":"270","width_grid":"307","height_simplelist":"230","width_simplelist":"260","height_advgrid":"230","width_advgrid":"461","height_supergrid":"250","width_supergrid":"461","width_pinboard":"280","limit_data_pinboard":"12","limit_data_grid":"12","limit_data_list":"12","limit_data_simplelist":"12","limit_data_advlist":"12","limit_data_advgrid":"12","limit_data_supergrid":"12","pagging":"button","title":"Articles","nomobile":"0","name":"sesarticle.browse-articles"}',
        ));
    }
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
      ->where('name = ?', 'sesarticle.profile-sesarticles')
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
        'name'    => 'sesarticle.profile-sesarticles',
        'parent_content_id' => ($tab_id ? $tab_id : $middle_id),
        'order'   => 6,
        'params'  => '{"title":"Sesarticles","titleCount":true}',
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
                      ->where('name = ?', 'sesarticle.text.singular')
                      ->limit(1)
                      ->query()
                      ->fetchColumn();
	  if(!$singularWord)
      $singularWord = 'article';

		$pluralWord = $db->select()
                    ->from('engine4_core_settings', 'value')
                    ->where('name = ?', 'sesarticle.text.plural')
                    ->limit(1)
                    ->query()
                    ->fetchColumn();
	  if(!$pluralWord)
      $pluralWord = 'articles';

		$oldSigularWord = 'article';
		$oldPluralWord = 'articles';
		$newSigularWord = $singularWord;
		$newPluralWord = $pluralWord;
		$newSigularWordUpper = ucfirst($newSigularWord);
		$newPluralWordUpper = ucfirst($newPluralWord);

		$tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/sesarticle.csv', 'null', array('delimiter' => ';','enclosure' => '"',));

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

		$targetFile = APPLICATION_PATH . '/application/languages/en/sesarticle.csv';
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
