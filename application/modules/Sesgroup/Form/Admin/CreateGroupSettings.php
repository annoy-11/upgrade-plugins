<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CreateGroupSettings.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Form_Admin_CreateGroupSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Group Creation Settings')
            ->setDescription('Here, you can choose the settings which are related to the creation of Groups on your website. The settings enabled or disabled will effect Group Community creation page, popup and Edit groups.');

    $this->addElement('Radio', 'sesgroup_open_smoothbox', array(
        'label' => 'Page or Popup for "Create New Group"',
        'description' => 'Do you want to open the "Create New Group" Form in popup or in a Page, when they click on the "Create New Group" Link available in the Main Navigation Menu of this plugin?',
        'multiOptions' => array(
            '1' => "Open Create Group Form in 'popup'",
            '0' => "Open Create Group Form in 'page'",
        ),
        'value' => $settings->getSetting('sesgroup.open.smoothbox', 0),
    ));

    $this->addElement('Radio', 'sesgroup_enable_addgroupshortcut', array(
        'label' => 'Show "Create New Group" Icon',
        'description' => 'Do you want to show "Create New Group" icon in the bottom right side of all pages of this plugin?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sesgroup.enable.addgroupshortcut', 1),
        'onclick' => 'showQuickOption(this.value)',
    ));
    $this->addElement('Radio', 'sesgroup_icon_open_smoothbox', array(
        'label' => 'Page or Popup From Create Icon',
        'description' => 'Do you want to open the \'Create New Group\' form in popup or page, when users click on the \'Create New Group Icon\' in the bottom right side of all pages of this plugin?',
        'multiOptions' => array(
            '1' => "Open 'Create Group Form' in 'popup'",
            '0' => "Open 'Create Group Form' in 'page'",
        ),
        'value' => $settings->getSetting('sesgroup.icon.open.smoothbox', 0),
    ));
    $this->addElement('Radio', 'sesgroup_category_selection', array(
        'label' => 'Choose Category Before Creating Group',
        'description' => 'Do you want to show the Category Selection Form as the first step, when user creates a Group. If Yes, then users will be moved to Group Create Form only after selecting the category. If No, then user will be directly moved to Group Create Form.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sesgroup.category.selection', 0),
        'onclick' => 'showCategoryIcon(this.value)',
    ));
    $this->addElement('Radio', 'sesgroup_category_icon', array(
        'label' => 'Category Photo Display',
        'description' => 'Choose from below the which photo of categories do you display with category names. You can upload and esti these photos from the "Categories & Profile Fields" section of this plugin.',
        'multiOptions' => array(
            1 => 'Icon',
            0 => 'Colored Icon',
            2 => 'Thumbnail',
        ),
        'value' => $settings->getSetting('sesgroup.category.icon', 1),
    ));
    $this->addElement('Radio', 'sesgroup_quick_create', array(
        'label' => 'Create Group from Categories Only',
        'description' => 'Do you want the Group to be created by filling the details in the category boxes? This will enable quick creation of Groups on your website.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sesgroup.quick.create', 0),
    ));
    $this->addElement('Radio', 'sesgroup_add_question', array(
        'label' => 'Enable Add Question',
        'description' => 'Do you want to enable Add Question feature for your groups when it must be approved by the admin?',
        'multiOptions' => array(
            0 => 'No',
            1 => 'Yes'
        ),
        'value' => $settings->getSetting('sesgroup.add.question', 1),
    ));
    $this->addElement('Select', 'sesgroup_redirect', array(
        'label' => 'Redirection After Group Creation',
        'description' => 'Choose from below where you want to redirect users after a Group is successfully created.',
        'multiOptions' => array(
            '0' => 'On Group Dashboard',
            '1' => 'On Group Profile (view page)',
        ),
        'value' => $settings->getSetting('sesgroup.redirect', 1),
    ));
    $this->addElement('Radio', 'sesgroup_create_form', array(
        'label' => 'Create Group Form Type',
        'description' => 'What type of Form you want to show on Create New Group and Dashboard?',
        'multiOptions' => array(
            0 => 'Default SE Form',
            1 => 'Designed Form'
        ),
        'value' => $settings->getSetting('sesgroup.create.form', 1),
    ));
    $this->addElement('Select', 'sesgroup_autoopenpopup', array(
        'label' => 'Auto-Open Advanced Share Popup',
        'description' => 'Do you want the "Advanced Share Popup" to be auto-populated after the Group is created? [Note: This setting will only work if you have placed Advanced Share widget on Group View or Group Dashboard, wherever user is redirected just after Group creation.]',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesgroup.autoopenpopup', 1),
    ));
    $this->addElement('Radio', 'sesgroup_edit_url', array(
        'label' => 'Edit Custom URL',
        'description' => 'Do you want to allow users to edit the custom URL of their Groups once the Groups are created? If you choose Yes, then the URL can be edited from the dashboard of Groups?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesgroup.edit.url', 0),
    ));
    $this->addElement('Radio', 'sesgroup_category_required', array(
        'label' => 'Make Group Categories Mandatory',
        'description' => 'Do you want to make Category field mandatory when users create or edit their Groups?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesgroup.category.required', 0),
    ));
    $this->addElement('Radio', 'sesgroup_enable_description', array(
        'label' => 'Enable Group Description',
        'description' => 'Do you want to enable description of Groups on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesgroup.enable.description', 1),
        'onclick' => 'showGroupDescription(this.value);',
    ));
    $this->addElement('Radio', 'sesgroup_description_required', array(
        'label' => 'Make Group Description Mandatory',
        'description' => 'Do you want to make Description field mandatory when users create or edit their Groups?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesgroup.description.required', 1),
    ));
    $this->addElement('Radio', 'sesgroup_groupmainphoto', array(
        'label' => 'Make Group Main Photo Mandatory',
        'description' => 'Do you want to make Main Photo field mandatory when users create or edit their Groups?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesgroup.groupmainphoto', 1),
    ));
    $this->addElement('Radio', 'sesgroup_grouptags', array(
        'label' => 'Enable Tags',
        'description' => 'Do you want to enable tags for the Groups on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesgroup.grouptags', 1),
    ));
    $this->addElement('Radio', 'sesgroup_allow_join', array(
        'label' => 'Enable Group Joining',
        'description' => 'Do you want to enable joining of Groups on your website? If you choose Yes, then other members will be able to join Groups and become members of Groups on your website.',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesgroup.allow.join', 1),
    ));
    $this->addElement('Radio', 'sesgroup_auto_join', array(
        'label' => 'Auto-Join Group',
        'description' => 'Do you want owners of Groups to automatically join Groups after their creation on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesgroup.auto.join', 1),
    ));
    $this->addElement('Radio', 'sesgroup_allow_owner_join', array(
        'label' => 'Allow Owners to Enable Joining',
        'description' => 'Do you want to allow Group owners to choose to enable / disable Join feature for their Groups?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesgroup.allow.owner.join', 1),
    ));
    $this->addElement('Radio', 'sesgroup_default_joinoption', array(
        'label' => 'Default Option for Member Approval',
        'description' => 'Select default option whether members should be allowed to join immediately, or wait for approval, when they Join a Group on your website.?',
        'multiOptions' => array(
            '1' => 'New members can join immediately',
            '0' => 'New members must wait for approval',
        ),
        'value' => $settings->getSetting('sesgroup.default.joinoption', 1),
    ));
    $this->addElement('Radio', 'sesgroup_show_approvaloption', array(
        'label' => 'Select Member Approval Options',
        'description' => 'Do you want to allow group owners to choose new members to immediately become members of their Groups or wait for their approval when new members join their Groups?',
        'multiOptions' => array(
            '1' => 'Yes, allow Group Owners to choose.',
            '0' => 'No, do not allow Group Owners to choose.',
        ),
        'value' => $settings->getSetting('sesgroup.show.approvaloption', 1),
    ));
    $this->addElement('Radio', 'sesgroup_default_approvaloption', array(
        'label' => 'Default Option for Member Approval',
        'description' => 'Select default option whether members should be allowed to join immediately or wait for approval when they Join a Group on your website.',
        'multiOptions' => array(
            '1' => 'New members can join immediately',
            '0' => 'New members must wait for approval',
        ),
        'value' => $settings->getSetting('sesgroup.default.approvaloption', 1),
    ));
    $this->addElement('Radio', 'sesgroup_joingroup_memtitle', array(
        'label' => 'Member\'s Title',
        'description' => 'Do you want to allow group owners to choose title for the members of their Groups?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesgroup.joingroup.memtitle', 1),
    ));
    $this->addElement('Text', 'sesgroup_default_title_singular', array(
        'label' => 'Default Member\'s Singular Title',
        'description' => 'Enter the title for members of Groups on your website. E.g. Music Artist, Blogger, Painter, Dance Lover etc.',
        'value' => $settings->getSetting('sesgroup.default.title.singular', ''),
    ));
    $this->addElement('Text', 'sesgroup_default_title_plural', array(
        'label' => 'Default Member\'s Plural Title',
        'description' => 'Enter the title for members of Groups on your website. E.g. Music Artists, Bloggers, Painters, Dance Lovers etc.',
        'value' => $settings->getSetting('sesgroup.default.title.plural', ''),
    ));
    $this->addElement('Radio', 'sesgroup_memtitle_required', array(
        'label' => 'Make Member\'s Title Mandatory',
        'description' => 'Do you want to make Members\' title field mandatory when users create or edit their Groups?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesgroup.memtitle.required', 1),
    ));
    $this->addElement('Radio', 'sesgroup_invite_enable', array(
        'label' => 'Enable Invitations in Groups',
        'description' => 'Do you want to enable invitation to Join, Like and Follow Groups on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('sesgroup.invite.enable', 1),
    ));
    $this->addElement('Radio', 'sesgroup_invite_allow_owner', array(
        'label' => 'Allow Owners to Enable Invites',
        'description' => 'Do you want to allow group owners to choose to enable / disable Invite feature for their Groups?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('sesgroup.invite.allow.owner', 1),
    ));
    $this->addElement('Radio', 'sesgroup_invite_people_default', array(
        'label' => 'Select Member Invitation Options',
        'description' => 'Do you want to allow Group owners to choose to enable site members to invite their friends to Like, Follow and Join their Groups?',
        'multiOptions' => array(
            1 => 'Yes, allow members to invite other people.',
            0 => 'No, do not allow members to invite other people.',
        ),
        'value' => $settings->getSetting('sesgroup.invite.people.default', 1),
    ));
    $this->addElement('Radio', 'sesgroup_global_search', array(
        'label' => 'Enable “People can search for this Group” Field',
        'description' => 'Do you want to enable “People can search for this Group” field while creating and editing Groups on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('sesgroup.global.search', 1),
    ));
    $this->addElement('Radio', 'sesgroup_guidelines', array(
        'label' => 'Group Creation Guidelines',
        'description' => 'Do you want to provide Group owners with some Guidelines? If yes, then the box containing the guidelines will remain static on the top right of the create page when user scroll down the form.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('sesgroup.guidelines', 1),
        'onclick' => 'showGuideEditor(this.value)',
    ));

    $allowed_html = 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr';

    $editorOptions = array(
        'html' => (bool) $allowed_html,
    );
    $editorOptions['plugins'] = array(
        'preview', 'code',
    );
    $this->addElement('TinyMce', 'sesgroup_message_guidelines', array(
        'label' => 'Enter Guidelines',
        'class' => 'tinymce',
        'editorOptions' => $editorOptions,
        'value' => $settings->getSetting('sesgroup.message.guidelines', ''),
    ));

    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
