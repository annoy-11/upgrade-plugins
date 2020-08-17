<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//OTP User Phone Number
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'otpsms_index_phone-number')
    ->limit(1)
    ->query()
    ->fetchColumn();

if( !$pageId ) {

    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'otpsms_index_phone-number',
    'displayname' => 'SES - OTP User Phone Number',
    'title' => 'Phone Number',
    'description' => 'This page is the user phone number settings page.',
    'custom' => 0,
    ));
    $pageId = $db->lastInsertId();

    // Insert top
    $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'top',
    'page_id' => $pageId,
    'order' => 1,
    ));
    $topId = $db->lastInsertId();

    // Insert main
    $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $pageId,
    'order' => 2,
    ));
    $mainId = $db->lastInsertId();

    // Insert top-middle
    $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $pageId,
    'parent_content_id' => $topId,
    ));
    $topMiddleId = $db->lastInsertId();

    // Insert main-middle
    $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $pageId,
    'parent_content_id' => $mainId,
    'order' => 2,
    ));
    $mainMiddleId = $db->lastInsertId();

    // Insert menu
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'user.settings-menu',
    'page_id' => $pageId,
    'parent_content_id' => $topMiddleId,
    'order' => 1,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.content',
    'page_id' => $pageId,
    'parent_content_id' => $mainMiddleId,
    'order' => 1,
    ));
}

$phone_number = $db->query('SHOW COLUMNS FROM engine4_users LIKE \'phone_number\'')->fetch();
if (empty($phone_number)) {
    $db->query("ALTER TABLE `engine4_users` ADD `phone_number` VARCHAR(45) NULL;");
}
$country_code = $db->query('SHOW COLUMNS FROM engine4_users LIKE \'country_code\'')->fetch();
if (empty($country_code)) {
    $db->query("ALTER TABLE `engine4_users` ADD `country_code` VARCHAR(45) NULL;");
}
$enable_verification = $db->query('SHOW COLUMNS FROM engine4_users LIKE \'enable_verification\'')->fetch();
if (empty($enable_verification)) {
    $db->query("ALTER TABLE `engine4_users` ADD `enable_verification` tinyint(1) NOT NULL DEFAULT \"1\";");
}

//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $formPermmission = new Otpsms_Form_Admin_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
  ));
  $values = $formPermmission->getValues();
  $valuesForm = $permissionsTable->getAllowed('otpsms', $level->level_id, array_keys($formPermmission->getValues()));

  $formPermmission->populate($valuesForm);
  if ($formPermmission->defattribut)
    $formPermmission->defattribut->setValue(0);
  $db = $permissionsTable->getAdapter();
  $db->beginTransaction();
  try {
    $nonBooleanSettings = $formPermmission->nonBooleanFields();
    $permissionsTable->setAllowed('otpsms', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}

//SET language template
$translate = Zend_Registry::get('Zend_Translate');
// Prepare language list
$languageList = $translate->getList();
$localeObject = Zend_Registry::get('Locale');

$languages = Zend_Locale::getTranslationList('language', $localeObject);
$territories = Zend_Locale::getTranslationList('territory', $localeObject);

$defaultLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');
if (!in_array($defaultLanguage, $languageList)) {
	if ($defaultLanguage == 'auto' && isset($languageList['en'])) {
		$defaultLanguage = 'en';
	} else {
		$defaultLanguage = null;
	}
}
$localeMultiOptions = array();
foreach ($languageList as $key) {
	$languageName = null;
	if (!empty($languages[$key])) {
		$languageName = $languages[$key];
	} else {
		$tmpLocale = new Zend_Locale($key);
		$region = $tmpLocale->getRegion();
		$language = $tmpLocale->getLanguage();
		if (!empty($languages[$language]) && !empty($territories[$region])) {
			$languageName = $languages[$language] . ' (' . $territories[$region] . ')';
		}
	}
	if ($languageName) {
		$localeMultiOptions[$key] = $languageName;
	} else {
		$localeMultiOptions[$key] = '';
	}
}
$localeMultiOptions = array_merge(array($defaultLanguage => $defaultLanguage
		), $localeMultiOptions);
foreach($localeMultiOptions as $key=>$language){
	$formLanguage = new Otpsms_Form_Admin_Templates();
	$formLanguage->language->setValue($key);
	$result = Engine_Api::_()->getDbTable('templates','otpsms')->getTemplates($key);
    if($result)
      $formLanguage->populate($result->toArray());

	if($result){
		$result->setFromArray($formLanguage->getValues());
		$result->save();
	}else{
		$table = Engine_Api::_()->getDbTable('templates','otpsms');
		$result = $table->createRow();
		$result->setFromArray($formLanguage->getValues());
		$result->save();
	}
}
