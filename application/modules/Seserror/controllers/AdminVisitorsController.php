<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminVisitorsController.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seserror_AdminVisitorsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seserror_admin_main', array(), 'seserror_admin_main_comingsoon');

    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('visitors', 'seserror')->getAllContacts();

    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function mailAction() {
  
    $this->view->form = $form = new Seserror_Form_Admin_Mail();
    

    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    $values = $form->getValues();

    $table = Engine_Api::_()->getDbTable('visitors', 'seserror');
    
    $select = new Zend_Db_Select($table->getAdapter());

    $select->from($table->info('name'), 'email');
    
    $emails = array();
    foreach( $select->query()->fetchAll(Zend_Db::FETCH_COLUMN, 0) as $email ) {
      $emails[] = $email;
    }

    // temporarily enable queueing if requested
    $temporary_queueing = Engine_Api::_()->getApi('settings', 'core')->core_mail_queueing;
    if (isset($values['queueing']) && $values['queueing']) {
      Engine_Api::_()->getApi('settings', 'core')->core_mail_queueing = 1;
    }

    $mailApi = Engine_Api::_()->getApi('mail', 'core');

    $mail = $mailApi->create();
    $mail
      ->setFrom($values['from_address'], $values['from_name'])
      ->setSubject($values['subject'])
      ->setBodyHtml(nl2br($values['body']));

    if( !empty($values['body_text']) ) {
      $mail->setBodyText($values['body_text']);
    } else {
      $mail->setBodyText(strip_tags($values['body']));
    }
    foreach( $emails as $email ) {
      $mail->addTo($email);
    }

    $mailApi->send($mail);

    $mailComplete = $mailApi->create();
    $mailComplete
      ->addTo(Engine_Api::_()->user()->getViewer()->email)
      ->setFrom($values['from_address'], $values['from_name'])
      ->setSubject('Mailing Complete: '.$values['subject'])
      ->setBodyHtml('Your email blast to your members has completed.  Please note that, while the emails have been
        sent to the recipients\' mail server, there may be a delay in them actually receiving the email due to
        spam filtering systems, incoming mail throttling features, and other systems beyond SocialEngine\'s control.')
      ;
    $mailApi->send($mailComplete);

    // emails have been queued (or sent); re-set queueing value to original if changed
    if (isset($values['queueing']) && $values['queueing']) {
      Engine_Api::_()->getApi('settings', 'core')->core_mail_queueing = $temporary_queueing;
    }

//     $this->view->form = null;
//     $this->view->status = true;
    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh' => 10,
      'messages' => array('Your message has been queued for sending.')
    ));
  }

}
