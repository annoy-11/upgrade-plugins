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

class Sesuserdocverification_Form_Admin_Signup_Documentverification extends Engine_Form {

  public function init() {

    $this->setAttrib('enctype', 'multipart/form-data');

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $step_table = Engine_Api::_()->getDbtable('signup', 'user');
    $step_row = $step_table->fetchRow($step_table->select()->where('class = ?', 'Sesuserdocverification_Plugin_Signup_Documentverification'));
    $count = $step_row->order;
    $title = $this->getView()->translate('Step %d: Upload Verification Document (SES - Member Verification via KYC Documents Plugin)', $count);
    $this->setTitle($title)->setDisableTranslator(true);

    $enable = new Engine_Form_Element_Radio('enable');
    $enable->setLabel("Document Verification");
    $enable->setDescription("Do you want members to upload document during the signup process? (They will be able to upload Document.)");
    $enable->addMultiOptions(
      array(
        1 => 'Yes, include the "Document Verification" step during signup.',
        0 => 'No, do not include this step.'
    ));
    $enable->setValue($step_row->enable);

    $this->addElements(array($enable));


    $this->addElement('Radio', 'sesuserdocverification_requried', array(
        'label' => 'Require Document for Verification',
        'description' => 'Do you want to require your users to upload a document for verification upon signup?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sesuserdocverification.requried', 0),
    ));


    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
    ));
  }
}
