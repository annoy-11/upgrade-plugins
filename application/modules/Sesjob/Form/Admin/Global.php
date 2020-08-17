<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesjob_Form_Admin_Global extends Engine_Form {

  public function init() {

    $this
            ->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesjob_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesjob.licensekey'),
    ));
    $this->getElement('sesjob_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    if ($settings->getSetting('sesjob.pluginactivated')) {

      $this->addElement('Radio', 'sesjob_company', array(
          'label' => 'Enable Company',
          'description' => 'Do you want to allow users to enter company information when post job?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.company', 1),
      ));

      $this->addElement('Radio', 'sesjob_subscription', array(
          'label' => 'Enable Subscription',
          'description' => 'Do you want to allow users to subscribe company? If you choose Yes, then members will get notifications when new jobs are posted by company they have subscribed.',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.subscription', 0),
      ));

      $this->addElement('Text', 'sesjob_text_singular', array(
          'label' => 'Singular Text for "Job"',
          'description' => 'Enter the text which you want to show in place of "Job" at various places in this plugin like activity feeds, etc.',
          'value' => $settings->getSetting('sesjob.text.singular', 'job'),
      ));

      $this->addElement('Text', 'sesjob_text_plural', array(
          'label' => 'Plural Text for "Job"',
          'description' => 'Enter the text which you want to show in place of "Jobs" at various places in this plugin like search form, navigation menu, etc.',
          'value' => $settings->getSetting('sesjob.text.plural', 'jobs'),
      ));

      $this->addElement('Text', 'sesjob_job_manifest', array(
          'label' => 'Singular "job" Text in URL',
          'description' => 'Enter the text which you want to show in place of "job" in the URLs of this plugin.',
          'value' => $settings->getSetting('sesjob.job.manifest', 'job'),
      ));

      $this->addElement('Text', 'sesjob_jobs_manifest', array(
          'label' => 'Plural "jobs" Text in URL',
          'description' => 'Enter the text which you want to show in place of "jobs" in the URLs of this plugin.',
          'value' => $settings->getSetting('sesjob.jobs.manifest', 'jobs'),
      ));

//       $this->addElement('Radio', 'sesjob_check_welcome', array(
//           'label' => 'Welcome Page Visibility',
//           'description' => 'Choose from below the users who will see the Welcome page of this plugin?',
//           'multiOptions' => array(
//               0 => 'Only logged in users',
//               1 => 'Only non-logged in users',
//               2 => 'Both, logged-in and non-logged in users',
//           ),
//           'value' => $settings->getSetting('sesjob.check.welcome', 2),
//       ));

      $this->addElement('Radio', 'sesjob_enable_welcome', array(
          'label' => 'Job Main Menu Redirection',
          'description' => 'Choose from below where do you want to redirect users when Jobs Menu item is clicked in the Main Navigation Menu Bar.',
          'multiOptions' => array(
              0 => 'Job Home Page',
              2 => 'Job Browse Page',
          ),
          'value' => $settings->getSetting('sesjob.enable.welcome', 0),
      ));
      $this->addElement('Radio', 'sesjob_redirect_creation', array(
          'label' => 'Redirection After Job Creation',
          'description' => 'Choose from below where do you want to redirect users after a job is successfully created.',
          'multiOptions' => array('1' => 'On Job Dashboard Page', '0' => 'On Job Profile Page'),
          'value' => $settings->getSetting('sesjob.redirect.creation', 0),
      ));



      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
//       $this->addElement('Radio', 'sesjob_watermark_enable', array(
//           'label' => 'Add Watermark to Photos',
//           'description' => 'Do you want to add watermark to photos (from this plugin) on your website? If you choose Yes, then you can upload watermark image to be added to the photos from the <a href="' . $view->baseUrl() . "/admin/sesjob/level" . '">Member Level Settings</a>.',
//           'multiOptions' => array(
//               1 => 'Yes',
//               0 => 'No'
//           ),
//           'onclick' => 'show_position(this.value)',
//           'value' => $settings->getSetting('sesjob.watermark.enable', 0),
//       ));
//       $this->addElement('Select', 'sesjob_position_watermark', array(
//           'label' => 'Watermark Position',
//           'description' => 'Choose the position for the watermark.',
//           'multiOptions' => array(
//               0 => 'Middle ',
//               1 => 'Top Left',
//               2 => 'Top Right',
//               3 => 'Bottom Right',
//               4 => 'Bottom Left',
//               5 => 'Top Middle',
//               6 => 'Middle Right',
//               7 => 'Bottom Middle',
//               8 => 'Middle Left',
//           ),
//           'value' => $settings->getSetting('sesjob.position.watermark', 0),
//       ));
//       $this->sesjob_watermark_enable->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


      $this->addElement('Radio', "sesjob_other_modulejobs", array(
          'label' => 'Jobs Created in Content Visibility',
          'description' => "Choose the visibility of the jobs created in a content to only that content (module) or show in Home page, Browse page and other places of this plugin as well? (To enable users to create jobs in a content or module, place the widget \"Content Profile Jobs\" on the profile page of the desired content.)",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesjob.other.modulejobs', 1),
      ));

      //default photos
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
      //job main photo
      if (count($default_photos_main) > 0) {
        $default_photos = array_merge(array('application/modules/Sesjob/externals/images/nophoto_job_thumb_profile.png' => ''), $default_photos_main);
        $this->addElement('Select', 'sesjob_job_default_photo', array(
            'label' => 'Main Default Photo for Jobs',
            'description' => 'Choose Main default photo for the jobs on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change job default photo.]',
            'multiOptions' => $default_photos,
            'value' => $settings->getSetting('sesjob.job.default.photo'),
        ));
      } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo in the File & Media Manager for the main photo. Please upload the Photo to be chosen for main photo from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section.') . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'sesjob_job_default_photo', array(
            'label' => 'Main Default Photo for Jobs',
            'description' => $description,
        ));
      }
      $this->sesjob_job_default_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Radio', 'sesjob_enable_location', array(
          'label' => 'Enable Location',
          'description' => 'Do you want to enable location for jobs on your website?',
          'multiOptions' => array(
              '1' => 'Yes,Enable Location',
              '0' => 'No,Don\'t Enable Location',
          ),
          'onclick' => 'showSearchType(this.value)',
          'value' => $settings->getSetting('sesjob.enable.location', 1),
      ));

      $this->addElement('Radio', 'sesjob_search_type', array(
          'label' => 'Proximity Search Unit',
          'description' => 'Choose the unit for proximity search of location of jobs on your website.',
          'multiOptions' => array(
              1 => 'Miles',
              0 => 'Kilometres'
          ),
          'value' => $settings->getSetting('sesjob.search.type', 1),
      ));

      $this->addElement('Radio', 'sesjob_start_date', array(
          'label' => 'Enable Custom Job Publish Date',
          'description' => 'Do you want to allow users to choose a custom publish date for their jobs. If you choose Yes, then jobs on your website will display in activity feeds, various pages and widgets on their publish dates.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => $settings->getSetting('sesjob.start.date', 1),
      ));

      $this->addElement('Radio', 'sesjob_category_enable', array(
          'label' => 'Make Job Categories Mandatory',
          'description' => 'Do you want to make category field mandatory when users create or edit their jobs?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesjob.category.enable', 1),
      ));
      $this->addElement('Radio', 'sesjob_description_mandatory', array(
          'label' => 'Make Job Description Mandatory',
          'description' => 'Do you want to make description field mandatory when users create or edit their jobs?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesjob.description.mandatory', 1),
      ));
      $this->addElement('Radio', 'sesjob_photo_mandatory', array(
          'label' => 'Make Job Main Photo Mandatory',
          'description' => 'Do you want to make main photo field mandatory when users create or edit their jobs?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesjob.photo.mandatory', 1),
      ));

      $this->addElement('Radio', 'sesjob_enable_favourite', array(
          'label' => 'Allow to Favourite Jobs',
          'description' => 'Do you want to allow users to favourite jobs on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesjob.enable.favourite', 1),
      ));

      $this->addElement('Radio', 'sesjob_enable_bounce', array(
          'label' => 'Allow to Bounce Marker for Sponsored Jobs',
          'description' => 'Do you want to allow maker to bounce for sponsored jobs on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesjob.enable.bounce', 1),
      ));

      $this->addElement('Radio', 'sesjob_enable_report', array(
          'label' => 'Allow to Report Jobs',
          'description' => 'Do you want to allow users to report jobs on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesjob.enable.report', 1),
      ));

      $this->addElement('Radio', 'sesjob_enable_sharing', array(
          'label' => 'Allow to Share Jobs',
          'description' => 'Do you want to allow users to share jobs on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesjob.enable.sharing', 1),
      ));

      $this->addElement('Select', 'sesjob_taboptions', array(
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
          'value' => $settings->getSetting('sesjob.taboptions', 6),
      ));


      $this->addElement('Text', 'sesjob_expirationtime', array(
          'label' => 'Job Expiration Time',
          'description' => 'Enter the number of days that you want to expire job created by members using this plugin.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sesjob.expirationtime', '30'),
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
