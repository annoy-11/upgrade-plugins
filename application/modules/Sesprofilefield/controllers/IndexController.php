<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_IndexController extends Core_Controller_Action_Standard {

  public function addLanguageAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprofilefield_Form_Profile_AddLanguage();
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();
    if($is_ajax) {
      // Process
      $table = Engine_Api::_()->getDbTable('languages', 'sesprofilefield');
      $managelanguages = Engine_Api::_()->getDbTable('managelanguages', 'sesprofilefield');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $getColumnName = Engine_Api::_()->getDbTable('managelanguages', 'sesprofilefield')->getColumnName(array('column_name' => 'managelanguage_id', 'languagename' => $_POST['languagename']));
        $values = array_merge($_POST, array('user_id' => $viewer->getIdentity()));
        if(!empty($getColumnName)) {
            $values['managelanguage_id'] = $getColumnName;
        } else {
            $managerow = $managelanguages->createRow();
            $managerow->setFromArray(array('languagename' => $_POST['languagename'], 'enabled' => 0));
            $managerow->save();
            $values['managelanguage_id'] = $managerow->getIdentity();
        }
        $row = $table->createRow();
        $row->setFromArray($values);
        $row->save();
        $db->commit();

        $languagesEntries = Engine_Api::_()->getDbTable('languages', 'sesprofilefield')->getLanguages(array('user_id' => $viewer->getIdentity(), 'column_name' => '*'));
        $showData =  $this->view->partial('_languages.tpl','sesprofilefield',array('languages' => $languagesEntries, 'viewer_id'=> $viewer_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'count' => count($languagesEntries)));exit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function editLanguageAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->language_id = $language_id = $this->_getParam('language_id');
    $this->view->language = $language = Engine_Api::_()->getItem('sesprofilefield_language', $language_id);

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprofilefield_Form_Profile_EditLanguage();
      // Populate form
      $form->populate($language->toArray());
    }

    if($is_ajax) {
      // Process
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $language->setFromArray($_POST);
        $language->save();
        $db->commit();

        $languageEntries = Engine_Api::_()->getDbTable('languages', 'sesprofilefield')->getLanguages(array('column_name' => '*', 'user_id' => $viewer_id));
        $showData =  $this->view->partial('_languages.tpl','sesprofilefield',array('languages' => $languageEntries, 'viewer_id'=> $viewer_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'count' => count($languageEntries)));exit();
      }
      catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function deleteLanguageAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->language_id = $language_id = $this->_getParam('language_id');
    $language = Engine_Api::_()->getItem('sesprofilefield_language', $language_id);

    if(!$is_ajax) {
      $this->view->form = $form = new Sesprofilefield_Form_Profile_DeleteLanguage();
    }

    if($is_ajax) {
      $db = $language->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $language->delete();
        $db->commit();
      } catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function endorsementAction() {

		$this->view->resource_id = $resource_id = $this->_getParam('resource_id');
    $this->view->showViewMore = $this->_getParam('showViewMore', 0);

    $skills = Engine_Api::_()->getItem('sesprofilefield_skill', $resource_id);

    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('endorsements', 'sesprofilefield')->getEndorsmentPaginator($skills);

		$paginator->setItemCountPerPage(1);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    $this->view->count = $paginator->getTotalItemCount();
  }

  public function endorsementsAction() {

    $viewer = Engine_Api::_()->user()->getViewer() ;
    $resource_id = $this->_getParam( 'resource_id' ) ;
    $resource_type = $this->_getParam( 'resource_type' ) ;
    $endorsement_id = $this->_getParam( 'endorsement_id' ) ;
    $resource = Engine_Api::_()->getItem( $resource_type , $resource_id ) ;

    if ( empty( $endorsement_id ) ) {
      $hasEndorsment = Engine_Api::_()->sesprofilefield()->hasEndorsment($resource_type, $resource_id);
      if ( empty( $hasEndorsment[0]['endorsement_id'] ) ) {
        $endorsementTable = Engine_Api::_()->getItemTable( 'sesprofilefield_endorsements' ) ;
        $db = $endorsementTable->getAdapter() ;
        $db->beginTransaction() ;
        try {
	        $endorsement_id = $endorsementTable->addEndorsment( $resource , $viewer )->endorsement_id ;
	        $this->view->endorsement_id = $endorsement_id ;
	        $db->commit() ;
        }
        catch ( Exception $e ) {
          $db->rollBack() ;
          throw $e ;
        }
      }
      else {
        $this->view->endorsement_id = $hasEndorsment[0]['endorsement_id'] ;
      }
    }
    else {
      if ( !empty( $resource ) && isset( $resource->skill_count ) ) {
        $resource->skill_count-- ;
        $resource->save() ;
      }
      $contentTable = Engine_Api::_()->getDbTable( 'endorsements' , 'sesprofilefield' )->delete( array ( 'endorsement_id =?' => $endorsement_id ) ) ;
    }
    $this->view->skillCount = $resource->skill_count;;
  }

  public function addSkillAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->user_id = $viewer->getIdentity();

		if(!$is_ajax)
      $this->view->form = $form = new Sesprofilefield_Form_Profile_AddSkill();

	  if($is_ajax) {

      $user_id = $this->_getParam('user_id', 0);

      $skillsTable = Engine_Api::_()->getDbtable('skills', 'sesprofilefield');

      $manageskillsTable = Engine_Api::_()->getDbtable('manageskills', 'sesprofilefield');

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      if( $this->getRequest()->isPost()) {

        unset($_POST['skillname']);
        unset($_POST['button']);
        if(isset($_POST['new_skill'])){
          foreach($_POST['new_skill'] as $key => $value){
            $row = $manageskillsTable->createRow();
            $row->setFromArray(array('skillname'=>$value));
            $row->save();
            $userSkillRow = $skillsTable->createRow();
            if(isset($_POST['new_select'][$key])){
              $level = 	$_POST['new_select'][$key];
            }else
              $level = 0;
            $userSkillRow->setFromArray(array('skillname'=>$value,'user_id'=>$user_id,'manageskill_id'=>$row->getIdentity()));
            $userSkillRow->save();
            $db->commit();
          }
        }
        if(isset($_POST['existing_skill'])){
          foreach($_POST['existing_skill'] as $key=>$value)	{
            $row = $skillsTable->createRow();
            if(!isset($_POST['existing_skill_value'][$key]))
              continue;
            if(isset($_POST['existing_select'][$key])){
              $level = 	$_POST['existing_select'][$key];
            } else
              $level = 0;
            $row->setFromArray(array('skillname' => $value, 'user_id' => $user_id, 'manageskill_id'=>$_POST['existing_skill_value'][$key]));
            $row->save();
            $db->commit();
          }
        }
        $db->commit();

        $skills = Engine_Api::_()->getDbtable('skills', 'sesprofilefield')->getSkills(array('user_id' => $viewer->getIdentity(), 'column_name' => '*'));
        $showData =  $this->view->partial('_skills.tpl','sesprofilefield',array('skills' => $skills, 'viewer_id'=> $viewer_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'count' => count($skills)));exit();
      }
	  }
  }

  public function deleteSkillAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->skill_id = $skill_id = $this->_getParam('skill_id');
    $skill = Engine_Api::_()->getItem('sesprofilefield_skill', $skill_id);

    if(!$is_ajax) {
      $this->view->form = $form = new Sesprofilefield_Form_Profile_DeleteSkill();
    }

    if($is_ajax) {
      $db = $skill->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $skill->delete();
        $db->commit();
      } catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function getSkillAction() {

    $sesdata = array();
    $manageskillsTable = Engine_Api::_()->getDbtable('manageskills', 'sesprofilefield');
		$param = $this->_getParam('param', null);
    $user_id = $this->_getParam('user_id', null);
    $allSkills = Engine_Api::_()->getDbtable('skills', 'sesprofilefield')->getSkills(array('user_id' => $user_id, 'column_name' => '*'));
    $skills = array();
    foreach($allSkills as $allSkill) {
	    $skills[] = $allSkill->manageskill_id;
    }

    $select = $manageskillsTable->select()->where('enabled = ?', 1)->where('skillname  LIKE ? ', '%' . $this->_getParam('text') . '%')->order('skillname ASC')->limit('40');

    if($skills)
	    $select = $select->where('manageskill_id NOT IN(?)', $skills);

    $manageskills = $manageskillsTable->fetchAll($select);
    foreach ($manageskills as $manageskill) {
      $sesdata[] = array(
        'id' => $manageskill->manageskill_id,
        'label' => $manageskill->skillname
      );
    }
		if(!count($sesdata) && !$param){
			$sesdata[] = array(
        'id' => 0,
        'label' => 'Add New'
      );
		}
    return $this->_helper->json($sesdata);
  }

  public function getlanguageDataAction() {

    $text = $this->_getParam('text', null);
    $data = array();
    $table = Engine_Api::_()->getDbTable('managelanguages', 'sesprofilefield');
    $select = $table->select()
                    ->where('enabled =?', 1)
                    ->where('languagename LIKE "%' . $this->_getParam('text', '') . '%"')
                    ->group('languagename');
    $results = $table->fetchAll($select);
    foreach ($results as $result) {
        $data[] = array(
          'id' => $result->getIdentity(),
          'label' => $result->languagename,
        );
    }
    return $this->_helper->json($data);
  }

  public function getDataAction() {

    $text = $this->_getParam('text', null);

    $resource_type = $this->_getParam('resource_type', null);

    switch($resource_type) {
      case 'school':
        $tableName = 'schools';
      break;
      case 'degree':
        $tableName = 'degrees';
      break;
      case 'field_of_study':
        $tableName = 'studies';
      break;
      case 'authority':
        $tableName = 'authorities';
      break;
      case 'position':
        $tableName = 'positions';
      break;
      case 'company':
        $tableName = 'companies';
      break;
      case 'language':
        $tableName = 'managelanguages';
      break;
    }

    $data = array();
    $educationsTable = Engine_Api::_()->getDbTable($tableName, 'sesprofilefield');
    $select = $educationsTable->select()
                              ->where('enabled =?', 1)
                              ->where('name LIKE "%' . $this->_getParam('text', '') . '%"')
                              ->group('name');
    $results = $educationsTable->fetchAll($select);
    foreach ($results as $result) {

      if(in_array($resource_type, array('school', 'authority', 'company'))) {
        if($result->photo_id) {
          $icon = $this->view->itemPhoto($result, '');
        } else {
          if($resource_type == 'authority') {
            $icon =  '<img src="application/modules/Sesprofilefield/externals/images/authority.png" alt="" class="main item_photo_sesprofilefield_authority item_nophoto ">';
          } else if($resource_type == 'school') {
            $icon =  '<img src="application/modules/Sesprofilefield/externals/images/school.png" alt="" class="main item_photo_sesprofilefield_school item_nophoto ">';
          } else if($resource_type == 'company') {
            $icon =  '<img src="application/modules/Sesprofilefield/externals/images/company.png" alt="" class="main item_photo_sesprofilefield_company item_nophoto ">';
          }
        }

        $data[] = array(
          'id' => $result->getIdentity(),
          'label' => $result->name,
          'photo' => $icon
        );
      } else {
        $data[] = array(
          'id' => $result->getIdentity(),
          'label' => $result->name,
        );
      }
    }
    return $this->_helper->json($data);
  }

  public function addEducationAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprofilefield_Form_Profile_AddEducation();
    }

    if($is_ajax) {
      // Process
      $table = Engine_Api::_()->getDbTable('educations', 'sesprofilefield');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $values = array_merge($_POST, array(
          'owner_type' => $viewer->getType(),
          'owner_id' => $viewer->getIdentity()
        ));
        $row = $table->createRow();
        $row->setFromArray($values);
        $row->save();

        //Uplaod Document Work
        for($i=1;$i<=3;$i++) {
          if (isset($_FILES['upload_'.$i]['name']) && $_FILES['upload_'.$i]['name'] != '') {
            $storage = Engine_Api::_()->getItemTable('storage_file');
            $filename = $storage->createFile($_FILES['upload_'.$i], array(
              'parent_id' => $viewer_id,
              'parent_type' => 'sesprofilefield',
              'user_id' => $viewer_id,
            ));
            // Remove temporary file
            @unlink($file['tmp_name']);
            $upload = 'upload_'.$i;
            $row->$upload = $filename->file_id;
            $row->save();
          }
        }

        if($_POST['school']) {
          $getColumnValue = Engine_Api::_()->getDbTable('schools', 'sesprofilefield')->getColumnValue(array('name' => $_POST['school']));
          if(empty($getColumnValue)) {
            $dbInsert = Engine_Db_Table::getDefaultAdapter();
            $dbInsert->query('INSERT IGNORE INTO `engine4_sesprofilefield_schools` (`name`) VALUES ("'.$_POST['school'].'");');
          }
        }
        if($_POST['degree']) {
          $getColumnValue = Engine_Api::_()->getDbTable('degrees', 'sesprofilefield')->getColumnValue(array('name' => $_POST['degree']));
          if(empty($getColumnValue)) {
            $dbInsert = Engine_Db_Table::getDefaultAdapter();
            $dbInsert->query('INSERT IGNORE INTO `engine4_sesprofilefield_degrees` (`name`) VALUES ("'.$_POST['degree'].'");');
          }
        }
        if($_POST['field_of_study']) {
          $getColumnValue = Engine_Api::_()->getDbTable('studies', 'sesprofilefield')->getColumnValue(array('name' => $_POST['field_of_study']));
          if(empty($getColumnValue)) {
            $dbInsert = Engine_Db_Table::getDefaultAdapter();
            $dbInsert->query('INSERT IGNORE INTO `engine4_sesprofilefield_studys` (`name`) VALUES ("'.$_POST['field_of_study'].'");');
          }
        }
        $db->commit();

        $educationEntries = Engine_Api::_()->getDbTable('educations', 'sesprofilefield')->getAllEducations($viewer->getIdentity());
        $showData =  $this->view->partial('_educations.tpl','sesprofilefield',array('educationEntries' => $educationEntries, 'viewer_id'=> $viewer_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'count' => count($educationEntries)));exit();

      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function editEducationAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->education_id = $education_id = $this->_getParam('education_id');
    $this->view->education = $education = Engine_Api::_()->getItem('sesprofilefield_education', $education_id);

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprofilefield_Form_Profile_EditEducation();
      // Populate form
      $form->populate($education->toArray());
    }

    if($is_ajax) {
      // Process
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $education->setFromArray($_POST);
        $education->modified_date = date('Y-m-d H:i:s');
        $education->save();

        //Uplaod Document Work
        for($i=1;$i<=3;$i++) {
          if (isset($_FILES['upload_'.$i]['name']) && $_FILES['upload_'.$i]['name'] != '') {
            $storage = Engine_Api::_()->getItemTable('storage_file');
            $filename = $storage->createFile($_FILES['upload_'.$i], array(
              'parent_id' => $viewer_id,
              'parent_type' => 'sesprofilefield',
              'user_id' => $viewer_id,
            ));
            // Remove temporary file
            @unlink($file['tmp_name']);
            $upload = 'upload_'.$i;
            $education->$upload = $filename->file_id;
            $education->save();
          }
        }

        if($_POST['school']) {
          $getColumnValue = Engine_Api::_()->getDbTable('schools', 'sesprofilefield')->getColumnValue(array('name' => $_POST['school']));
          if(empty($getColumnValue)) {
            $dbInsert = Engine_Db_Table::getDefaultAdapter();
            $dbInsert->query('INSERT IGNORE INTO `engine4_sesprofilefield_schools` (`name`) VALUES ("'.$_POST['school'].'");');
          }
        }
        if($_POST['degree']) {
          $getColumnValue = Engine_Api::_()->getDbTable('degrees', 'sesprofilefield')->getColumnValue(array('name' => $_POST['degree']));
          if(empty($getColumnValue)) {
            $dbInsert = Engine_Db_Table::getDefaultAdapter();
            $dbInsert->query('INSERT IGNORE INTO `engine4_sesprofilefield_degrees` (`name`) VALUES ("'.$_POST['degree'].'");');
          }
        }
        if($_POST['field_of_study']) {
          $getColumnValue = Engine_Api::_()->getDbTable('studies', 'sesprofilefield')->getColumnValue(array('name' => $_POST['field_of_study']));
          if(empty($getColumnValue)) {
            $dbInsert = Engine_Db_Table::getDefaultAdapter();
            $dbInsert->query('INSERT IGNORE INTO `engine4_sesprofilefield_studys` (`name`) VALUES ("'.$_POST['field_of_study'].'");');
          }
        }
        $db->commit();

        $educationEntries = Engine_Api::_()->getDbTable('educations', 'sesprofilefield')->getAllEducations($viewer->getIdentity());
        $showData =  $this->view->partial('_educations.tpl','sesprofilefield',array('educationEntries' => $educationEntries, 'viewer_id'=> $viewer_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'count' => count($educationEntries)));exit();

      }
      catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function deleteEducationAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->education_id = $education_id = $this->_getParam('education_id');
    $education = Engine_Api::_()->getItem('sesprofilefield_education', $education_id);

    if(!$is_ajax) {
      $this->view->form = $form = new Sesprofilefield_Form_Profile_DeleteEducation();
    }

    if($is_ajax) {
      $db = $education->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $education->delete();
        $db->commit();
      } catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function addCertificationAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprofilefield_Form_Profile_AddCertification();
    }

    if($is_ajax) {
      // Process
      $table = Engine_Api::_()->getDbTable('certifications', 'sesprofilefield');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $values = array_merge($_POST, array(
          'owner_type' => $viewer->getType(),
          'owner_id' => $viewer->getIdentity()
        ));
        $row = $table->createRow();
        $row->setFromArray($values);
        $row->save();

        if($_POST['authority']) {
          $getColumnValue = Engine_Api::_()->getDbTable('authorities', 'sesprofilefield')->getColumnValue(array('name' => $_POST['authority']));
          if(empty($getColumnValue)) {
            $dbInsert = Engine_Db_Table::getDefaultAdapter();
            $dbInsert->query('INSERT IGNORE INTO `engine4_sesprofilefield_authorities` (`name`) VALUES ("'.$_POST['authority'].'");');
          }
        }

        $db->commit();

        $certificationEntries = Engine_Api::_()->getDbTable('certifications', 'sesprofilefield')->getAllCertifications($viewer_id);
        $showData =  $this->view->partial('_certifications.tpl','sesprofilefield',array('certificationEntries' => $certificationEntries, 'viewer_id'=> $viewer_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'count' => count($certificationEntries)));exit();

      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function editCertificationAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->certification_id = $certification_id = $this->_getParam('certification_id');
    $this->view->certification = $certification = Engine_Api::_()->getItem('sesprofilefield_certification', $certification_id);

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprofilefield_Form_Profile_EditCertification();
      // Populate form
      $form->populate($certification->toArray());
    }

    if($is_ajax) {
      // Process
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $certification->setFromArray($_POST);
        $certification->modified_date = date('Y-m-d H:i:s');
        $certification->save();

        if($_POST['authority']) {
          $getColumnValue = Engine_Api::_()->getDbTable('authorities', 'sesprofilefield')->getColumnValue(array('name' => $_POST['authority']));
          if(empty($getColumnValue)) {
            $dbInsert = Engine_Db_Table::getDefaultAdapter();
            $dbInsert->query('INSERT IGNORE INTO `engine4_sesprofilefield_authorities` (`name`) VALUES ("'.$_POST['authority'].'");');
          }
        }

        $db->commit();

        $certificationEntries = Engine_Api::_()->getDbTable('certifications', 'sesprofilefield')->getAllCertifications($viewer_id);
        $showData =  $this->view->partial('_certifications.tpl','sesprofilefield',array('certificationEntries' => $certificationEntries, 'viewer_id'=> $viewer_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'count' => count($certificationEntries)));exit();
      }
      catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function deleteCertificationAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->certification_id = $certification_id = $this->_getParam('certification_id');
    $certification = Engine_Api::_()->getItem('sesprofilefield_certification', $certification_id);

    if(!$is_ajax) {
      $this->view->form = $form = new Sesprofilefield_Form_Profile_DeleteCertification();
    }

    if($is_ajax) {
      $db = $certification->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $certification->delete();
        $db->commit();
      } catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function addCourseAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprofilefield_Form_Profile_AddCourse();
    }

    if($is_ajax) {
      // Process
      $table = Engine_Api::_()->getDbTable('courses', 'sesprofilefield');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $values = array_merge($_POST, array(
          'owner_type' => $viewer->getType(),
          'owner_id' => $viewer->getIdentity()
        ));
        $row = $table->createRow();
        $row->setFromArray($values);
        $row->save();
        $db->commit();

        $courseEntries = Engine_Api::_()->getDbTable('courses', 'sesprofilefield')->getAllCourses($viewer_id);
        $showData =  $this->view->partial('_courses.tpl','sesprofilefield',array('courseEntries' => $courseEntries, 'viewer_id'=> $viewer_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'count' => count($courseEntries)));exit();

      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function editCourseAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->course_id = $course_id = $this->_getParam('course_id');
    $course = Engine_Api::_()->getItem('sesprofilefield_course', $course_id);

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprofilefield_Form_Profile_EditCourse();
      // Populate form
      $form->populate($course->toArray());
    }

    if($is_ajax) {
      // Process
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $course->setFromArray($_POST);
        $course->modified_date = date('Y-m-d H:i:s');
        $course->save();
        $db->commit();

        $courseEntries = Engine_Api::_()->getDbTable('courses', 'sesprofilefield')->getAllCourses($viewer_id);
        $showData =  $this->view->partial('_courses.tpl','sesprofilefield',array('courseEntries' => $courseEntries, 'viewer_id'=> $viewer_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'count' => count($courseEntries)));exit();
      }
      catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function deleteCourseAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->course_id = $course_id = $this->_getParam('course_id');
    $course = Engine_Api::_()->getItem('sesprofilefield_course', $course_id);

    if(!$is_ajax) {
      $this->view->form = $form = new Sesprofilefield_Form_Profile_DeleteCourse();
    }

    if($is_ajax) {
      $db = $course->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $course->delete();
        $db->commit();
      } catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }


  public function addAwardAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprofilefield_Form_Profile_AddAward();
    }

    if($is_ajax) {
      // Process
      $table = Engine_Api::_()->getDbTable('awards', 'sesprofilefield');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $values = array_merge($_POST, array(
          'owner_type' => $viewer->getType(),
          'owner_id' => $viewer->getIdentity()
        ));
        $row = $table->createRow();
        $row->setFromArray($values);
        $row->save();
        $db->commit();

        $awardEntries = Engine_Api::_()->getDbTable('awards', 'sesprofilefield')->getAllAwards($viewer_id);
        $showData =  $this->view->partial('_awards.tpl','sesprofilefield',array('awardEntries' => $awardEntries, 'viewer_id'=> $viewer_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'count' => count($awardEntries)));exit();

      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function editAwardAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->award_id = $award_id = $this->_getParam('award_id');
    $award = Engine_Api::_()->getItem('sesprofilefield_award', $award_id);

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprofilefield_Form_Profile_EditAward();
      // Populate form
      $form->populate($award->toArray());
    }

    if($is_ajax) {
      // Process
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $award->setFromArray($_POST);
        $award->modified_date = date('Y-m-d H:i:s');
        $award->save();
        $db->commit();

        $awardEntries = Engine_Api::_()->getDbTable('awards', 'sesprofilefield')->getAllAwards($viewer_id);
        $showData =  $this->view->partial('_awards.tpl','sesprofilefield',array('awardEntries' => $awardEntries, 'viewer_id'=> $viewer_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'count' => count($awardEntries)));exit();
      }
      catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function deleteAwardAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->award_id = $award_id = $this->_getParam('award_id');
    $award = Engine_Api::_()->getItem('sesprofilefield_award', $award_id);

    if(!$is_ajax) {
      $this->view->form = $form = new Sesprofilefield_Form_Profile_DeleteAward();
    }

    if($is_ajax) {
      $db = $award->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $award->delete();
        $db->commit();
      } catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }


  public function addExperienceAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprofilefield_Form_Profile_AddExperience();
    }

    if($is_ajax) {
      // Process
      $table = Engine_Api::_()->getDbTable('experiences', 'sesprofilefield');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $values = array_merge($_POST, array(
          'owner_type' => $viewer->getType(),
          'owner_id' => $viewer->getIdentity()
        ));
        $row = $table->createRow();
        $row->setFromArray($values);
        $row->save();

        //Uplaod Document Work
        if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {

          $storage = Engine_Api::_()->getItemTable('storage_file');
          $filename = $storage->createFile($_FILES['file'], array(
            'parent_id' => $viewer_id,
            'parent_type' => 'sesprofilefield',
            'user_id' => $viewer_id,
          ));
          // Remove temporary file
          @unlink($file['tmp_name']);

          $row->photo_id = $filename->file_id;
          $row->save();
        }

        if($_POST['title']) {
          $getColumnValue = Engine_Api::_()->getDbTable('positions', 'sesprofilefield')->getColumnValue(array('name' => $_POST['title']));
          if(empty($getColumnValue)) {
            $dbInsert = Engine_Db_Table::getDefaultAdapter();
            $dbInsert->query('INSERT IGNORE INTO `engine4_sesprofilefield_positions` (`name`) VALUES ("'.$_POST['title'].'");');
          }
        }

        if($_POST['company']) {
          $getColumnValue = Engine_Api::_()->getDbTable('companies', 'sesprofilefield')->getColumnValue(array('name' => $_POST['company']));
          if(empty($getColumnValue)) {
            $dbInsert = Engine_Db_Table::getDefaultAdapter();
            $dbInsert->query('INSERT IGNORE INTO `engine4_sesprofilefield_companies` (`name`) VALUES ("'.$_POST['company'].'");');
          }
        }

        $db->commit();

        $experienceEntries = Engine_Api::_()->getDbTable('experiences', 'sesprofilefield')->getAllExperiences($viewer->getIdentity());
        $showData =  $this->view->partial('_work_experience.tpl','sesprofilefield',array('experienceEntries' => $experienceEntries, 'viewer_id'=> $viewer_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'count' => count($experienceEntries)));exit();

      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function editExperienceAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->experience_id = $experience_id = $this->_getParam('experience_id');
    $this->view->experience = $experience = Engine_Api::_()->getItem('sesprofilefield_experience', $experience_id);

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprofilefield_Form_Profile_EditExperience();
      // Populate form
      $form->populate($experience->toArray());
    }

    if($is_ajax) {
      // Process
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $experience->setFromArray($_POST);
        $experience->modified_date = date('Y-m-d H:i:s');
        $experience->save();

        //Uplaod Document Work
        if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {

          $storage = Engine_Api::_()->getItemTable('storage_file');
          $filename = $storage->createFile($_FILES['file'], array(
            'parent_id' => $viewer_id,
            'parent_type' => 'sesprofilefield',
            'user_id' => $viewer_id,
          ));
          // Remove temporary file
          @unlink($file['tmp_name']);

          $experience->photo_id = $filename->file_id;
          $experience->save();
        }

        if($_POST['title']) {
          $getColumnValue = Engine_Api::_()->getDbTable('positions', 'sesprofilefield')->getColumnValue(array('name' => $_POST['title']));
          if(empty($getColumnValue)) {
            $dbInsert = Engine_Db_Table::getDefaultAdapter();
            $dbInsert->query('INSERT IGNORE INTO `engine4_sesprofilefield_positions` (`name`) VALUES ("'.$_POST['title'].'");');
          }
        }

        if($_POST['company']) {
          $getColumnValue = Engine_Api::_()->getDbTable('companies', 'sesprofilefield')->getColumnValue(array('name' => $_POST['company']));
          if(empty($getColumnValue)) {
            $dbInsert = Engine_Db_Table::getDefaultAdapter();
            $dbInsert->query('INSERT IGNORE INTO `engine4_sesprofilefield_companies` (`name`) VALUES ("'.$_POST['company'].'");');
          }
        }

        $db->commit();
        $experienceEntries = Engine_Api::_()->getDbTable('experiences', 'sesprofilefield')->getAllExperiences($viewer->getIdentity());
        $showData =  $this->view->partial('_work_experience.tpl','sesprofilefield',array('experienceEntries' => $experienceEntries, 'viewer_id' => $viewer_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'count' => count($experienceEntries)));exit();
      }
      catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function deleteExperienceAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->experience_id = $experience_id = $this->_getParam('experience_id');
    $experience = Engine_Api::_()->getItem('sesprofilefield_experience', $experience_id);

    if(!$is_ajax) {
      $this->view->form = $form = new Sesprofilefield_Form_Profile_DeleteExperience();
    }

    if($is_ajax) {
      $db = $experience->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $experience->delete();
        $db->commit();
      } catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

 public function addOrganizationAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprofilefield_Form_Profile_AddOrganization();
    }

    if($is_ajax) {
      // Process
      $table = Engine_Api::_()->getDbTable('organizations', 'sesprofilefield');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $values = array_merge($_POST, array(
          'owner_type' => $viewer->getType(),
          'owner_id' => $viewer->getIdentity()
        ));
        $row = $table->createRow();
        $row->setFromArray($values);
        $row->save();
        $db->commit();

        $organizationEntries = Engine_Api::_()->getDbTable('organizations', 'sesprofilefield')->getAllOrganizations($viewer->getIdentity());
        $showData =  $this->view->partial('_organization.tpl','sesprofilefield',array('organizationEntries' => $organizationEntries, 'viewer_id'=> $viewer_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'count' => count($organizationEntries)));exit();

      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function editOrganizationAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->organization_id = $organization_id = $this->_getParam('organization_id');
    $this->view->organization = $organization = Engine_Api::_()->getItem('sesprofilefield_organization', $organization_id);

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprofilefield_Form_Profile_EditOrganization();
      // Populate form
      $form->populate($organization->toArray());
    }

    if($is_ajax) {
      // Process
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $organization->setFromArray($_POST);
        $organization->modified_date = date('Y-m-d H:i:s');
        $organization->save();

        $db->commit();
        $organizationEntries = Engine_Api::_()->getDbTable('organizations', 'sesprofilefield')->getAllOrganizations($viewer->getIdentity());
        $showData =  $this->view->partial('_organization.tpl','sesprofilefield',array('organizationEntries' => $organizationEntries, 'viewer_id' => $viewer_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'count' => count($organizationEntries)));exit();
      }
      catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function deleteOrganizationAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->organization_id = $organization_id = $this->_getParam('organization_id');
    $organization = Engine_Api::_()->getItem('sesprofilefield_organization', $organization_id);

    if(!$is_ajax) {
      $this->view->form = $form = new Sesprofilefield_Form_Profile_DeleteOrganization();
    }

    if($is_ajax) {
      $db = $organization->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $organization->delete();
        $db->commit();
      } catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

 public function addProjectAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprofilefield_Form_Profile_AddProject();
    }

    if($is_ajax) {
      // Process
      $table = Engine_Api::_()->getDbTable('projects', 'sesprofilefield');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $values = array_merge($_POST, array(
          'owner_type' => $viewer->getType(),
          'owner_id' => $viewer->getIdentity()
        ));
        $row = $table->createRow();
        $row->setFromArray($values);
        $row->save();
        $db->commit();

        $projectEntries = Engine_Api::_()->getDbTable('projects', 'sesprofilefield')->getAllProjects($viewer->getIdentity());
        $showData =  $this->view->partial('_projects.tpl','sesprofilefield',array('projectEntries' => $projectEntries, 'viewer_id'=> $viewer_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'count' => count($projectEntries)));exit();

      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function editProjectAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->project_id = $project_id = $this->_getParam('project_id');
    $this->view->project = $project = Engine_Api::_()->getItem('sesprofilefield_project', $project_id);

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesprofilefield_Form_Profile_EditProject();
      // Populate form
      $form->populate($project->toArray());
    }

    if($is_ajax) {
      // Process
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $project->setFromArray($_POST);
        $project->modified_date = date('Y-m-d H:i:s');
        $project->save();

        $db->commit();
        $projectEntries = Engine_Api::_()->getDbTable('projects', 'sesprofilefield')->getAllProjects($viewer->getIdentity());
        $showData =  $this->view->partial('_projects.tpl','sesprofilefield',array('projectEntries' => $projectEntries, 'viewer_id' => $viewer_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'count' => count($projectEntries)));exit();
      }
      catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function deleteProjectAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->project_id = $project_id = $this->_getParam('project_id');
    $project = Engine_Api::_()->getItem('sesprofilefield_project', $project_id);

    if(!$is_ajax) {
      $this->view->form = $form = new Sesprofilefield_Form_Profile_DeleteProject();
    }

    if($is_ajax) {
      $db = $project->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $project->delete();
        $db->commit();
      } catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }
}
