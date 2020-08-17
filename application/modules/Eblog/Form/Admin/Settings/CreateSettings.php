<?php
/**
* SocialEngineSolutions
*
* @category   Application_Eblog
* @package    Eblog
* @copyright  Copyright 2019-2020 SocialEngineSolutions
* @license    http://www.socialenginesolutions.com/license/
* @version    $Id:BlogCreateSettings.php 2019-08-20 00:00:00 SocialEngineSolutions $
* @author     SocialEngineSolutions
*/

class Eblog_Form_Admin_Settings_CreateSettings extends Engine_Form {

  public function init() {
  
    $settings = Engine_Api::_()->getApi('settings', 'core');
    
    $this->setTitle('Blog Creation Settings')
          ->setDescription('Here, you can choose the settings which are related to the creation of blogs on your website. The settings enabled or disabled will effect Blog creation page, popup and Edit pages.');

    $this->addElement('Radio', 'eblog_page_pop', array(
      'label' => 'Page or Popup for "Create New Blog".',
      'description' => 'Do you want to open the ‘Create New Blog’ Form in popup or in a Page, when they click on the ‘Create New Blog’ Link available in the Main Navigation Menu of this plugin?',
      'multiOptions' => array('1' => "Open Create Blog Form in 'popup'", '0' => "Open Create Blog Form in 'page'"),
      'value' => $settings->getSetting('eblog.page.pop', 0),
    ));
    
    $this->addElement('Radio', 'eblog_redirect_creation', array(
      'label' => 'Redirection After Blog Creation',
      'description' => 'Choose from below where do you want to redirect users after a blog is successfully created.',
      'multiOptions' => array('1' => 'On Blog Dashboard Page', '0' => 'On Blog Profile Page'),
      'value' => $settings->getSetting('eblog.redirect.creation', 0),
    ));

    $this->addElement('Radio', 'eblogcre_creblog_type', array(
      'label' => 'Create Blog Form Type',
      'description' => "What type of Form you want to show on Create New Blog and Dashboard?",
      'multiOptions' => array(
        1 => "Default SE Form",
        0 => "Designed Form",
      ),
      'value' => $settings->getSetting('eblogcre.creblog.type', 1),
    ));

    $this->addElement('Radio', 'eblog_readtime', array(
      'label' => 'Blog Read Time',
      'description' => 'Do you want to allow users to create and view blog estimated Reading Time.',
      'multiOptions' => array(
        1 => "Yes",
        0 => "No",
      ),
      'onchange' => 'changereadtime();',
      'value' => $settings->getSetting('eblog.readtime', 1),
    ));
    
    $this->addElement('Radio', 'eblog_man_readtime', array(
      'label' => 'Blog Read Time Mandatory',
      'description' => 'Do you want to mandatory Reading Time.',
      'multiOptions' => array(
        1 => "Yes",
        0 => "No",
      ),
      'value' => $settings->getSetting('eblog.man.readtime', 1),
    ));
    
    $this->addElement('MultiCheckbox', 'eblog_photouploadoptions', array(
      'label' => 'Photo Upload options',
      'description' => 'Choose options for Blog Image which will be available to the users while creating or editing their Blogs.',
      'multiOptions' => array(
        'dragdrop' => "Drag & Drop",
        'multiupload' => "Multi Upload",
        'fromurl' => "From URL",
      ),
      'value' => unserialize($settings->getSetting('eblog.photouploadoptions', '')),
    ));

    $this->addElement('Select', 'eblog_autoopenpopup', array(
      'label' => 'Auto-Open Advanced Share Popup',
      'description' => 'Do you want the "Advanced Share Popup" to be auto-populated after the blog is created? [Note: This setting will only work if you have placed Advanced Share widget on Blog View or Blog Dashboard, wherever user is redirected just after Blog creation.]',
      //  'class'=>'select2',
      'multiOptions' => array(
        1 => "Yes",
        0 => "No",
      ),
      'value' => $settings->getSetting('eblog.autoopenpopup', 1),
    ));

    $this->addElement('Radio', 'eblogcre_ecust_url', array(
      'label' => 'Edit Custom URL',
      'description' => 'Do you want to allow users to edit the custom URL of their blogs once the blogs are created? If you choose Yes, then the URL can be edited from the dashboard of blog?',
      'multiOptions' => array(
        1 => "Yes",
        0 => "No",
      ),
      'value' => $settings->getSetting('eblogcre.ecust.url', 1),
    ));

    $this->addElement('Radio', 'eblogcre_enable_tags', array(
      'label' => 'Enable Tags',
      'description' => 'Do you want to enable tags for the Blogs on your website?',
      'multiOptions' => array(
        1 => "Yes",
        0 => "No",
      ),
      'value' => $settings->getSetting('eblogcre.enable.tags', 1),
    ));

    $this->addElement('Radio', 'eblog_start_date', array(
      'label' => 'Enable Custom Blog Publish Date',
      'description' => 'Do you want to allow users to choose a custom publish date for their blogs. If you choose Yes, then blogs on your website will display in activity feeds, various pages and widgets on their publish dates.',
      'multiOptions' => array(
        1 => 'Yes',
        0 => 'No',
      ),
      'value' => $settings->getSetting('eblog.start.date', 1),
    ));

    $this->addElement('Radio', 'eblogcre_enb_category', array(
      'label' => 'Enable Blog Category',
      'description' => 'Do you want to enable categories for the blogs at the time of creation?',
      'onchange' => 'changeenablecategory();',
      'multiOptions' => array(
        1 => "Yes",
        0 => "No",
      ),
      'value' => $settings->getSetting('eblogcre.enb.category', 1),
    ));

    $this->addElement('Radio', 'eblogcre_cat_req', array(
      'label' => 'Make Blog Categories Mandatory',
      'description' => 'Do you want to make Category field mandatory when users create or edit their Blogs?',
      'multiOptions' => array(
        1 => "Yes",
        0 => "No",
      ),
      'value' => $settings->getSetting('eblogcre.cat.req', 1),
    ));

    $this->addElement('Radio', 'eblog_cre_photo', array(
      'label' => 'Enable Blog Main Photo',
      'description' => 'Do you want to enable Blog Main Photo on your website?',
      'onchange' => 'changeenablephoto();',
      'multiOptions' => array(
        1 => "Yes",
        0 => "No",
      ),
      'value' => $settings->getSetting('eblog.cre.photo', 1),
    ));

    $this->addElement('Radio', 'eblog_photo_mandatory', array(
      'label' => 'Make Blogs Main Photo Mandatory',
      'description' => 'Do you want to make Main Photo field mandatory when users create or edit their Blogs?',
      'multiOptions' => array(
        1 => "Yes",
        0 => "No",
      ),
      'value' => $settings->getSetting('eblog.photo.mandatory', 1),
    ));

    $this->addElement('Radio', 'eblogcre_enb_des', array(
      'label' => 'Enable Blog Description',
      'description' => 'Do you want to enable description of Blogs on your website?',
      'onchange' => 'changeenabledescriptition();',
      'multiOptions' => array(
        1 => "Yes",
        0 => "No",
      ),
      'value' => $settings->getSetting('eblogcre.enb.des', 1),
    ));

    $this->addElement('Radio', 'eblogcre_des_req', array(
      'label' => 'Make Blog Description Mandatory',
      'description' => 'Do you want to make Description field mandatory when users create or    
      edit their Blogs?',
      'multiOptions' => array(
        1 => "Yes",
        0 => "No",
      ),
      'value' => $settings->getSetting('eblogcre.des.req', 1),
    ));

    $this->addElement('Radio', 'eblogcre_people_search', array(
      'label' => 'Enable “People can search for this Blog” Field.',
      'description' => 'Do you want to enable “People can search for this Blog” field while creating and editing Blogs on your website?',
      'multiOptions' => array(
        1 => "Yes",
        0 => "No",
      ),
      'value' => $settings->getSetting('eblogcre.people.search', 1),
    ));

    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true
    ));
  }
}
