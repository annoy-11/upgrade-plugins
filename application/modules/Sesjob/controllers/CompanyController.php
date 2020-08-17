<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_CompanyController extends Core_Controller_Action_Standard
{
  public function init() {

    // only show to member_level if authorized
    //if( !$this->_helper->requireAuth()->setAuthParams('sesjob_company', null, 'view')->isValid() ) return;
    $company_id = $this->_getParam('company_id', $this->_getParam('id', null));
    if ($company_id) {
      $company = Engine_Api::_()->getItem('sesjob_company', $company_id);
      if ($company) {
		Engine_Api::_()->core()->setSubject($company);
      }
    }
  }

  public function subscribeAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    if (empty($viewer_id))
      return;

    $resource_id = $this->_getParam('resource_id');
    $resource_type = $this->_getParam('resource_type');
    $cpnysubscribe_id = $this->_getParam('cpnysubscribe_id');

    $item = Engine_Api::_()->getItem($resource_type, $resource_id);

    $favouriteTable = Engine_Api::_()->getDbTable('cpnysubscribes', 'sesjob');
    $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
    $activityStrameTable = Engine_Api::_()->getDbtable('stream', 'activity');

    if (empty($cpnysubscribe_id)) {
      $isCpnysubscribe = $favouriteTable->isCpnysubscribe(array('resource_id' => $resource_id, 'resource_type' => $resource_type));
      if (empty($isCpnysubscribe)) {
        $db = $favouriteTable->getAdapter();
        $db->beginTransaction();
        try {
          if (!empty($item))
            $cpnysubscribe_id = $favouriteTable->addCpnysubscribe($item, $viewer)->cpnysubscribe_id;

            $this->view->cpnysubscribe_id = $cpnysubscribe_id;

            $owner = Engine_Api::_()->getItem('user', $item->owner_id);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $item, 'sesjob_cpnysubscribe');
            $action = $activityTable->addActivity($viewer, $item, 'sesjob_cpnysubscribe');
            if ($action)
                $activityTable->attachActivity($action, $item);

          $db->commit();
        } catch (Exception $e) {
          $db->rollBack();
          throw $e;
        }
      } else {
        $this->view->cpnysubscribe_id = $isCpnysubscribe;
      }
    } else {
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => "sesjob_cpnysubscribe", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
        $action = $activityTable->fetchRow(array('type =?' => "sesjob_cpnysubscribe", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));

      if (!empty($action)) {
        $action->deleteItem();
        $action->delete();
      }

      $favouriteTable->removeCpnysubscribe($item, $viewer);
    }
  }

  public function getCompanyAction() {
    $sesdata = array();
    $value['textSearch'] = $this->_getParam('text', null);
    $value['search'] = 1;
    $value['fetchAll'] = true;
    $value['getjob'] = true;
    $jobs = Engine_Api::_()->getDbtable('companies', 'sesjob')->getCompanySelect($value);
    foreach ($jobs as $job) {
      $icon = $this->view->itemPhoto($job, 'thumb.icon');
      $sesdata[] = array(
          'id' => $job->company_id,
          'label' => $job->company_name,
          'photo' => $icon
      );
    }
    return $this->_helper->json($sesdata);
  }


  public function applyAction() {

    $job = Engine_Api::_()->getItem('sesjob_job', $this->getRequest()->getParam('job_id'));

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesjob_Form_Company_Apply();
    // If not post or form not valid, return
    if( !$this->getRequest()->isPost() )
    return;

    if( !$form->isValid($this->getRequest()->getPost()) )
    return;
    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $table = Engine_Api::_()->getDbtable('applications', 'sesjob');
    $db = $table->getAdapter();
    $db->beginTransaction();

    $values = $form->getValues();

    if(!empty($this->view->viewer_id))
        $values['owner_id'] = $this->view->viewer_id;
    else
        $values['owner_id'] = '0';
    $values['job_id'] = $job->getIdentity();
    try {
        $application = $table->createRow();
        $application->setFromArray($values);
        $application->save();

        if(isset($values['photo']) && !empty($values['photo'])) {
            $file_ext = pathinfo($_FILES['photo']['name']);

            $file_ext = $file_ext['extension'];
            $storage = Engine_Api::_()->getItemTable('storage_file');
            $storageObject = $storage->createFile($form->photo, array(
                'parent_id' => $application->getIdentity(),
                'parent_type' => $application->getType(),
                'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
            ));
            // Remove temporary file
            @unlink($file['tmp_name']);
            $application->file_id = $storageObject->file_id;
            $application->save();
        }

        $job->applicant_count++;
        $job->save();

        if(!empty($this->view->viewer_id)) {
            Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($job->getOwner(), $viewer, $job, 'sesjob_new_application');
        }

        $jobOwner = Engine_Api::_()->getItem('user', $job->owner_id);
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($jobOwner->email, 'sesjob_new_application', array('sender_title' => $values['name'], 'object_link' => $job->getHref(), 'object_title' => $job->getTitle(), 'host' => $_SERVER['HTTP_HOST'], 'email' => $values['email'], 'phone' => $values['mobile_number'], 'location' => $values['location']));

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('You have successfully submitted resume for this job.');
    return $this->_forward('success' ,'utility', 'core', array(
      'smoothboxClose' => true,
      'parentRefresh' => false,
      'messages' => Array($this->view->message)
    ));
  }


  public function getcompanyinformationAction() {

    $company_id = $this->_getParam('company_id', null);

    $sesdata = array();
    $companiesTable = Engine_Api::_()->getDbtable('companies', 'sesjob');
    $select = $companiesTable->select()
                    ->where('company_id =?', $company_id);
    $results = $companiesTable->fetchRow($select);

    echo json_encode(array(
        'company_name' => $results->company_name,
        'company_websiteurl' => $results->company_websiteurl,
        'company_description' => $results->company_description,
        'industry_id' => $results->industry_id,
    ));
    die;
  }

  public function browseAction() {
    // Render
    $this->_helper->content->setEnabled();
  }

  public function viewAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    $this->view->company_id = $company_id = $this->_getParam('company_id', null);

    if(!Engine_Api::_()->core()->hasSubject())
        $company = Engine_Api::_()->getItem('sesjob_company', $company_id);
    else
        $company = Engine_Api::_()->core()->getSubject();

    if( !$this->_helper->requireSubject()->isValid() )
        return;

//     if( !$this->_helper->requireAuth()->setAuthParams($company, $viewer, 'view')->isValid() )
//         return;
    $this->_helper->content->setContentName('sesjob_company_view')->setEnabled();
  }

  public function editAction() {

    $company = Engine_Api::_()->getItem('sesjob_company', $this->getRequest()->getParam('company_id'));

    //if( !$this->_helper->requireAuth()->setAuthParams($company, null, 'delete')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesjob_Form_Company_Edit();
    $form->populate($company->toArray());

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $company->getTable()->getAdapter();
    $db->beginTransaction();

    $values = $form->getValues();
    try {

       $company->setFromArray($values);
       $company->save();

       if(isset($values['photo']) && !empty($values['photo'])) {
        $photo_id = $this->setPhoto($form->photo, $company->company_id);
        $company->photo_id = $photo_id;
        $company->save();
       }

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('You have successfully edit company information.');
    return $this->_forward('success' ,'utility', 'core', array(
      'smoothboxClose' => true,
      'parentRefresh' => false,
      'messages' => Array($this->view->message)
    ));
  }

  public function enableAction() {

    $company = Engine_Api::_()->getItem('sesjob_company', $this->getRequest()->getParam('company_id'));
    //if( !$this->_helper->requireAuth()->setAuthParams($company, null, 'delete')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesjob_Form_Company_Enable();
    if($company->enable) {
        $form->setTitle('Disable Company');
        $form->setDescription("Are you sure that want to disable this company, after disable this company, this company will not show?");
        $form->submit->setLabel("Disable");
    } else {
        $form->setTitle('Enable Company');
        $form->setDescription("Are you sure that want to enable this company?");
        $form->submit->setLabel("Enable");
    }

    if( !$company ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Company entry doesn't exist or not authorized to disable");
      return;
    }

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $company->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $company->enable = !$company->enable;
      $company->save();
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('You have successfully disable your company.');
    return $this->_forward('success' ,'utility', 'core', array(
      'parentRefresh' => 10,
      'smoothboxClose' => 10,
      'messages' => Array($this->view->message)
    ));
  }


  // USER SPECIFIC METHODS
  public function manageAction() {

    if( !$this->_helper->requireUser()->isValid() ) return;

    // Render
    $this->_helper->content
        //->setNoRender()
        ->setEnabled()
        ;

    // Prepare data
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Sesjob_Form_Search();
    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('sesjob', null, 'create')->checkRequire();

    $form->removeElement('show');

    // Populate form
    $categories = Engine_Api::_()->getDbtable('categories', 'sesjob')->getCategoriesAssoc();
    if( !empty($categories) && is_array($categories) && $form->getElement('category') ) {
      $form->getElement('category')->addMultiOptions($categories);
    }
  }

  public function deleteAction() {

    $company = Engine_Api::_()->getItem('sesjob_company', $this->getRequest()->getParam('company_id'));
    if( !$this->_helper->requireAuth()->setAuthParams($company, null, 'delete')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesjob_Form_Delete();

    if( !$company ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Sesjob entry doesn't exist or not authorized to delete");
      return;
    }

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $company->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      Engine_Api::_()->sesjob()->deleteJob($company);;

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your sesjob entry has been deleted.');
    return $this->_forward('success' ,'utility', 'core', array(
      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sesjob_general', true),
      'messages' => Array($this->view->message)
    ));
  }

  protected function setPhoto($photo, $id) {

    if ($photo instanceof Zend_Form_Element_File) {
      $file = $photo->getFileName();
      $fileName = $file;
    } else if ($photo instanceof Storage_Model_File) {
      $file = $photo->temporary();
      $fileName = $photo->name;
    } else if ($photo instanceof Core_Model_Item_Abstract && !empty($photo->file_id)) {
      $tmpRow = Engine_Api::_()->getItem('storage_file', $photo->file_id);
      $file = $tmpRow->temporary();
      $fileName = $tmpRow->name;
    } else if (is_array($photo) && !empty($photo['tmp_name'])) {
      $file = $photo['tmp_name'];
      $fileName = $photo['name'];
    } else if (is_string($photo) && file_exists($photo)) {
      $file = $photo;
      $fileName = $photo;
    } else {
      throw new User_Model_Exception('invalid argument passed to setPhoto');
    }
    if (!$fileName) {
      $fileName = $file;
    }
    $name = basename($file);
    $extension = ltrim(strrchr($fileName, '.'), '.');
    $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_type' => 'sesjob_application',
        'parent_id' => $id,
        'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        'name' => $fileName,
    );
    // Save
    $filesTable = Engine_Api::_()->getDbtable('files', 'storage');
    $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_main.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
            //->resize(500, 500)
            ->write($mainPath)
            ->destroy();
    // Store
    try {
      $iMain = $filesTable->createFile($mainPath, $params);
    } catch (Exception $e) {
      // Remove temp files
      @unlink($mainPath);
      // Throw
      if ($e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE) {
        throw new Sesjob_Model_Exception($e->getMessage(), $e->getCode());
      } else {
        throw $e;
      }
    }
    // Remove temp files
    @unlink($mainPath);
    // Update row
    // Delete the old file?
    if (!empty($tmpRow)) {
      $tmpRow->delete();
    }
    return $iMain->file_id;
  }
}
