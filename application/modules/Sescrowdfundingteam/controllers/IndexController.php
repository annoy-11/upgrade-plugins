<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingteam
 * @package    Sescrowdfundingteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfundingteam_IndexController extends Core_Controller_Action_Standard {

  public function viewAction() {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function getDataAction() {

    $data = $existUserIds = array();
    $text = $this->_getParam('text', null);
    $crowdfunding_id = $this->_getParam('crowdfunding_id', null);
    if($crowdfunding_id) {
      $table = Engine_Api::_()->getDbTable('teams', 'sescrowdfundingteam');
      $select = $table->select()
                      ->where('crowdfunding_id =?', $crowdfunding_id)
                      ->where('type =?', 'sitemember');
      $teams = $table->fetchAll($select);
      foreach($teams as $team) {
        $existUserIds[] = $team->user_id;
      }
    }

    $usersTable = Engine_Api::_()->getDbTable('users', 'user');
    $select = $usersTable->select()
                        ->where('enabled =?', 1)
                        ->where('displayname LIKE "%' . $this->_getParam('text', '') . '%"');
    if($existUserIds) {
      $select->where('user_id NOT IN (?)', $existUserIds);
    }

    $results = $usersTable->fetchAll($select);
    foreach ($results as $result) {
      $icon = $this->view->itemPhoto($result, '');
      $data[] = array(
        'id' => $result->getIdentity(),
        'label' => $result->getTitle(),
        'photo' => $icon
      );
    }
    return $this->_helper->json($data);
  }


  public function editAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->crowdfunding_id = $crowdfunding_id = $this->_getParam('crowdfunding_id', null);
    $this->view->type = $type = $this->_getParam('type', 'sitemember');
    $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $crowdfunding_id);

    $this->view->team_id = $team_id = $this->_getParam('team_id');
    $this->view->team = $team = Engine_Api::_()->getItem('sescrowdfundingteam_team', $team_id);

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sescrowdfundingteam_Form_EditSiteTeam();
      // Populate form
      $form->populate($team->toArray());
    }

    if($is_ajax) {
      // Process
      if (!$_POST['name'])
        unset($_POST['name']);
      if (empty($_POST['photo_id']))
        unset($_POST['photo_id']);
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        if ($_POST["designation_id"]) {
          $team->designation_id = $_POST["designation_id"];
          $designation = Engine_Api::_()->getItem('sescrowdfundingteam_designations', $_POST["designation_id"])->designation;
          $team->designation = $designation;
        }
        $team->setFromArray($_POST);
        $team->save();

        //Uplaod Document Work
        if (isset($_FILES['photo_id']['name']) && $_FILES['photo_id']['name'] != '') {
          $previousCatIcon = $team->photo_id;
          $storage = Engine_Api::_()->getItemTable('storage_file');
          $filename = $storage->createFile($_FILES['photo_id'], array(
            'parent_id' => $team->team_id,
            'parent_type' => 'sescrowdfundingteam_team',
            'user_id' => $viewer_id,
          ));
          // Remove temporary file
          @unlink($file['tmp_name']);
          if ($previousCatIcon) {
            $catIcon = Engine_Api::_()->getItem('storage_file', $previousCatIcon);
            $catIcon->delete();
          }
          $team->photo_id = $filename->file_id;
          $team->save();
        }

        if (isset($_POST['remove_profilecover']) && !empty($_POST['remove_profilecover'])) {
          $storage = Engine_Api::_()->getItem('storage_file', $team->photo_id);
          $team->photo_id = 0;
          $team->save();
          if ($storage)
            $storage->delete();
        }

        $db->commit();

        $paginator = Engine_Api::_()->getDbTable('teams', 'sescrowdfundingteam')->getTeamMemers(array('crowdfunding_id' => $crowdfunding->crowdfunding_id));
        $showData =  $this->view->partial('_teams.tpl','sescrowdfundingteam',array('paginator' => $paginator, 'viewer_id'=> $viewer_id, 'crowdfunding_id' => $crowdfunding->crowdfunding_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData));exit();

      }
      catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function addAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->crowdfunding_id = $crowdfunding_id = $this->_getParam('crowdfunding_id', null);
    $this->view->type = $type = $this->_getParam('type', 'sitemember');
    $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $crowdfunding_id);

    if(!$is_ajax) {
      //Render Form
      $this->view->form = $form = new Sescrowdfundingteam_Form_AddSiteTeam();
      $form->setTitle('Add New Team Member');
      $form->setDescription("Here, you can choose a team member of your website and enter various information about the team member like Designation, Description, Email, Social URLs, etc.");
    }

    if($is_ajax) {
      // Process
      $table = Engine_Api::_()->getDbTable('teams', 'sescrowdfundingteam');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {

        $values = $_POST;
        $values['crowdfunding_id'] = $crowdfunding_id;
        $values['type'] = $type;
        if($type == 'nonsitemember') {
          $values['user_id'] = 0;
        }

        if (empty($values['photo_id'])) {
          $values['photo_id'] = 0;
        }

        $row = $table->createRow();
        $row->user_id = $values["user_id"];

        if ($values["designation_id"]) {
          $row->designation_id = $values["designation_id"];
          $designation = Engine_Api::_()->getItem('sescrowdfundingteam_designations', $values["designation_id"])->designation;
          $row->designation = $designation;
        }
        $row->setFromArray($values);
        $row->save();

        if (isset($_FILES['photo_id']['name']) && $_FILES['photo_id']['name'] != '') {
          $storage = Engine_Api::_()->getItemTable('storage_file');
          $filename = $storage->createFile($_FILES['photo_id'], array(
            'parent_id' => $row->team_id,
            'parent_type' => 'sescrowdfundingteam_team',
            'user_id' => $viewer_id,
          ));
          // Remove temporary file
          @unlink($file['tmp_name']);
          $row->photo_id = $filename->file_id;
          $row->save();
        }

        $db->commit();
        $paginator = Engine_Api::_()->getDbTable('teams', 'sescrowdfundingteam')->getTeamMemers(array('crowdfunding_id' => $crowdfunding->crowdfunding_id));
        $showData =  $this->view->partial('_teams.tpl','sescrowdfundingteam',array('paginator' => $paginator, 'viewer_id'=> $viewer_id, 'crowdfunding_id' => $crowdfunding->crowdfunding_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData));exit();

      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }


  public function deleteAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->team_id = $team_id = $this->_getParam('team_id');
    $item = Engine_Api::_()->getItem('sescrowdfundingteam_team', $team_id);
    if(!$is_ajax) {
      $this->view->form = $form = new Sescrowdfundingteam_Form_Delete();
    }
    if($is_ajax) {
      $db = $item->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $item->delete();
        $db->commit();
      } catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function addDesignationAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $this->view->crowdfunding_id = $crowdfunding_id = $this->_getParam('crowdfunding_id', null);
    $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $crowdfunding_id);

    if(!$is_ajax) {
      //Render Form
      $this->view->form = $form = new Sescrowdfundingteam_Form_Adddesignation();
      $form->setTitle('Add Designation');
      $form->setDescription("Here, you can add new designation.");
    }

    if($is_ajax) {
      // Process
      $table = Engine_Api::_()->getDbTable('designations', 'sescrowdfundingteam');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $values = $_POST;
        $values['crowdfunding_id'] = $crowdfunding_id;
        $values['is_admincreated'] = 0;
        $row = $table->createRow();
        $row->setFromArray($values);
        $row->save();
        $row->order = $row->getIdentity();
        $row->save();
        $db->commit();
        $paginator = Engine_Api::_()->getDbTable('designations', 'sescrowdfundingteam')->getAllDesignations(array('crowdfunding_id' => $crowdfunding->crowdfunding_id));
        $showData =  $this->view->partial('_designations.tpl','sescrowdfundingteam',array('designations' => $paginator, 'viewer_id'=> $viewer_id, 'crowdfunding_id' => $crowdfunding->crowdfunding_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData));exit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function editDesignationAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $this->view->crowdfunding_id = $crowdfunding_id = $this->_getParam('crowdfunding_id', null);
    $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $crowdfunding_id);
    $this->view->designation_id = $designation_id = $this->_getParam('designation_id');
    $this->view->designation = $designation = Engine_Api::_()->getItem('sescrowdfundingteam_designations', $designation_id);

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sescrowdfundingteam_Form_Editdesignation();
      // Populate form
      $form->populate($designation->toArray());
    }

    if($is_ajax) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $designation->setFromArray($_POST);
        $designation->save();
        $db->commit();
        $paginator = Engine_Api::_()->getDbTable('designations', 'sescrowdfundingteam')->getAllDesignations(array('crowdfunding_id' => $crowdfunding->crowdfunding_id));
        $showData =  $this->view->partial('_designations.tpl','sescrowdfundingteam',array('designations' => $paginator, 'viewer_id'=> $viewer_id, 'crowdfunding_id' => $crowdfunding->crowdfunding_id, 'is_ajax'=>true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData));exit();
      }
      catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  public function deleteDesignationAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $this->view->designation_id = $designation_id = $this->_getParam('designation_id');
    $item = Engine_Api::_()->getItem('sescrowdfundingteam_designations', $designation_id);
    if(!$is_ajax) {
      $this->view->form = $form = new Sescrowdfundingteam_Form_DeleteDesignation();
    }
    if($is_ajax) {
      $db = $item->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $dbInsert = Engine_Db_Table::getDefaultAdapter();
        $db->update('engine4_sescrowdfundingteam_teams', array('designation_id' => '', 'designation' => ''), array('designation_id = ?' => $designation_id));
        $item->delete();
        $db->commit();
      } catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }
}
