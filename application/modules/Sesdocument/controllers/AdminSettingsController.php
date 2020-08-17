<?php

class Sesdocument_AdminSettingsController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
	 $db = Zend_Db_Table_Abstract::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesdocument_admin_main', array(), 'sesdocument_admin_main_settings');

    $this->view->form = $form = new Sesdocument_Form_Admin_Global();

    if( $this->getRequest()->isPost() && $form->isValid($this->_getAllParams()) ) {
        $values = $form->getValues();

        //START TEXT CHNAGE WORK IN CSV FILE
        $oldSigularWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.text.singular', 'document');
        $oldPluralWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.text.plural', 'documents');
        $newSigularWord = @$values['sesdocument_text_singular'] ? @$values['sesdocument_text_singular'] : 'document';
        $newPluralWord = @$values['sesdocument_text_plural'] ? @$values['sesdocument_text_plural'] : 'documents';
        $newSigularWordUpper = ucfirst($newSigularWord);
        $newPluralWordUpper = ucfirst($newPluralWord);
        if($newSigularWord != $oldSigularWord && $newPluralWord != $oldPluralWord) {

          $tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/sesdocument.csv', 'null', array('delimiter' => ';','enclosure' => '"'));
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

          $targetFile = APPLICATION_PATH . '/application/languages/en/sesdocument.csv';
          if (file_exists($targetFile))
            @unlink($targetFile);

          touch($targetFile);
          chmod($targetFile, 0777);

          $writer = new Engine_Translate_Writer_Csv($targetFile);
          $writer->setTranslations($OutputData);
          $writer->write();
        }
        //END CSV FILE WORK

        foreach ($values as $key => $value) {
            if(Engine_Api::_()->getApi('settings', 'core')->hasSetting($key))
                Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
    } else
        return;

      if ($this->getRequest()->isPost() || !empty($_GET['code'])){
          //check refresh token
          if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.google.refreshtoken')){
            include APPLICATION_PATH.DS.'application'.DS.'modules'.DS.'Sesdocument'.DS.'Api'.DS.'drive.php';
            $createLink = false;
              if (empty($_GET['code'])){
                  $createLink = true;
              }
              $drive = new Drive(null,$createLink);

          }
    }

  }

  public function levelAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesdocument_admin_main', array(), 'sesdocument_admin_main_level');



    // Get level id
    if (null !== ($id = $this->_getParam('id'))) {
      $level = Engine_Api::_()->getItem('authorization_level', $id);
    } else {
      $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();
    }
    if (!$level instanceof Authorization_Model_Level) {
      throw new Engine_Exception('missing level');
    }
    $level_id = $id = $level->level_id;





    // Make form
    $this->view->form = $form = new Sesdocument_Form_Admin_Level(array(
    'public' => ( in_array($level->type, array('public')) ),
        'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
    ));
    $form->level_id->setValue($level_id);
    $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
		$valuesForm = $permissionsTable->getAllowed('sesdocument', $level_id, array_keys($form->getValues()));


    $form->populate($valuesForm);
    if (!$this->getRequest()->isPost()) {
      return;
    }
    // Check validitiy
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    // Process
    $values = $form->getValues();
    $db = $permissionsTable->getAdapter();
    $db->beginTransaction();
    try {
      if ($level->type != 'public') {
        // Set permissions
        $values['auth_comment'] = (array) $values['auth_comment'];
        $values['auth_photo'] = (array) $values['auth_photo'];
        $values['auth_view'] = (array) $values['auth_view'];
      }
      $permissionsTable->setAllowed('sesdocument', $level_id, $values);
      // Commit
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $form->addNotice('Your changes have been saved.');
  }


   public function manageAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesdocument_admin_main', array(), 'sesdocument_admin_main_manage');

    $this->view->form = $form = new Sesdocument_Form_Admin_Manage();

    //https://docs.google.com/uc?id=1movYpK1q_2UyqlWHft89zaRrR91FBHPS&export=download

  }


   public function widgetAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesdocument_admin_main', array(), 'sesdocument_admin_main_widget');
 $documentsArray = array(

        'sesdocument_index_home',
        'sesdocument_index_create',
        'sesdocument_category_browse',
        'sesdocument_category_index',
        'sesdocument_index_browse',
        'sesdocument_index_manage',
        'sesdocument_index_tags',
        'sesdocument_profile_index',

    );

    $this->view->documentsArray = $documentsArray;
  }

   public function statisticsAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesdocument_admin_main', array(), 'sesdocument_admin_main_statistics');

    $documentTable = Engine_Api::_()->getDbTable('sesdocuments', 'sesdocument');
    $documentTableName = $documentTable->info('name');

    //Total documents
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

  }


   public function helpAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesdocument_admin_main', array(), 'sesdocument_admin_main_help');


  }
}




