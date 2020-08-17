<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageteamController.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sessportz_AdminManageteamController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessportz_admin_main', array(), 'sessportz_admin_main_manageteam');
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('teams', 'sessportz')->getTeamMemers(array('type' => 'teammember'));
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  //Add new team members
  public function addTeamMemberAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessportz_admin_main', array(), 'sessportz_admin_main_manageteam');

    //Render Form
    $this->view->form = $form = new Sessportz_Form_Admin_Addteammembers();
    $form->setDescription("Here, you can add a new team.");

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $teamTable = Engine_Api::_()->getDbtable('teams', 'sessportz');
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $values = $form->getValues();

        if (!$values['photo_id']) {
          $values['photo_id'] = 0;
        }

        $row = $teamTable->createRow();
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

      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_helper->redirector->gotoRoute(array('action' => 'index'));
    }
  }

  //Edit team members
  public function editAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessportz_admin_main', array(), 'sessportz_admin_main_manageteam');

    //Get team id and make team table object according to team id
    $team = Engine_Api::_()->getItem('sessportz_teams', $this->_getParam('team_id'));

    $form = $this->view->form = new Sessportz_Form_Admin_Editteammembers();
    $form->setDescription("Here, you can add a new team.");
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

        $team->setFromArray($values);
        $team->save();
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
    $this->renderScript('admin-manageteam/edit.tpl');
  }

  //Delete team member
  public function deleteAction() {

    if ($this->getRequest()->isPost()) {

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        Engine_Api::_()->getDbtable('teams', 'sessportz')->delete(array('team_id =?' => $this->_getParam('team_id')));
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully removed team entry.'))
      ));
    }
    $this->renderScript('admin-manageteam/delete.tpl');
  }

  //Delete multiple team members
  public function multiDeleteAction() {

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $sessportz_teams = Engine_Api::_()->getItem('sessportz_teams', (int) $value);
          if (!empty($sessportz_teams))
            $sessportz_teams->delete();
        }
      }
    }
    $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }

  //Enable Action
  public function enabledAction() {

    $id = $this->_getParam('team_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sessportz_teams', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sessportz/manageteam');
  }

  public function orderteamAction() {

    if (!$this->getRequest()->isPost())
      return;

    $table = Engine_Api::_()->getDbtable('teams', 'sessportz');
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
        'parent_type' => 'sessportz_team',
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
