<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Apply.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Form_Company_Apply extends Engine_Form {

  public function init() {

    $translate = Zend_Registry::get('Zend_Translate');

    $this->setTitle('Apply to this Job');

    $user = Engine_Api::_()->user()->getViewer();
    $user_id = $user->getIdentity();

    $name = $email = $mobile_number = $location = '';
    if(!empty($user_id)) {
        $name = $user->getTitle();
        $email = $user->email;
    }

    $this->addElement('Text', 'name', array(
        'label' => 'Name',
        'allowEmpty' => false,
        'required' => true,
        'value' => $name,
    ));

    $this->addElement('Text', 'email', array(
        'label' => 'Email',
        'allowEmpty' => false,
        'required' => true,
        'value' => $email,
    ));

    $this->addElement('Text', 'mobile_number', array(
        'label' => 'Mobile Number',
        'allowEmpty' => false,
        'required' => true,
    ));

    $this->addElement('Text', 'location', array(
        'label' => 'Current Location',
        'allowEmpty' => false,
        'required' => true,
    ));

    $this->addElement('File', 'photo', array(
        'label' => 'Upload Resume',
        'description' => 'You can choose documents. [DEFAULT ALLOWED EXTENSIONS: pdf, txt, ps, rtf, epub, odt, odp, ods, odg, odf, sxw, sxc, sxi, sxd, doc, ppt, pps, xls, docx, pptx, ppsx, xlsx, tif, tiff, jpg, jpeg, png, gif.]',
        'allowEmpty' => false,
        'required' => true,
    ));
    $this->photo->addValidator('Extension', false, 'pdf, txt, ps, rtf, epub, odt, odp, ods, odg, odf, sxw, sxc, sxi, sxd, doc, ppt, pps, xls, docx, pptx, ppsx, xlsx, tif, tiff, jpg, jpeg, png, gif, text');

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Apply',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));
    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onclick' => 'parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');
  }
}
