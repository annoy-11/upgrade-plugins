<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CreateBusinessSettings.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Form_Admin_CreateBusinessSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Business Creation Settings')
            ->setDescription('Here, you can choose the settings which are related to the creation of Businesses on your website. The settings enabled or disabled will effect Business Directory creation page, popup and Edit businesses.');

    $this->addElement('Radio', 'sesbusiness_open_smoothbox', array(
        'label' => 'Page or Popup for "Create New Business"',
        'description' => 'Do you want to open the "Create New Business" Form in popup or in a Page, when they click on the "Create New Business" Link available in the Main Navigation Menu of this plugin?',
        'multiOptions' => array(
            '1' => "Open Create Business Form in 'popup'",
            '0' => "Open Create Business Form in 'page'",
        ),
        'value' => $settings->getSetting('sesbusiness.open.smoothbox', 0),
    ));

    $this->addElement('Radio', 'sesbusiness_enable_addbusinesseshortcut', array(
        'label' => 'Show "Create New Business" Icon',
        'description' => 'Do you want to show "Create New Business" icon in the bottom right side of all pages of this plugin?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sesbusiness.enable.addbusinesseshortcut', 1),
        'onclick' => 'showQuickOption(this.value)',
    ));
    $this->addElement('Radio', 'sesbusiness_icon_open_smoothbox', array(
        'label' => 'Page or Popup From Create Icon',
        'description' => 'Do you want to open the \'Create New Business\' form in popup or page, when users click on the \'Create New Business Icon\' in the bottom right side of all pages of this plugin?',
        'multiOptions' => array(
            '1' => "Open 'Create Business Form' in 'popup'",
            '0' => "Open 'Create Business Form' in 'page'",
        ),
        'value' => $settings->getSetting('sesbusiness.icon.open.smoothbox', 0),
    ));
    $this->addElement('Radio', 'sesbusiness_category_selection', array(
        'label' => 'Choose Category Before Creating Business',
        'description' => 'Do you want to show the Category Selection Form as the first step, when user creates a Business. If Yes, then users will be moved to Business Create Form only after selecting the category. If No, then user will be directly moved to Business Create Form.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sesbusiness.category.selection', 0),
        'onclick' => 'showCategoryIcon(this.value)',
    ));
    $this->addElement('Radio', 'sesbusiness_category_icon', array(
        'label' => 'Category Photo Display',
        'description' => 'Choose from below the which photo of categories do you display with category names. You can upload and esti these photos from the "Categories & Profile Fields" section of this plugin.',
        'multiOptions' => array(
            1 => 'Icon',
            0 => 'Colored Icon',
            2 => 'Thumbnail',
        ),
        'value' => $settings->getSetting('sesbusiness.category.icon', 1),
    ));
    $this->addElement('Radio', 'sesbusiness_quick_create', array(
        'label' => 'Create Business from Categories Only',
        'description' => 'Do you want the Business to be created by filling the details in the category boxes? This will enable quick creation of Businesses on your website.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sesbusiness.quick.create', 0),
    ));
    $this->addElement('Select', 'sesbusiness_redirect', array(
        'label' => 'Redirection After Business Creation',
        'description' => 'Choose from below where you want to redirect users after a Business is successfully created.',
        'multiOptions' => array(
            '0' => 'On Business Dashboard',
            '1' => 'On Business Profile (view page)',
        ),
        'value' => $settings->getSetting('sesbusiness.redirect', 1),
    ));
    $this->addElement('Radio', 'sesbusiness_create_form', array(
        'label' => 'Create Business Form Type',
        'description' => 'What type of Form you want to show on Create New Business and Dashboard?',
        'multiOptions' => array(
            0 => 'Default SE Form',
            1 => 'Designed Form'
        ),
        'value' => $settings->getSetting('sesbusiness.create.form', 1),
    ));
    $this->addElement('Select', 'sesbusiness_autoopenpopup', array(
        'label' => 'Auto-Open Advanced Share Popup',
        'description' => 'Do you want the "Advanced Share Popup" to be auto-populated after the Business is created? [Note: This setting will only work if you have placed Advanced Share widget on Business View or Business Dashboard, wherever user is redirected just after Business creation.]',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesbusiness.autoopenpopup', 1),
    ));
    $this->addElement('Radio', 'sesbusiness_edit_url', array(
        'label' => 'Edit Custom URL',
        'description' => 'Do you want to allow users to edit the custom URL of their Businesses once the Businesses are created? If you choose Yes, then the URL can be edited from the dashboard of Businesses?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesbusiness.edit.url', 0),
    ));
    $this->addElement('Radio', 'sesbusiness_category_required', array(
        'label' => 'Make Business Categories Mandatory',
        'description' => 'Do you want to make Category field mandatory when users create or edit their Businesses?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesbusiness.category.required', 0),
    ));
    $this->addElement('Radio', 'sesbusiness_enable_description', array(
        'label' => 'Enable Business Description',
        'description' => 'Do you want to enable description of Businesses on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesbusiness.enable.description', 1),
        'onclick' => 'showBusinessDescription(this.value);',
    ));
    $this->addElement('Radio', 'sesbusiness_description_required', array(
        'label' => 'Make Business Description Mandatory',
        'description' => 'Do you want to make Description field mandatory when users create or edit their Businesses?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesbusiness.description.required', 1),
    ));
    $this->addElement('Radio', 'sesbusiness_businessmainphoto', array(
        'label' => 'Make Business Main Photo Mandatory',
        'description' => 'Do you want to make Main Photo field mandatory when users create or edit their Businesses?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesbusiness.businessmainphoto', 1),
    ));
    $this->addElement('Radio', 'sesbusiness_businesstags', array(
        'label' => 'Enable Tags',
        'description' => 'Do you want to enable tags for the Businesses on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesbusiness.businesstags', 1),
    ));
    $this->addElement('Radio', 'sesbusiness_allow_join', array(
        'label' => 'Enable Business Joining',
        'description' => 'Do you want to enable joining of Businesses on your website? If you choose Yes, then other members will be able to join Businesses and become members of Businesses on your website.',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesbusiness.allow.join', 1),
    ));
    $this->addElement('Radio', 'sesbusiness_auto_join', array(
        'label' => 'Auto-Join Business',
        'description' => 'Do you want owners of Businesses to automatically join Businesses after their creation on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesbusiness.auto.join', 1),
    ));
    $this->addElement('Radio', 'sesbusiness_allow_owner_join', array(
        'label' => 'Allow Owners to Enable Joining',
        'description' => 'Do you want to allow Business owners to choose to enable / disable Join feature for their Businesses?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesbusiness.allow.owner.join', 1),
    ));
    $this->addElement('Radio', 'sesbusiness_default_joinoption', array(
        'label' => 'Default Option for Member Approval',
        'description' => 'Select default option whether members should be allowed to join immediately, or wait for approval, when they Join a Business on your website.?',
        'multiOptions' => array(
            '1' => 'New members can join immediately',
            '0' => 'New members must wait for approval',
        ),
        'value' => $settings->getSetting('sesbusiness.default.joinoption', 1),
    ));
    $this->addElement('Radio', 'sesbusiness_show_approvaloption', array(
        'label' => 'Select Member Approval Options',
        'description' => 'Do you want to allow business owners to choose new members to immediately become members of their Businesses or wait for their approval when new members join their Businesses?',
        'multiOptions' => array(
            '1' => 'Yes, allow Business Owners to choose.',
            '0' => 'No, do not allow Business Owners to choose.',
        ),
        'value' => $settings->getSetting('sesbusiness.show.approvaloption', 1),
    ));
    $this->addElement('Radio', 'sesbusiness_default_approvaloption', array(
        'label' => 'Default Option for Member Approval',
        'description' => 'Select default option whether members should be allowed to join immediately or wait for approval when they Join a Business on your website.',
        'multiOptions' => array(
            '1' => 'New members can join immediately',
            '0' => 'New members must wait for approval',
        ),
        'value' => $settings->getSetting('sesbusiness.default.approvaloption', 1),
    ));
    $this->addElement('Radio', 'sesbusiness_joinbusiness_memtitle', array(
        'label' => 'Member\'s Title',
        'description' => 'Do you want to allow business owners to choose title for the members of their Businesses?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesbusiness.joinbusiness.memtitle', 1),
    ));
    $this->addElement('Text', 'sesbusiness_default_title_singular', array(
        'label' => 'Default Member\'s Singular Title',
        'description' => 'Enter the title for members of Businesses on your website. E.g. Music Artist, Blogger, Painter, Dance Lover etc.',
        'value' => $settings->getSetting('sesbusiness.default.title.singular', ''),
    ));
    $this->addElement('Text', 'sesbusiness_default_title_plural', array(
        'label' => 'Default Member\'s Plural Title',
        'description' => 'Enter the title for members of Businesses on your website. E.g. Music Artists, Bloggers, Painters, Dance Lovers etc.',
        'value' => $settings->getSetting('sesbusiness.default.title.plural', ''),
    ));
    $this->addElement('Radio', 'sesbusiness_memtitle_required', array(
        'label' => 'Make Member\'s Title Mandatory',
        'description' => 'Do you want to make Members\' title field mandatory when users create or edit their Businesses?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesbusiness.memtitle.required', 1),
    ));
    $this->addElement('Radio', 'sesbusiness_invite_enable', array(
        'label' => 'Enable Invitations in Businesses',
        'description' => 'Do you want to enable invitation to Join, Like and Follow Businesses on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('sesbusiness.invite.enable', 1),
    ));
    $this->addElement('Radio', 'sesbusiness_invite_allow_owner', array(
        'label' => 'Allow Owners to Enable Invites',
        'description' => 'Do you want to allow business owners to choose to enable / disable Invite feature for their Businesses?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('sesbusiness.invite.allow.owner', 1),
    ));
    $this->addElement('Radio', 'sesbusiness_invite_people_default', array(
        'label' => 'Select Member Invitation Options',
        'description' => 'Do you want to allow Business owners to choose to enable site members to invite their friends to Like, Follow and Join their Businesses?',
        'multiOptions' => array(
            1 => 'Yes, allow members to invite other people.',
            0 => 'No, do not allow members to invite other people.',
        ),
        'value' => $settings->getSetting('sesbusiness.invite.people.default', 1),
    ));
    $this->addElement('Radio', 'sesbusiness_global_search', array(
        'label' => 'Enable “People can search for this Business” Field',
        'description' => 'Do you want to enable “People can search for this Business” field while creating and editing Businesses on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('sesbusiness.global.search', 1),
    ));
    $this->addElement('Radio', 'sesbusiness_guidelines', array(
        'label' => 'Business Creation Guidelines',
        'description' => 'Do you want to provide Business owners with some Guidelines? If yes, then the box containing the guidelines will remain static on the top right of the create page when user scroll down the form.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('sesbusiness.guidelines', 1),
        'onclick' => 'showGuideEditor(this.value)',
    ));

    $allowed_html = 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr';

    $editorOptions = array(
        'html' => (bool) $allowed_html,
    );
    $editorOptions['plugins'] = array(
        'preview', 'code',
    );
    $this->addElement('TinyMce', 'sesbusiness_message_guidelines', array(
        'label' => 'Enter Guidelines',
        'class' => 'tinymce',
        'editorOptions' => $editorOptions,
        'value' => $settings->getSetting('sesbusiness.message.guidelines', ''),
    ));

    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
