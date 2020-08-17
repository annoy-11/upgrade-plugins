<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercovervideo
 * @package    Sesusercovervideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminLevelController.php 2016-01-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesusercovervideo_AdminLevelController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    // Make navigation
    $this->view->navigation  = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesusercoverphoto_admin_main', array(), 'sesusercovervideo_admin_main_level');

    // Get level id
    if( null !== ($id = $this->_getParam('level_id', $this->_getParam('id'))) ) {
      $level = Engine_Api::_()->getItem('authorization_level', $id);
    } else {
      $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();
    }
    if( !$level instanceof Authorization_Model_Level ) {
      throw new Engine_Exception('missing level');
    }
    $id = $level->level_id;
    // Make form
    $this->view->form = $form = new Sesusercovervideo_Form_Admin_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
    ));
    $form->level_id->setValue($id);
    $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
    // Check post
    if( !$this->getRequest()->isPost() ) {

      $form->populate($permissionsTable->getAllowed('sesusercovevideo', $id, array_keys($form->getValues())));
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
    try
    {
      // Set permissions
			$values['option'] = array_merge((array)$values['option'],array('title'));

      $permissionsTable->setAllowed('sesusercovevideo', $id, $values);
      // Commit
      $db->commit();
    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }
    $form->addNotice('Your changes have been saved.');
  }
}
