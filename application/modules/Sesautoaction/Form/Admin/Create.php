<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesautoaction_Form_Admin_Create extends Engine_Form {

  public function init() {

    $this->setTitle('Create New Auto Action for New Signup Members')->setAttrib('id', 'form-auto-action');
    $this->setMethod('post');

    $availableTypes = Engine_Api::_()->getApi('search', 'core')->getAvailableTypes();

    $getResults = Engine_Api::_()->getDbTable('integrateothersmodules', 'sesautoaction')->getResults(array('enabled' => 1));

    $intArray = array();
    foreach($getResults as $getResult) {
        $intArray[] = $getResult['content_type'];
    }

    $final_array = array_intersect($availableTypes,$intArray);

    $options = array('' => '');
    foreach ($final_array as $type) {
        $options[$type] = strtoupper('ITEM_TYPE_' . $type);
    }

    $this->addElement('Select', "resource_type", array(
        'label' => 'Choose Module',
		'description' => 'Below, select a module in which you want newly signed up members to perform actions. (Note: You will only see those modules which have some content in them. If there is no content, then the module will not come in the drop-down below. To get started, create content to select modules.) [Also, if you see module, but not the content dropdown, then you may have created actions for all existing content and now you need to add more content in the module to get started.]',
        'multiOptions' => $options,
        'allowEmpty' => false,
        'required' => true,
        'onchange' => 'getAllContent(this.value);showAllAction(this.value);'
    ));

    $this->addElement('Multiselect', 'resource_id', array(
        'label' => "Choose Content",
		'description' => 'Below, choose the content on which you want the newly signed up members to perform actions.',
        'allowEmpty' => true,
        'required' => false,
        'registerInArrayValidator' => false,
    ));


    $this->addElement('Radio', 'newsignup', array(
      'label' => 'Newly Signup Member',
      'description' => 'Do you want auto action perform on selected content when new member signup on your website?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'onclick' => 'newsignup(this.value);',
      'value' => '1',

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
        'description' => 'Choose the member levels belonging to which new signed up members will perform actions on your website. (Ctrl + Click to select multiple member levels.)',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions' => $levelOptions,
        'value' => '',
    ));

    $this->addElement('Select', 'likeaction', array(
      'label' => 'Auto Like',
      'description' => 'Do you want new signed up members to auto Like the above selected content?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '1',
    ));

    $this->addElement('Select', 'commentaction', array(
      'label' => 'Auto Comment',
      'description' => 'Do you want new signed up members to auto Comment the above selected content? You can add comments which will be randomly posted from the "Manage Comments" section of this plugin.',
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
      'description' => 'Do you want new signed up members to auto Join the above selected content?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '0',
    ));

    $this->addElement('Select', 'favourite', array(
      'label' => 'Auto Favourite',
      'description' => 'Do you want new signed up members to auto Favourite the above selected content?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '0',
    ));

    $this->addElement('Select', 'follow', array(
      'label' => 'Auto Follow',
      'description' => 'Do you want new signed up members to auto Follow the above selected content?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '0',
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Create',
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
