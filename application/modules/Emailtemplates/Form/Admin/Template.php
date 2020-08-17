<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Template.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Emailtemplates_Form_Admin_Template extends Engine_Form {

  public function init()
  {
    // Set form attributes
    $description = $this->getTranslator()->translate(
      'Various notification emails are sent to your members as they interact with the community.' 
      . ' Use this form to customize the content of these emails. Any changes you make here will'
      . ' only be saved after you click the "Save Changes" button at the bottom of the form.');
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if( $settings->getSetting('user.support.links', 0) == 1 ) {
    $moreinfo = $this->getTranslator()->translate( 
    'More Info: <a href="%1$s" target="_blank"> KB Article</a>');
    } else {
    $moreinfo = $this->getTranslator()->translate( 
    '');
    }
    //$description = vsprintf($description.$moreinfo, array(
     // 'http://support.socialengine.com/questions/184/Admin-Panel-Settings-Mail-Templates',
   // ));

    // Decorators
    //$this->loadDefaultDecorators();
    //$this->getDecorator('Description')->setOption('escape', false);

    $this
      ->setTitle('Mail Templates')
      ->setDescription($description)
      ;

    // Element: language
    $this->addElement('Select', 'language', array(
      'label' => 'Language Pack',
      'description' => 'Your community has more than one language pack installed. Please select the language pack you want to edit right now.',
      'onchange' => 'javascript:setEmailLanguage(this.value);',
    ));

    // Languages
    $localeObject = Zend_Registry::get('Locale');
    $translate    = Zend_Registry::get('Zend_Translate');
    $languageList = $translate->getList();

    $languages = Zend_Locale::getTranslationList('language', $localeObject);
    $territories = Zend_Locale::getTranslationList('territory', $localeObject);

    $localeMultiOptions = array();
    foreach( /*array_keys(Zend_Locale::getLocaleList())*/ $languageList as $key ) {
      $languageName = null;
      if( !empty($languages[$key]) ) {
        $languageName = $languages[$key];
      } else {
        $tmpLocale = new Zend_Locale($key);
        $region = $tmpLocale->getRegion();
        $language = $tmpLocale->getLanguage();
        if( !empty($languages[$language]) && !empty($territories[$region]) ) {
          $languageName =  $languages[$language] . ' (' . $territories[$region] . ')';
        }
      }

      if( $languageName ) {
        $localeMultiOptions[$key] = $languageName . ' [' . $key . ']';
      }
    }
    
    $defaultLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');
    if( isset($localeMultiOptions[$defaultLanguage]) ) {
      $localeMultiOptions = array_merge(array(
        $defaultLanguage => $localeMultiOptions[$defaultLanguage],
      ), $localeMultiOptions);
    }

    $this->language->setMultiOptions($localeMultiOptions);


    // Element: template_id
    $this->addElement('Select', 'template', array(
      'label' => 'Choose Message',
      'onchange' => 'javascript:fetchEmailTemplate(this.value);',
      'ignore' => true
    ));
    $this->template->getDecorator("Description")->setOption("placement", "append");

    $enabledModuleNames = Engine_Api::_()->getDbtable('modules', 'core')->getEnabledModuleNames();
    $select = Engine_Api::_()->getDbtable('MailTemplates', 'core')
        ->select()
        ->where('module IN(?)', $enabledModuleNames);
    foreach( Engine_Api::_()->getDbtable('MailTemplates', 'core')->fetchAll($select) as $mailTemplate ) {
      $title = $translate->_(strtoupper("_email_" . $mailTemplate->type . "_title"));
      $this->template->addMultiOption($mailTemplate->mailtemplate_id, $title);
    }

    // Element: subject
    $this->addElement('Text', 'subject', array(
      'label' => 'Subject',
      'style' => 'min-width:400px;',
    ));

    //UPLOAD PHOTO URL
			$upload_urlb = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);
			$allowed_htmlb = 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr';
			$editorOptionsb = array(
					'upload_url' => $upload_urlb,
					'html' => (bool) $allowed_htmlb,
			);
			
			if (!empty($upload_urlb)) {
			
				$editorOptionsb['editor_selector'] = 'tinymce';
				$editorOptionsb['mode'] = 'specific_textareas';
				$editorOptionsb['plugins'] = array(
						'table', 'fullscreen', 'media', 'preview', 'paste',
						'code', 'image', 'textcolor', 'jbimages', 'link'
				);
				$editorOptionsb['toolbar1'] = array(
						'undo', 'redo','format', 'pastetext', '|', 'code',
						'media', 'image', 'jbimages', 'link', 'fullscreen',
						'preview'
				);
			}

    $this->addElement('TinyMce', 'bodyhtml', array(
      'label' => 'Message Body',
      'editorOptions' => $editorOptionsb,
			'class'=> 'tinymce',
    ));
		
		// choose template

    $this->addElement('Radio', 'template_check', array(
      'label' => 'Select template',
			'multioptions'=>array(
				'0'=>'Simple template',
				'1'=>'Select template',
			),
			'value' => '0',
    ));
		
		$templateTable = Engine_Api::_()->getDbTable('templates','emailtemplates');
		$templateTableName = $templateTable->info('name');
		$select = $templateTable->select()->from($templateTableName,array("template_id","title"));
		$select->order($templateTableName . '.creation_date ASC');
		$data = $templateTable->fetchAll($select);
		$emailtemplateOptions = array();
		foreach($data as $emailtemplate){
			$emailtemplateOptions[$emailtemplate->template_id] = $emailtemplate->title;
		}
			
		$this->addElement('Select', 'emailtemplate', array(
      'label' => 'Choose template',
      'ignore' => true,
			'multioptions'=>$emailtemplateOptions,
    ));
    
		
		$this->addElement('TinyMce', 'signature', array(
			'label' => 'Make Signature',
			'description' => 'Make Signature from here which you want to show in Email Template.',
			'allowEmpty' => true,
			'required' => false,
			'editorOptions' => $editorOptionsb,
			'class' => 'tinymce',
		));
    // Element: submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
    ));
  }
}
