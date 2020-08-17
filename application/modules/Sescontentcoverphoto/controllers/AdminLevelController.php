<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontentcoverphoto
 * @package    Sescontentcoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminLevelController.php 2016-06-020 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescontentcoverphoto_AdminLevelController extends Core_Controller_Action_Admin {

  public function indexAction() {

    // Make navigation
    $this->view->navigation  = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescontentcoverphoto_admin_main', array(), 'sescontentcoverphoto_admin_main_level');

    // Get level id
    if( null !== ($id = $this->_getParam('level_id', $this->_getParam('id'))) ) {
      $level = Engine_Api::_()->getItem('authorization_level', $id);
    } else {
      $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();
    }
    if( !$level instanceof Authorization_Model_Level ) {
      throw new Engine_Exception('missing level');
    }

    $this->view->id = $id = $level->level_id;

    if( null !== ($resource_type = $this->_getParam('resource_type', $this->_getParam('resource_type'))) ) {
      $resource_type = $this->_getParam('resource_type', $this->_getParam('resource_type', ''));
    } else {
      $resource_type = '';
    }
    $this->view->resource_type = $resource_type;



    if($resource_type) {
      // Make form
      $this->view->form = $form = new Sescontentcoverphoto_Form_Admin_Level(array(
        'public' => ( in_array($level->type, array('public')) ),
        'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
      ));
      $form->level_id->setValue($id);
      $level_id_public = Engine_Api::_()->getDbtable('levels', 'authorization')->getPublicLevel()->level_id;
      if($level_id_public) {
        $form->level_id->removeMultiOption($level_id_public);
      }
    } else {
      $this->view->form = $form = new Sescontentcoverphoto_Form_Admin_Level();
    }

    $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
    // Check post
    if( !$this->getRequest()->isPost() ) {
      if($resource_type) {
        $form->populate($permissionsTable->getAllowed('sescontcvrpto', $id, array_keys($form->getValues())));
        $form->resource_type->setValue($resource_type);
      }
      return;
    }

    // Check validitiy
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process
    $values = $form->getValues();
    $db = $permissionsTable->getAdapter();
    $db->beginTransaction();
    try {
      // Set permissions
			$values['option_'.$resource_type] = array_merge((array)$values['option_'.$resource_type],array('title'));
      $permissionsTable->setAllowed('sescontcvrpto', $id, $values);
      // Commit
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
    $form->addNotice('Your changes have been saved.');
  }
}
