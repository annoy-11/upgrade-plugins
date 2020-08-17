<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSpeakerController.php 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seseventspeaker_AdminSpeakerController extends Core_Controller_Action_Admin {

  public function indexAction() {
  
    $db = Engine_Db_Table::getDefaultAdapter();
    
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesevent_admin_main', array(), 'sesevent_admin_main_seseventspeaker');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seseventspeaker_admin_main', array(), 'sesevent_admin_main_managespeaker');
    
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('speakers', 'seseventspeaker')->getSpeakerMemers(array('type' => 'admin'));
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  //Add new speaker
  public function addSpeakerAction() {

    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
    
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesevent_admin_main', array(), 'sesevent_admin_main_seseventspeaker');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seseventspeaker_admin_main', array(), 'sesevent_admin_main_managespeaker');

    //Render Form
    $this->view->form = $form = new Seseventspeaker_Form_Admin_Addspeaker();
    $form->setDescription("Here, you can add details for the new speaker to be added to your website and enter various information about the speaker like Photo, Description, Email, Social URLs, etc.");

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $speakerTable = Engine_Api::_()->getDbtable('speakers', 'seseventspeaker');
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $values = $form->getValues();
        if (!$values['photo_id'])
          $values['photo_id'] = 0;
        $row = $speakerTable->createRow();
        $values['type'] = 'admin';
        $row->setFromArray($values);
        $row->save();
        if (isset($_FILES['photo_id']) && $values['photo_id']) {
          $photo = $this->setPhoto($form->photo_id, array('speaker_id' => $row->speaker_id));
          if (!empty($photo))
            $row->photo_id = $photo;
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

  //Edit speaker members
  public function editAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesevent_admin_main', array(), 'sesevent_admin_main_seseventspeaker');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seseventspeaker_admin_main', array(), 'sesevent_admin_main_managespeaker');

    $speaker = Engine_Api::_()->getItem('seseventspeaker_speakers', $this->_getParam('speaker_id'));

    $form = $this->view->form = new Seseventspeaker_Form_Admin_Editspeaker();
    $form->setDescription("Here, you can add details for the speaker to be added to your website and enter various information about the speaker member like Photo, Description, Email, Social URLs, etc.");
    $form->button->setLabel('Save Changes');
    $form->populate($speaker->toArray());

    //Check post
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      if (empty($values['photo_id']))
        unset($values['photo_id']);
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $speaker->setFromArray($values);
        $speaker->save();

        if (isset($_FILES['photo_id']) && !empty($_FILES['photo_id']['name'])) {
          $previousCatIcon = $speaker->photo_id;
          $photo = $this->setPhoto($form->photo_id, array('speaker_id' => $speaker->speaker_id));
          if (!empty($photo)) {
            if ($previousCatIcon) {
              $catIcon = Engine_Api::_()->getItem('storage_file', $previousCatIcon);
              if ($catIcon)
                $catIcon->delete();
            }
            $speaker->photo_id = $photo;
            $speaker->save();
          }
        }
        if (isset($values['remove_profilecover']) && !empty($values['remove_profilecover'])) {
          $storage = Engine_Api::_()->getItem('storage_file', $speaker->photo_id);
          $speaker->photo_id = 0;
          $speaker->save();
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

  //Delete speaker member
  public function deleteAction() {

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        Engine_Api::_()->getDbtable('speakers', 'seseventspeaker')->delete(array('speaker_id =?' => $this->_getParam('speaker_id')));
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully delete speaker entry.'))
      ));
    }
    $this->renderScript('admin-speaker/delete.tpl');
  }

  //Delete multiple speaker
  public function multiDeleteAction() {

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $sesevent_speakers = Engine_Api::_()->getItem('seseventspeaker_speakers', (int) $value);
          if (!empty($sesevent_speakers))
            $sesevent_speakers->delete();
        }
      }
    }
    $this->_redirect('admin/seseventspeaker/speaker');
  }

  //Enable Action
  public function enabledAction() {

    $id = $this->_getParam('speaker_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('seseventspeaker_speakers', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/seseventspeaker/speaker');
  }

  //Featured Action
  public function featuredAction() {

    $id = $this->_getParam('speaker_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('seseventspeaker_speakers', $id);
      $item->featured = !$item->featured;
      $item->save();
    }
    $this->_redirect('admin/seseventspeaker/speaker');
  }

  //Sponsored Action
  public function sponsoredAction() {

    $id = $this->_getParam('speaker_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('seseventspeaker_speakers', $id);
      $item->sponsored = !$item->sponsored;
      $item->save();
    }
    $this->_redirect('admin/seseventspeaker/speaker');
  }
  
  public function ofthedayAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $type = $this->_getParam('type');
    $param = $this->_getParam('param');

    $this->view->form = $form = new Seseventspeaker_Form_Admin_Oftheday();
    if ($type == 'sesevent_nonteam') {
      $item = Engine_Api::_()->getItem('seseventspeaker_speakers', $id);
      $form->setTitle("Event Speaker of the Day");
      $form->setDescription('Here, choose the start date and end date for this speaker to be displayed as "Event Speaker of the Day".');
      if (!$param)
        $form->remove->setLabel("Remove as Event Speaker of the Day");
      $table = 'engine4_seseventspeaker_speakers';
      $item_id = 'speaker_id';
    }

    if (!empty($id))
      $form->populate($item->toArray());

    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost())) {
        return;
      }
      $values = $form->getValues();

      $start = strtotime($values['starttime']);
      $end = strtotime($values['endtime']);

      $values['starttime'] = date('Y-m-d', $start);
      $values['endtime'] = date('Y-m-d', $end);

      $db->update($table, array('starttime' => $values['starttime'], 'endtime' => $values['endtime']), array("$item_id = ?" => $id));
      if ($values['remove']) {
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
        'parent_type' => 'seseventspeaker_speakers',
        'parent_id' => $param['speaker_id']
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