<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Petitionsettings.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Form_Admin_Petitionsettings extends Engine_Form
{
    public function init()
    {
        $settings = Engine_Api::_()->getApi('settings', 'core');
        $this
            ->setTitle('Petition Creation Settings')
            ->setDescription('Here, you can choose the settings which are related to the creation of petitions on your website. The settings enabled or disabled will effect Petition creation page & Edit petitions page.');


        $this->addElement('Radio', 'epetcre_bcategory', array(
            'label' => 'Choose Category Before Creating Petition',
            'description' => "Do you want to show the Category Selection Form as the first step, when user creates a Petition. If Yes, then users will be moved to Petition Create Form only after selecting the category. If No, then user will be directly moved to Petition Create Form.",
            'multiOptions' => array(
                 1 => "Yes",
                 0 => "No",
            ),
            'value' => $settings->getSetting('epetcre.bcategory', 1),
        ));


        $this->addElement('Select', 'epetition_redirect_creation', array(
            'label' => 'Redirection After Petition Creation',
            'description' => "Choose from below where you want to redirect users after a Petition is successfully created.",
            //'class'=>'select2',
            'multiOptions' => array(
                 1 => "On Petition Dashboard",
                 0 => "On Petition Profile(View Page)",
            ),
            'value' => $settings->getSetting('epetition.redirect.creation', 0),
        ));


        $this->addElement('Radio', 'epetcre_crepet_type', array(
            'label' => 'Create Petition Form Type',
            'description' => "What type of Form you want to show on Create New Petition and Dashboard?",
            'multiOptions' => array(
                 1 => "Default SE Form",
                 0 => "Designed Form",
            ),
            'value' => $settings->getSetting('epetcre.crepet.type', 1),
        ));


        $this->addElement('Radio', 'epetcre_enable_title', array(
            'label' => 'Enable Title',
            'description' => "Do you want to enable petition title?",
            'multiOptions' => array(
                 1 => "Yes",
                 0 => "No",
            ),
            'value' => $settings->getSetting('epetcre.enable.title', 1),
        ));

        $this->addElement('Select', 'epetition_autoopenpopup', array(
            'label' => 'Auto-Open Advanced Share Popup',
            'description' => 'Do you want the "Advanced Share Popup" to be auto-populated after the petition is created? [Note: This setting will only work if you have placed Advanced Share widget on Petition View or Petition Dashboard, wherever user is redirected just after Petition creation.]',
            //  'class'=>'select2',
            'multiOptions' => array(
                 1 => "Yes",
                 0 => "No",
            ),
            'value' => $settings->getSetting('epetition.autoopenpopup', 1),
        ));


        $this->addElement('Radio', 'epetcre_ecust_url', array(
            'label' => 'Edit Custom URL',
            'description' => 'Do you want to allow users to edit the custom URL of their petitions once the petitions are created? If you choose Yes, then the URL can be edited from the dashboard of petition?',
            'multiOptions' => array(
                 1 => "Yes",
                 0 => "No",
            ),
            'value' => $settings->getSetting('epetcre.ecust.url', 1),
        ));


        $this->addElement('Radio', 'epetcre_enb_category', array(
            'label' => 'Enable Category',
            'description' => 'Do you want to enable categories for the petitions at the time of creation?',
            'onchange' => 'changeenablecategory();',
            'multiOptions' => array(
                 1 => "Yes",
                 0 => "No",
            ),
            'value' => $settings->getSetting('epetcre.enb.category', 1),
        ));


        $this->addElement('Radio', 'epetcre_cat_req', array(
            'label' => 'Make Petition Categories Mandatory',
            'description' => 'Do you want to make Category field mandatory when users create or edit their Petitions?',
            'multiOptions' => array(
                 1 => "Yes",
                 0 => "No",
            ),
            'value' => $settings->getSetting('epetcre.cat.req', 1),
        ));

        $this->addElement('Radio', 'epetcre_enb_des', array(
            'label' => 'Enable Petition Description',
            'description' => 'Do you want to enable description of Petitions on your website?',
            'onchange' => 'changeenabledescriptition();',
            'multiOptions' => array(
                 1 => "Yes",
                 0 => "No",
            ),
            'value' => $settings->getSetting('epetcre.enb.des', 1),
        ));


        $this->addElement('Radio', 'epetcre_des_req', array(
            'label' => 'Make Petition Description Mandatory',
            'description' => 'Do you want to make Description field mandatory when users create or    
              edit their Petitions?',
            'multiOptions' => array(
                1 => "Yes",
                0 => "No",
            ),
            'value' => $settings->getSetting('epetcre.des.req', 1),
        ));


        $this->addElement('Radio', 'epetcre_enb_overview', array(
            'label' => 'Enable Petition Overview',
            'description' => 'Do you want to enable petition overview on your website?',
            'multiOptions' => array(
                1 => "Yes",
                0 => "No",
            ),
            'value' => $settings->getSetting('epetcre.enb.overview', 1),
        ));


        $this->addElement('Radio', 'epetition_photo_mandatory', array(
            'label' => 'Make Petitions Main Photo Mandatory',
            'description' => 'Do you want to make Main Photo field mandatory when users create or edit their Petitions?',
            'multiOptions' => array(
                1 => "Yes",
                0 => "No",
            ),
            'value' => $settings->getSetting('epetition.photo.mandatory', 1),
        ));

        $this->addElement('Radio', 'epetcre_enable_tags', array(
            'label' => 'Enable Tags',
            'description' => 'Do you want to enable tags for the Petitions on your website?',
            'multiOptions' => array(
                 1 => "Yes",
                 0 => "No",
            ),
            'value' => $settings->getSetting('epetcre.enable.tags', 1),
        ));

        $this->addElement('Radio', 'epetcre_sign_goal', array(
            'label' => 'Enable Signature Goal',
            'description' => 'Do you want to enable signature goal for the petitions on your website?',
            'multiOptions' => array(
                1 => "Yes",
                0 => "No",
            ),
            'value' => $settings->getSetting('epetcre.sign.goal', 1),
        ));


        $this->addElement('Radio', 'epetcre_pet_dline', array(
            'label' => 'Enable Petition Deadline',
            'description' => 'Do you want to allow users to enter deadline for the petitions at the time of creation?',
            'multiOptions' => array(
                1 => "Yes",
                0 => "No",
            ),
            'value' => $settings->getSetting('epetcre.pet.dline', 1),
        ));

/*        $this->addElement('Radio', 'epetcre_sponsored_by', array(
            'label' => 'Enable Sponsored By',
            'description' => 'Do you want to enable sponsored by field for the petitions on your website?',
            'multiOptions' => array(
                1 => "Yes",
                0 => "No",
            ),
            'value' => $settings->getSetting('epetcre.sponsored.by', 1),
        ));*/

        $this->addElement('Radio', 'epetcre_status_field', array(
            'label' => 'Enable Status field',
            'description' => 'Do you want to enable status field as published/draft for the petitions at the time of creation?',
            'multiOptions' => array(
                 1 => "Yes",
                 0 => "No",
            ),
            'value' => $settings->getSetting('epetcre.status.field', 1),
        ));


        $this->addElement('Radio', 'epetcre_people_search', array(
            'label' => 'Enable “People can search for this Petition” Field.',
            'description' => 'Do you want to enable “People can search for this Petition” field while creating and editing Petitions on your website?',
            'multiOptions' => array(
                1 => "Yes",
                0 => "No",
            ),
            'value' => $settings->getSetting('epetcre.people.search', 1),
        ));

        $this->addElement('Radio', 'epetcre_cre_guid', array(
            'label' => 'Petition Creation Guidelines',
            'description' => 'Do you want to provide Petitions owners with some Guidelines? If yes, then the box containing the guidelines will remain static on the top right of the create page when user scroll down the form.',
            'onchange' => 'changepetitioncreationguidelines();',
            'multiOptions' => array(
                1 => "Yes",
                0 => "No",
            ),
            'value' => $settings->getSetting('epetcre.cre.guid', 1),
        ));

        $this->addElement('textarea', 'epetcre_enter_guid', array(
            'label' => 'Enter Guidelines',
            'value' => $settings->getSetting('epetcre.enter.guid', ''),
        ));
        $this->addElement('Button', 'submit', array(
            'label' => 'Save Changes',
            'type' => 'submit',
            'ignore' => true
        ));
    }
}
