<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessreview_AdminManageController extends Core_Controller_Action_Admin {

  public function reviewSettingsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesbusiness_admin_main', array(), 'sesbusinessreview_admin_settings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesbusinessreview_admin_settings', array(), 'sesbusinessreview_admin_main_reviewparametersettings');
    $this->view->form = $form = new Sesbusinessreview_Form_Admin_Manage_ReviewSettings();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
        $values = $form->getValues();
        include_once APPLICATION_PATH . "/application/modules/Sesbusinessreview/controllers/License.php";
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.pluginactivated')) {
            foreach ($values as $key => $value) {
                Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
            }
            $form->addNotice('Your changes have been saved.');
            if($error)
                $this->_helper->redirector->gotoRoute(array());
        }
    }
  }

  public function manageReviewsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesbusiness_admin_main', array(), 'sesbusinessreview_admin_settings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesbusinessreview_admin_settings', array(), 'sesbusinessreview_admin_main_managereview');

    $this->view->formFilter = $formFilter = new Sesbusinessreview_Form_Admin_Manage_Review_Filter();

    //Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    foreach ($_GET as $key => $value) {
      if ('' === $value)
        unset($_GET[$key]);
      else
        $values[$key] = $value;
    }

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          Engine_Api::_()->getItem('businessreview', $value)->delete();
        }
      }
    }

    $table = Engine_Api::_()->getDbtable('businessreviews', 'sesbusinessreview');
    $tableName = $table->info('name');
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $select = $table->select()
                    ->from($tableName)
                    ->setIntegrityCheck(false)
                    ->joinLeft($tableUserName, "$tableUserName.user_id = $tableName.owner_id", 'username')->order('review_id DESC');

    // Set up select info
    if (!empty($_GET['title']))
      $select->where($tableName . '.title LIKE ?', '%' . $values['title'] . '%');

    if (isset($_GET['featured']) && $_GET['featured'] != '')
      $select->where($tableName . '.featured = ?', $values['featured']);

    if (isset($_GET['new']) && $_GET['new'] != '')
      $select->where('new = ?', $values['new']);

    if (isset($_GET['verified']) && $_GET['verified'] != '')
      $select->where($tableName . '.verified = ?', $values['verified']);

    if (!empty($values['creation_date']))
      $select->where('date(' . $tableName . '.creation_date) = ?', $values['creation_date']);

    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (isset($_GET['oftheday']) && $_GET['oftheday'] != '')
      $select->where($tableName . '.oftheday =?', $values['oftheday']);

    $business = $this->_getParam('page', 1);

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($business);
  }

  public function levelSettingsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesbusiness_admin_main', array(), 'sesbusinessreview_admin_settings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesbusinessreview_admin_settings', array(), 'sesbusinessreview_admin_main_levelsettings');

    //Get level id
    if (null !== ($id = $this->_getParam('level_id', $this->_getParam('id'))))
      $level = Engine_Api::_()->getItem('authorization_level', $id);
    else
      $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();

    if (!$level instanceof Authorization_Model_Level)
      throw new Engine_Exception('missing level');

    $id = $level->level_id;

    //Make form
    $this->view->form = $form = new Sesbusinessreview_Form_Admin_Manage_Level(array(
        'public' => ( in_array($level->type, array('public')) ),
        'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
    ));
    $form->level_id->setValue($id);

    $content_type = 'businessreview';
    $module_name = $this->_getParam('module_name', null);

    $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
    $form->populate($permissionsTable->getAllowed($content_type, $id, array_keys($form->getValues())));

    //Check post
    if (!$this->getRequest()->isPost())
      return;

    //Check validitiy
    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    //Process
    $values = $form->getValues();

    $db = $permissionsTable->getAdapter();
    $db->beginTransaction();
    try {
      //Set permissions
      $permissionsTable->setAllowed($content_type, $id, $values);
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $form->addNotice('Your changes have been saved.');
  }

  public function reviewParameterAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesbusiness_admin_main', array(), 'sesbusinessreview_admin_settings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesbusinessreview_admin_settings', array(), 'sesbusinessreview_admin_main_reviewparameter');
    $this->view->categories = Engine_Api::_()->getDbTable('categories', 'sesbusiness')->getCategory(array('column_name' => '*'));
  }

  public function addParameterAction() {
    $category_id = $this->_getParam('id', null);
    if (!$category_id)
      return $this->_forward('notfound', 'error', 'core');
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesbusinessreview_Form_Admin_Parameter_Add();
    $reviewParameters = Engine_Api::_()->getDbtable('parameters', 'sesbusinessreview')->getParameterResult(array('category' => $category_id));
    if (!count($reviewParameters))
      $form->setTitle('Add Review Parameters');
    else {
      $form->setTitle('Edit Review Parameters');
      $form->submit->setLabel('Edit');
    }
    $form->setDescription("");
    if (!$this->getRequest()->isPost()) {
      return;
    }
    $table = Engine_Api::_()->getDbtable('parameters', 'sesbusinessreview');
    $tablename = $table->info('name');
    try {
      $values = $form->getValues();
      unset($values['addmore']);
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $deleteIds = explode(',', $_POST['deletedIds']);
      foreach ($deleteIds as $val) {
        if (!$val)
          continue;
        $query = 'DELETE FROM ' . $tablename . ' WHERE parameter_id = ' . $val;
        $dbObject->query($query);
      }
      foreach ($_POST as $key => $value) {
        if (count(explode('_', $key)) != 3 || !$value)
          continue;
        $id = str_replace('sesbusinessreview_review_', '', $key);
        $query = 'UPDATE ' . $tablename . ' SET title = "' . $value . '" WHERE parameter_id = ' . $id;
        $dbObject->query($query);
      }
      foreach ($_POST['parameters'] as $key => $val) {
        if ($_POST['parameters'][$key] != '') {
          $query = 'INSERT IGNORE INTO ' . $tablename . ' (`parameter_id`, `category`, `title`, `rating`) VALUES ("","' . $category_id . '","' . $val . '","0")';
          $dbObject->query($query);
        }
      }
    } catch (Exception $e) {
      throw $e;
    }
    $this->view->message = Zend_Registry::get('Zend_Translate')->_("SESBUSINESS Review Parameters have been saved.");
    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array($this->view->message)
    ));
  }

  public function viewAction() {
    $this->view->item = Engine_Api::_()->getItem('businessreview', $this->_getParam('id', null));
  }

  public function featuredReviewAction() {
    $id = $this->_getParam('review_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('businessreview', $id);
      $item->featured = !$item->featured;
      $item->save();
    }
    $this->_redirect('admin/sesbusinessreview/manage/manage-reviews');
  }

  public function verifiedReviewAction() {

    $id = $this->_getParam('review_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('businessreview', $id);
      $item->verified = !$item->verified;
      $item->save();
    }
    $this->_redirect('admin/sesbusinessreview/manage/manage-reviews');
  }

  public function reviewOfthedayAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->_helper->layout->setLayout('admin-simple');

    $id = $this->_getParam('id');

    $this->view->form = $form = new Sesbusinessreview_Form_Admin_Oftheday();
    $item = Engine_Api::_()->getItem('businessreview', $id);

    if (!empty($id))
      $form->populate($item->toArray());

    if ($this->getRequest()->isPost()) {

      if (!$form->isValid($this->getRequest()->getPost()))
        return;

      $values = $form->getValues();
      $values['starttime'] = date('Y-m-d', strtotime($values['starttime']));
      $values['endtime'] = date('Y-m-d', strtotime($values['endtime']));

      $db->update('engine4_sesbusinessreview_reviews', array('starttime' => $values['starttime'], 'endtime' => $values['endtime']), array("review_id = ?" => $id));
      if (isset($values['remove']) && $values['remove']) {
        $db->update('engine4_sesbusinessreview_reviews', array('oftheday' => 0), array("review_id = ?" => $id));
      } else {
        $db->update('engine4_sesbusinessreview_reviews', array('oftheday' => 1), array("review_id = ?" => $id));
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('')
      ));
    }
  }

}
