<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('edocument_admin_main', array(), 'edocument_admin_main_settings');

    $this->view->form  = $form = new Edocument_Form_Admin_Global();

    if( $this->getRequest()->isPost() && $form->isValid($this->_getAllParams()) ) {

      $values = $form->getValues();

      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.pluginactivated')) {
        $this->savememberlevelsettings();
      }

      Engine_Api::_()->getApi('settings', 'core')->setSetting('edocument.pluginactivated', 1);
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.pluginactivated')) {

        //Langauge Change
        $this->wordChange($values);

        foreach ($values as $key => $value){
            if (Engine_Api::_()->getApi('settings', 'core')->hasSetting($key, $value))
                Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
            if (!$value && strlen($value) == 0)
                continue;
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
      }
    } else
        return;

    if ($this->getRequest()->isPost() || !empty($_GET['code'])) {
        //check refresh token
        if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.google.refreshtoken')) {
            include APPLICATION_PATH.DS.'application'.DS.'modules'.DS.'Edocument'.DS.'Api'.DS.'drive.php';
            $createLink = false;
            if (empty($_GET['code'])) {
                $createLink = true;
            }
            $drive = new Drive(null,$createLink);

        }
    }
  }

  public function manageWidgetizePageAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('edocument_admin_main', array(), 'edocument_admin_main_managepages');

    $this->view->pagesArray = array('edocument_index_home', 'edocument_index_browse', 'edocument_category_browse',   'edocument_index_manage', 'edocument_index_create', 'edocument_index_view', 'edocument_index_tags', 'edocument_category_index');
  }

  public function savememberlevelsettings() {

    //Default Privacy Set Work
    $permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
    foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
        $form = new Edocument_Form_Admin_Settings_Level(array(
            'public' => ( in_array($level->type, array('public')) ),
            'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
        ));
        $values = $form->getValues();
        $valuesForm = $permissionsTable->getAllowed('edocument', $level->level_id, array_keys($form->getValues()));

        $form->populate($valuesForm);
        if ($form->defattribut)
            $form->defattribut->setValue(0);
        $db = $permissionsTable->getAdapter();
        $db->beginTransaction();
        try {
            if ($level->type != 'public') {
                // Set permissions
                $values['auth_comment'] = (array) $values['auth_comment'];
                $values['auth_view'] = (array) $values['auth_view'];
            }
            $nonBooleanSettings = $form->nonBooleanFields();
            $permissionsTable->setAllowed('edocument', $level->level_id, $values, '', $nonBooleanSettings);
            // Commit
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
  }

  public function supportAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('edocument_admin_main', array(), 'edocument_admin_main_support');
  }

  public function statisticAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('edocument_admin_main', array(), 'edocument_admin_main_statistic');

    $documentTable = Engine_Api::_()->getDbtable('edocuments', 'edocument');
    $documentTableName = $documentTable->info('name');

    //Total Documents
    $select = $documentTable->select()->from($documentTableName, 'count(*) AS totaldocument');
    $this->view->totaldocument = $select->query()->fetchColumn();

    //Total approved document
    $select = $documentTable->select()->from($documentTableName, 'count(*) AS totalapproveddocument')->where('is_approved =?', 1);
    $this->view->totalapproveddocument = $select->query()->fetchColumn();

    //Total verified document
    $select = $documentTable->select()->from($documentTableName, 'count(*) AS totalverified')->where('verified =?', 1);
    $this->view->totaldocumentverified = $select->query()->fetchColumn();

    //Total featured document
    $select = $documentTable->select()->from($documentTableName, 'count(*) AS totalfeatured')->where('featured =?', 1);
    $this->view->totaldocumentfeatured = $select->query()->fetchColumn();

    //Total sponsored document
    $select = $documentTable->select()->from($documentTableName, 'count(*) AS totalsponsored')->where('sponsored =?', 1);
    $this->view->totaldocumentsponsored = $select->query()->fetchColumn();

    //Total favourite document
    $select = $documentTable->select()->from($documentTableName, 'count(*) AS totalfavourite')->where('favourite_count <>?', 0);
    $this->view->totaldocumentfavourite = $select->query()->fetchColumn();

    //Total comments document
    $select = $documentTable->select()->from($documentTableName, 'count(*) AS totalcomment')->where('comment_count <>?', 0);
    $this->view->totaldocumentcomments = $select->query()->fetchColumn();

     //Total view document
    $select = $documentTable->select()->from($documentTableName, 'count(*) AS totalview')->where('view_count <>?', 0);
    $this->view->totaldocumentviews = $select->query()->fetchColumn();

     //Total like document
    $select = $documentTable->select()->from($documentTableName, 'count(*) AS totallike')->where('like_count <>?', 0);
    $this->view->totaldocumentlikes = $select->query()->fetchColumn();

    //Total rated document
    $select = $documentTable->select()->from($documentTableName, 'count(*) AS totalrated')->where('rating <>?', 0);
    $this->view->totaldocumentrated = $select->query()->fetchColumn();
  }

	public function wordChange($values) {

		//START TEXT CHNAGE WORK IN CSV FILE
		$oldSigularWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.text.singular', 'document');
		$oldPluralWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.text.plural', 'documents');
		$newSigularWord = @$values['edocument_text_singular'] ? @$values['edocument_text_singular'] : 'document';
		$newPluralWord = @$values['edocument_text_plural'] ? @$values['edocument_text_plural'] : 'documents';
		$newSigularWordUpper = ucfirst($newSigularWord);
		$newPluralWordUpper = ucfirst($newPluralWord);
		if($newSigularWord != $oldSigularWord && $newPluralWord != $oldPluralWord) {

			$tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/edocument.csv', 'null', array('delimiter' => ';','enclosure' => '"'));
			if( !empty($tmp['null']) && is_array($tmp['null']) )
				$inputData = $tmp['null'];
			else
				$inputData = array();

			$OutputData = array();
			$chnagedData = array();
			foreach($inputData as $key => $input) {
				$chnagedData = str_replace(array($oldPluralWord, $oldSigularWord,ucfirst($oldPluralWord),ucfirst($oldSigularWord),strtoupper($oldPluralWord),strtoupper($oldSigularWord)), array($newPluralWord, $newSigularWord, ucfirst($newPluralWord), ucfirst($newSigularWord), strtoupper($newPluralWord), strtoupper($newSigularWord)), $input);
				$OutputData[$key] = $chnagedData;
			}

			$targetFile = APPLICATION_PATH . '/application/languages/en/edocument.csv';
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
}
