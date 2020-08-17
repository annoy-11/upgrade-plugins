<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Emailtemplates_AdminManageController extends Core_Controller_Action_Admin{
  public function indexAction(){
		$this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
		->getNavigation('emailtemplates_admin_main', array(), 'emailtemplates_admin_main_manage');
		$this->view->formFilter = $formFilter = new Emailtemplates_Form_Admin_Filter();
		$params = array();
		$params['is_active'] = $this->_getParam('is_active',null);
		
    $formFilter->populate($params);
		$this->view->paginator = $paginator =  Engine_Api::_()->getDbtable('templates', 'emailtemplates')->getTemplates($params);
		$urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey => $urlParamsVal) {
      if ($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
        continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
		$this->view->urlParams = $urlParams;
		if ($this->getRequest()->isPost()){
			$db = Engine_Db_Table::getDefaultAdapter();
			$values = $this->getRequest()->getPost();
			foreach ($values as $key => $value){
				if ($key == 'delete_' . $value) {
					$template = Engine_Api::_()->getItem('emailtemplates_template', $value);
					if($template){
						$template->delete();
					}
				}
			}
		}
		$paginator->setItemCountPerPage(50);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

  }
	
	public function createAction(){
		
		$this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
		->getNavigation('emailtemplates_admin_main', array(), 'emailtemplates_admin_main_manage');
		$viewer = Engine_Api::_()->user()->getViewer();
		
		$template_id = $this->_getParam('template_id',null);
		
		$this->view->form = $form = new Emailtemplates_Form_Admin_Design();
		if($this->_getParam('duplicate','0')){
			
			$this->view->duplicateTemplate = $duplicateTemplate = Engine_Api::_()->getItem('emailtemplates_template', $this->_getParam('duplicate','0'));
			
			$form->save->setLabel('Save Changes');
			$form->setTitle("Edit Templates");
			$form->setDescription("Edit the details below for the Templates.");
			$values = $duplicateTemplate->toArray();
			$values['footer_social_icons'] = (explode(",", $duplicateTemplate->footer_social_icons));
			$form->populate($values);
		}
		if($template_id){
			$this->view->template = $template = Engine_Api::_()->getItem('emailtemplates_template', $template_id);
			$form->save->setLabel('Save Changes');
			$form->setTitle("Edit Templates");
			$form->setDescription("Edit the details below for the Templates.");
			$values = $template->toArray();
			$values['footer_social_icons'] = (explode(",", $template->footer_social_icons));
			if($template->is_active){
				$values['activate_thistemplate'] = $template->is_active;
			}
			$form->populate($values);
		}
		if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())){
      return;
    }
		
		// test mail
		$values = $form->getValues();
		if($values['test_email_check'] && !$_POST['test_email']){
			$form->addError("Test Email not available.");
			return;
		}
		
		// test mail
		
		$templateTable = Engine_Api::_()->getDbTable('templates','emailtemplates');
		$db = $templateTable->getAdapter();
		$db->beginTransaction();
		try{
			$values = $form->getValues();
			if(empty($template))
				$template = $templateTable->createRow();
			if(!empty($values['footer_social_icons'])){
				$values['footer_social_icons'] = implode(",", $values['footer_social_icons']);
			}
			
			/*----------- unset values if type of file -----------------------*/
			if( key_exists('header_logo',$values))
				unset($values['header_logo']);
			if($this->_getParam('duplicate','0')){
				$values['header_logo'] = $duplicateTemplate->header_logo;
			}
			if (isset($_FILES['header_logo']['name']) && $_FILES['header_logo']['name'] != '') {
				$storage = Engine_Api::_()->getItemTable('storage_file');
				$thumbname = $storage->createFile($form->header_logo, array(
						'parent_id' => $template->getIdentity(),
						'parent_type' => 'emailtemplates_template',
						'user_id' => $viewer->getIdentity(),
				));
				// Remove temporary file
				@unlink($file['tmp_name']);
				$template->header_logo = $thumbname->file_id;
			}
			$values['user_id'] = $viewer->getIdentity();
			if($values['activate_thistemplate']){
				$values['is_active'] = '1';
				$dbb = Zend_Db_Table_Abstract::getDefaultAdapter();
				$dbb->query('UPDATE `engine4_emailtemplates_templates` SET `is_active` = "0" WHERE `engine4_emailtemplates_templates`.`is_active` = "1";');
				
			}else{
				$values['is_active'] = '0';
			}
			
		
		$template->setFromArray($values);
		$template->save();
			
			$db->commit();
			if (!empty($_POST['test_email_check'])) {
        $description = '<p><span style="font-weight: 400;">Hello,</span></p>
<p><span style="font-weight: 400;">This is a test email which you can send to your site users.</span></p><p>&nbsp;</p><p><span style="font-weight: 400;">Thank You</span></p>';
        $search = array(
            '/\>[^\S ]+/s', // strip whitespaces after tags, except space
            '/[^\S ]+\</s', // strip whitespaces before tags, except space
            '/(\s)+/s'       // shorten multiple whitespace sequences
        );
        $replace = array(
            '>',
            '<',
            '\\1'
        );
				
        //check uploaded content images
        $doc = new DOMDocument();
        @$doc->loadHTML($description);
        $tags = $doc->getElementsByTagName('img');
        foreach ($tags as $tag) {
          $src = $tag->getAttribute('src');
          if (strpos($src, 'http://') === FALSE && strpos($src, 'https://') === FALSE) {
            $imageGetFullURL = (!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" . $_SERVER['HTTP_HOST'] . $src : "http://" . $_SERVER['HTTP_HOST'] . $src;
            $tag->setAttribute('src', $imageGetFullURL);
          }
        }
        $description = $doc->saveHTML();
        $description = preg_replace($search, $replace, $description);
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($values['test_email'], 'emailtemplate_test_mail', array('host' => $_SERVER['HTTP_HOST'], 'emailtemplate_content' => $description, 'emailtemplate_subject' => 'Email Templates Test Subject', 'queue' => false, 'recipient_title' => $viewer->displayname,'template_id'=>$template->template_id));
        $form->addNotice('Test email send successfully.');
      } else {
        unset($_POST['test_email_check']);
      }
		}catch(Exception $e){
			$db->rollback();
			throw $e;
		}
		if (isset($_POST['save']))
			return $this->_helper->redirector->gotoRoute(array('module' => 'emailtemplates', 'controller' => 'manage', 'action' => 'create','template_id'=>$template->getIdentity()), 'admin_default', true);
		else
			return $this->_helper->redirector->gotoRoute(array('module' => 'emailtemplates', 'controller' => 'manage'), 'admin_default', true);
  }
	public function testmailAction(){
		$templateId = $this->_getParam('template_id');
		
		$this->_helper->layout->setLayout('admin-simple');
		$this->view->form = $form = new Emailtemplates_Form_Admin_Testemail();
		$viewer = Engine_Api::_()->user()->getViewer();
		
		if($_POST){
			if(!$_POST['email']){
				$form->addError("Email not available.");
				return;
			}
			
			$description = '<p><span style="font-weight: 400;">Hello,</span></p><p><span style="font-weight: 400;">This is a test email which you can send to your site users.</span></p><p>&nbsp;</p><p><span style="font-weight: 400;">Thank You</span></p>';
			$search = array(
					'/\>[^\S ]+/s', // strip whitespaces after tags, except space
					'/[^\S ]+\</s', // strip whitespaces before tags, except space
					'/(\s)+/s'       // shorten multiple whitespace sequences
			);
			$replace = array(
					'>',
					'<',
					'\\1'
			);
			//check uploaded content images
			$doc = new DOMDocument();
			@$doc->loadHTML($description);
			$tags = $doc->getElementsByTagName('img');
			foreach ($tags as $tag) {
				$src = $tag->getAttribute('src');
				if (strpos($src, 'http://') === FALSE && strpos($src, 'https://') === FALSE) {
					$imageGetFullURL = (!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" . $_SERVER['HTTP_HOST'] . $src : "http://" . $_SERVER['HTTP_HOST'] . $src;
					$tag->setAttribute('src', $imageGetFullURL);
				}
			}
			$description = $doc->saveHTML();
			//get all background url tags
			//$description = $this->getBackgroundImages($description);
			$description = preg_replace($search, $replace, $description);
			Engine_Api::_()->getApi('mail', 'core')->sendSystem($_POST['email'], 'emailtemplate_test_mail', array('host' => $_SERVER['HTTP_HOST'], 'emailtemplate_content' => $description, 'emailtemplate_subject' => 'Email Templates Test Subject', 'queue' => false, 'recipient_title' => $viewer->displayname,'template_id'=>$templateId));
			$form->addNotice('Test email send successfully.');
			$this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh'=> 10,
          'messages' => array('Test email send successfully.')
      ));
		} 
	}
	
	public function deleteAction() {

		// In smoothbox
		$this->_helper->layout->setLayout('admin-simple');
		$id = $this->_getParam('template_id');
		$this->view->item_id = $id;
		// Check post
		if ($this->getRequest()->isPost()) {
				$template = Engine_Api::_()->getItem('emailtemplates_template', $id);
				if($template){
					$template->delete();
				}
				$this->_forward('success', 'utility', 'core', array(
						'smoothboxClose' => 10,
						'parentRefresh' => 10,
						'messages' => array('Email Template Deleted Successfully.')
				));
		}
		// Output
		$this->renderScript('admin-manage/delete.tpl');
	}
	public function enabledAction(){
		$template_id = $this->_getParam('template_id', 0);
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$db->query('UPDATE `engine4_emailtemplates_templates` SET `is_active` = "0" WHERE `engine4_emailtemplates_templates`.`is_active` = "1";');
		
		if (!empty($template_id)) {
			$item = Engine_Api::_()->getItem('emailtemplates_template', $template_id);
			$item->is_active = !$item->is_active;
			$item->save();
		}
		$this->_redirect('admin/emailtemplates/manage');
	}
	
	public function templateAction(){
		$this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
		->getNavigation('emailtemplates_admin_main', array(), 'emailtemplates_admin_main_emailtemplate');
		
		$this->view->form = $form = new Emailtemplates_Form_Admin_Template();
		
		// Get language
    $this->view->language = $language = preg_replace('/[^a-zA-Z_-]/', '', $this->_getParam('language', 'en'));
    if( !Zend_Locale::isLocale($language)) {
      $form->removeElement('submit');
      return $form->addError('Please select a valid language.');
    }

    // Check dir for exist/write
    $languageDir = APPLICATION_PATH . '/application/languages/' . $language;
    $languageFile = $languageDir . '/custom.csv';
    if( !is_dir($languageDir) ) {
      $form->removeElement('submit');
      return $form->addError('The language does not exist, please create it first');
    }
    if( !is_writable($languageDir) ) {
      $form->removeElement('submit');
      return $form->addError('The language directory is not writable. Please set CHMOD -R 0777 on the application/languages folder.');
    }
    if( is_file($languageFile) && !is_writable($languageFile) ) {
      $form->removeElement('submit');
      return $form->addError('The custom language file exists, but is not writable. Please set CHMOD -R 0777 on the application/languages folder.');
    }


    
    // Get template
    $this->view->template = $template = $this->_getParam('template', '1');
    $this->view->templateObject = $templateObject = Engine_Api::_()->getItem('core_mail_template', $template);
		
    if( !$templateObject ) {
      $templateObject = Engine_Api::_()->getDbtable('MailTemplates', 'core')->fetchRow();
      $template = $templateObject->mailtemplate_id;
    }

    // Populate form
    $description = $this->view->translate(strtoupper("_email_".$templateObject->type."_description"));
    $description .= '<br /><br />';
    $description .= $this->view->translate('Available Placeholders:');
    $description .= '<br />';
    $description .= join(', ', explode(',', $templateObject->vars));

    $form->getElement('template')
      ->setDescription($description)
      ->getDecorator('Description')
        ->setOption('escape', false)
        ;

    // Get translate
    $translate = Zend_Registry::get('Zend_Translate');


    // Get stuff
    $subjectKey = strtoupper("_email_".$templateObject->type."_subject");
    $subject = $translate->_($subjectKey, $language);
    if( $subject == $subjectKey ) {
      $subject = $translate->_($subjectKey, 'en');
    }

    $bodyHTMLKey = strtoupper("_email_".$templateObject->type."_bodyhtml");
    $bodyHTML = $translate->_($bodyHTMLKey, $language);
    if( $bodyHTML == $bodyHTMLKey ) {
      $bodyHTML = $translate->_($bodyHTMLKey, 'en');
    }

    // get body from email body key if not found by bodyhtml key
    if( $bodyHTML == $bodyHTMLKey ) {
        $bodyKey = strtoupper("_email_".$templateObject->type."_body");
        $body = $translate->_($bodyKey, $language);
        if( $body == $bodyKey ) {
          $body = $translate->_($bodyKey, 'en');
        }
        $bodyHTML = nl2br($body);
    }

		$emailtemplateTable = Engine_Api::_()->getDbTable('selecttemplates','emailtemplates');
		$emailtemplateTableName = $emailtemplateTable->info('name');
		$select = $emailtemplateTable->select()->from($emailtemplateTableName,array("template_check","template_id","signature","selecttemplate_id"));
		$select->where('core_template_id =?', $template);
		$selecttemplate = $emailtemplateTable->fetchRow($select);
		//echo '<pre>';print_r($selecttemplate->toArray());die;
		if(COUNT($selecttemplate)){
			$dom = 1;
			if(!$selecttemplate->signature){
				$signature = Engine_Api::_()->getApi('settings', 'core')->getSetting('emailtemplates.signature', 0);
				$ptemplate_check = $selecttemplate->template_check;
				$ptemplate_id = $selecttemplate->template_id;
			}else{
				$dom = 2;
				$signature = $selecttemplate->signature;
				$ptemplate_check = $selecttemplate->template_check;
				$ptemplate_id = $selecttemplate->template_id;
			}
		}else{
			$dom = 3;
			$emltemplateTable = Engine_Api::_()->getDbTable('templates','emailtemplates');
			$emltemplateTableName = $emltemplateTable->info('name');
			$selectemltemplateTable = $emltemplateTable->select()->from($emltemplateTableName,array("template_id"));
			$selectemltemplateTable->where('is_active =?',1);
			$id = $selectemltemplateTable->query()->fetchColumn();
			if($id){
				$signature = Engine_Api::_()->getApi('settings', 'core')->getSetting('emailtemplates.signature', '');
				$ptemplate_check = 0;
				$ptemplate_id = $id;
			}else{
				$dom = 4;
				$signature = Engine_Api::_()->getApi('settings', 'core')->getSetting('emailtemplates.signature', '');
				$ptemplate_check = 0;
				$ptemplate_id = 0;
			}
		}
		
    $form->populate(array(
      'language' => $language,
      'template' => $template,
      'subject' => $subject,
      'bodyhtml' => $bodyHTML,
			'template_check'=>$ptemplate_check,
			'emailtemplate'=>$ptemplate_id,
			'signature'=>$signature,
    ));
    
    // Check method/valid
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process
    $values = $form->getValues();
		
    $writer = new Engine_Translate_Writer_Csv();

    // Try to write to a file
    $targetFile = APPLICATION_PATH . '/application/languages/' . $language . '/custom.csv';
    if( !file_exists($targetFile) ) {
      touch($targetFile);
      chmod($targetFile, 0777);
    }

    // set the local folder depending on the language_id
    $writer->read(APPLICATION_PATH . '/application/languages/' . $language . '/custom.csv');

    // write new subject
    $writer->removeTranslation(strtoupper("_email_" . $templateObject->type . "_subject"));
    $writer->setTranslation(strtoupper("_email_" . $templateObject->type . "_subject"), $values['subject']);

    // write new body
    $writer->removeTranslation(strtoupper("_email_" . $templateObject->type . "_bodyhtml"));
    $writer->setTranslation(strtoupper("_email_" . $templateObject->type . "_bodyhtml"), $values['bodyhtml']);

    $writer->write();


    // Clear cache?
    $translate->clearCache();
	
		$select = $emailtemplateTable->select()->from($emailtemplateTableName,array("COUNT(selecttemplate_id)"));
		$select->where('core_template_id =?', $template);
    $count = $select->query()->fetchColumn();
		//$dbb = Zend_Db_Table_Abstract::getDefaultAdapter();
		$emailtemplateTabledb = $emailtemplateTable->getAdapter();
		try{
			$emailtemplateTabledb->beginTransaction();
			if($count > 0){
				$emailtemplateTableRow = Engine_Api::_()->getItem('emailtemplates_selecttemplate', $selecttemplate->selecttemplate_id);
				$emailtemplateTableRow->template_id = $_POST['emailtemplate'];
				$emailtemplateTableRow->template_check = $_POST['template_check'] ;
				$emailtemplateTableRow->core_template_id = $template;
				$emailtemplateTableRow->signature = $_POST['signature'];
			
			}else{
				$emailtemplateTableRow = $emailtemplateTable->createRow();
				
				$templateValue = array();
				$templateValue['core_template_id'] = $template;
				$templateValue['template_id'] = $_POST['emailtemplate'];
				$templateValue['template_check'] = $_POST['template_check'] ;
				$templateValue['signature'] = $_POST['signature'];
				$emailtemplateTableRow->setFromArray($templateValue);	
			}
			$emailtemplateTableRow->save();
			$emailtemplateTabledb->commit();
		}catch(Exception $e){
				throw $e;
		}
		
    $form->addNotice('Your changes have been saved.');

    // Check which Translation Adapter has been selected
    $db = Engine_Db_Table::getDefaultAdapter();
    $translationAdapter = $db->select()
      ->from('engine4_core_settings', 'value')
      ->where('`name` = ?', 'core.translate.adapter')
      ->query()
      ->fetchColumn();
    if ($translationAdapter == 'array') {
        $form->addNotice('You have enabled the "Translation Performance" setting from \"<a href="admin/core/settings/performance">Performance and Caching</a>\" section of administration. For your email template changes to be effective by re-generation of updated translation PHP array, please click on "Save Changes" button of \"<a href="admin/core/settings/performance">Performance and Caching</a>\" section, with "Flush cache?" enabled, after completing all your changes in email templates.');
    }


	}
}
