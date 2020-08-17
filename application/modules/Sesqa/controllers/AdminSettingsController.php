<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesqa_AdminSettingsController extends Core_Controller_Action_Admin {
  public function supportAction() {

        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesqa_admin_main', array(), 'sesqa_admin_main_support');

    }
  public function indexAction() {
     $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesqa_admin_main', array(), 'sesqa_admin_main_settings');
    // Make form
    $this->view->form = $form = new Sesqa_Form_Admin_Global();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
        $values = $form->getValues();
      $oldSigularWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('qanda.singular.text', 'question');
      $oldPluralWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('qanda.plural.text', 'questions');
      $newSigularWord = !empty($values['qanda_singular_text']) ? $values['qanda_singular_text'] : 'question';
      $newPluralWord = !empty($values['qanda_plural_text']) ? $values['qanda_plural_text'] : 'questions';
      $newSigularWordUpper = ucfirst($newSigularWord);
      $newPluralWordUpper = ucfirst($newPluralWord);
      if ($newSigularWord != $oldSigularWord && $newPluralWord != $oldPluralWord) {
        $tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/sesqa.csv', 'null', array('delimiter' => ';', 'enclosure' => '"'));
        if (!empty($tmp['null']) && is_array($tmp['null']))
          $inputData = $tmp['null'];
        else
          $inputData = array();
        $OutputData = array();
        $chnagedData = array();
        foreach ($inputData as $key => $input) {
          $chnagedData = str_replace(array($oldPluralWord, $oldSigularWord, ucfirst($oldPluralWord), ucfirst($oldSigularWord), strtoupper($oldPluralWord), strtoupper($oldSigularWord)), array($newPluralWord, $newSigularWord, ucfirst($newPluralWord), ucfirst($newSigularWord), strtoupper($newPluralWord), strtoupper($newSigularWord)), $input);
          $OutputData[$key] = $chnagedData;
        }
        $targetFile = APPLICATION_PATH . '/application/languages/en/sesqa.csv';
        if (file_exists($targetFile))
          @unlink($targetFile);
        touch($targetFile);
        chmod($targetFile, 0777);
        $writer = new Engine_Translate_Writer_Csv($targetFile);
        $writer->setTranslations($OutputData);
        $writer->write();
        //END CSV FILE WORK
      }

        include_once APPLICATION_PATH . "/application/modules/Sesqa/controllers/License.php";
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.pluginactivated')) {
            foreach ($values as $key => $value) {
            if (is_null($value) || $value == '')
                continue;
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
            }
            $form->addNotice('Your changes have been saved.');
            if($error)
                $this->_helper->redirector->gotoRoute(array());
        }
    }
    
  }

 // for default installation
  function setCategoryPhoto($file, $cat_id, $resize = false) {
    $fileName = $file;
    $name = basename($file);
    $extension = ltrim(strrchr($fileName, '.'), '.');
    $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_type' => 'sesqa_category',
        'parent_id' => $cat_id,
        'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        'name' => $name,
    );

    // Save
    $filesTable = Engine_Api::_()->getDbtable('files', 'storage');
    if ($resize) {
      // Resize image (main)
      $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_poster.' . $extension;
      $image = Engine_Image::factory();
      $image->open($file)
              ->resize(800, 800)
              ->write($mainPath)
              ->destroy();

      // Resize image (normal) make same image for activity feed so it open in pop up with out jump effect.
      $normalPath = $path . DIRECTORY_SEPARATOR . $base . '_thumb.' . $extension;
      $image = Engine_Image::factory();
      $image->open($file)
              ->resize(500, 500)
              ->write($normalPath)
              ->destroy();
    } else {
      $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_poster.' . $extension;
      copy($file, $mainPath);
    }
    if ($resize) {
      // normal main  image resize
      $normalMainPath = $path . DIRECTORY_SEPARATOR . $base . '_icon.' . $extension;
      $image = Engine_Image::factory();
      $image->open($file)
              ->resize(100, 100)
              ->write($normalMainPath)
              ->destroy();
    } else {
      $normalMainPath = $path . DIRECTORY_SEPARATOR . $base . '_icon.' . $extension;
      copy($file, $normalMainPath);
    }
    // Store
    try {
      $iMain = $filesTable->createFile($mainPath, $params);
      if ($resize) {
        $iIconNormal = $filesTable->createFile($normalPath, $params);
        $iMain->bridge($iIconNormal, 'thumb.thumb');
      }
      $iNormalMain = $filesTable->createFile($normalMainPath, $params);
      $iMain->bridge($iNormalMain, 'thumb.icon');
    } catch (Exception $e) {
      die;
      // Remove temp files
      @unlink($mainPath);
      if ($resize) {
        @unlink($normalPath);
      }
      @unlink($normalMainPath);
      // Throw
      if ($e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE) {
        throw new Core_Model_Exception($e->getMessage(), $e->getCode());
      } else {
        throw $e;
      }
    }
    // Remove temp files
    @unlink($mainPath);
    if ($resize) {
      @unlink($normalPath);
    }
    @unlink($normalMainPath);
    // Update row
    // Delete the old file?
    if (!empty($tmpRow)) {
      $tmpRow->delete();
    }
    return $iMain->file_id;
  }

  public function createSettingsAction(){
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesqa_admin_main', array(), 'sesqa_admin_main_createqa');

       // Make form
    $this->view->form = $form = new Sesqa_Form_Admin_Create();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      // Check ffmpeg path
        foreach ($values as $key => $value) {

          if($key == "qanda_create_mediaoptions"){
            if(Engine_Api::_()->getApi('settings', 'core')->hasSetting($key))
               Engine_Api::_()->getApi('settings', 'core')->removeSetting($key) ;
          }


          if (is_null($value) || $value == '')
            continue;
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
    }
  }

  public function manageAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesqa_admin_main', array(), 'sesqa_admin_main_manageqa');
    $this->view->form = $formFilter = new Sesqa_Form_Admin_Filter();
		$this->view->category_id=isset($_GET['category_id']) ?  $_GET['category_id'] : 0;
		$this->view->subcat_id=isset($_GET['subcat_id']) ?  $_GET['subcat_id'] : 0;
		$this->view->subsubcat_id=isset($_GET['subsubcat_id']) ? $_GET['subsubcat_id'] : 0;
		// Process form
    $values = array();
    if( $formFilter->isValid($this->_getAllParams()) ) {
      $values = $formFilter->getValues();
    }
    foreach( $_GET as $key => $value ) {
      if( '' === $value ) {
        unset($_GET[$key]);
      }else
				$values[$key]=$value;
    }
    if( $this->getRequest()->isPost() ) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $album = Engine_Api::_()->getItem('sesqa_questions', $value);
          $album->delete();
        }
      }
    }
		$tableQuestion = Engine_Api::_()->getDbtable('questions', 'sesqa');
		$tableQuestionName = $tableQuestion->info('name');
		$tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $select = $tableQuestion->select()
													->from($tableQuestionName)
												 ->setIntegrityCheck(false)
												 ->joinLeft($tableUserName, "$tableUserName.user_id = $tableQuestionName.owner_id", 'username');
		$select->order('question_id DESC');
		// Set up select info
		if( isset($_GET['category_id']) && $_GET['category_id'] != 0)
      $select->where($tableQuestionName.'.category_id = ?', $values['category_id'] );

		if( isset($_GET['subcat_id']) && $_GET['subcat_id'] != 0)
      $select->where($tableQuestionName.'.subcat_id = ?',  $values['subcat_id']);

		if( isset($_GET['subsubcat_id']) && $_GET['subsubcat_id'] != 0)
      $select->where($tableQuestionName.'.subsubcat_id = ?', $values['subsubcat_id']);

    if( !empty($_GET['title']) )
      $select->where($tableQuestionName.'.title LIKE ?', '%' . $values['title'] . '%');

    if( isset($_GET['is_featured']) && $_GET['is_featured'] != '')
      $select->where($tableQuestionName.'.featured = ?', $values['is_featured']);

    if( isset($_GET['is_hot']) && $_GET['is_hot'] != '')
      $select->where($tableQuestionName.'.hot = ?', $values['is_hot']);

    if( isset($_GET['is_verified']) && $_GET['is_verified'] != '')
      $select->where($tableQuestionName.'.verified = ?', $values['is_verified']);

    if( isset($_GET['is_sponsored']) && $_GET['is_sponsored'] != '')
      $select->where($tableQuestionName.'.sponsored = ?', $values['is_sponsored'] );

    if( !empty($values['creation_date']) )
      $select->where('date(creation_date) = ?', $values['creation_date'] );

		 if( isset($_GET['location']) && $_GET['location'] != '')
      $select->where($tableQuestionName.'.location != ?', '' );

		if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

		if( isset($_GET['offtheday']) && $_GET['offtheday'] != '')
			$select->where($tableQuestionName.'.offtheday =?',$values['offtheday']);


    $page = $this->_getParam('page', 1);

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
		$paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber( $page );

  }

	public function ofthedayAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $type = $this->_getParam('type');
    $param = $this->_getParam('param');
    $this->view->form = $form = new Sesqa_Form_Admin_Oftheday();
      $item = Engine_Api::_()->getItem('sesqa_question', $id);
      $form->setTitle("Question of the Day");
      $form->setDescription('Here, choose the start date and end date for this  album to be displayed as "Question of the Day".');
      if (!$param)
        $form->remove->setLabel("Remove as Question of the Day");
      $table = 'engine4_sesqa_questions';
      $item_id = 'question_id';

    if (!empty($id))
      $form->populate($item->toArray());
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $values = $form->getValues();
      $values['starttime'] = date('Y-m-d',  strtotime($values['starttime']));
      $values['endtime'] = date('Y-m-d', strtotime($values['endtime']));
      $db->update($table, array('starttime' => $values['starttime'], 'endtime' => $values['endtime']), array("$item_id = ?" => $id));
      if ($values['remove']) {
        $db->update($table, array('offtheday' => 0), array("$item_id = ?" => $id));
      } else {
        $db->update($table, array('offtheday' => 1), array("$item_id = ?" => $id));
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Successfully updated the item.')
      ));
    }
  }
  public function viewAction() {
    $this->view->type = $type = $this->_getParam('type', 1);
    $id = $this->_getParam('id', 1);
      $item = Engine_Api::_()->getItem('sesqa_question', $id);

    $this->view->item = $item;
  }
  public function deleteAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->question_id = $id = $this->_getParam('id');
    // Check post
    if( $this->getRequest()->isPost())
    {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try
      {
        $question = Engine_Api::_()->getItem('sesqa_question', $id);
        $question->delete();
        $db->commit();
      }
      catch( Exception $e )
      {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh'=> 10,
          'messages' => array('Question deleted successfully.')
      ));
    }
    // Output
  }
    public function approvedAction(){
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();

        try {
            Engine_Api::_()->getDbtable('questions', 'sesqa')->update(array('approved' => $this->_getParam('status')), array("question_id = ?" => $this->_getParam('id')));
            $question = Engine_Api::_()->getItem('sesqa_question', $this->_getParam('id'));
            $owner = $question->getOwner();
            if($question->approved == 1) {
                Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $owner, $question, 'sesqa_qaapproved');
                Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner->email, 'sesqa_qaapproved', array('host' => $_SERVER['HTTP_HOST'], 'queue' => false, 'title' => $question->title, 'question_link' => $question->getHref(), 'member_name' => $owner->getTitle()));
            } else {
                Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($question->getOwner(), $question->getOwner(), $question, 'sesqa_qadisapproved');

                Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner->email, 'sesqa_qadisapproved', array('host' => $_SERVER['HTTP_HOST'], 'queue' => false, 'title' => $question->title, 'question_link' => $question->getHref(), 'member_name' => $owner->getTitle()));
            }
            $db->commit();
        } catch( Exception $e ) {
            $db->rollBack();
            throw $e;
        }
        header('location:'.$_SERVER['HTTP_REFERER']);
	}
  public function verifiedAction(){
		$id = $this->_getParam('id');
		 $status = $this->_getParam('status');

		  $col = 'question_id';
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try
      {
				Engine_Api::_()->getDbtable('questions', 'sesqa')->update(array(
        'verified' => $status,
      ), array(
        "$col = ?" => $id,
      ));
       $db->commit();
			}
      catch( Exception $e )
      {
        $db->rollBack();
        throw $e;
      }
			header('location:'.$_SERVER['HTTP_REFERER']);
	}
  public function hotAction(){
		$id = $this->_getParam('id');
		 $status = $this->_getParam('status');

		  $col = 'question_id';
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try
      {
				Engine_Api::_()->getDbtable('questions', 'sesqa')->update(array(
        'hot' => $status,
      ), array(
        "$col = ?" => $id,
      ));
       $db->commit();
			}
      catch( Exception $e )
      {
        $db->rollBack();
        throw $e;
      }
			header('location:'.$_SERVER['HTTP_REFERER']);
	}


  public function featureSponsoredAction(){
		 $id = $this->_getParam('id');
		$status = $this->_getParam('status');
		$category = $this->_getParam('category');

		  $col = 'question_id';
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try
      {
				Engine_Api::_()->getDbtable('questions', 'sesqa')->update(array(
        $category => $status,
      ), array(
        "$col = ?" => $id,
      ));
       $db->commit();
			}
      catch( Exception $e )
      {
        $db->rollBack();
        throw $e;
      }
			header('location:'.$_SERVER['HTTP_REFERER']);
	}
  public function statisticsAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesqa_admin_main', array(), 'sesqa_admin_main_statistics');


    //Total Questions
    $questions = Engine_Api::_()->getDbTable('questions','sesqa');
    $this->view->questions = count($questions->fetchAll($questions->select()));

    //Total Featured Questions
    $this->view->featuredquestions = count($questions->fetchAll($questions->select()->where('featured =?',1)));

    //Total Sponsored Questions
    $this->view->sponquestions = count($questions->fetchAll($questions->select()->where('sponsored =?',1)));

    //Total Hot Questions
    $this->view->hotquestions = count($questions->fetchAll($questions->select()->where('hot =?',1)));

    //Total Verified Questions
    $this->view->veriquestions = count($questions->fetchAll($questions->select()->where('verified =?',1)));

    //Total Favourite Questions
    $this->view->favquestions = count($questions->fetchAll($questions->select()->where('favourite_count !=?',0)));

    //Total Open Questions
    $this->view->opnquestions = count($questions->fetchAll($questions->select()->where('open_close =?',0)));

    //Total Closed Questions
    $this->view->closequestions = count($questions->fetchAll($questions->select()->where('favourite_count =?',1)));

    //Total Likes on the Questions
    $select = $questions->select()->from($questions->info('name'), 'count(*) AS totalLikes')->where('like_count <>?', 0);
    $this->view->totalLikes = $select->query()->fetchColumn();

    $select = $questions->select()->from($questions->info('name'), 'count(*) AS totalAnswer')->where('answer_count <>?', 0);
    $this->view->totalAnswer = $select->query()->fetchColumn();


    $select = $questions->select()->from($questions->info('name'), 'count(*) AS followAnswer')->where('follow_count <>?', 0);
    $this->view->followAnswer = $select->query()->fetchColumn();

    $select = $questions->select()->from($questions->info('name'), 'count(*) AS voteAnswer')->where('vote_count <>?', 0);
    $this->view->voteAnswer = $select->query()->fetchColumn();

    $select = $questions->select()->from($questions->info('name'), 'count(*) AS downvote')->where('downvote_count <>?', 0);
    $this->view->downvote = $select->query()->fetchColumn();

    $select = $questions->select()->from($questions->info('name'), 'count(*) AS upvote')->where('upvote_count <>?', 0);
    $this->view->upvote = $select->query()->fetchColumn();

  }


  public function widgetizedAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesqa_admin_main', array(), 'sesqa_admin_main_widgetizedpages');

    $this->view->pagesArray = array('sesqa_category_browse', 'sesqa_category_index', 'sesqa_index_tags', 'sesqa_index_browse', 'sesqa_index_create', 'sesqa_index_view', 'sesqa_index_manage', 'sesqa_index_unanswered', 'sesqa_index_featured', 'sesqa_index_hot', 'sesqa_index_sponsored');
  }
  public function resetPageSettingsAction(){

    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle("Reset This Page?");
    $form->setDescription('Are you sure you want to reset this page? Once reset, it will not be undone.');
    $form->submit->setLabel("Reset Page");
    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    $page_id = (int) $this->_getParam('page_id');
    $pageName = $this->_getParam('page_name');
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    try {
      $db->query("DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`page_id` = $page_id");
      include_once APPLICATION_PATH . "/application/modules/Sesqa/controllers/resetPage.php";
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    if( $this->getRequest()->getParam('format') == 'smoothbox' ) {
      return $this->_forward('success', 'utility', 'core', array(
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('This Page has been reset successfully.')),
        'smoothboxClose' => true,
      ));
    }
  }
}
