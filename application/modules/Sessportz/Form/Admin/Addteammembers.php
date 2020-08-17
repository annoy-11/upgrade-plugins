<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Addteammembers.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sessportz_Form_Admin_Addteammembers extends Engine_Form {

  public function init() {

    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
    $this->setTitle('Add New Team')
            ->setMethod('POST');

    $this->addElement('Text', "name", array(
        'label' => 'Team Name',
        'description' => "Enter the name of team.",
        'allowEmpty' => false,
        'required' => true,
    ));

    $this->addElement('File', 'photo_id', array(
        'label' => 'Team Photo',
        'description' => "Choose a team photo for the team member.",
    ));
    $this->photo_id->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG');
    $team_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('team_id', null);
    $team = Engine_Api::_()->getItem('sessportz_teams', $team_id);
    $photo_id = 0;
    if (isset($team->photo_id))
      $photo_id = $team->photo_id;
    if ($photo_id && $team) {
      $path = Engine_Api::_()->storage()->get($photo_id, '')->getPhotoUrl();
      if (!empty($path)) {
        $this->addElement('Image', 'profile_photo_preview', array(
            'label' => 'Team Photo Preview',
            'src' => $path,
            'width' => 100,
            'height' => 100,
        ));
      }
    }
    if ($photo_id) {
      $this->addElement('Checkbox', 'remove_profilecover', array(
          'label' => 'Yes, remove profile photo.'
      ));
    }

    $this->addElement('Text', "wins", array(
        'label' => 'Wins',
        'description' => "Enter Wins.",
    ));

    $this->addElement('Text', "draw", array(
        'label' => 'Draw',
        'description' => "Enter Draw.",
    ));

    $this->addElement('Text', "loss", array(
        'label' => 'Loss',
        'description' => "Enter Loss.",
    ));

    $this->addElement('Text', "points", array(
        'label' => 'Points',
        'description' => "Enter Points.",
    ));

    //Add Element: Submit
    $this->addElement('Button', 'button', array(
        'label' => 'Add',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    // Element: cancel
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sessportz', 'controller' => 'manage', 'action' => 'index'), 'admin_default', true),
        'onclick' => '',
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('button', 'cancel'), 'buttons');
  }
}
