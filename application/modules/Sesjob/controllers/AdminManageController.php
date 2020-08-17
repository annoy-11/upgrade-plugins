<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2019-03-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_AdminManageController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesjob_admin_main', array(), 'sesjob_admin_main_manage');

    $this->view->formFilter = $formFilter = new Sesjob_Form_Admin_Filter();
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $sesjob = Engine_Api::_()->getItem('sesjob_job', $value);
					Engine_Api::_()->sesjob()->deleteJob($sesjob);
        }
      }
    }

    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
    $values = $formFilter->getValues();
    $values = array_merge(array(
    'order' => isset($_GET['order']) ? $_GET['order'] :'',
    'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
    ), $values);
    $this->view->assign($values);
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $jobTable = Engine_Api::_()->getDbTable('jobs', 'sesjob');
    $jobTableName = $jobTable->info('name');
    $select = $jobTable->select()
    ->setIntegrityCheck(false)
    ->from($jobTableName)
    ->joinLeft($tableUserName, "$jobTableName.owner_id = $tableUserName.user_id", 'username')
    ->order((!empty($_GET['order']) ? $_GET['order'] : 'job_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
    $select->where($jobTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
    $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

     if (!empty($_GET['category_id']))
      $select->where($jobTableName . '.category_id =?', $_GET['category_id']);

    if (!empty($_GET['subcat_id']))
      $select->where($jobTableName . '.subcat_id =?', $_GET['subcat_id']);

    if (!empty($_GET['subsubcat_id']))
      $select->where($jobTableName . '.subsubcat_id =?', $_GET['subsubcat_id']);

    if (isset($_GET['featured']) && $_GET['featured'] != '')
    $select->where($jobTableName . '.featured = ?', $_GET['featured']);

    if (isset($_GET['sponsored']) && $_GET['sponsored'] != '')
    $select->where($jobTableName . '.sponsored = ?', $_GET['sponsored']);

		if (isset($_GET['package_id']) && $_GET['package_id'] != '')
    $select->where($jobTableName . '.package_id = ?', $_GET['package_id']);

    if (isset($_GET['status']) && $_GET['status'] != '')
    $select->where($jobTableName . '.draft = ?', $_GET['status']);

		if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
    	$select->where($jobTableName . '.is_approved = ?', $_GET['is_approved']);

    if (isset($_GET['verified']) && $_GET['verified'] != '')
    $select->where($jobTableName . '.verified = ?', $_GET['verified']);

    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
    $select->where($jobTableName . '.offtheday = ?', $_GET['offtheday']);

    if (isset($_GET['rating']) && $_GET['rating'] != '') {
      if ($_GET['rating'] == 1):
      $select->where($jobTableName . '.rating <> ?', 0);
      elseif ($_GET['rating'] == 0 && $_GET['rating'] != ''):
      $select->where($jobTableName . '.rating = ?', $_GET['rating']);
      endif;
    }

    if (!empty($_GET['creation_date']))
    $select->where($jobTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

		if (isset($_GET['subcat_id'])) {
			$formFilter->subcat_id->setValue($_GET['subcat_id']);
			$this->view->category_id = $_GET['category_id'];
		}

    if (isset($_GET['subsubcat_id'])) {
			$formFilter->subsubcat_id->setValue($_GET['subsubcat_id']);
			$this->view->subcat_id = $_GET['subcat_id'];
    }

    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey=>$urlParamsVal){
      if($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
      continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function deleteAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->job_id=$id;
    // Check post
    if( $this->getRequest()->isPost() )
    {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try
      {
        $sesjob = Engine_Api::_()->getItem('sesjob_job', $id);
        // delete the sesjob entry into the database
        Engine_Api::_()->sesjob()->deleteJob($sesjob);
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
          'messages' => array('')
      ));
    }

    // Output
    $this->renderScript('admin-manage/delete.tpl');
  }

  //Approved Action
  public function approvedAction() {
    $job_id = $this->_getParam('id');
    if (!empty($job_id)) {
      $sesjob = Engine_Api::_()->getItem('sesjob_job', $job_id);
      $sesjob->is_approved = !$sesjob->is_approved;
      $sesjob->save();
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($sesjob);
      if(count($action->toArray()) <= 0 && (!$sesjob->publish_date || strtotime($sesjob->publish_date) <= time())) {
          $viewer = Engine_Api::_()->getItem('user', $sesjob->owner_id);
          $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $sesjob, 'sesjob_new');
          // make sure action exists before attaching the sesjob to the activity
          if( $action ) {
            Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $sesjob);
          }
      }
    }
    $this->_redirect('admin/sesjob/manage');
  }

  //Featured Action
  public function featuredAction() {

    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('sesjob_job', $event_id);
      $event->featured = !$event->featured;
      $event->save();
    }
    $this->_redirect('admin/sesjob/manage');
  }


  //Sponsored Action
  public function sponsoredAction() {

    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('sesjob_job', $event_id);
      $event->sponsored = !$event->sponsored;
      $event->save();
    }
    $this->_redirect('admin/sesjob/manage');
  }

  //Verify Action
  public function verifyAction() {

    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('sesjob_job', $event_id);
      $event->verified = !$event->verified;
      $event->save();
    }
    $this->_redirect('admin/sesjob/manage');
  }

  //Hot Action
  public function hotAction() {

    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('sesjob_job', $event_id);
      $event->hot = !$event->hot;
      $event->save();
    }
    $this->_redirect('admin/sesjob/manage');
  }

  public function ofthedayAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $param = $this->_getParam('param');
    $this->view->form = $form = new Sesjob_Form_Admin_Oftheday();
    $item = Engine_Api::_()->getItem('sesjob_job', $id);
    $form->setTitle("Job of the Day");
    $form->setDescription('Here, choose the start date and end date for this job to be displayed as "Job of the Day".');
    if (!$param)
      $form->remove->setLabel("Remove as Job of the Day");

    if (!empty($id))
      $form->populate($item->toArray());
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $values = $form->getValues();
      $values['starttime'] = date('Y-m-d',  strtotime($values['starttime']));
      $values['endtime'] = date('Y-m-d', strtotime($values['endtime']));
      $db->update('engine4_sesjob_jobs', array('starttime' => $values['starttime'], 'endtime' => $values['endtime']), array("job_id = ?" => $id));
      if (isset($values['remove']) && $values['remove']) {
        $db->update('engine4_sesjob_jobs', array('offtheday' => 0), array("job_id = ?" => $id));
      } else {
        $db->update('engine4_sesjob_jobs', array('offtheday' => 1), array("job_id = ?" => $id));
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Successfully updated the item.')
      ));
    }
  }

  //view item function
  public function viewAction() {
    $id = $this->_getParam('id', 1);
    $item = Engine_Api::_()->getItem('sesjob_job', $id);
    $this->view->item = $item;
  }

}
