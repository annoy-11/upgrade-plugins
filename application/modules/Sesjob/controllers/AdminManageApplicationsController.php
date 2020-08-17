<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageApplicationsController.php  2019-03-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_AdminManageApplicationsController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesjob_admin_main', array(), 'sesjob_admin_main_manageappctions');

    $this->view->formFilter = $formFilter = new Sesjob_Form_Admin_Application_Filter();

//     if ($this->getRequest()->isPost()) {
//       $values = $this->getRequest()->getPost();
//       foreach ($values as $key => $value) {
//         if ($key == 'delete_' . $value) {
//           $sesjob = Engine_Api::_()->getItem('sesjob_application', $value);
//           //Engine_Api::_()->sesjob()->deleteJob($sesjob);
//         }
//       }
//     }

    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
    $values = $formFilter->getValues();
    $values = array_merge(array(
    'order' => isset($_GET['order']) ? $_GET['order'] :'',
    'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
    ), $values);
    $this->view->assign($values);

    $tableJobName = Engine_Api::_()->getItemTable('sesjob_job')->info('name');

    $applicationTable = Engine_Api::_()->getDbTable('applications', 'sesjob');
    $applicationTableName = $applicationTable->info('name');

    $select = $applicationTable->select()
                        ->setIntegrityCheck(false)
                        ->from($applicationTableName)
                        ->joinLeft($tableJobName, "$applicationTableName.job_id = $tableJobName.job_id", 'title')
                        ->order((!empty($_GET['order']) ? $_GET['order'] : 'application_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));

    if (!empty($_GET['name']))
    $select->where($applicationTableName . '.name LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['email']))
        $select->where($applicationTableName . '.email = ?', $_GET['email']);

    if (!empty($_GET['mobile_number']))
        $select->where($applicationTableName . '.mobile_number = ?', $_GET['mobile_number']);

    if (!empty($_GET['title']))
    $select->where($tableJobName . '.title LIKE ?', '%' . $_GET['title'] . '%');

    if (!empty($_GET['creation_date']))
    $select->where($applicationTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

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

  public function downloadAction() {

    $application = Engine_Api::_()->getItem('sesjob_application', $this->_getParam('id'));
    $storage = Engine_Api::_()->getItem('storage_file', $application->file_id);

    if($storage->service_id == 2) {
      $servicesTable = Engine_Api::_()->getDbtable('services', 'storage');
      $result  = $servicesTable->select()
                  ->from($servicesTable->info('name'), 'config')
                  ->where('service_id = ?', $storage->service_id)
                  ->limit(1)
                  ->query()
                  ->fetchColumn();
      $serviceResults = Zend_Json_Decoder::decode($result);
      if($serviceResults['baseUrl']) {
        $path = 'http://' . $serviceResults['baseUrl'] . '/' . $storage->storage_path;
      } else {
        $path = 'http://' . $serviceResults['bucket'] . '.s3.amazonaws.com/' . $storage->storage_path;
      }
    } else {
      //Song file name and path
      $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . $storage->storage_path;
    }

    //KILL ZEND'S OB
    while (ob_get_level() > 0) {
      ob_end_clean();
    }

    $baseName = $storage->name; // . '.' . $storage->extension;

    header("Content-Disposition: attachment; filename=" . basename($baseName), true);
    header("Content-Transfer-Encoding: Binary", true);

    header("Content-Type: application/force-download", true);
    header("Content-type: audio/mpeg3");

    header("Content-Description: File Transfer", true);
    header("Content-Length: " . filesize($path), true);
    readfile("$path");
    exit();
    return;
  }

//   public function deleteAction()
//   {
//     // In smoothbox
//     $this->_helper->layout->setLayout('admin-simple');
//     $id = $this->_getParam('id');
//     $this->view->application_id=$id;
//     // Check post
//     if( $this->getRequest()->isPost() )
//     {
//       $db = Engine_Db_Table::getDefaultAdapter();
//       $db->beginTransaction();
//
//       try
//       {
//         $sesjob = Engine_Api::_()->getItem('sesjob_company', $id);
//         // delete the sesjob entry into the database
//         Engine_Api::_()->sesjob()->deleteJob($sesjob);
//         $db->commit();
//       }
//
//       catch( Exception $e )
//       {
//         $db->rollBack();
//         throw $e;
//       }
//
//       $this->_forward('success', 'utility', 'core', array(
//           'smoothboxClose' => 10,
//           'parentRefresh'=> 10,
//           'messages' => array('')
//       ));
//     }
//
//     // Output
//     $this->renderScript('admin-manage-companies/delete.tpl');
//   }
}
