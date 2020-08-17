<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminNonsiteteamController.php 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesteam_AdminNonsiteteamController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesteam_admin_main', array(), 'sesteam_admin_main_managenonsiteteam');
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('teams', 'sesteam')->getTeamMemers(array('type' => 'nonsitemember'));
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  //Add new team members
  public function addTeamMemberAction() {

    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesteam_admin_main', array(), 'sesteam_admin_main_managenonsiteteam');

    //Render Form
    $this->view->form = $form = new Sesteam_Form_Admin_Addteammembers();
    $form->setDescription("Here, you can add details for the new team member to be added to your website and enter various information about the team member like Photo, Designation, Description, Email, Social URLs, etc.");

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $teamTable = Engine_Api::_()->getDbtable('teams', 'sesteam');
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $values = $form->getValues();

        if (isset($values["user_id"]) && $values["user_id"]) {
          $select = $teamTable->select()->where('user_id = ?', $values["user_id"]);
          $result = $teamTable->fetchRow($select);
        }

        if ($type == 'nonsitemember' && !$values['photo_id']) {
          $values['photo_id'] = 0;
        }

        if ($type != 'nonsitemember' && count($result) > 0) {
          $itemError = Zend_Registry::get('Zend_Translate')->_("You have already add this member. Please chooese another one from auto-suggest.");
          $form->addError($itemError);
          return;
        } else {

          $row = $teamTable->createRow();
          if ($type != 'nonsitemember' && empty($result)) {
            $row->user_id = $values["user_id"];
          }

          if ($values["designation_id"]) {
            $row->designation_id = $values["designation_id"];
            $row->designation = Engine_Api::_()->getItem('sesteam_designations', $values["designation_id"])->designation;
          }
          // unset($values['photo_id']);
          $values['type'] = 'nonsitemember';
          $row->setFromArray($values);
          $row->save();

          if ($type == 'nonsitemember') {
            //Upload categories icon
            if (isset($_FILES['photo_id']) && $values['photo_id']) {
              $Icon = $this->setPhoto($form->photo_id, array('team_id' => $row->team_id));
              if (!empty($Icon))
                $row->photo_id = $Icon;
              $row->save();
            }
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

    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesteam_admin_main', array(), 'sesteam_admin_main_managenonsiteteam');

    //Get team id and make team table object according to team id
    $team = Engine_Api::_()->getItem('sesteam_teams', $this->_getParam('team_id'));

    $form = $this->view->form = new Sesteam_Form_Admin_Editteammembers();
    $form->setDescription("Here, you can add details for the new team member to be added to your website and enter various information about the team member like Photo, Designation, Description, Email, Social URLs, etc.");
    $form->button->setLabel('Save Changes');
    $form->populate($team->toArray());

    //Check post
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      if (empty($values['photo_id']))
        unset($values['photo_id']);

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        if ($values["designation_id"]) {
          $team->designation_id = $values["designation_id"];
          $team->designation = Engine_Api::_()->getItem('sesteam_designations', $values["designation_id"])->designation;
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
              if ($catIcon)
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
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully delete team member entry.'))
      ));
    }
    $this->renderScript('admin-nonsiteteam/delete.tpl');
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
    $this->_redirect('admin/sesteam/nonsiteteam');
  }

  //Enable Action
  public function enabledAction() {

    $id = $this->_getParam('team_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesteam_teams', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesteam/nonsiteteam');
  }

  //Featured Action
  public function featuredAction() {

    $id = $this->_getParam('team_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesteam_teams', $id);
      $item->featured = !$item->featured;
      $item->save();
    }
    $this->_redirect('admin/sesteam/nonsiteteam');
  }

  //Sponsored Action
  public function sponsoredAction() {

    $id = $this->_getParam('team_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesteam_teams', $id);
      $item->sponsored = !$item->sponsored;
      $item->save();
    }
    $this->_redirect('admin/sesteam/nonsiteteam');
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
      throw new Core_Model_Exception('Invalid argument passed to setPhoto: ' . print_r($photo, 1));

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