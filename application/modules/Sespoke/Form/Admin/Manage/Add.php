<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespoke_Form_Admin_Manage_Add extends Engine_Form {

  public function init() {

    $manageactionId = Zend_Controller_Front::getInstance()->getRequest()->getParam('manageaction_id', null);
    $manageActions = Engine_Api::_()->getItem('sespoke_manageaction', $manageactionId);

    $this->setTitle('Add New Action or Gift')
            ->setDescription('Below, you can add new Action (like Poke, Slap, Wink, etc.) or Gift (like Heart, Cake, Beer, Coffee, etc). You can also choose to show this action or gift to members of all or specific Member Levels.');

    if (!$manageactionId) {
      $this->addElement('Select', 'action', array(
          'label' => 'Action or Gift?',
          'description' => "Do you want to create Action or Gift?",
          'multiOptions' => array(
              'action' => 'Action',
              'gift' => 'Gift',
          ),
          'onchange' => 'checkAction(this.value)',
      ));
    }

    $this->addElement('Text', 'name', array(
        'label' => 'Action or Gift Name',
        'description' => 'Enter the name of the action or gift.',
        'allowEmpty' => FALSE,
        'validators' => array(
            array('NotEmpty', true),
        )
    ));

    $this->addElement('Text', 'verb', array(
        'label' => 'Action Verb',
        'description' => 'Enter the 3rd form of the verb for this action [This verb will be used in activity feed, notification.].',
    ));

    //Add Element: Add icon
    $this->addElement('File', 'icon', array(
        'label' => 'Action or Gift Icon',
        'description' => 'Upload an icon for action or gift. (The recommended dimension for the icon is - 16 x 16 pixels.)',
        'onchange' => 'showReadImage(this,"icon_preview")',
    ));
    $this->icon->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG');

    if (@$manageActions->icon) {
      $img_path = Engine_Api::_()->storage()->get($manageActions->icon, '')->getPhotoUrl();
      if (isset($img_path) && !empty($img_path)) {
        $this->addElement('Image', 'icon_preview', array(
            'label' => 'Icon Preview',
            'src' => $img_path,
            'width' => 16,
            'height' => 16,
        ));
      }
    } else {
      $this->addElement('Image', 'icon_preview', array(
          'label' => 'Icon Preview',
          'width' => 16,
          'height' => 16,
          'disable' => true
      ));
    }

    //Add Element: Add icon
    $this->addElement('File', 'image', array(
        'label' => 'Action or Gift Large Icon',
        'description' => 'Upload a large icon for action or gift. (The recommended dimension for the icon is - 200x200 pixels.) [This icon will show up in activity feeds. You can also upload a gif icon.]',
        'onchange' => 'showReadImage(this,"image_preview")',
    ));
    $this->icon->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG, gif');
    
    if (@$manageActions->image) {
      $img_path = Engine_Api::_()->storage()->get($manageActions->image, '')->getPhotoUrl();
      if (isset($img_path) && !empty($img_path)) {
        $this->addElement('Image', 'image_preview', array(
            'label' => 'Image Preview',
            'src' => $img_path,
            'max-width' => 200,
            'max-height' => 200,
        ));
      }
    } else {
      $this->addElement('Image', 'image_preview', array(
          'label' => 'Image Preview',
          'max-width' => 200,
          'max-height' => 200,
          'disable' => true
      ));
    }
    
    $levelOptions = array();
    $levelValues = array();
    foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
      if ($level->type != 'public') {
        $levelOptions[$level->level_id] = $level->getTitle();
        $levelValues[] = $level->level_id;
      }
    }

    // Select Member Levels
    $this->addElement('multiselect', 'member_levels', array(
        'label' => 'Member Levels',
        'multiOptions' => $levelOptions,
        'description' => 'Below choose Member Levels belonging to which members on your website would be able to take this action / send this gift.',
        'value' => $levelValues,
    ));

    $this->addElement('Checkbox', 'enable_activity', array(
        'description' => 'Enable Activity Feed?',
        'label' => 'Yes, enable activity feed for this action / gift',
        'value' => 1,
    ));

    $this->addElement('Checkbox', 'enabled', array(
        'description' => 'Enable This Action / Gift?',
        'label' => 'Yes, enable this action / gift now.',
        'value' => 1,
    ));

    $this->addElement('Checkbox', 'enabled_gutter', array(
        'description' => 'Enable in Profile Options?',
        'label' => 'Yes, enable this action / gift in the Profile Options widget on Member Profile page.',
        'value' => 1,
    ));

    $this->addElement('Button', 'execute', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'prependText' => ' or ',
        'ignore' => true,
        'link' => true,
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
        'decorators' => array('ViewHelper'),
    ));
  }

}
