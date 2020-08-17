<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sescrowdfunding_Form_Admin_Level_Level extends Authorization_Form_Admin_Level_Abstract {

    public function init() {

        $class = '';

        parent::init();

        // My stuff
        $this->setTitle('Member Level Settings')
            ->setDescription("These settings are applied on a per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level below.");

        // Element: view
        $this->addElement('Radio', 'view', array(
            'label' => 'Allow Viewing of Crowdfunding?',
            'description' => 'Do you want to let members view crowdfundings? If set to no, some other settings on this page may not apply.',
            'multiOptions' => array(
                2 => 'Yes, allow viewing of all crowdfundings, even private ones.',
                1 => 'Yes, allow viewing of crowdfundings.',
                0 => 'No, do not allow crowdfundings to be viewed.',
            ),
            'value' => ( $this->isModerator() ? 2 : 1 ),
        ));
        if( !$this->isModerator() ) {
            unset($this->view->options[2]);
        }


        if( !$this->isPublic() ) {

            // Element: create
            $this->addElement('Radio', 'create', array(
                'label' => 'Allow Creation of Crowdfunding?',
                'description' => 'Do you want to let members create crowdfundings? If set to no, some other settings on this page may not apply. This is useful if you want members to be able to view crowdfundings, but only want certain levels to be able to create crowdfundings.',
                'multiOptions' => array(
                    1 => 'Yes, allow creation of crowdfundings.',
                    0 => 'No, do not allow crowdfundings to be created.'
                ),
                'value' => 1,
            ));

            // Element: edit
            $this->addElement('Radio', 'edit', array(
                'label' => 'Allow Editing of Crowdfunding?',
                'description' => 'Do you want to let members edit crowdfundings? If set to no, some other settings on this page may not apply.',
                'multiOptions' => array(
                    2 => 'Yes, allow members to edit all crowdfundings.',
                    1 => 'Yes, allow members to edit their own crowdfundings.',
                    0 => 'No, do not allow members to edit their crowdfundings.',
                ),
                'value' => ( $this->isModerator() ? 2 : 1 ),
            ));
            if( !$this->isModerator() ) {
                unset($this->edit->options[2]);
            }

            // Element: delete
            $this->addElement('Radio', 'delete', array(
                'label' => 'Allow Deletion of Crowdfunding?',
                'description' => 'Do you want to let members delete crowdfundings? If set to no, some other settings on this page may not apply.',
                'multiOptions' => array(
                    2 => 'Yes, allow members to delete all crowdfundings.',
                    1 => 'Yes, allow members to delete their own crowdfundings.',
                    0 => 'No, do not allow members to delete their crowdfundings.',
                ),
                'value' => ( $this->isModerator() ? 2 : 1 ),
            ));
            if( !$this->isModerator() ) {
                unset($this->delete->options[2]);
            }

            // Element: comment
            $this->addElement('Radio', 'comment', array(
                'label' => 'Allow Commenting on Crowdfunding?',
                'description' => 'Do you want to let members of this level comment on crowdfundings?',
                'multiOptions' => array(
                    2 => 'Yes, allow members to comment on all crowdfundings, including private ones.',
                    1 => 'Yes, allow members to comment on crowdfundings.',
                    0 => 'No, do not allow members to comment on crowdfundings.',
                ),
                'value' => ( $this->isModerator() ? 2 : 1 ),
            ));
            if( !$this->isModerator() ) {
                unset($this->comment->options[2]);
            }

            // Element: auth_view
            $this->addElement('MultiCheckbox', 'auth_view', array(
                'label' => 'Crowdfunding Entry Privacy',
                'description' => 'Your members can choose from any of the options checked below when they decide who can see their crowdfunding entries. These options appear on your members\' "Create Crowdfunding" and "Edit Crowdfunding" pages. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
                'multiOptions' => array(
                    'everyone'            => 'Everyone',
                    'registered'          => 'All Registered Members',
                    'owner_network'       => 'Friends and Networks',
                    'owner_member_member' => 'Friends of Friends',
                    'owner_member'        => 'Friends Only',
                    'owner'               => 'Just Me'
                ),
                'value' => array('everyone', 'owner_network', 'owner_member_member', 'owner_member', 'owner'),
            ));

            // Element: auth_comment
            $this->addElement('MultiCheckbox', 'auth_comment', array(
                'label' => 'Crowdfunding Comment Options',
                'description' => 'Your members can choose from any of the options checked below when they decide who can post comments on their entries. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
                'multiOptions' => array(
                    'everyone'            => 'Everyone',
                    'registered'          => 'All Registered Members',
                    'owner_network'       => 'Friends and Networks',
                    'owner_member_member' => 'Friends of Friends',
                    'owner_member'        => 'Friends Only',
                    'owner'               => 'Just Me'
                ),
                'value' => array('everyone', 'registered', 'owner_network', 'owner_member_member', 'owner_member', 'owner'),
            ));

            $this->addElement('Radio', 'upload_mainphoto', array(
                'label' => 'Allow to Upload Crowdfunding Main Photo',
                'description' => 'Do you want to allow members of this member level to upload main photo for their Crowdfunding. If set to No, then the default main photo will get displayed instead which you can choose in settings below.',
                'class' => $class,
                'multiOptions' => array(
                    1 => 'Yes',
                    0 => 'No',
                ),
                'value' => 1,
            ));

            $this->addElement('Radio', 'auth_crodstyle', array(
                'label' => 'Allow to Choose Crowdfunding Profile Design Views',
                'description' => 'Do you want to enable members of this level to choose designs for their Crowdfunding Profiles? (If you choose No, then you can choose a default layout for the Crowdfunding Profiles on your website. But, if you choose Yes, then you can choose which all designs will be allowed for selection in Crowdfunding dashboards.)',
                'class' => $class,
                'multiOptions' => array(
                    1 => 'Yes',
                    0 => 'No',
                ),
                'value' => 1,
            ));
            $this->addElement('MultiCheckbox', 'select_pagestyle', array(
                'label' => 'Select Crowdfunding Profile Designs',
                'description' => 'Select Crowdfunding profile designs which will be available to members while creating or editing their Crowdfunding.',
                'class' => $class,
                'multiOptions' => array(
                    1 => 'Template 1',
                    2 => 'Template 2',
                    3 => 'Template 3',
                    4 => 'Template 4',
                ),
                'value' => array(1,2,3,4),
            ));
            // Element: auth_view
            $this->addElement('Radio', 'page_style_type', array(
                'label' => 'Default Crowdfunding Profile Design',
                'description' => 'Choose the default profile design for Crowdfundings created by members of this member level.',
                'class' => $class,
                'multiOptions' => array(
                    '1' => 'Template 1',
                    '2' => 'Template 2',
                    '3' => 'Template 3',
                    '4' => 'Template 4'
                ),
                'value' => 1,
            ));

            $this->addElement('Radio', 'seo', array(
                'description' => 'Do you want to enable the "SEO" fields for the Crowdfunding created by members of this level? If you choose Yes, then members will be able to enter the details from dashboard of their Crowdfunding.',
                'label' => 'Enable SEO Fields',
                'multiOptions' => array(
                    1 => 'Yes',
                    0 => 'No',
                ),
                'class' => $class,
                'value' => 1,
            ));

            $this->addElement('Radio', 'overview', array(
                'description' => 'Do you want to enable the "Overview" field for the Crowdfunding created by members of this level? If you choose Yes, then members will be able to enter the details from dashboard of their Crowdfunding.',
                'label' => 'Enable Overview',
                'multiOptions' => array(
                    1 => 'Yes',
                    0 => 'No',
                ),
                'class' => $class,
                'value' => 1,
            ));
            $this->addElement('Radio', 'bgphoto', array(
                'description' => 'Do you want to enable the "Background Photo" functionality for the Crowdfunding created by members of this member level? If you choose Yes, then members will be able to upload the photo from dashboard of their Crowdfunding.',
                'label' => 'Enable Background Photo',
                'multiOptions' => array(
                    1 => 'Yes',
                    0 => 'No',
                ),
                'class' => $class,
                'value' => 1,
            ));
            $this->addElement('Radio', 'contactinfo', array(
                'description' => 'Do you want to enable the "Contact Info" functionality for the Crowdfunding created by members of this member level? If you choose Yes, then members will be able to enter the contact details from dashboard of their Crowdfunding.',
                'label' => 'Enable Contact Info',
                'multiOptions' => array(
                    1 => 'Yes',
                    0 => 'No',
                ),
                'class' => $class,
                'value' => 1,
            ));
            $this->addElement('Radio', 'edit_style', array(
                'description' => 'Do you want to enable "Edit CSS Style" for the Crowdfunding created by members of this level? If you choose Yes, then members will be able to edit the CSS Style from dashboard of their Crowdfunding.',
                'label' => 'Enable Edit Style',
                'multiOptions' => array(
                    1 => 'Yes',
                    0 => 'No',
                ),
                'class' => $class,
                'value' => 1,
            ));

            // Element: rating
            $this->addElement('Radio', 'rating', array(
                'label' => 'Allow Rating on Crowdfunding?',
                'description' => 'Do you want to let members of this level rate crowdfundings?',
                'multiOptions' => array(
                    1 => 'Yes, allow members to rate crowdfundings.',
                    0 => 'No, do not allow members to rate crowdfundings.',
                ),
                'value' => ( $this->isModerator() ? 2 : 1 ),
            ));
            if( !$this->isModerator() ) {
                unset($this->rating->options[2]);
            }

            $this->addElement('Radio', 'crwdapprove', array(
                'description' => 'Do you want Crowdfunding created by members of this level to be auto-approved? If you choose No, then you can manually approve Crowdfunding from Manage Crowdfunding section of this plugin.',
                'label' => 'Auto Approve Crowdfunding',
                'multiOptions' => array(
                    1 => 'Yes, auto-approve Crowdfunding.',
                    0 => 'No, do not auto-approve Crowdfunding.'
                ),
                'value' => 1,
            ));

            if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sescrowdfundingteam')) {
                // Team enable permission
                $this->addElement('Radio', 'team', array(
                    'label' => 'Enable Crowdfunding Team',
                    'description' => 'Do you want to enable Crowdfunding Team for the Crowdfunding created by the members of this level?',
                    'multiOptions' => array(
                        1 => 'Yes',
                        0 => 'No',
                    ),
                    'value' => 1,
                ));
            }

            // Element: photo
            $this->addElement('Radio', 'album', array(
                'label' => 'Allow Photos Upload in Crowdfunding?',
                'description' => 'Do you want to let members of this level upload photos in Crowdfunding? If you choose Yes, then members will be able to upload photos.',
                'multiOptions' => array(
                    2 => 'Yes, allow members to upload photos on Crowdfunding, including private ones.',
                    1 => 'Yes, allow members to upload photos in Crowdfunding.',
                    0 => 'No, do not allow members to upload photos in Crowdfunding.',
                ),
                'value' => ( $this->isModerator() ? 2 : 1 ),
            ));
            if (!$this->isModerator()) {
                unset($this->album->options[2]);
            }

        if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sescrowdfundingvideo')) {
            // Element: video
            $this->addElement('Radio', 'video', array(
                'label' => 'Allow Videos Upload in Crowdfunding?',
                'description' => 'Do you want to let members of this level upload videos in Crowdfunding?',
                'multiOptions' => array(
                    2 => 'Yes, allow members to upload videos on Crowdfunding, including private ones.',
                    1 => 'Yes, allow members to upload videos in Crowdfunding.',
                    0 => 'No, do not allow members to upload videos in Crowdfunding.',
                ),
                'value' => ( $this->isModerator() ? 2 : 1 ),
            ));
            if (!$this->isModerator()) {
                unset($this->video->options[2]);
            }
            // Element: auth_photo
            $this->addElement('MultiCheckbox', 'auth_video', array(
                'label' => 'Video Upload Options',
                'description' => 'Your users can choose from any of the options checked below when they decide who can upload videos to their crowdfunding. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
                'multiOptions' => array(
                    'everyone'            => 'Everyone',
                    'registered'          => 'All Registered Members',
                    'owner_network'       => 'Friends and Networks',
                    'owner_member_member' => 'Friends of Friends',
                    'owner_member'        => 'Friends Only',
                    'owner'               => 'Just Me'
                ),
                'value' => array('everyone', 'registered', 'owner_network', 'owner_member_member', 'owner_member', 'owner'),
            ));
        }

            $this->addElement('Radio', 'auth_announce', array(
                'label' => 'Allow to Manage Announcements',
                'class' => $class,
                'description' => 'Do you want to allow members of this level to manage announcements in their Crowdfunding on your website? If you choose Yes, then members will be able to create, edit and manage announcements from dashboard of their Crowdfunding.',
                'multiOptions' => array(
                    1 => 'Yes',
                    0 => 'No',
                ),
                'value' => 1,
            ));


            $this->addElement('Radio', 'auth_rewards', array(
                'label' => 'Allow to Manage Rewards',
                'class' => $class,
                'description' => 'Do you want to allow members of this level to manage rewards in their Crowdfunding on your website? If you choose Yes, then members will be able to create, edit and manage announcements from dashboard of their Crowdfunding.',
                'multiOptions' => array(
                    1 => 'Yes',
                    0 => 'No',
                ),
                'value' => 1,
            ));

            $this->addElement('Radio', 'auth_insightrpt', array(
                'label' => 'Allow to View Insights & Reports',
                'class' => $class,
                'description' => 'Do you want to allow members of this level to view Insights and Reports of their Crowdfunding on your website? If you choose Yes, then members will be able to view insights and reports from dashboard of their Crowdfunding.',
                'multiOptions' => array(
                    1 => 'Yes',
                    0 => 'No',
                ),
                'value' => 1,
            ));

            $this->addElement('Text', 'count', array(
                'label' => 'Maximum Allowed Crowdfunding',
                'description' => 'Enter the maximum number of allowed Crowdfunding to be created by members of this level. The field must contain an integer between 1 and 999, or 0 for unlimited.',
                'class' => $class,
                'validators' => array(
                    array('Int', true),
                ),
                'value' => 10,
            ));

            //commission
            $this->addElement('Select', 'admin_commission', array(
                'label' => 'Unit for Commission',
                'description' => 'Choose the unit for admin commission in donations made for crowdfunding campaigns on your website.',
                'multiOptions' => array(
                    1 => 'Percentage',
                    2 => 'Fixed'
                ),
                'allowEmpty' => false,
                'required' => true,
                'value' => 1,
            ));

            $this->addElement('Text', "commission_value", array(
                'label' => 'Commission Value',
                'description' => "Enter the value for commission according to the unit chosen in above setting. [If you have chosen Percentage, then value should be in range 1 to 100.]",
                'allowEmpty' => true,
                'required' => false,
                'value' => 1,
            ));

            $this->addElement('Text', "threshold_amount", array(
                'label' => 'Threshold Amount for Releasing Payment',
                'description' => "Enter the threshold amount which will be required before making request for releasing payment from admins.",
                'allowEmpty' => false,
                'required' => true,
                'value' => 100,
            ));

    //       $this->addElement('Text', 'sescrowdfunding_commison', array(
    //         'label' => 'Enter Commison in Percentage',
    //         'description' => 'Enter Commison in Percentage',
    //         'required' => true,
    //         'allowEmpty' => false,
    //         'validators' => array(
    //           array('int', true),
    //           new Engine_Validate_AtLeast(0),
    //         ),
    //         'value' => '5',
    //       ));

        }
    }
}
