<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Documentverification.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesuserdocverification_Plugin_Signup_Documentverification extends Core_Plugin_FormSequence_Abstract
{
 	protected $_name = 'documentverification';

 	protected $_formClass = 'Sesuserdocverification_Form_Signup_Documentverification';

 	protected $_script = array('index/signupdocumentverification.tpl', 'sesuserdocverification');

 	protected $_adminFormClass = 'Sesuserdocverification_Form_Admin_Signup_Documentverification';

 	protected $_adminScript = array('admin-signup/documentverification.tpl', 'sesuserdocverification');

 	protected $_skip;

 	public function onSubmit(Zend_Controller_Request_Abstract $request) {

    // Form was valid
    $skip = $request->getParam("skip");
    // do this if the form value for "skip" was not set
    // if it is set, $this->setActive(false); $this->onsubmisvalue and return true.
    if( $skip == "skipForm" ) {
      $this->setActive(false);
      $this->onSubmitIsValid();
      $this->getSession()->skip = true;
      $this->_skip = true;
      return true;
    } else {
        if(isset($_SESSION['userVerficationDocumentId']))
            unset($_SESSION['userVerficationDocumentId']);
        if($_FILES['file']['name']) {

          $storage = Engine_Api::_()->getItemTable('storage_file');
          $filename = $storage->createFile($_FILES['file'], array(
            'parent_id' => '1',
            'parent_type' => 'userdocverification',
            'user_id' => '1',
          ));
          $_SESSION['userVerficationDocumentId'] = $filename->file_id;
        }
      parent::onSubmit($request);
    }
	}


  public function onView() {

  }

  public function onProcess() {

    // In this case, the step was placed before the account step.
    // Register a hook to this method for onUserCreateAfter
    if( !$this->_registry->user ) {
      // Register temporary hook
      Engine_Hooks_Dispatcher::getInstance()->addEvent('onUserCreateAfter', array(
        'callback' => array($this, 'onProcess'),
      ));
      return;
    }
    $user = $this->_registry->user;

    $data = $this->getSession()->data;
    $form = $this->getForm();
    if( !$this->_skip && !$this->getSession()->skip ) {
      //if( $form->isValid($data) ) {
        $values = $form->getValues();

        if(!empty($_SESSION['userVerficationDocumentId'])) {

          Engine_Api::_()->getItemTable('storage_file')->update(array('parent_id' => $user->getIdentity(),'user_id' => $user->getIdentity()), array('file_id = ?' => $_SESSION['userVerficationDocumentId']));

          $storage = Engine_Api::_()->getItem('storage_file', $_SESSION['userVerficationDocumentId']);

          $table = Engine_Api::_()->getDbTable('documents', 'sesuserdocverification');
          $row = $table->createRow();
          $row->file_id = $_SESSION['userVerficationDocumentId']; //$filename->file_id;
          $row->user_id = $user->getIdentity();
          $row->storage_path = $storage->storage_path;
          $row->submintoadmin = '1';
          $row->documenttype_id = $values['documenttype_id'] ?  $values['documenttype_id'] : '0';
          $row->save();
          unset($_SESSION['userVerficationDocumentId']);
        }
      //}
    }
  }

  public function onAdminProcess($form) {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $step_table = Engine_Api::_()->getDbtable('signup', 'user');
    $step_row = $step_table->fetchRow($step_table->select()->where('class = ?', 'Sesuserdocverification_Plugin_Signup_Documentverification'));
    $step_row->enable = $form->getValue('enable');
    $step_row->save();
    $values = $form->getValues();

    $settings->setSetting('sesuserdocverification.signup.documentverification', $step_row->enable);
    $settings->setSetting('sesuserdocverification.requried', $values['sesuserdocverification_requried']);
    $form->addNotice('Your changes have been saved.');
  }
}
