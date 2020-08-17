<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Global.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Setting')
        ->setDescription('These settings affect all members in your community.');
        
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "epetition_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('epetition.licensekey'),
    ));
    $this->getElement('epetition_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if ($settings->getSetting('epetition.pluginactivated')) {

      if(!$settings->getSetting('epetition.changelanding', 0))
        {
          $this->addElement('Radio', 'epetition_changelanding', array(
              'label' => 'Set Welcome Page as Landing Page',
              'description' => 'Do you want to set the Default Welcome Page of this plugin as Landing page of your website? [This is a one time setting, so if you choose ‘Yes’ and save changes, then later you can manually make changes in the Landing page from Layout Editor.',
              'multiOptions' => array(
                  1 => 'Yes',
                  0 => 'No',
              ),
              'value' => $settings->getSetting('epetition.changelanding', 0),
          ));
        }

        $this->addElement('text', 'epetition_text_singular', array(
            'label' => 'Singular Text for "Petition"',
            'description' => 'Enter the text which you want to show in place of "Petition" at various places in this plugin like activity feeds, etc.',
            'value' => $settings->getSetting('epetition.text.singular', 'petition'),
        ));


        $this->addElement('text', 'epetition_text_plural', array(
            'label' => 'Plural Text for "Petition"',
            'description' => 'Enter the text which you want to show in place of "Petitions" at various places in this plugin like search form, navigation menu, etc.',
            'value' => $settings->getSetting('epetition.text.plural', 'Petitions'),
        ));

        $this->addElement('text', 'epetition_petition_manifest', array(
            'label' => 'Singular "petition" Text in URL',
            'description' => 'Enter the text which you want to show in place of "petition" in the URLs of this plugin.',
            'value' => $settings->getSetting('epetition.petition.manifest', 'petition'),
        ));

        $this->addElement('text', 'epetition_manifest', array(
            'label' => 'Plural "petitions" Text in URL',
            'description' => 'Enter the text which you want to show in place of "petitions" in the URLs of this plugin.',
            'value' => $settings->getSetting('epetition.manifest', 'petitions'),
        ));

        $this->addElement('Radio', 'epetition_check_welcome', array(
            'label' => 'Welcome Page Visibility',
            'description' => 'Choose from below the users who will see the Welcome page of this plugin?',
            'multiOptions' => array(
                0 => 'Only logged in users',
                1 => 'Only non-logged in users',
                2 => 'Both, logged-in and non-logged in users',
            ),
            'value' => $settings->getSetting('epetition.check.welcome', 2),
        ));


        $this->addElement('Radio', 'epetition_enable_welcome', array(
          'label' => 'Petition Main Menu Redirection',
          'description' => 'Choose from below where do you want to redirect users when Petitions Menu item is clicked in the Main Navigation Menu Bar.',
          'multiOptions' => array(
              0 => 'Petition Home Page',
              2 => 'Petition Browse Page',
          ),
          'value' => $settings->getSetting('epetition.enable.welcome', 0),
       ));

        $this->addElement('Text', "epetition_mainheight", array(
          'label' => 'Large Photo Height',
          'description' => 'Enter the maximum height of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on "Petition View Page". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('epetition.mainheight', 1600),
        ));

        $this->addElement('Text', "epetition_mainwidth", array(
          'label' => 'Large Photo Width',
          'description' => 'Enter the maximum width of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on "Petition View Page". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('epetition.mainwidth', 1600),
         ));


        $this->addElement('Text', "epetition_normalheight", array(
          'label' => 'Medium Photo Height',
          'description' => "Enter the maximum height of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('epetition.normalheight', 500),
      ));
      $this->addElement('Text', "epetition_normalwidth", array(
          'label' => 'Medium Photo Width',
          'description' => "Enter the maximum width of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('epetition.normalwidth', 500),
      ));




//      $this->addElement('Radio', "epetition_other_modulepetitions", array(
//          'label' => 'Petitions Created in Content Visibility',
//          'description' => "Choose the visibility of the Petitions created in a content to only that content (module) or show in Home page, Browse page and other places of this plugin as well? (To enable users to create Petitions in a content or module, place the widget \"Content Profile Petitions\" on the profile page of the desired content.)",
//          'multiOptions' => array(
//               1 => 'Yes',
//               0 => 'No',
//          ),
//          'value' => $settings->getSetting('epetition.other.modulepetitions', 1),
//      ));




        //default photos  start
      $default_photos_main = array();
      $path = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
      foreach ($path as $file) {
        if ($file->isDot() || !$file->isFile())
          continue;
        $base_name = basename($file->getFilename());
        if (!($pos = strrpos($base_name, '.')))
          continue;
        $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
        if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png')))
          continue;
        $default_photos_main['public/admin/' . $base_name] = $base_name;
      }
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $fileLink = $view->baseUrl() . '/admin/files/';
      //petition main photo
      if (count($default_photos_main) > 0) {
        $default_photos = array_merge(array('application/modules/Epetition/externals/images/nophoto_petition_thumb_profile.png' => ''), $default_photos_main);
        $this->addElement('Select', 'epetition_default_photo', array(
            'label' => 'Main Default Photo for Petitions',
            'description' => 'Choose Main default photo for the petitions on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change petition default photo.]',
            'multiOptions' => $default_photos,
            'value' => $settings->getSetting('epetition.default.photo'),
        ));
      } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo in the File & Media Manager for the main photo. Please upload the Photo to be chosen for main photo from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section.') . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'epetition.default.photo', array(
            'label' => 'Main Default Photo for Petitions',
            'description' => $description,
        ));
      }

      //$this->epetition_default_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


     $this->addElement('Radio', 'epetition_enable_location', array(
          'label' => 'Enable Location',
          'description' => 'Do you want to enable location for petitions on your website?',
          'multiOptions' => array(
               1 => 'Yes,Enable Location',
               0 => 'No,Don\'t Enable Location',
          ),
          'onchange'=>'changeenablelocation()',
          'value' => $settings->getSetting('epetition.enable.location', 1),
      ));


       $this->addElement('Radio', 'epetition_search_type', array(
          'label' => 'Proximity Search Unit',
          'description' => 'Choose the unit for proximity search of location of petitions on your website.',
          'multiOptions' => array(
              1 => 'Miles',
              0 => 'Kilometres'
          ),
          'value' => $settings->getSetting('epetition.search.type', 1),
      ));


        $this->addElement('Radio', 'epetition_signlimit', array(
          'label' => 'Add Signature Limit Authority',
          'description' => 'Whom do you want to give authority to add signature limit for the petition created on your website?',
          'multiOptions' => array(
              1 => 'Petition Owner',
              2 => 'Decision Makers',
              3=>  'Both',
          ),
          'value' => $settings->getSetting('epetition.signlimit', 3),
      ));


      $this->addElement('Text', "epetition_normalheight", array(
        'label' => 'Medium Photo Height',
        'description' => "Enter the maximum height of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]",
        'allowEmpty' => true,
        'required' => false,
        'value' => $settings->getSetting('epetition.normalheight', 500),
      ));

        $this->addElement('Radio', 'epetition_enb_reason', array(
                'label' => 'Enable Reasons',
                'description' => 'Do you want to allow users to add reason for the submission of signatures on the petitions?',
                'multiOptions' => array(
                    1 => 'Yes',
                    0 => 'No',
                ),
                'value' => $settings->getSetting('epetition.enb.reason',1),
                'onchange'=>'changeReasonsMandatory()',
            )
        );

      $this->addElement('Radio', 'epetition_reason_man', array(
          'label' => 'Make Reasons Mandatory',
          'description' => 'Do you want to make Reasons field mandatory when users create or edit their signatures?',
          'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
          ),
          'value' => $settings->getSetting('epetition.reason.man',1),
        )
      );


      $this->addElement('Radio', 'epetition_enb_supt', array(
                'label' => 'Enable Support Statement',
                'description' => 'Do you want to allow users to add support statement for the submission of signatures on the petitions?',
                'multiOptions' => array(
                    1 => 'Yes',
                    0 => 'No',
                   ),
                'value' => $settings->getSetting('epetition.enb.supt',1),
                'onchange'=>'changeSupportMandatory()',
            )
        );

      $this->addElement('Radio', 'epetition_supt_man', array(
          'label' => 'Make Support Statement Mandatory',
          'description' => 'Do you want to make Reasons field mandatory when users create or edit their signatures?',
          'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
          ),
          'value' => $settings->getSetting('epetition.supt.man',1),
        )
      );

      $this->addElement('Radio', 'epetition_enb_loc', array(
          'label' => 'Enable Signature Location',
          'description' => 'Do you want to allow users to add location for the submission of signatures on the petitions?',
          'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
          ),
          'value' => $settings->getSetting('epetition.enb.loc',1),
          'onchange'=>'changeLocationMandatory()',
        )
      );
      $this->addElement('Radio', 'epetition_loc_man', array(
          'label' => 'Make Location Mandatory',
          'description' => 'Do you want to make location field mandatory when users create or edit their signatures?',
          'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
          ),
          'value' => $settings->getSetting('epetition.loc.man',1),
        )
      );


        $this->addElement('Radio', 'epetition_enable_favourite', array(
                'label' => 'Allow to Favourite Petitions',
                'description' => 'Do you want to allow users to favourite petitions on your website?',
                'multiOptions' => array(
                     1 => 'Yes',
                     0 => 'No',
                ),
                'value' => $settings->getSetting('epetition.enable.favourite',1),
            )
        );


//        $this->addElement('Radio', 'epetition_boe_spons', array(
//                'label' => 'Allow to Bounce Marker for Sponsored Petitions',
//                'description' => 'Do you want to allow marker to bounce for sponsored petitions on your website?',
//                'multiOptions' => array(
//                     1 => 'Yes',
//                     0 => 'No',
//                ),
//               'value' => $settings->getSetting('epetition.boe.spons',1),
//            )
//        );


        $this->addElement('Radio', 'epetition_allow_report', array(
                'label' => 'Allow to Report Petitions',
                'description' => 'Do you want to allow users to report petitions on your website?',
                'multiOptions' => array(
                     1 => 'Yes',
                     0 => 'No',
                ),
                'value' => $settings->getSetting('epetition.allow.report',1),
            )
        );


        $this->addElement('Radio', 'epetition_share_pet', array(
                'label' => 'Allow to Share Petitions',
                'description' => 'Do you want to allow users to share Petitions on your website?',
                'multiOptions' => array(
                     1 => 'Yes',
                     0 => 'No',
                ),
                'value' => $settings->getSetting('epetition.share.pet',1),
            )
        );

        $this->addElement('Select', 'epetition_item_count', array(
            'label' => 'Menu Items Count in Main Navigation',
            'description' => 'How many menu items do you want to show in the Main Navigation Menu of this plugin?',
            'multiOptions' => array(
              0 => 0,
              1 => 1,
              2 => 2,
              3 => 3,
              4 => 4,
              5 => 5,
              6 => 6,
              7 => 7,
              8 => 8,
              9 => 9,
              ),
             'value' => $settings->getSetting('epetition.item.count',6),
        ));

        // Add submit button
        $this->addElement('Button', 'submit', array(
            'label' => 'Save Changes',
            'type' => 'submit',
            'ignore' => true
        ));
    } else {
      //Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Activate Your Plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }
}
