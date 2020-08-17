<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesuserdocverification_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {


    $getSignupStep = Engine_Api::_()->sesuserdocverification()->getSignupStep();

    $description = $this->getTranslator()->translate('These settings affect all members in your community.<br /> You can manage the Step of uploading document during signup process from here: <a href="admin/user/signup/index/signup_id/'.$getSignupStep.'"> Document Verification</a>.');

    // Decorators
    $this->loadDefaultDecorators();
    $this->getDecorator('Description')->setOption('escape', false);

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
            ->setDescription($description);
            
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesuserdocverification_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesuserdocverification.licensekey'),
    ));
    $this->getElement('sesuserdocverification_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if ($settings->getSetting('sesuserdocverification.pluginactivated')) {
  
      $this->addElement('Radio', 'sesuserdocverification_docutyperequried', array(
          'label' => 'Make Document Type Selection Mandatory',
          'description' => 'Do you want to make the selection of document type while uploading document mandatory?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesuserdocverification.docutyperequried', 0),
      ));

      $this->addElement('MultiCheckbox', 'sesuserdocverification_extension', array(
          'label' => 'Allow Extensions',
          'description' => 'Choose from below the extensions which you want to allow for documents being uploaded on your website for verification.',
          'multiOptions' => array(
              'PDF' => 'PDF',
              'PNG' => 'PNG',
              'JPG' => 'JPG',
              'JPEG' => 'JPEG',
              'DOCX' => 'DOCX',
              'XLSX' => 'XLSX',
              'PPTX' => 'PPTX',
          ),
          'value' => unserialize($settings->getSetting('sesuserdocverification.extension', 'a:7:{i:0;s:3:"PDF";i:1;s:3:"PNG";i:2;s:3:"JPG";i:3;s:4:"JPEG";i:4;s:4:"DOCX";i:5;s:4:"XLSX";i:6;s:4:"PPTX";}')),
      ));


      $description = "<div><span>" . Zend_Registry::get('Zend_Translate')->_('This plugin works with Auto-Approve Members setting available in SocialEngine core Signup Process such that if you disable this setting, then members will not be auto-approve and you can Verify & Enable their accounts at once from the <a href="admin/sesuserdocverification/manage" >Manage Documents</a> section of this plugin. To configure this setting, <a href="admin/user/signup/index/signup_id/1" >Click Here</a>.') . "</span></div>";
      //Add Element: Dummy
      $this->addElement('Dummy', 'sesuserdocverification_approve', array(
          'label' => 'Auto-Approve Members',
          'description' => $description,
      ));
      $this->sesuserdocverification_approve->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


      $this->addElement('Text', 'sesuserdocverification_doccount', array(
          'label' => 'Document Count',
          'description' => 'Enter the number of documents users can upload on your website. Enter 0 if you want users to upload unlimited documents.',
          'value' => $settings->getSetting('sesuserdocverification.doccount', 0),
      ));

      $this->addElement('Text', 'sesuserdocverification_maxsize', array(
          'label' => 'Maximum Upload Size',
          'description' => 'Enter the maximum upload size (in MB) of the document which users will be allowed to upload on your website. (This limit should be less than equal to the maximum file upload size in your php.ini file.)',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sesuserdocverification.maxsize', '25'),
      ));


      $this->addElement('Radio', 'sesuserdocverification_showpreview', array(
          'label' => 'Enable Document Preview',
          'description' => 'Do you want to allow users to see the preview of their documents they have submitted for verification in Manage Document section?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesuserdocverification.showpreview', 0),
      ));

      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
    } else {
      $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
      ));
    }
  }
}
