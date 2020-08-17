<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesautoaction_Form_Admin_Edit extends Engine_Form {

  public function init() {

    $this->setTitle('Edit This Auto Action')->setAttrib('id', 'form-auto-action');
    $this->setMethod('post');

    $resource_type = Zend_Controller_Front::getInstance()->getRequest()->getParam('resource_type', 0);

    $availableTypes = Engine_Api::_()->getApi('search', 'core')->getAvailableTypes();

    $options = array('' => '');
    foreach ($availableTypes as $type) {
        $options[$type] = strtoupper('ITEM_TYPE_' . $type);
    }

    $this->addElement('Select', "resource_type", array(
        'label' => 'Choose Plugin',
        'multiOptions' => $options,
        //'allowEmpty' => false,
        //'required' => true,
        'disable' => true,
        'onchange' => 'getAllContent(this.value);showAllAction(this.value);'
    ));


    $this->addElement('Multiselect', 'resource_id', array(
        'label' => "Select Content",
        'allowEmpty' => true,
        'required' => false,
        'disable' => true,
        'registerInArrayValidator' => false,
    ));


    $this->addElement('Radio', 'newsignup', array(
      'label' => 'New Signup Member',
      'description' => 'Do you want auto action perform on selected content when new member signup on your website?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'onclick' => 'newsignup(this.value);',
      'value' => '0',

    ));

    $levelOptions = array();
    foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
        $levelOptions[$level->level_id] = $level->getTitle();
    }
    unset($levelOptions['5']);
    unset($levelOptions['1']);
    unset($levelOptions['2']);
    unset($levelOptions['3']);

    $this->addElement('Multiselect', 'member_levels', array(
        'label' => 'Member Level',
        'description' => 'Choose the member levels. (Ctrl + Click to select multiple member levels.)',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions' => $levelOptions,
        'value' => '',
    ));



    $this->addElement('Select', 'likeaction', array(
      'label' => 'Auto Like',
      'description' => 'Do you want auto like selected content?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '1',
    ));

    $this->addElement('Select', 'commentaction', array(
      'label' => 'Auto Comment',
      'description' => 'Do you want auto comment selected content?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '0',
    ));

    $this->addElement('Select', 'friend', array(
      'label' => 'Auto Friend',
      'description' => 'Do you want auto friend of selected content?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '0',
    ));

    $this->addElement('Select', 'join', array(
      'label' => 'Auto Join',
      'description' => 'Do you want auto join of selected content?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '0',
    ));

    $this->addElement('Select', 'favourite', array(
      'label' => 'Auto Favourite',
      'description' => 'Do you want auto favourite of selected content?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '0',
    ));

    $this->addElement('Select', 'follow', array(
      'label' => 'Auto Follow',
      'description' => 'Do you want auto follow of selected content?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '0',
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }
}
