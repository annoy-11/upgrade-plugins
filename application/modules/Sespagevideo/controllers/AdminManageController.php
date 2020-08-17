<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagevideo
 * @package    Sespagevideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagevideo_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespage_admin_main', array(), 'sespage_admin_main_sespagevideo');

    $this->view->subNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagevideo_admin_main', array(), 'sespagevideo_admin_main_manage');

    $this->view->formFilter = $formFilter = new Sespagevideo_Form_Admin_Manage_Filter();

    // Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams())) {
      $values = $formFilter->getValues();
    }
    foreach ($_GET as $key => $value) {
      if ('' === $value) {
        unset($_GET[$key]);
      } else
        $values[$key] = $value;
    }
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $video = Engine_Api::_()->getItem('pagevideo', $value)->delete();
        }
      }
    }

    $table = Engine_Api::_()->getDbtable('videos', 'sespagevideo');
    $tableName = $table->info('name');
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
		$tablePageName = Engine_Api::_()->getItemTable('sespage_page')->info('name');
    $select = $table->select()
            ->from($tableName)
            ->setIntegrityCheck(false)
            ->joinLeft($tableUserName, "$tableUserName.user_id = $tableName.owner_id", 'username')
						->joinLeft($tablePageName, "$tablePageName.page_id = $tableName.parent_id", 'page_id');
		$select->where($tablePageName.'.page_id != ?','');
    $select->order('video_id DESC');
    // Set up select info

    if (!empty($_GET['title']))
      $select->where($tableName.'.title LIKE ?', '%' . $values['title'] . '%');

		if (!empty($_GET['page_title']))
      $select->where($tablePageName.'.title LIKE ?', '%' . $values['page_title'] . '%');

    if (isset($_GET['is_featured']) && $_GET['is_featured'] != '')
      $select->where($tableName.'.is_featured = ?', $values['is_featured']);

    if (isset($_GET['is_hot']) && $_GET['is_hot'] != '')
      $select->where($tableName.'.is_hot = ?', $values['is_hot']);

    if (isset($_GET['is_sponsored']) && $_GET['is_sponsored'] != '')
      $select->where($tableName.'.is_sponsored = ?', $values['is_sponsored']);

	 if (isset($_GET['status']) && $_GET['status'] != '')
      $select->where($tableName.'.status = ?', $values['status']);
	 if (isset($_GET['type']) && $_GET['type'] != '')
      $select->where($tableName.'.type = ?', $values['type']);

    if (!empty($values['creation_date']))
      $select->where($tableName.'.date(' . $tableName . '.creation_date) = ?', $values['creation_date']);

    if (isset($_GET['location']) && $_GET['location'] != '')
      $select->where($tableName.'.location != ?', '');

    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
      $select->where($tableName . '.offtheday =?', $values['offtheday']);

    if (isset($_GET['rating']) && $_GET['rating'] != '') {
      if ($_GET['rating'] == 1):
        $select->where($tableName.'.rating != ?', 0);
      elseif ($_GET['rating'] == 0 && $_GET['rating'] != ''):
        $select->where($tableName.'.rating =?', 0);
      endif;
    }
    $page = $this->_getParam('page', 1);
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber($page);
  }

  public function hotAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->video_id = $id = $this->_getParam('id');
    $this->view->status = $status = $this->_getParam('status');
    $db = Engine_Db_Table::getDefaultAdapter();
    $table = 'videos';
    $type_id = 'video_id';

    $db->beginTransaction();
    try {
      Engine_Api::_()->getDbtable($table, 'sespagevideo')->update(array(
          'is_hot' => $status,
              ), array(
          $type_id . " = ?" => $id,
      ));

      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    header('location:' . $_SERVER['HTTP_REFERER']);
  }
	 public function approveAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->video_id = $id = $this->_getParam('id');
    $this->view->approve = $approve = $this->_getParam('approve');

    $video = Engine_Api::_()->getItem('pagevideo', $id);
    $owner = $video->getOwner();
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
      Engine_Api::_()->getDbtable('videos', 'sespagevideo')->update(array(
          'approve' => $approve,
              ), array(
          "video_id = ?" => $id,
      ));
      $db->commit();
			if($approve){

				$actionsTable = Engine_Api::_()->getDbtable('actions', 'activity');
				$db = $actionsTable->getAdapter();
				$db->beginTransaction();
				try {
					// new action
					$action = $actionsTable->addActivity($owner, $video, 'sespagevideo_new');
					if ($action) {
						$actionsTable->attachActivity($action, $video);
					}
					// notify the owner
					Engine_Api::_()->getDbtable('notifications', 'activity')
									->addNotification($owner, $owner, $video, 'sespagevideo_approved');
					$db->commit();
				} catch (Exception $e) {
					$db->rollBack();
					throw $e; // throw
				}
			}else{
				Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner->email, 'NOTIFY_SESPAGEVIDEO_DISAPPROVED', array(
							'object_title' => $video->getTitle(),
							'object_link' => $video->getHref(),
							'host' => $_SERVER['HTTP_HOST'],
            ));
			}
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    header('location:' . $_SERVER['HTTP_REFERER']);
  }

  public function featureSponsoredAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->video_id = $id = $this->_getParam('id');
    $this->view->status = $status = $this->_getParam('status');
    $this->view->category = $category = $this->_getParam('category');
    $this->view->params = $params = $this->_getParam('param');
    if ($status == 1)
      $statusChange = ' ' . $category;
    else
      $statusChange = 'un' . $category;

    if ($params == 'videos')
      $col = 'video_id';
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
      Engine_Api::_()->getDbtable($params, 'sespagevideo')->update(array(
          'is_' . $category => $status,
              ), array(
          "$col = ?" => $id,
      ));

      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    header('location:' . $_SERVER['HTTP_REFERER']);
  }

  public function deleteAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Video?');
    $form->setDescription('Are you sure that you want to delete this video? It will not be recoverable after being deleted. ');
    $form->submit->setLabel('Delete');

    $id = $this->_getParam('id');
    $this->view->video_id = $id;
    // Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $video = Engine_Api::_()->getItem('pagevideo', $id);
        Engine_Api::_()->getApi('core', 'sespagevideo')->deleteVideo($video);
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('')
      ));
    }
  }

  public function killAction() {
    $id = $this->_getParam('video_id', null);
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $video = Engine_Api::_()->getItem('pagevideo', $id);
        $video->status = 3;
        $video->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }

  //view item function
  public function viewAction() {
    $this->view->type = $type = $this->_getParam('type', 1);
    $id = $this->_getParam('id', 1);
    $item = Engine_Api::_()->getItem($type, $id);
    $this->view->item = $item;
  }

  //make item off the day
  public function ofthedayAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $type = $this->_getParam('type');
    $param = $this->_getParam('param');
    $this->view->form = $form = new Sespagevideo_Form_Admin_Settings_Oftheday();
    $item = Engine_Api::_()->getItem('pagevideo', $id);

    $form->setTitle("Video of the Day");
    $form->setDescription('Here, choose the start date and end date for this video to be displayed as "Video of the Day".');
    if (!$param)
      $form->remove->setLabel("Remove as Video of the Day");

    if (!empty($id))
      $form->populate($item->toArray());

    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $values = $form->getValues();
      $values['starttime'] = date('Y-m-d', strtotime($values['starttime']));
      $values['endtime'] = date('Y-m-d', strtotime($values['endtime']));
      $db->update('engine4_sespagevideo_videos', array('starttime' => $values['starttime'], 'endtime' => $values['endtime']), array("video_id = ?" => $id));
      if (isset($values['remove']) && $values['remove']) {
        $db->update('engine4_sespagevideo_videos', array('offtheday' => 0), array("video_id = ?" => $id));
      } else {
        $db->update('engine4_sespagevideo_videos', array('offtheday' => 1), array("video_id = ?" => $id));
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Successfully updated the item.')
      ));
    }
  }

}
