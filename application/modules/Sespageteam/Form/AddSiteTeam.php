<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageteam
 * @package    Sespageteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AddSiteTeam.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespageteam_Form_AddSiteTeam extends Engine_Form {

  public function init() {

    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
    $team_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('team_id');
    
    $page_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('page_id');
    
    $this
            ->setMethod('POST')
            ->setAttrib('name', 'sespageteam_addteam')
            ->setAttrib('class', 'sespageteam_formcheck global_form');

    if ($type == 'nonsitemember') {
      $this->addElement('Text', "name", array(
          'label' => 'Team Member',
          'description' => "Enter the name of member to be added as team member to your website.",
          'allowEmpty' => false,
          'required' => true,
      ));
    } else {
      $this->addElement('Text', "name", array(
          'label' => 'Team Member',
          'description' => "Enter the name of member on your website who you want to add as your Team Member in the auto-suggest below.",
          'allowEmpty' => false,
          'required' => true,
      ));
      $this->addElement('Hidden', 'user_id', array());
    }

    if ($type == 'nonsitemember') {
      $this->addElement('File', 'photo_id', array(
          'label' => 'Profile Photo',
          'description' => "Choose a profile photo for the team member.",
      ));
      $this->photo_id->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG');
      $team_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('team_id', null);
      $team = Engine_Api::_()->getItem('sespageteam_team', $team_id);
      $photo_id = 0;
      if (isset($team->photo_id))
        $photo_id = $team->photo_id;
      if ($photo_id && $team) {
        $path = Engine_Api::_()->storage()->get($photo_id, '')->getPhotoUrl();
        if (!empty($path)) {
          $this->addElement('Image', 'profile_photo_preview', array(
              'label' => 'Profile Photo Preview',
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
    }
    
    $designations = Engine_Api::_()->getDbtable('designations', 'sespageteam')->getDesignations();

    $allPageDesignations = Engine_Api::_()->getDbtable('designations', 'sespageteam')->getAllDesignations(array('page_id' => $page_id));
    if(count($allPageDesignations) > 0) {
      foreach ($allPageDesignations as $designation) {
        $designations[$designation['designation_id']] = $designation['designation'];
      }
    }
    
    $this->addElement('Select', 'designation_id', array(
        'label' => 'Designation',
        'description' => "Choose the designation of the team member.",
        'required' => true,
        'multiOptions' => $designations,
    ));

    $this->addElement('Textarea', "description", array(
        'label' => 'Short Description',
        'description' => "Enter short description about the team member. [The description should be of 300 characters only. This description would be shown on the Team Page.]",
        'maxlength' => '300',
        'filters' => array(
            'StripTags',
            new Engine_Filter_Censor(),
            new Engine_Filter_StringLength(array('max' => '300')),
            new Engine_Filter_EnableLinks(),
        ),
    ));

    //UPLOAD PHOTO URL
    $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'manage', 'action' => "upload-image"), 'admin_default', true);

    $allowed_html = 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr';
    $editorOptions = array(
        'upload_url' => $upload_url,
        'html' => (bool) $allowed_html,
    );
    if (!empty($upload_url)) {
      $editorOptions['plugins'] = array(
          'table', 'fullscreen', 'media', 'preview', 'paste',
          'code', 'image', 'textcolor', 'jbimages', 'link'
      );
      $editorOptions['toolbar1'] = array(
          'undo', 'redo', 'removeformat', 'pastetext', '|', 'code',
          'media', 'image', 'jbimages', 'link', 'fullscreen',
          'preview'
      );
    }

    $this->addElement('TinyMce', 'detail_description', array(
        'label' => 'Detailed Description',
        'description' => 'Enter detailed description about the team member. [This description would be shown on the Member Profile page.]',
        'editorOptions' => $editorOptions,
    ));

    $this->addElement('Text', "email", array(
        'label' => 'Email',
        'description' => "Enter email address of the team member which will be displayed on the team page.",
    ));

    $this->addElement('Text', "location", array(
        'label' => 'Location',
        'description' => "Enter location of the team member from the auto-suggest below. [When clicked location will open in Google Map.]",
    ));

    $this->addElement('Text', "phone", array(
        'label' => 'Phone',
        'description' => "Enter phone number of the team member.",
    ));

    $this->addElement('Text', "website", array(
        'label' => 'Website',
        'description' => "Enter website of the team member.",
    ));

    $this->addElement('Text', "facebook", array(
        'label' => 'Facebook URL',
        'description' => "Enter URL of the Facebook Profile or Page of the team member.",
    ));

    $this->addElement('Text', "twitter", array(
        'label' => 'Twitter URL',
        'description' => "Enter URL of the Twitter Profile of the team member.",
    ));

    $this->addElement('Text', "linkdin", array(
        'label' => 'LinkedIn URL',
        'description' => "Enter URL of the LinkedIn Profile of the team member.",
    ));

    $this->addElement('Text', "googleplus", array(
        'label' => 'Google Plus URL',
        'description' => "Enter URL of the Google Plus Profile of the team member.",
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Save',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'Cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onclick' => 'javascript:sessmoothboxclose();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');
  }

}
