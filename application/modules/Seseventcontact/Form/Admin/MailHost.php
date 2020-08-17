<?php

class Seseventcontact_Form_Admin_MailHost extends Engine_Form {

  public function init() {
	
		$description = $this->getTranslator()->translate('Using this form, you will be able to send an email out to all event hosts.  Emails are sent out using a queue system, so they will be sent out over time.  An email will be sent to you when all emails have been sent. <br>');
			
		$settings = Engine_Api::_()->getApi('settings', 'core');

		// Decorators
    $this->loadDefaultDecorators();
		$this->getDecorator('Description')->setOption('escape', false);

    $this->setTitle('Email All Event Hosts')
	      ->setDescription($description);

    $settings = Engine_Api::_()->getApi('settings', 'core')->core_mail;

    $this->addElement('Text', 'from_address', array(
      'label' => 'From:',
      'value' => (!empty($settings['from']) ? $settings['from'] : 'noreply@' . $_SERVER['HTTP_HOST']),
      'required' => true,
      //'disable' => true,
      'allowEmpty' => false,
      'validators' => array(
        'EmailAddress',
      )
    ));
    $this->from_address->getValidator('EmailAddress')->getHostnameValidator()->setValidateTld(false);
    
//     $this->addElement('Text', 'from_name', array(
//       'label' => 'From (name):',
//       'required' => true,
//       'allowEmpty' => false,
//       'value' => (!empty($settings['name']) ? $settings['name'] : 'Site Administrator'),
//     ));
    
    $categories = Engine_Api::_()->getDbtable('categories', 'sesevent')->getCategoriesAssoc();
    $categories = 
    $this->addElement('Multiselect', 'sesevent_categories', array(
      'label' => 'Event Categories',
      'description' => 'Hold down the CTRL key to select or de-select specific Member Levels.',
      'required' => true,
      'allowEmpty' => false,
      'multiOptions' => $categories,
      'value' => array_keys($categories),
    ));
    $this->sesevent_categories->getDecorator('Description')->setOptions(array('placement' => 'APPEND'));
    
    $status_array = array('published' => 'Published', 'draft' => 'Draft', 'featured' => 'Featured', 'sponsored' => 'Sponsored', 'verified' => 'Verified');
    $this->addElement('Multiselect', 'sesevent_status', array(
      'label' => 'Event Status',
      'description' => 'Hold down the CTRL key to select or de-select specific Member Levels.',
     // 'required' => true,
     // 'allowEmpty' => false,
      'multiOptions' => $status_array,
      'value' => array_keys($status_array),
    ));
    $this->sesevent_status->getDecorator('Description')->setOptions(array('placement' => 'APPEND'));

    $this->addElement('Text', 'subject', array(
      'label' => 'Subject:',
      'required' => true,
      'allowEmpty' => false,
    ));

    $this->addElement('Textarea', 'body', array(
      'label' => 'Body',
      'required' => true,
      'allowEmpty' => false,
      'description' => '(HTML or Plain Text)',
    ));
    $this->body->getDecorator('Description')->setOptions(array('placement' => 'APPEND'));


    $this->addElement('Textarea', 'body_text', array(
      'label' => 'Body (text)',
    ));

    $this->addDisplayGroup(array('body_text'), 'advanced', array(
      'decorators' => array(
        'FormElements',
        array('Fieldset', array('style' => 'display:none;')),
      ),
    ));

    // init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Send Emails',
      'type' => 'submit',
      'ignore' => true,
    ));
  }

}