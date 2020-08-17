<?php

class Sesinviter_AdminManageController extends Core_Controller_Action_Admin
{
  public function indexAction() {

    $this->view->navigation  = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesinviter_admin_main', array(), 'sesinviter_admin_main_manage');

		$this->view->formFilter = $formFilter = new Sesinviter_Form_Admin_Filter();

		// Process form
    $values = array();
    if( $formFilter->isValid($this->_getAllParams()) ) {
      $values = $formFilter->getValues();
    }

    foreach( $_GET as $key => $value ) {
      if( '' === $value ) {
        unset($_GET[$key]);
      }else
        $values[$key]=$value;
    }

    if( $this->getRequest()->isPost() ) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $invite = Engine_Api::_()->getItem('sesinviter_invite', $value);
          $invite->delete();
        }
      }
    }

    $tableInvite = Engine_Api::_()->getDbtable('invites', 'sesinviter');
    $inviteTableName = $tableInvite->info('name');

    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');

    $select = $tableInvite->select()
            ->from($inviteTableName)
            ->setIntegrityCheck(false)
            ->joinLeft($tableUserName, "$tableUserName.user_id = $inviteTableName.sender_id", null)
            ->order('invite_id DESC');

    if( isset($_GET['email']) && $_GET['email'] != '')
      $select->where($tableUserName.'.email = ?', $values['email']);

    if( !empty($_GET['displayname']) )
      $select->where($tableUserName.'.displayname LIKE ?', '%' . $values['displayname'] . '%');

    if( isset($_GET['recipient_email']) && $_GET['recipient_email'] != '')
      $select->where($inviteTableName.'.recipient_email = ?', $values['recipient_email']);

    if( isset($_GET['import_method']) && $_GET['import_method'] != '')
      $select->where($inviteTableName.'.import_method = ?', $values['import_method']);

    if( !empty($values['creation_date']) )
      $select->where($inviteTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

    $page = $this->_getParam('page', 1);

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
		$paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber( $page );
  }


  public function deleteAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete This Entry?');
    $form->setDescription('Are you sure that you want to delete this entry? It will not be recoverable after being deleted. ');
    $form->submit->setLabel('Delete');

    $id = $this->_getParam('id');
    $this->view->offer_id = $id;
    // Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $invite = Engine_Api::_()->getItem('sesinviter_invite', $id);
        $invite->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Entry deleted successfully.')
      ));
    }
  }
}
