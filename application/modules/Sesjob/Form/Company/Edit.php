<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Form_Company_Edit extends Engine_Form {

  public function init() {

    $translate = Zend_Registry::get('Zend_Translate');

    $this->setTitle('Edit Company Entry')
      ->setDescription('Edit company entry below, then click "Save Changes".')->setAttrib('name', 'sescompany_edit');

    $user = Engine_Api::_()->user()->getViewer();
    $user_level = Engine_Api::_()->user()->getViewer()->level_id;

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.company', 1)) {

        $this->addElement('Text', 'company_name', array(
            'label' => 'Company Name',
            'allowEmpty' => false,
            'required' => true,
        ));

        $this->addElement('Text', 'company_websiteurl', array(
            'label' => 'Company Website URL',
            'allowEmpty' => false,
            'required' => true,
        ));

        $this->addElement('Textarea', 'company_description', array(
            'label' => 'Company Description',
            'allowEmpty' => false,
            'required' => true,
        ));

        $industries = Engine_Api::_()->getDbTable('industries', 'sesjob')->getIndustriesAssoc();
        if(count($industries) > 0) {
            $industries = array('' => '') + $industries;
            $this->addElement('Select', 'industry_id', array(
                'label' => 'Industry',
                'multiOptions' => $industries,
                'allowEmpty' => false,
                'required' => true,
            ));
        }
    }

    $this->addElement('File', 'photo', array(
      'label' => 'Choose Company Cover Photo',
    ));
    $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Chanegs',
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
