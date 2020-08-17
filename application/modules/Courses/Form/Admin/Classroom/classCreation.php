<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: classCreation.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Form_Admin_Classroom_classCreation extends Engine_Form {
  public function init() {
        $settings = Engine_Api::_()->getApi('settings', 'core');
        $this->setTitle('Classroom Creation Settings')
                ->setDescription('Here, you can choose the settings which are related to the creation of Classroom on your website. The settings enabled or disabled will affect Classroom creation page, pop-up and edit classroom.');
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $this->addElement('Radio', 'eclassroom_open_smoothbox', array(
          'label' => 'Page or Pop-up for "Create New Classroom"',
          'description'=>'Do you want to open the "Create New Classroom" Form in popup or in a Page, when they click on the "Create New Classroom" Link available in the Main Navigation Menu of this Plugin?.',
          'multiOptions' => array('1' => "Open Create Classroom Form in 'popup'",'0' => "Open Create Classroom Form in 'page'"),
          'value' => $settings->getSetting('eclassroom.open.smoothbox', '0'),
        ));
        $this->addElement('Radio', 'eclassroom_enable_addclassshortcut', array(
          'label' => 'Show "Create New Classroom" Icon',
          'description' => 'Do you want to show "Create New Classroom" icon in the bottom right side of all pages of this Plugin?',
          'multiOptions' => array(1 => 'Yes',0 => 'No'),
          'value' => $settings->getSetting('eclassroom.enable.addclassshortcut', 1),
          'onclick' => 'showQuickOption(this.value)',
        ));
        $this->addElement('Radio', 'eclassroom_icon_open_smoothbox', array(
          'label' => 'Page or Popup From Create Icon',
          'description' => 'Do you want to open the \'Create New Classroom\' form in popup or page, when users click on the \'Create New Classroom Icon\' in the bottom right side of all pages of this plugin?',
          'multiOptions' => array(
              '1' => "Open 'Create Classroom Form' in 'popup'",
              '0' => "Open 'Create Classroom Form' in 'page'",
          ),
          'value' => $settings->getSetting('eclassroom.icon.open.smoothbox', 0),
        ));
        $this->addElement('Radio', 'eclassroom_category_selection', array(
          'label' => 'Choose Category Before Creating Classroom',
          'description' => 'Do you want to show the Category Selection Form as the first step, when user creates a Classroom. If Yes, then users will be moved to Classroom Create Form only after selecting the category. If No, then user will be directly moved to Classroom Create Form',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.category.selection', 1),
          'onclick' => 'showCategoryIcon(this.value)',
        ));
        $this->addElement('Radio', 'eclassroom_category_icon', array(
          'label' => 'Category Photo Display',
          'description' => 'Choose from the below the which photo of categories do you display with category names. You can upload and esti these photos from the "Categories & Profile Fields" section of this plugin',
          'multiOptions' => array('0' => "Icon",'1' => "Colored Icon",'2' => "Thumbnail"),
          'value' => $settings->getSetting('eclassroom.category.icon', 1),
        ));
        $this->addElement('Radio', 'eclassroom_quick_create', array(
          'label' => 'Create Classroom from Categories Only',
          'description' => 'Do you want the Classroom to be created by filling the details in the category boxes? This will enable quick creation of Classroom on your website.',
          'multiOptions' => array('1' => 'Yes','0' => 'No',),
          'value' => $settings->getSetting('eclassroom.quick.create', 1),
        ));
        $this->addElement('Radio', 'eclassroom_redirect', array(
          'label' => 'Redirection After Classroom Creation',
          'description'=>'Choose from below where you want to redirect users after a Classroom is successfully created.',
          'multiOptions' => array('1' => 'On Classroom Profile page','0' => 'Classroom Dashboard'),
          'value' => $settings->getSetting('eclassroom.redirect', 1),
        ));
        $this->addElement('Radio', 'eclassroom_create_form', array(
          'label' => 'Create Classroom Form Type',
          'description' => 'What type of Form you want to show on Create New Classroom and Dashboard?',
          'multiOptions' => array('1' => 'Designed Form','0' => 'Default SE Form',
          ),
          'value' => $settings->getSetting('eclassroom.create.form', 1),
        ));
        $this->addElement('Radio', 'eclassroom_autoopenpopup', array(
          'label' => 'Auto-Open Advanced Share Popup',
          'description' => 'Do you want the "Advanced Share Popup" to be auto-populated after the Classroom is created? [Note: This setting will only work if you have placed Advanced Share widget on Classroom View or Classroom Dashboard, wherever user is redirected just after Classroom creation.]',
          'multiOptions' => array('1' => 'Yes','0' => 'No',
          ),
          'value' => $settings->getSetting('eclassroom.autoopenpopup', 1),
        ));
        $this->addElement('Radio', 'eclassroom_edit_url', array(
          'label' => 'Edit Custom URL',
          'description' => 'Do you want to allow users to edit the custom URL of their Classroom once the Classroom are created? If you choose Yes, then the URL can be edited from the dashboard of Classroom?.',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.edit.url', 1),
        ));
        $this->addElement('Radio', 'eclassroom_enable_category', array(
          'label' => 'Enable Classroom categories',
          'description' => 'Do you want to enable categories of Classroom on your website?',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.enable.category', 1),
          'onclick' => 'showClassroomCategory(this.value);',
        ));
        $this->addElement('Radio', 'eclassroom_category_mandatory', array(
          'label' => 'Make Classroom Categories Mandatory',
          'description' => 'Do you want to make Category field mandatory when users create or edit their Classrooms?',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.category.mandatory', 0),
        ));
        $this->addElement('Radio', 'eclassroom_enable_description', array(
          'label' => 'Enable Classroom Description',
          'description' => 'Do you want to enable description of Classroom on your website?',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.enable.description', 1),
          'onclick' => 'showClassroomDescription(this.value);',
        ));
        $this->addElement('Radio', 'eclassroom_description_required', array(
          'label' => 'Make Classroom Description Mandatory',
          'description' => 'Do you want to enable “People can search for this Classroom” field while creating and editing Classroom on your website?',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.description.required', 1),
        ));
        $this->addElement('Radio', 'eclassroom_enable_mainphoto', array(
          'label' => 'Enable Classroom Main Photo',
          'description' => 'Do you want to enable Classroom Main photo on your website?',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.enable.mainphoto', 1),
          'onclick' => 'showClassroomPhoto(this.value);',
        ));
        $this->addElement('Radio', 'eclassroom_classmainphoto', array(
          'label' => 'Classroom  Main Photo Mandatory',
          'description' => 'Do you want to make Classroom Main Photo field mandatory when users create or edit their Classroom?',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.classmainphoto', 1),
        ));
        $this->addElement('Radio', 'eclassroom_classtags', array(
          'label' => 'Enable Tags',
          'description' => 'Do you want to enable tags for the Classroom on your website?',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.classtags', 1),
        ));
        $this->addElement('Radio', 'eclassroom_allow_join', array(
          'label' => 'Enable Classroom Joining',
          'description' => 'Do you want to enable joining of Classroom on your website? If you choose Yes, then other members will be able to join Classroom and become members of Classroom on your website.',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.allow.join', 1),
          'onclick' => 'showClassroomOwnerJoin(this.value);',
        ));
        $this->addElement('Radio', 'eclassroom_auto_join', array(
          'label' => 'Auto-Join Classroom',
          'description' => 'Do you want owners of Classrooms to automatically join Classrooms after their creation on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('eclassroom.auto.join', 1),
        ));
        $this->addElement('Radio', 'eclassroom_allow_owner_join', array(
          'label' => 'Allow Owners to Enable Joining',
          'description' => 'Do you want to allow Classroom owners to choose to enable / disable Join feature for their Classroom?',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.allow.owner.join', 1),
        ));
        $this->addElement('Radio', 'eclassroom_show_approvaloption', array(
          'label' => 'Select Member Approval Options',
          'description' => 'Do you want to allow Classroom owners to choose new members to immediately become members of their Classroom or wait for their approval when new members join their Classroom?',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.show.approvaloption', 1),
          'onclick' => 'showClassroomApprovalOptions(this.value);',
        ));
        $this->addElement('Radio', 'eclassroom_default_joinoption', array(
          'label' => 'Default Option for Member Approval',
          'description' => 'Select default option whether members should be allowed to join immediately, or wait for approval, when they Join a Classroom on your website.?',
          'multiOptions' => array('1' => 'New members can join immediately','0' => 'New members must wait for approval'),
          'value' => $settings->getSetting('eclassroom.default.joinoption', 1),
        ));
        $this->addElement('Radio', 'eclassroom_joinclass_memtitle', array(
          'label' => "Member's Title",
          'description' => 'Do you want to allow Classroom owners to choose title for the members of their Classroom?',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.joinclass.memtitle', 1),
          'onclick' => 'showClassroomMemTitle(this.value);',
        ));
        $this->addElement('Radio', 'eclassroom_memtitle_required', array(
          'label' => "Make Member's Title Mandatory",
          'description' => "Do you want to make Members' title field mandatory when users create or edit their Classroom?",
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.memtitle.required', 1),
        ));
        $this->addElement('Radio', 'eclassroom_default_title_singular', array(
          'label' => "Default Member's Singular Title",
          'description' => 'Enter the title for members of Classroom on your website. E.g. Music Artist, Blogger, Painter, Dance Lover etc',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.default.title.singular', 1),
        ));
        $this->addElement('Radio', 'eclassroom_default_title_plural', array(
          'label' => "Default Member's Plural Title",
          'description' => 'Enter the title for members of Classroom on your website. E.g. Music Artists, Bloggers, Painters, Dance Lovers etc',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.default.title.plural', 1),
        ));
        $this->addElement('Radio', 'eclassroom_invite_enable', array(
          'label' => 'Enable Invitations in Classroom',
          'description' => 'Do you want to enable invitation to Join, Like and Follow Classroom on your website?',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.invite.enable', 1),
          'onclick' => 'showClassroomInvite(this.value);',
        ));
        $this->addElement('Radio', 'eclassroom_invite_allow_owner', array(
          'label' => 'Allow Owners to Enable Invites',
          'description' => 'Do you want to allow classroom owners to choose to enable / disable Invite feature for their Classroom?',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.invite.allow.owner', 1),
          'onclick' => 'showClassroomOwnerInvite(this.value);',
        ));
        $this->addElement('Radio', 'eclassroom_invite_people_default', array(
          'label' => 'Select Member Invitation Options',
          'description' => 'Do you want to allow Classroom owners to choose to enable site members to invite their friends to Like, Follow and Join their Classroom?',
          'multiOptions' => array('1' => 'Yes, allow members to invite other people.','0' => 'No, do not allow members to invite other people.'),
          'value' => $settings->getSetting('eclassroom.invite.people.default', 1),
        ));
        $this->addElement('Radio', 'eclassroom_global_search', array(
          'label' => 'Enable “People can search for this Classroom” Field',
          'description' => 'Do you want to enable “People can search for this Classroom” field while creating and editing Classroom on your website?',
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.global.search', 1),
        ));
       // $this->addElement('Radio', 'eclassroom_guidelines', array(
         //   'label' => 'Enter Guidelines for Classroom',
           // 'description' => 'Enter guidelines in the box to display on classroom create form.',
            //'multiOptions' => array('1' => 'Yes','0' => 'No'),
            //'value' => $settings->getSetting('eclassroom.guidelines', 1),
        //));
// 				$this->addElement('Radio', 'eclassroom_guidelines', array(
//         'label' => 'Enter Guidelines for Classroom',
//         'description' => 'Do you want to provide classroom owners with some Guidelines? If yes, then the box containing the guidelines will remain static on the top right of the create form when user scroll down the form.',
//         'multiOptions' => array(
//             1 => 'Yes',
//             0 => 'No',
//         ),
//         'value' => $settings->getSetting('eclassroom.guidelines', 1),
//         'onclick' => 'showGuideEditor(this.value)',
//     ));
// 
//     $allowed_html = 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr';
// 
//     $editorOptions = array(
//         'html' => (bool) $allowed_html,
//     );
//     $editorOptions['plugins'] = array(
//         'preview', 'code',
//     );
//     $this->addElement('TinyMce', 'eclassroom_message_guidelines', array(
//         'label' => 'Enter Guidelines',
//         'class' => 'tinymce',
//         'editorOptions' => $editorOptions,
//         'value' => $settings->getSetting('eclassroom.message.guidelines', ''),
//     ));
        // Add submit button
        $this->addElement('Button', 'submit', array(
            'label' => 'Save Changes',
            'type' => 'submit',
            'ignore' => true
        ));
    }
}
