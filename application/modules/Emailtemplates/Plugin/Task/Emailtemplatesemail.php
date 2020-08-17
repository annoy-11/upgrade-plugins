<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Emailtemplatesemail.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */



class Emailtemplates_Plugin_Task_Emailtemplatesemail extends Core_Plugin_Task_Abstract {

    public function execute() {
			//Refrence from Core/Bootstrap.php
			$content = Engine_Content::getInstance();
			$content->getView()->baseUrl();
			$storage = $content->getStorage();
			$results = Engine_Api::_()->getDbTable('emails', 'emailtemplates')->getResult();
			$dbInsert = Engine_Db_Table::getDefaultAdapter();
			$mailApi = Engine_Api::_()->getApi('mail', 'core');
			$templateTable = Engine_Api::_()->getItemTable('emailtemplates_template');
			$templateTableName = $templateTable->info('name');
			$is_signature = false;
			foreach($results as $result) {
					$select = $templateTable->select()->from($templateTableName)->where('template_id = ?', $result->template_id);
					$signt = Engine_Api::_()->getApi('settings', 'core')->getSetting('emailtemplates.signature', '');
					if($signt){
						$is_signature = true;
						$signature = $signt;
					}
					$this->view->results = $results = $templateTable->fetchRow($select);
					$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
					$viewer = Engine_Api::_()->user()->getViewer();
					$user = Engine_Api::_()->getItemTable('user')->fetchRow(array('email LIKE ?' => $result->email));
					if( null !== $user ) {
						$recipient = $user;
					}
					if(count($results)>0){
						$finalbodyTextTemplate = $view->partial('_emailhtml.tpl','emailtemplates',array('result'=>$results,'body'=>nl2br($result->body),'id'=>$recipient->user_id,'is_signature'=>$is_signature,'signature'=>$signature));
					}
					$message = $finalbodyTextTemplate;
					$dom = new DomDocument();
					$dom->loadHTML($message);
					$message = $dom->saveHTML();

					//Send email
					$mail = $mailApi->create();
					$mail->setFrom($result->from_address, $result->from_name)
							->setSubject($result->subject)
							->setBodyHtml($message);
					$mail->addTo($result->email);
					$mailApi->send($mail);

					//Delete afetr sent mail
					$dbInsert->query('DELETE FROM `engine4_emailtemplates_emails` WHERE `engine4_emailtemplates_emails`.`email_id` = "'.$result->email_id.'";');
			}
    }
}
