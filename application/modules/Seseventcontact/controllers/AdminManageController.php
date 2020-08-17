<?php

class Seseventcontact_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {
  
	  $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seseventcontact_admin_main', array(), 'seseventcontact_admin_main_manage');
            
    $this->view->form = $form = new Seseventcontact_Form_Admin_Mail();
    
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }
    
    $mailApi = Engine_Api::_()->getApi('mail', 'core');

    $values = $form->getValues();
    
    $eventsTable = Engine_Api::_()->getDbtable('events', 'sesevent');
    $eventsTableName = $eventsTable->info('name');
    $usertableName = Engine_Api::_()->getItemTable('user')->info('name');
    
    $select = $eventsTable->select()
											    ->from($eventsTableName, array('user_id'))
												  ->group($eventsTableName . '.user_id');

		if(isset($values['sesevent_categories']) && !empty($values['sesevent_categories'])) {
			$select->where($eventsTableName . '.category_id IN(?)', $values['sesevent_categories']);
		}
		
		if(isset($values['sesevent_status'])) {
	    if (in_array("featured", $values['sesevent_status']))
	      $select->where($eventsTableName . '.featured = ?', '1');

	    if (in_array("sponsored", $values['sesevent_status']))
	      $select->where($eventsTableName . '.sponsored = ?', '1');
	    
	    if (in_array("verified", $values['sesevent_status']))
	      $select->where($eventsTableName . '.verified = ?', '1');
	    
	    if ((in_array("published", $values['sesevent_status']) && in_array("draft", $values['sesevent_status']) )) {
	      $select->where($eventsTableName . '.draft = ?', '1')
				      ->orWhere($eventsTableName . '.draft = ?', '0');
	    } elseif (in_array("draft", $values['sesevent_status'])) {
	      $select->where($eventsTableName . '.draft = ?', '0');
	    } elseif (in_array("published", $values['sesevent_status'])) {
	      $select->where($eventsTableName . '.draft = ?', '1');
	    }
    }

    if(isset($values['sesevent_memberlevels']) && !empty($values['sesevent_memberlevels'])) { 
		  $select->setIntegrityCheck(false)
						->join($usertableName, $usertableName . '.user_id = ' . $eventsTableName . '.user_id', array())
						->where($usertableName . '.level_id IN(?)', $values['sesevent_memberlevels']);
		}

    foreach( $select->query()->fetchAll(Zend_Db::FETCH_COLUMN, 0) as $user_id ) {
			$user = Engine_Api::_()->getItem('user', $user_id);
			if(!empty($user->email)) {
				$mailApi->sendSystem($user->email, 'SESEVENTCONTACT_EVENTOWNER_CONTACT', array(
				'subject' => $values['subject'],
				'message' => $values['body'],
				'email' => $values['from_address'],
				'queue' => false));
			}
    }

    // temporarily enable queueing if requested
//     $temporary_queueing = Engine_Api::_()->getApi('settings', 'core')->core_mail_queueing;
//     if (isset($values['queueing']) && $values['queueing']) {
//       Engine_Api::_()->getApi('settings', 'core')->core_mail_queueing = 1;
//     }

    $mailComplete = $mailApi->create();
    $mailComplete
      ->addTo(Engine_Api::_()->user()->getViewer()->email)
      ->setFrom($values['from_address'], $values['from_name'])
      ->setSubject('Mailing Complete: '.$values['subject'])
      ->setBodyHtml('Your email blast to your members has completed.  Please note that, while the emails have been
        sent to the recipients\' mail server, there may be a delay in them actually receiving the email due to
        spam filtering systems, incoming mail throttling features, and other systems beyond SocialEngine\'s control.');
    $mailApi->send($mailComplete);

    // emails have been queued (or sent); re-set queueing value to original if changed
//     if (isset($values['queueing']) && $values['queueing']) {
//       Engine_Api::_()->getApi('settings', 'core')->core_mail_queueing = $temporary_queueing;
//     }

    $this->view->form = null;
    $this->view->status = true;
  }
  
  public function mailhostAction() {
  
	  $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seseventcontact_admin_main', array(), 'seseventcontact_admin_main_mailhost');

    $this->view->form = $form = new Seseventcontact_Form_Admin_MailHost();
    
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }
    
    $mailApi = Engine_Api::_()->getApi('mail', 'core');

    $values = $form->getValues();
    
    $eventsTable = Engine_Api::_()->getDbtable('events', 'sesevent');
    $eventsTableName = $eventsTable->info('name');
    
    $hostsTable = Engine_Api::_()->getDbtable('hosts', 'sesevent');
    $hostsTableName = $hostsTable->info('name');

    $usertableName = Engine_Api::_()->getItemTable('user')->info('name');
    
    $select = $eventsTable->select()
											    ->from($eventsTableName, array('host'))
												  ->group($eventsTableName . '.host');

		if(isset($values['sesevent_categories']) && !empty($values['sesevent_categories'])) {
			$select->where($eventsTableName . '.category_id IN(?)', $values['sesevent_categories']);
		}
		
		if(isset($values['sesevent_status'])) {
	    if (in_array("featured", $values['sesevent_status']))
	      $select->where($eventsTableName . '.featured = ?', '1');

	    if (in_array("sponsored", $values['sesevent_status']))
	      $select->where($eventsTableName . '.sponsored = ?', '1');
	    
	    if (in_array("verified", $values['sesevent_status']))
	      $select->where($eventsTableName . '.verified = ?', '1');
	    
	    if ((in_array("published", $values['sesevent_status']) && in_array("draft", $values['sesevent_status']) )) {
	      $select->where($eventsTableName . '.draft = ?', '1')
				      ->orWhere($eventsTableName . '.draft = ?', '0');
	    } elseif (in_array("draft", $values['sesevent_status'])) {
	      $select->where($eventsTableName . '.draft = ?', '0');
	    } elseif (in_array("published", $values['sesevent_status'])) {
	      $select->where($eventsTableName . '.draft = ?', '1');
	    }
    }

    foreach( $select->query()->fetchAll(Zend_Db::FETCH_COLUMN, 0) as $host_id ) {
			$host = Engine_Api::_()->getItem('sesevent_host', $host_id);
			if(!empty($host->host_email)) {
				$mailApi->sendSystem($host->host_email, 'SESEVENTCONTACT_EVENTOWNER_CONTACTHOST', array(
				'subject' => $values['subject'],
				'message' => $values['body'],
				'email' => $values['from_address'],
				'queue' => false));
			}
    }

    // temporarily enable queueing if requested
//     $temporary_queueing = Engine_Api::_()->getApi('settings', 'core')->core_mail_queueing;
//     if (isset($values['queueing']) && $values['queueing']) {
//       Engine_Api::_()->getApi('settings', 'core')->core_mail_queueing = 1;
//     }

    $mailComplete = $mailApi->create();
    $mailComplete
      ->addTo(Engine_Api::_()->user()->getViewer()->email)
      ->setFrom($values['from_address'], $values['from_name'])
      ->setSubject('Mailing Complete: '.$values['subject'])
      ->setBodyHtml('Your email blast to your members has completed.  Please note that, while the emails have been
        sent to the recipients\' mail server, there may be a delay in them actually receiving the email due to
        spam filtering systems, incoming mail throttling features, and other systems beyond SocialEngine\'s control.');
    $mailApi->send($mailComplete);

    // emails have been queued (or sent); re-set queueing value to original if changed
//     if (isset($values['queueing']) && $values['queueing']) {
//       Engine_Api::_()->getApi('settings', 'core')->core_mail_queueing = $temporary_queueing;
//     }

    $this->view->form = null;
    $this->view->status = true;
  }
}