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

class Sesuserdocverification_Form_Signup_Documentverification extends Engine_Form {

  public function init() {

    $this->setAttrib('enctype', 'multipart/form-data')->setTitle('Upload document for verification');

    $this->setAttrib('id', 'SignupFormDocumentVerification');

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesuserdocverification.docutyperequried', 0)) {
      $allowEmpty = false;
      $required = true;
    } else {
      $allowEmpty = true;
      $required = false;
    }

    $documentTypes = Engine_Api::_()->getDbtable('documenttypes', 'sesuserdocverification')->getAllDocumentTypes();
    if( count($documentTypes) > 1 ) {
      $this->addElement('Select', 'documenttype_id', array(
        'label' => 'Document Type',
        'description' => 'Select the type of document which you want to upload for verification.',
        'multiOptions' => $documentTypes,
        'allowEmpty' => $allowEmpty,
        'required' => $required,
      ));
    }

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesuserdocverification.requried', 0)) {
      $allowEmpty = false;
      $required = true;
    } else {
      $allowEmpty = true;
      $required = false;
    }

    $extensions = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesuserdocverification.extension', 'a:7:{i:0;s:3:"PDF";i:1;s:3:"PNG";i:2;s:3:"JPG";i:3;s:4:"JPEG";i:4;s:4:"DOCX";i:5;s:4:"XLSX";i:6;s:4:"PPTX";}'));

    $string = implode(", ",$extensions) . ', '. strtolower(implode(", ",$extensions));
    $finalEx = array();
    foreach($extensions as $extension) {
        $finalEx[] = '.'.$extension;
    }

    $size = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesuserdocverification.maxsize', '25');
    $size = $size * 1048576;
    $sizes = array(' B', ' kB', ' MB', ' GB', ' TB', ' PB', ' EB', ' ZB', ' YB');
    for ($i=0; $size >= 1024 && $i < 9; $i++) {
        $sizess /= 1024;
    }
    $sizes = round($sizess, 2) . $sizes[$i];

    $this->addElement('File', 'file', array(
        'label' => "Upload Document",
        'description' => 'Upload your document for verification. (only '.strtolower(implode(", ",$finalEx)).' extensions are allowed. Size allowed: '.$sizes.')',
        'allowEmpty' => $allowEmpty,
        'required' => $required,
    ));
    $this->file->addValidator('Extension', false, $string)->addValidator(new Zend_Validate_File_FilesSize(array('max' => $size)));

    $this->addElement('Hash', 'token');

    $this->addElement('Hidden', 'nextStep', array(
      'order' => 3
    ));

    $this->addElement('Hidden', 'skip', array(
     'order' => 4
    ));

    $this->addElement('Button', 'done', array(
      'label' => 'Upload Document',
      'type' => 'submit',
      'onclick' => 'javascript:finishForm();',
      'decorators' => array(
        'ViewHelper',
      ),
    ));

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesuserdocverification.requried', 0) == 0) {
    $this->addElement('Cancel', 'skip-link', array(
      'label' => 'skip',
      'prependText' => ' or ',
      'link' => true,
      'href' => 'javascript:void(0);',
      'onclick' => 'skipForm(); return false;',
      'decorators' => array(
        'ViewHelper',
      ),
    ));
    }
  }
}
