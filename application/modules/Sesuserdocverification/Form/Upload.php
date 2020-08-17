<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Upload.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesuserdocverification_Form_Upload extends Engine_Form {

  public function init() {

    $this->setTitle('Upload document for verification');

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesuserdocverification.docutyperequried', 0)) {
      $allowEmpty = false;
      $required = true;
    } else {
      $allowEmpty = true;
      $required = false;
    }

    $documentTypes = Engine_Api::_()->getDbtable('documenttypes', 'sesuserdocverification')->getAllDocumentTypes();
    if( count($documentTypes) > 1) {
      $this->addElement('Select', 'documenttype_id', array(
        'label' => 'Document Type',
        'description' => 'Select the type of document which you want to upload for verification. You will have to submit the document for verification after uploading.',
        'multiOptions' => $documentTypes,
        'allowEmpty' => $allowEmpty,
        'required' => $required,
      ));
    }

    $document_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('document_id', 0);
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesuserdocverification.requried', 0)) {
      if($document_id) {
        $allowEmpty = true;
        $required = false;
      } else {
        $allowEmpty = false;
        $required = true;
      }
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
      'description' => 'Upload your document for verification. (only '.strtolower(implode(", ",$finalEx)).' extensions are allowed. Size allowed: '.$sizes.')',
      'allowEmpty' => $allowEmpty,
      'required' => $required,
    ));
    $this->file->addValidator('Extension', false, $string)->addValidator(new Zend_Validate_File_FilesSize(array('max' => $size)));

    $this->addElement('Button', 'submit', array(
        'label' => 'Upload',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'onclick' => 'javascript:parent.Smoothbox.close()',
        'link' => true,
        'prependText' => ' or ',
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        ),
    ));
  }
}
