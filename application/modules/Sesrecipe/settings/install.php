<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Installer extends Engine_Package_Installer_Module {

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

  public function onInstall() {

    $db = $this->getDb();

    parent::onInstall();
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
                      ->where('name = ?', 'sesrecipe.text.singular')
                      ->limit(1)
                      ->query()
                      ->fetchColumn();
	  if(!$singularWord)
      $singularWord = 'recipe';

		$pluralWord = $db->select()
                    ->from('engine4_core_settings', 'value')
                    ->where('name = ?', 'sesrecipe.text.plural')
                    ->limit(1)
                    ->query()
                    ->fetchColumn();
	  if(!$pluralWord)
      $pluralWord = 'recipes';

		$oldSigularWord = 'recipe';
		$oldPluralWord = 'recipes';
		$newSigularWord = $singularWord;
		$newPluralWord = $pluralWord;
		$newSigularWordUpper = ucfirst($newSigularWord);
		$newPluralWordUpper = ucfirst($newPluralWord);

		$tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/sesrecipe.csv', 'null', array('delimiter' => ';','enclosure' => '"',));

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

		$targetFile = APPLICATION_PATH . '/application/languages/en/sesrecipe.csv';
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
