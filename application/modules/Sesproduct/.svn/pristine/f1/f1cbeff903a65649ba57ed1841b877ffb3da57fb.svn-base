<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Installer extends Engine_Package_Installer_Module {

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
                      ->where('name = ?', 'sesproduct.text.singular')
                      ->limit(1)
                      ->query()
                      ->fetchColumn();
	  if(!$singularWord)
      $singularWord = 'product';

		$pluralWord = $db->select()
                    ->from('engine4_core_settings', 'value')
                    ->where('name = ?', 'sesproduct.text.plural')
                    ->limit(1)
                    ->query()
                    ->fetchColumn();
	  if(!$pluralWord)
      $pluralWord = 'sesproducts';

		$oldSigularWord = 'product';
		$oldPluralWord = 'sesproducts';
		$newSigularWord = $singularWord;
		$newPluralWord = $pluralWord;
		$newSigularWordUpper = ucfirst($newSigularWord);
		$newPluralWordUpper = ucfirst($newPluralWord);

		$tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/sesproduct.csv', 'null', array('delimiter' => ';','enclosure' => '"',));

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

		$targetFile = APPLICATION_PATH . '/application/languages/en/sesproduct.csv';
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
