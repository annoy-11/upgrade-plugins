<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CreateStoreSettings.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Form_Admin_CreateStoreSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Store Creation Settings')
            ->setDescription('Here, you can choose the settings which are related to the creation of Stores on your website. The settings enabled or disabled will effect Store Directory creation page, popup and Edit stores.');

    $this->addElement('Radio', 'estore_open_smoothbox', array(
        'label' => 'Page or Popup for "Create New Store"',
        'description' => 'Do you want to open the "Create New Store" Form in popup or in a Page, when they click on the "Create New Store" Link available in the Main Navigation Menu of this plugin?',
        'multiOptions' => array(
            '1' => "Open Create Store Form in 'popup'",
            '0' => "Open Create Store Form in 'page'",
        ),
        'value' => $settings->getSetting('estore.open.smoothbox', 0),
    ));

    $this->addElement('Radio', 'estore_enable_addstoreshortcut', array(
        'label' => 'Show "Create New Store" Icon',
        'description' => 'Do you want to show "Create New Store" icon in the bottom right side of all pages of this plugin?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('estore.enable.addstoreshortcut', 1),
        'onclick' => 'showQuickOption(this.value)',
    ));
    $this->addElement('Radio', 'estore_icon_open_smoothbox', array(
        'label' => 'Page or Popup From Create Icon',
        'description' => 'Do you want to open the \'Create New Store\' form in popup or page, when users click on the \'Create New Store Icon\' in the bottom right side of all pages of this plugin?',
        'multiOptions' => array(
            '1' => "Open 'Create Store Form' in 'popup'",
            '0' => "Open 'Create Store Form' in 'page'",
        ),
        'value' => $settings->getSetting('estore.icon.open.smoothbox', 0),
    ));
    $this->addElement('Radio', 'estore_category_selection', array(
        'label' => 'Choose Category Before Creating Store',
        'description' => 'Do you want to show the Category Selection Form as the first step, when user creates a Store. If Yes, then users will be moved to Store Create Form only after selecting the category. If No, then user will be directly moved to Store Create Form.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('estore.category.selection', 0),
        'onclick' => 'showCategoryIcon(this.value)',
    ));
    $this->addElement('Radio', 'estore_category_icon', array(
        'label' => 'Category Photo Display',
        'description' => 'Choose from below the which photo of categories do you display with category names. You can upload and esti these photos from the "Categories & Profile Fields" section of this plugin.',
        'multiOptions' => array(
            1 => 'Icon',
            0 => 'Colored Icon',
            2 => 'Thumbnail',
        ),
        'value' => $settings->getSetting('estore.category.icon', 1),
    ));
    $this->addElement('Radio', 'estore_quick_create', array(
        'label' => 'Create Store from Categories Only',
        'description' => 'Do you want the Store to be created by filling the details in the category boxes? This will enable quick creation of Stores on your website.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('estore.quick.create', 0),
    ));
    $this->addElement('Select', 'estore_redirect', array(
        'label' => 'Redirection After Store Creation',
        'description' => 'Choose from below where you want to redirect users after a Store is successfully created.',
        'multiOptions' => array(
            '0' => 'On Store Dashboard',
            '1' => 'On Store Profile (view page)',
        ),
        'value' => $settings->getSetting('estore.redirect', 1),
    ));
    $this->addElement('Radio', 'estore_create_form', array(
        'label' => 'Create Store Form Type',
        'description' => 'What type of Form you want to show on Create New Store and Dashboard?',
        'multiOptions' => array(
            0 => 'Default SE Form',
            1 => 'Designed Form'
        ),
        'value' => $settings->getSetting('estore.create.form', 1),
    ));
    $this->addElement('Select', 'estore_autoopenpopup', array(
        'label' => 'Auto-Open Advanced Share Popup',
        'description' => 'Do you want the "Advanced Share Popup" to be auto-populated after the Store is created? [Note: This setting will only work if you have placed Advanced Share widget on Store View or Store Dashboard, wherever user is redirected just after Store creation.]',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('estore.autoopenpopup', 1),
    ));
    $this->addElement('Radio', 'estore_edit_url', array(
        'label' => 'Edit Custom URL',
        'description' => 'Do you want to allow users to edit the custom URL of their Stores once the Stores are created? If you choose Yes, then the URL can be edited from the dashboard of Stores?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('estore.edit.url', 0),
    ));
    $this->addElement('Radio', 'estore_category_required', array(
        'label' => 'Make Store Categories Mandatory',
        'description' => 'Do you want to make Category field mandatory when users create or edit their Stores?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('estore.category.required', 0),
    ));
    $this->addElement('Radio', 'estore_enable_description', array(
        'label' => 'Enable Store Description',
        'description' => 'Do you want to enable description of Stores on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('estore.enable.description', 1),
        'onclick' => 'showStoreDescription(this.value);',
    ));
    $this->addElement('Radio', 'estore_description_required', array(
        'label' => 'Make Store Description Mandatory',
        'description' => 'Do you want to make Description field mandatory when users create or edit their Stores?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('estore.description.required', 1),
    ));
    $this->addElement('Radio', 'estore_storemainphoto', array(
        'label' => 'Make Store Main Photo Mandatory',
        'description' => 'Do you want to make Main Photo field mandatory when users create or edit their Stores?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('estore.storemainphoto', 1),
    ));
    $this->addElement('Radio', 'estore_storetags', array(
        'label' => 'Enable Tags',
        'description' => 'Do you want to enable tags for the Stores on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('estore.storetags', 1),
    ));
    $this->addElement('Radio', 'estore_allow_join', array(
        'label' => 'Enable Store Joining',
        'description' => 'Do you want to enable joining of Stores on your website? If you choose Yes, then other members will be able to join Stores and become members of Stores on your website.',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('estore.allow.join', 1),
    ));
    $this->addElement('Radio', 'estore_auto_join', array(
        'label' => 'Auto-Join Store',
        'description' => 'Do you want owners of Stores to automatically join Stores after their creation on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('estore.auto.join', 1),
    ));
    $this->addElement('Radio', 'estore_allow_owner_join', array(
        'label' => 'Allow Owners to Enable Joining',
        'description' => 'Do you want to allow Store owners to choose to enable / disable Join feature for their Stores?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('estore.allow.owner.join', 1),
    ));
    $this->addElement('Radio', 'estore_default_joinoption', array(
        'label' => 'Default Option for Member Approval',
        'description' => 'Select default option whether members should be allowed to join immediately, or wait for approval, when they Join a Store on your website.?',
        'multiOptions' => array(
            '1' => 'New members can join immediately',
            '0' => 'New members must wait for approval',
        ),
        'value' => $settings->getSetting('estore.default.joinoption', 1),
    ));
    $this->addElement('Radio', 'estore_show_approvaloption', array(
        'label' => 'Select Member Approval Options',
        'description' => 'Do you want to allow store owners to choose new members to immediately become members of their Stores or wait for their approval when new members join their Stores?',
        'multiOptions' => array(
            '1' => 'Yes, allow Store Owners to choose.',
            '0' => 'No, do not allow Store Owners to choose.',
        ),
        'value' => $settings->getSetting('estore.show.approvaloption', 1),
    ));
    $this->addElement('Radio', 'estore_default_approvaloption', array(
        'label' => 'Default Option for Member Approval',
        'description' => 'Select default option whether members should be allowed to join immediately or wait for approval when they Join a Store on your website.',
        'multiOptions' => array(
            '1' => 'New members can join immediately',
            '0' => 'New members must wait for approval',
        ),
        'value' => $settings->getSetting('estore.default.approvaloption', 1),
    ));
    $this->addElement('Radio', 'estore_joinstore_memtitle', array(
        'label' => 'Member\'s Title',
        'description' => 'Do you want to allow store owners to choose title for the members of their Stores?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('estore.joinstore.memtitle', 1),
    ));
    $this->addElement('Text', 'estore_default_title_singular', array(
        'label' => 'Default Member\'s Singular Title',
        'description' => 'Enter the title for members of Stores on your website. E.g. Music Artist, Blogger, Painter, Dance Lover etc.',
        'value' => $settings->getSetting('estore.default.title.singular', ''),
    ));
    $this->addElement('Text', 'estore_default_title_plural', array(
        'label' => 'Default Member\'s Plural Title',
        'description' => 'Enter the title for members of Stores on your website. E.g. Music Artists, Bloggers, Painters, Dance Lovers etc.',
        'value' => $settings->getSetting('estore.default.title.plural', ''),
    ));
    $this->addElement('Radio', 'estore_memtitle_required', array(
        'label' => 'Make Member\'s Title Mandatory',
        'description' => 'Do you want to make Members\' title field mandatory when users create or edit their Stores?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('estore.memtitle.required', 1),
    ));
    $this->addElement('Radio', 'estore_invite_enable', array(
        'label' => 'Enable Invitations in Stores',
        'description' => 'Do you want to enable invitation to Join, Like and Follow Stores on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('estore.invite.enable', 1),
    ));
    $this->addElement('Radio', 'estore_invite_allow_owner', array(
        'label' => 'Allow Owners to Enable Invites',
        'description' => 'Do you want to allow store owners to choose to enable / disable Invite feature for their Stores?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('estore.invite.allow.owner', 1),
    ));
    $this->addElement('Radio', 'estore_invite_people_default', array(
        'label' => 'Select Member Invitation Options',
        'description' => 'Do you want to allow Store owners to choose to enable site members to invite their friends to Like, Follow and Join their Stores?',
        'multiOptions' => array(
            1 => 'Yes, allow members to invite other people.',
            0 => 'No, do not allow members to invite other people.',
        ),
        'value' => $settings->getSetting('estore.invite.people.default', 1),
    ));
    $this->addElement('Radio', 'estore_global_search', array(
        'label' => 'Enable “People can search for this Store” Field',
        'description' => 'Do you want to enable “People can search for this Store” field while creating and editing Stores on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('estore.global.search', 1),
    ));
    $this->addElement('Radio', 'estore_guidelines', array(
        'label' => 'Store Creation Guidelines',
        'description' => 'Do you want to provide Store owners with some Guidelines? If yes, then the box containing the guidelines will remain static on the top right of the create page when user scroll down the form.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('estore.guidelines', 1),
        'onclick' => 'showGuideEditor(this.value)',
    ));

    $allowed_html = 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr';

    $editorOptions = array(
        'html' => (bool) $allowed_html,
    );
    $editorOptions['plugins'] = array(
        'preview', 'code',
    );
    $this->addElement('TinyMce', 'estore_message_guidelines', array(
        'label' => 'Enter Guidelines',
        'class' => 'tinymce',
        'editorOptions' => $editorOptions,
        'value' => $settings->getSetting('estore.message.guidelines', ''),
    ));

    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
