<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2015-03-10 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesteam_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesteam_admin_main', array(), 'sesteam_admin_main_manage');
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('teams', 'sesteam')->getTeamMemers(array('type' => 'teammember'));
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  //Add new team members
  public function addTeamMemberAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesteam_admin_main', array(), 'sesteam_admin_main_manage');

    //Render Form
    $this->view->form = $form = new Sesteam_Form_Admin_Addteammembers();
    $form->setDescription("Here, you can choose a team member of your website and enter various information about the team member like Designation, Description, Email, Social URLs, etc.");

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $teamTable = Engine_Api::_()->getDbtable('teams', 'sesteam');
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $values = $form->getValues();
        if (!$values["user_id"]) {
          $itemError = Zend_Registry::get('Zend_Translate')->_("You have not chosen a member from the auto-suggest textbox. Please choose the site member from auto-suggest textbox below.");
          $form->addError($itemError);
          return;
        }
        if (!$values['photo_id']) {
          $values['photo_id'] = 0;
        }

        $result = $teamTable->getUserId(array('user_id' => $values["user_id"]));
        if (!empty($result)) {
          $itemError = Zend_Registry::get('Zend_Translate')->_("This member has already been added as team member, please choose any other member.");
          $form->addError($itemError);
          return;
        } else {

          if (empty($result)) {
            $row = $teamTable->createRow();
            $row->user_id = $values["user_id"];
          }

          if ($values["designation_id"]) {
            $row->designation_id = $values["designation_id"];
            $designation = Engine_Api::_()->getItem('sesteam_designations', $values["designation_id"])->designation;
            $row->designation = $designation;
          }
          $row->setFromArray($values);
          $row->save();
          //Upload categories icon
          if (isset($_FILES['photo_id']) && $values['photo_id']) {
            $Icon = $this->setPhoto($form->photo_id, array('team_id' => $row->team_id));
            if (!empty($Icon))
              $row->photo_id = $Icon;
            $row->save();
          }
          $db->commit();
        }
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_helper->redirector->gotoRoute(array('action' => 'index'));
    }
  }

  //Edit team members
  public function editAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesteam_admin_main', array(), 'sesteam_admin_main_manage');

    //Get team id and make team table object according to team id
    $team = Engine_Api::_()->getItem('sesteam_teams', $this->_getParam('team_id'));

    $form = $this->view->form = new Sesteam_Form_Admin_Editteammembers();
    $form->setDescription("Here, you can choose a team member of your website and enter various information about the team member like Designation, Description, Email, Social URLs, etc.");
    $form->button->setLabel('Save Changes');
    $form->populate($team->toArray());

    //Check post
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      if (!$values['name'])
        unset($values['name']);
      if (empty($values['photo_id']))
        unset($values['photo_id']);
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        if ($values["designation_id"]) {
          $team->designation_id = $values["designation_id"];
          $designation = Engine_Api::_()->getItem('sesteam_designations', $values["designation_id"])->designation;
          $team->designation = $designation;
        }
        $team->setFromArray($values);
        $team->save();
        //Upload categories icon
        if (isset($_FILES['photo_id']) && !empty($_FILES['photo_id']['name'])) {
          $previousCatIcon = $team->photo_id;
          $Icon = $this->setPhoto($form->photo_id, array('team_id' => $team->team_id));
          if (!empty($Icon)) {
            if ($previousCatIcon) {
              $catIcon = Engine_Api::_()->getItem('storage_file', $previousCatIcon);
              $catIcon->delete();
            }
            $team->photo_id = $Icon;
            $team->save();
          }
        }

        if (isset($values['remove_profilecover']) && !empty($values['remove_profilecover'])) {
          $storage = Engine_Api::_()->getItem('storage_file', $team->photo_id);
          $team->photo_id = 0;
          $team->save();
          if ($storage)
            $storage->delete();
        }

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_helper->redirector->gotoRoute(array('action' => 'index'));
    }

    //Output
    $this->renderScript('admin-manage/edit.tpl');
  }

  //Delete team member
  public function deleteAction() {

    if ($this->getRequest()->isPost()) {

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        Engine_Api::_()->getDbtable('teams', 'sesteam')->delete(array('team_id =?' => $this->_getParam('team_id')));
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully removed team member entry.'))
      ));
    }
    $this->renderScript('admin-manage/delete.tpl');
  }

  //Delete multiple team members
  public function multiDeleteAction() {

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $sesteam_teams = Engine_Api::_()->getItem('sesteam_teams', (int) $value);
          if (!empty($sesteam_teams))
            $sesteam_teams->delete();
        }
      }
    }
    $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }

  //Enable Action
  public function enabledAction() {

    $id = $this->_getParam('team_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesteam_teams', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesteam/manage');
  }

  //Featured Action
  public function featuredAction() {

    $id = $this->_getParam('team_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesteam_teams', $id);
      $item->featured = !$item->featured;
      $item->save();
    }
    $this->_redirect('admin/sesteam/manage');
  }

  //Sponsored Action
  public function sponsoredAction() {

    $id = $this->_getParam('team_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesteam_teams', $id);
      $item->sponsored = !$item->sponsored;
      $item->save();
    }
    $this->_redirect('admin/sesteam/manage');
  }

  public function ofthedayAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $type = $this->_getParam('type');

    $param = $this->_getParam('param');

    $this->view->form = $form = new Sesteam_Form_Admin_Oftheday();
    if ($type == 'sesteam_team') {
      $item = Engine_Api::_()->getItem('sesteam_teams', $id);
      $form->setTitle("Team Member of the Day");
      $form->setDescription('Here, choose the start date and end date for this team member to be displayed as "Team Member of the Day".');
      if (!$param)
        $form->remove->setLabel("Remove as Team Member of the Day");
      $table = 'engine4_sesteam_teams';
      $item_id = 'team_id';
    } elseif ($type == 'sesteam_nonteam') {
      $item = Engine_Api::_()->getItem('sesteam_teams', $id);
      $form->setTitle("Team Member of the Day");
      $form->setDescription('Here, choose the start date and end date for this team member to be displayed as "Team Member of the Day".');
      if (!$param)
        $form->remove->setLabel("Remove as Team Member of the Day");
      $table = 'engine4_sesteam_teams';
      $item_id = 'team_id';
    }

    if (!empty($id))
      $form->populate($item->toArray());

    if ($this->getRequest()->isPost()) {

      if (!$form->isValid($this->getRequest()->getPost()))
        return;

      $values = $form->getValues();
      $values['starttime'] = date('Y-m-d', strtotime($values['starttime']));
      $values['endtime'] = date('Y-m-d', strtotime($values['endtime']));

      $db->update($table, array('starttime' => $values['starttime'], 'endtime' => $values['endtime']), array("$item_id = ?" => $id));
      if (isset($values['remove']) && $values['remove']) {
        $db->update($table, array('offtheday' => 0), array("$item_id = ?" => $id));
      } else {
        $db->update($table, array('offtheday' => 1), array("$item_id = ?" => $id));
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('')
      ));
    }
  }

  //Add new team member using auto suggest
  public function getusersAction() {

    $sesdata = array();
    $users_table = Engine_Api::_()->getDbtable('users', 'user');
    $select = $users_table->select()
                    ->where('displayname  LIKE ? ', '%' . $this->_getParam('text') . '%')
                    ->order('displayname ASC')->limit('40');
    $users = $users_table->fetchAll($select);

    foreach ($users as $user) {
      $user_icon_photo = $this->view->itemPhoto($user, 'thumb.icon');
      $sesdata[] = array(
          'id' => $user->user_id,
          'label' => $user->displayname,
          'photo' => $user_icon_photo
      );
    }
    return $this->_helper->json($sesdata);
  }

  //Manage all designation
  public function designationsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesteam_admin_main', array(), 'sesteam_admin_main_managedesignation');

    $designations_table = Engine_Api::_()->getDbTable('designations', 'sesteam');
    $select = $designations_table->select()->order('order ASC');
    $this->view->paginator = $designations_table->fetchAll($select);
  }

  //Add new designation
  public function adddesignationAction() {

    //Set Layout
    $this->_helper->layout->setLayout('admin-simple');

    //Render Form
    $this->view->form = $form = new Sesteam_Form_Admin_Adddesignation();
    $form->setTitle('Add New Designation');
    $form->button->setLabel('Add');

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $designations_table = Engine_Api::_()->getDbtable('designations', 'sesteam');
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $values = $form->getValues();
        $row = $designations_table->createRow();
        $row->designation = $values["designation"];
        // $row->weight = $values["weight"];
        $row->save();
        $db->commit();

        if ($row->designation_id)
          $db->update('engine4_sesteam_designations', array('order' => $row->designation_id), array('designation_id = ?' => $row->designation_id));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully add designation.'))
      ));
    }
  }

  //Edit Designation
  public function editdesignationAction() {

    //Get designation id and make designation table object
    $designationItem = Engine_Api::_()->getItem('sesteam_designations', $this->_getParam('designation_id'));
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Sesteam_Form_Admin_Editdesignation();
    $form->setTitle('Edit Designation');
    $form->button->setLabel('Save Changes');

    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

    //Must have an id
    if (!($id = $this->_getParam('designation_id')))
      throw new Zend_Exception('No identifier specified');

    $form->populate($designationItem->toArray());

    //Check post
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $db->update('engine4_sesteam_teams', array('designation' => $values["designation"]), array('designation_id = ?' => $this->_getParam('designation_id')));
        $designationItem->designation = $values["designation"];
        //$designationItem->weight = $values["weight"];
        $designationItem->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      return $this->_forward('success', 'utility', 'core', array(
                  'smoothboxClose' => 10,
                  'parentRefresh' => 10,
                  'messages' => array('You have successfully edit designation entry.')
      ));
    }

    //Output
    $this->renderScript('admin-manage/editdesignation.tpl');
  }

  //Delete designation
  public function deletedesignationAction() {

    if ($this->getRequest()->isPost()) {

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $db->update('engine4_sesteam_teams', array('designation_id' => '', 'designation' => ''), array('designation_id = ?' => $this->_getParam('designation_id')));
        Engine_Api::_()->getDbtable('designations', 'sesteam')->delete(array('designation_id =?' => $this->_getParam('designation_id')));

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully delete entry'))
      ));
    }

    $this->renderScript('admin-manage/deletedesignation.tpl');
  }

  public function multiDeleteDesignationsAction() {

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();

      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $explodedKey = explode('_', $key);
          $slideImage = Engine_Api::_()->getItem('sesteam_designations', $explodedKey[1]);
          $slideImage->delete();
        }
      }
    }
    $this->_helper->redirector->gotoRoute(array('action' => 'designations'));
  }

  public function orderteamAction() {

    if (!$this->getRequest()->isPost())
      return;

    $table = Engine_Api::_()->getDbtable('teams', 'sesteam');
    $designations = $table->fetchAll($table->select());
    foreach ($designations as $designation) {
      $order = $this->getRequest()->getParam('teams_' . $designation->team_id);
//      if (!$order)
//        $order = 999;
      if ($order) {
        $designation->order = $order;
        $designation->save();
      }
    }
    return;
  }

  public function orderAction() {

    if (!$this->getRequest()->isPost())
      return;

    $table = Engine_Api::_()->getDbtable('designations', 'sesteam');
    $designations = $table->fetchAll($table->select());
    foreach ($designations as $designation) {
      $order = $this->getRequest()->getParam('designations_' . $designation->designation_id);
      if (!$order)
        $order = 999;
      $designation->order = $order;
      $designation->save();
    }
    return;
  }

  public function setPhoto($photo, $param = null) {

    if ($photo instanceof Zend_Form_Element_File)
      $file = $photo->getFileName();
    else if (is_array($photo) && !empty($photo['tmp_name']))
      $file = $photo['tmp_name'];
    else if (is_string($photo) && file_exists($photo))
      $file = $photo;
    else
      throw new Sesmusic_Model_Exception('Invalid argument passed to setPhoto: ' . print_r($photo, 1));

    $name = basename($file);
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_type' => 'sesteam_team',
        'parent_id' => $param['team_id']
    );

    //Save
    $storage = Engine_Api::_()->storage();
    if ($param == 'mainPhoto') {
      $image = Engine_Image::factory();
      $image->open($file)
              ->resize(500, 500)
              ->write($path . '/m_' . $name)
              ->destroy();
    } else {
      $image = Engine_Image::factory();
      $image->open($file)
              ->resize(1600, 1600)
              ->write($path . '/m_' . $name)
              ->destroy();
    }

    //Resize image (icon)
    $image = Engine_Image::factory();
    $image->open($file);

    $size = min($image->height, $image->width);
    $x = ($image->width - $size) / 2;
    $y = ($image->height - $size) / 2;

    $image->resample($x, $y, $size, $size, 48, 48)
            ->write($path . '/is_' . $name)
            ->destroy();

    //Store
    $iMain = $storage->create($path . '/m_' . $name, $params);
    $iSquare = $storage->create($path . '/is_' . $name, $params);

    $iMain->bridge($iMain, 'thumb.profile');
    $iMain->bridge($iSquare, 'thumb.icon');

    //Remove temp files
    @unlink($path . '/m_' . $name);
    @unlink($path . '/is_' . $name);

    $photo_id = $iMain->getIdentity();
    return $photo_id;
  }

}