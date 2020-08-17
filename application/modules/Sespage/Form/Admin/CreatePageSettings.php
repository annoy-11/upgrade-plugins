<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CreatePageSettings.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Form_Admin_CreatePageSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Page Creation Settings')
            ->setDescription('Here, you can choose the settings which are related to the creation of Pages on your website. The settings enabled or disabled will effect Page Directory creation page, popup and Edit pages.');

    $this->addElement('Radio', 'sespage_open_smoothbox', array(
        'label' => 'Page or Popup for "Create New Page"',
        'description' => 'Do you want to open the ‘Create New Page’ Form in popup or in a Page, when they click on the ‘Create New Page’ Link available in the Main Navigation Menu of this plugin?',
        'multiOptions' => array(
            '1' => "Open Create Page Form in 'popup'",
            '0' => "Open Create Page Form in 'page'",
        ),
        'value' => $settings->getSetting('sespage.open.smoothbox', 0),
    ));

    $this->addElement('Radio', 'sespage_enable_addpageshortcut', array(
        'label' => 'Show "Create New Page" Icon',
        'description' => 'Do you want to show “Create New Page” icon in the bottom right side of all pages of this plugin?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sespage.enable.addpageshortcut', 1),
        'onclick' => 'showQuickOption(this.value)',
    ));
    $this->addElement('Radio', 'sespage_icon_open_smoothbox', array(
        'label' => 'Page or Popup From Create Icon',
        'description' => 'Do you want to open the \'Create New Page\' form in popup or page, when users click on the \'Create New Page Icon\' in the bottom right side of all pages of this plugin?',
        'multiOptions' => array(
            '1' => "Open 'Create Page Form' in 'popup'",
            '0' => "Open ‘Create Page Form’ in ‘page’",
        ),
        'value' => $settings->getSetting('sespage.icon.open.smoothbox', 0),
    ));
    $this->addElement('Radio', 'sespage_category_selection', array(
        'label' => 'Choose Category Before Creating Page',
        'description' => 'Do you want to show the Category Selection Form as the first step, when user creates a Page. If Yes, then users will be moved to Page Create Form only after selecting the category. If No, then user will be directly moved to Page Create Form.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sespage.category.selection', 0),
        'onclick' => 'showCategoryIcon(this.value)',
    ));
    $this->addElement('Radio', 'sespage_category_icon', array(
        'label' => 'Category Photo Display',
        'description' => 'Choose from below the which photo of categories do you display with category names. You can upload and esti these photos from the "Categories & Profile Fields" section of this plugin.',
        'multiOptions' => array(
            1 => 'Icon',
            0 => 'Colored Icon',
            2 => 'Thumbnail',
        ),
        'value' => $settings->getSetting('sespage.category.icon', 1),
    ));
    $this->addElement('Radio', 'sespage_quick_create', array(
        'label' => 'Create Page from Categories Only',
        'description' => 'Do you want the Page to be created by filling the details in the category boxes? This will enable quick creation of Pages on your website.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sespage.quick.create', 0),
    ));
    $this->addElement('Select', 'sespage_redirect', array(
        'label' => 'Redirection After Page Creation',
        'description' => 'Choose from below where you want to redirect users after a Page is successfully created.',
        'multiOptions' => array(
            '0' => 'On Page Dashboard',
            '1' => 'On Page Profile (view page)',
        ),
        'value' => $settings->getSetting('sespage.redirect', 1),
    ));
    $this->addElement('Radio', 'sespage_create_form', array(
        'label' => 'Create Page Form Type',
        'description' => 'What type of Form you want to show on Create New Page and Dashboard?',
        'multiOptions' => array(
            0 => 'Default SE Form',
            1 => 'Designed Form'
        ),
        'value' => $settings->getSetting('sespage.create.form', 1),
    ));
    $this->addElement('Select', 'sespage_autoopenpopup', array(
        'label' => 'Auto-Open Advanced Share Popup',
        'description' => 'Do you want the "Advanced Share Popup" to be auto-populated after the Page is created? [Note: This setting will only work if you have placed Advanced Share widget on Page View or Page Dashboard, wherever user is redirected just after Page creation.]',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sespage.autoopenpopup', 1),
    ));
    $this->addElement('Radio', 'sespage_edit_url', array(
        'label' => 'Edit Custom URL',
        'description' => 'Do you want to allow users to edit the custom URL of their Pages once the Pages are created? If you choose Yes, then the URL can be edited from the dashboard of Pages?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sespage.edit.url', 0),
    ));
    $this->addElement('Radio', 'sespage_category_required', array(
        'label' => 'Make Page Categories Mandatory',
        'description' => 'Do you want to make Category field mandatory when users create or edit their Pages?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sespage.category.required', 0),
    ));
    $this->addElement('Radio', 'sespage_enable_description', array(
        'label' => 'Enable Page Description',
        'description' => 'Do you want to enable description of Pages on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sespage.enable.description', 1),
        'onclick' => 'showPageDescription(this.value);',
    ));
    $this->addElement('Radio', 'sespage_description_required', array(
        'label' => 'Make Page Description Mandatory',
        'description' => 'Do you want to make Description field mandatory when users create or edit their Pages?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sespage.description.required', 1),
    ));
    $this->addElement('Radio', 'sespage_pagemainphoto', array(
        'label' => 'Make Page Main Photo Mandatory',
        'description' => 'Do you want to make Main Photo field mandatory when users create or edit their Pages?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sespage.pagemainphoto', 1),
    ));
    $this->addElement('Radio', 'sespage_pagetags', array(
        'label' => 'Enable Tags',
        'description' => 'Do you want to enable tags for the Pages on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sespage.pagetags', 1),
    ));
    $this->addElement('Radio', 'sespage_allow_join', array(
        'label' => 'Enable Page Joining',
        'description' => 'Do you want to enable joining of Pages on your website? If you choose Yes, then other members will be able to join Pages and become members of Pages on your website.',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sespage.allow.join', 1),
    ));
    $this->addElement('Radio', 'sespage_auto_join', array(
        'label' => 'Auto-Join Page',
        'description' => 'Do you want owners of Pages to automatically join Pages after their creation on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sespage.auto.join', 1),
    ));
    $this->addElement('Radio', 'sespage_allow_owner_join', array(
        'label' => 'Allow Owners to Enable Joining',
        'description' => 'Do you want to allow Page owners to choose to enable / disable Join feature for their Pages?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sespage.allow.owner.join', 1),
    ));
    $this->addElement('Radio', 'sespage_default_joinoption', array(
        'label' => 'Default Option for Member Approval',
        'description' => 'Select default option whether members should be allowed to join immediately, or wait for approval, when they Join a Page on your website.?',
        'multiOptions' => array(
            '1' => 'New members can join immediately',
            '0' => 'New members must wait for approval',
        ),
        'value' => $settings->getSetting('sespage.default.joinoption', 1),
    ));
    $this->addElement('Radio', 'sespage_show_approvaloption', array(
        'label' => 'Select Member Approval Options',
        'description' => 'Do you want to allow page owners to choose new members to immediately become members of their Pages or wait for their approval when new members join their Pages?',
        'multiOptions' => array(
            '1' => 'Yes, allow Page Owners to choose.',
            '0' => 'No, do not allow Page Owners to choose.',
        ),
        'value' => $settings->getSetting('sespage.show.approvaloption', 1),
    ));
    $this->addElement('Radio', 'sespage_default_approvaloption', array(
        'label' => 'Default Option for Member Approval',
        'description' => 'Select default option whether members should be allowed to join immediately or wait for approval when they Join a Page on your website.',
        'multiOptions' => array(
            '1' => 'New members can join immediately',
            '0' => 'New members must wait for approval',
        ),
        'value' => $settings->getSetting('sespage.default.approvaloption', 1),
    ));
    $this->addElement('Radio', 'sespage_joinpage_memtitle', array(
        'label' => 'Member\'s Title',
        'description' => 'Do you want to allow page owners to choose title for the members of their Pages?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sespage.joinpage.memtitle', 1),
    ));
    $this->addElement('Text', 'sespage_default_title_singular', array(
        'label' => 'Default Member\'s Singular Title',
        'description' => 'Enter the title for members of Pages on your website. E.g. Music Artist, Blogger, Painter, Dance Lover etc.',
        'value' => $settings->getSetting('sespage.default.title.singular', ''),
    ));
    $this->addElement('Text', 'sespage_default_title_plural', array(
        'label' => 'Default Member\'s Plural Title',
        'description' => 'Enter the title for members of Pages on your website. E.g. Music Artists, Bloggers, Painters, Dance Lovers etc.',
        'value' => $settings->getSetting('sespage.default.title.plural', ''),
    ));
    $this->addElement('Radio', 'sespage_memtitle_required', array(
        'label' => 'Make Member\'s Title Mandatory',
        'description' => 'Do you want to make Members\' title field mandatory when users create or edit their Pages?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sespage.memtitle.required', 1),
    ));
    $this->addElement('Radio', 'sespage_invite_enable', array(
        'label' => 'Enable Invitations in Pages',
        'description' => 'Do you want to enable invitation to Join, Like and Follow Pages on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('sespage.invite.enable', 1),
    ));
    $this->addElement('Radio', 'sespage_invite_allow_owner', array(
        'label' => 'Allow Owners to Enable Invites',
        'description' => 'Do you want to allow page owners to choose to enable / disable Invite feature for their Pages?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('sespage.invite.allow.owner', 1),
    ));
    $this->addElement('Radio', 'sespage_invite_people_default', array(
        'label' => 'Select Member Invitation Options',
        'description' => 'Do you want to allow Page owners to choose to enable site members to invite their friends to Like, Follow and Join their Pages?',
        'multiOptions' => array(
            1 => 'Yes, allow members to invite other people.',
            0 => 'No, do not allow members to invite other people.',
        ),
        'value' => $settings->getSetting('sespage.invite.people.default', 1),
    ));
    $this->addElement('Radio', 'sespage_global_search', array(
        'label' => 'Enable “People can search for this Page” Field',
        'description' => 'Do you want to enable “People can search for this Page” field while creating and editing Pages on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('sespage.global.search', 1),
    ));
    $this->addElement('Radio', 'sespage_guidelines', array(
        'label' => 'Page Creation Guidelines',
        'description' => 'Do you want to provide Page owners with some Guidelines? If yes, then the box containing the guidelines will remain static on the top right of the create page when user scroll down the form.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('sespage.guidelines', 1),
        'onclick' => 'showGuideEditor(this.value)',
    ));

    $allowed_html = 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr';

    $editorOptions = array(
        'html' => (bool) $allowed_html,
    );
    $editorOptions['plugins'] = array(
        'preview', 'code',
    );
    $this->addElement('TinyMce', 'sespage_message_guidelines', array(
        'label' => 'Enter Guidelines',
        'class' => 'tinymce',
        'editorOptions' => $editorOptions,
        'value' => $settings->getSetting('sespage.message.guidelines', ''),
    ));

    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
