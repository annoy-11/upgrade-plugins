<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestestimonial_IndexController extends Core_Controller_Action_Standard {

    public function init() {
        // only show to member_level if authorized
        //  if( !$this->_helper->requireAuth()->setAuthParams('testimonial', null, 'view')->isValid() ) return;
    }

    public function indexAction() {
        // Render
        $this->_helper->content->setEnabled();
    }

    public function helpfulAction() {

        $testimonial_id = $this->_getParam('testimonial_id', null);
        $helpfultestimonial = $this->_getParam('helpfultestimonial', null);
        $viewer = Engine_Api::_()->user()->getViewer();
        $viewer_id = $viewer->getIdentity();
        $testimonial = Engine_Api::_()->getItem('testimonial', $testimonial_id);
        $reason_id = $this->_getParam('reason_id', 0);
        $checkHelpful = Engine_Api::_()->getDbTable('helptestimonials', 'sestestimonial')->checkHelpful($testimonial_id, $viewer_id);
        if($checkHelpful) {
            Engine_Api::_()->getDbTable('helptestimonials', 'sestestimonial')->setHelpful($testimonial_id, $viewer_id, $reason_id, $helpfultestimonial);
        } else {
            Engine_Api::_()->getDbTable('helptestimonials', 'sestestimonial')->setHelpful($testimonial_id, $viewer_id, $reason_id, $helpfultestimonial);
        }
    }

  public function viewAction() {

    // Check permission
    $viewer = Engine_Api::_()->user()->getViewer();
    $testimonial = Engine_Api::_()->getItem('testimonial', $this->_getParam('testimonial_id'));
    if( $testimonial ) {
      Engine_Api::_()->core()->setSubject($testimonial);
    }

    if( !$this->_helper->requireSubject()->isValid() ) {
      return;
    }
    if( !$this->_helper->requireAuth()->setAuthParams($testimonial, $viewer, 'view')->isValid() ) {
        return;
    }
    if( !$testimonial || !$testimonial->getIdentity()) {
      return $this->_helper->requireSubject->forward();
    }

    // Prepare data
    $testimonialTable = Engine_Api::_()->getDbtable('testimonials', 'sestestimonial');
    if (strpos($testimonial->body, '<') === false) {
        $testimonial->body = nl2br($testimonial->body);
    }
    $this->view->testimonial = $testimonial;
    $this->view->owner = $owner = $testimonial->getOwner();
    $this->view->viewer = $viewer;

    if( !$testimonial->isOwner($viewer) ) {
      $testimonialTable->update(array(
        'view_count' => new Zend_Db_Expr('view_count + 1'),
      ), array(
        'testimonial_id = ?' => $testimonial->getIdentity(),
      ));
    }

    // Render
    $this->_helper->content->setEnabled();
  }


  public function editAction()
  {
    if( !$this->_helper->requireUser()->isValid() ) return;

    $viewer = Engine_Api::_()->user()->getViewer();

    $testimonial_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('testimonial_id', 0);

    $testimonial = Engine_Api::_()->getItem('testimonial', $testimonial_id);

    if( !Engine_Api::_()->core()->hasSubject('testimonial') ) {
      Engine_Api::_()->core()->setSubject($testimonial);
    }

    if( !$this->_helper->requireSubject()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams($testimonial, $viewer, 'edit')->isValid() ) return;

    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestestimonial_main');

    // Prepare form
    $this->view->form = $form = new Sestestimonial_Form_Edit();

    // Populate form
    $form->populate($testimonial->toArray());

    $auth = Engine_Api::_()->authorization()->context;
    $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

    foreach( $roles as $role ) {
      if ($form->auth_view){
        if( $auth->isAllowed($testimonial, $role, 'view') ) {
         $form->auth_view->setValue($role);
        }
      }
    }

    // Check post/form
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }
    // Process
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
      $values = $form->getValues();

      if( empty($values['auth_view']) ) {
        $values['auth_view'] = 'everyone';
      }
      if( empty($values['auth_comment']) ) {
        $values['auth_comment'] = 'everyone';
      }

      $testimonial->setFromArray($values);
      $testimonial->modified_date = date('Y-m-d H:i:s');
      $testimonial->save();

      // Auth
      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);

      foreach( $roles as $i => $role ) {
        $auth->setAllowed($testimonial, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($testimonial, $role, 'comment', ($i <= $commentMax));
      }

      $db->commit();
    }
    catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'sestestimonial_general');
  }

  public function deleteAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $testimonial = Engine_Api::_()->getItem('testimonial', $this->getRequest()->getParam('testimonial_id'));
    if( !$this->_helper->requireAuth()->setAuthParams($testimonial, null, 'delete')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sestestimonial_Form_Delete();

    if( !$testimonial ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Testimonial entry doesn't exist or not authorized to delete");
      return;
    }

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $testimonial->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      $testimonial->delete();

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your testimonial entry has been deleted.');
    return $this->_forward('success' ,'utility', 'core', array(
      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sestestimonial_general', true),
      'messages' => Array($this->view->message)
    ));
  }


  public function createAction()
  {
    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('testimonial', null, 'create')->isValid()) return;

    // Render
    $this->_helper->content->setEnabled();

    // set up data needed to check quota
    $viewer = Engine_Api::_()->user()->getViewer();
    $values['user_id'] = $viewer->getIdentity();
    $paginator = Engine_Api::_()->getItemTable('testimonial')->getTestimonials($values);

    $this->view->quota = $quota = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'testimonial', 'max');
    $this->view->current_count = $paginator->getTotalItemCount();


    // Prepare form
    $this->view->form = $form = new Sestestimonial_Form_Create();

    // If not post or form not valid, return
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process
    $table = Engine_Api::_()->getDbTable('testimonials', 'sestestimonial');
    $db = $table->getAdapter();
    $db->beginTransaction();

    try {
      $viewer = Engine_Api::_()->user()->getViewer();
      $formValues = $form->getValues();

      if( empty($values['auth_view']) ) {
        $formValues['auth_view'] = 'everyone';
      }

      if( empty($values['auth_comment']) ) {
        $formValues['auth_comment'] = 'everyone';
      }

      $values = array_merge($formValues, array(
        'user_id' => $viewer->getIdentity(),
      ));
      $testimonial = $table->createRow();
      $testimonial->setFromArray($values);
      $testimonial->save();

      // Auth
      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);

      foreach( $roles as $i => $role ) {
        $auth->setAllowed($testimonial, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($testimonial, $role, 'comment', ($i <= $commentMax));
      }

      if(Engine_Api::_()->authorization()->isAllowed('testimonial', null, 'approve')) {
        $testimonial->approve = 1;
        $testimonial->save();
      } else {
        $getAdminSuperAdmins = Engine_Api::_()->sestestimonial()->getAdminSuperAdmins();
        foreach ($getAdminSuperAdmins as $getAdminSuperAdmin) {
            $user = Engine_Api::_()->getItem('user', $getAdminSuperAdmin['user_id']);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $testimonial, 'sestestimonial_aprvtes');
        }
      }

      // Commit
      $db->commit();
    } catch( Exception $e ) {

      return $this->exceptionWrapper($e, $form, $db);
    }

    return $this->_helper->redirector->gotoRoute(array('action' => 'manage'));
  }

  public function manageAction() {

    if( !$this->_helper->requireUser()->isValid() ) return;

    // Render
    $this->_helper->content->setEnabled();

    // Prepare data
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Sestestimonial_Form_Search();
    $form->removeElement('show');
    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('testimonial', null, 'create')->checkRequire();

    // Process form
    $defaultValues = $form->getValues();
    if( $form->isValid($this->_getAllParams()) ) {
      $values = $form->getValues();
    } else {
      $values = $defaultValues;
    }
    $this->view->formValues = array_filter($values);
    $values['user_id'] = $viewer->getIdentity();


    // Get paginator
    $this->view->paginator = $paginator = Engine_Api::_()->getItemTable('testimonial')->getTestimonials($values);
    $paginator->setItemCountPerPage(10);
    $this->view->paginator = $paginator->setCurrentPageNumber( $values['page'] );
  }

}
