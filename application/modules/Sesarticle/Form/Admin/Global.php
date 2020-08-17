<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesarticle_Form_Admin_Global extends Engine_Form {

  public function init() {

    $this
            ->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesarticle_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesarticle.licensekey'),
    ));
    $this->getElement('sesarticle_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sesarticle.pluginactivated')) {

      if (!$settings->getSetting('sesarticle.changelanding', 0)) {
        $this->addElement('Radio', 'sesarticle_changelanding', array(
            'label' => 'Set Welcome Page as Landing Page',
            'description' => 'Do you want to set the Default Welcome Page of this plugin as Landing page of your website? [This is a one time setting, so if you choose ‘Yes’ and save changes, then later you can manually make changes in the Landing page from Layout Editor.]',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => $settings->getSetting('sesarticle.changelanding', 0),
        ));
      }

      $this->addElement('Radio', 'sesarticle_subscription', array(
          'label' => 'Enable Subscription',
          'description' => 'Do you want to allow users to subscribe article owners? If you choose Yes, then members will get notifications when new articles are posted by members they have subscribed.',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesarticle.subscription', 0),
      ));

      $this->addElement('Text', 'sesarticle_text_singular', array(
          'label' => 'Singular Text for "Article"',
          'description' => 'Enter the text which you want to show in place of "Article" at various places in this plugin like activity feeds, etc.',
          'value' => $settings->getSetting('sesarticle.text.singular', 'article'),
      ));

      $this->addElement('Text', 'sesarticle_text_plural', array(
          'label' => 'Plural Text for "Article"',
          'description' => 'Enter the text which you want to show in place of "Articles" at various places in this plugin like search form, navigation menu, etc.',
          'value' => $settings->getSetting('sesarticle.text.plural', 'articles'),
      ));

      $this->addElement('Text', 'sesarticle_article_manifest', array(
          'label' => 'Singular "article" Text in URL',
          'description' => 'Enter the text which you want to show in place of "article" in the URLs of this plugin.',
          'value' => $settings->getSetting('sesarticle.article.manifest', 'article'),
      ));

      $this->addElement('Text', 'sesarticle_articles_manifest', array(
          'label' => 'Plural "articles" Text in URL',
          'description' => 'Enter the text which you want to show in place of "articles" in the URLs of this plugin.',
          'value' => $settings->getSetting('sesarticle.articles.manifest', 'articles'),
      ));

      $this->addElement('Radio', 'sesarticle_check_welcome', array(
          'label' => 'Welcome Page Visibility',
          'description' => 'Choose from below the users who will see the Welcome page of this plugin?',
          'multiOptions' => array(
              0 => 'Only logged in users',
              1 => 'Only non-logged in users',
              2 => 'Both, logged-in and non-logged in users',
          ),
          'value' => $settings->getSetting('sesarticle.check.welcome', 2),
      ));

      $this->addElement('Radio', 'sesarticle_enable_welcome', array(
          'label' => 'Article Main Menu Redirection',
          'description' => 'Choose from below where do you want to redirect users when Articles Menu item is clicked in the Main Navigation Menu Bar.',
          'multiOptions' => array(
              1 => 'Article Welcome Page',
              0 => 'Article Home Page',
              2 => 'Article Browse Page',
          ),
          'value' => $settings->getSetting('sesarticle.enable.welcome', 1),
      ));
      $this->addElement('Radio', 'sesarticle_redirect_creation', array(
          'label' => 'Redirection After Article Creation',
          'description' => 'Choose from below where do you want to redirect users after a article is successfully created.',
          'multiOptions' => array('1' => 'On Article Dashboard Page', '0' => 'On Article Profile Page'),
          'value' => $settings->getSetting('sesarticle.redirect.creation', 0),
      ));



      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $this->addElement('Radio', 'sesarticle_watermark_enable', array(
          'label' => 'Add Watermark to Photos',
          'description' => 'Do you want to add watermark to photos (from this plugin) on your website? If you choose Yes, then you can upload watermark image to be added to the photos from the <a href="' . $view->baseUrl() . "/admin/sesarticle/level" . '">Member Level Settings</a>.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onclick' => 'show_position(this.value)',
          'value' => $settings->getSetting('sesarticle.watermark.enable', 0),
      ));
      $this->addElement('Select', 'sesarticle_position_watermark', array(
          'label' => 'Watermark Position',
          'description' => 'Choose the position for the watermark.',
          'multiOptions' => array(
              0 => 'Middle ',
              1 => 'Top Left',
              2 => 'Top Right',
              3 => 'Bottom Right',
              4 => 'Bottom Left',
              5 => 'Top Middle',
              6 => 'Middle Right',
              7 => 'Bottom Middle',
              8 => 'Middle Left',
          ),
          'value' => $settings->getSetting('sesarticle.position.watermark', 0),
      ));
      $this->sesarticle_watermark_enable->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Text', "sesarticle_mainheight", array(
          'label' => 'Large Photo Height',
          'description' => 'Enter the maximum height of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on "Article Photo View Page". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesarticle.mainheight', 1600),
      ));
      $this->addElement('Text', "sesarticle_mainwidth", array(
          'label' => 'Large Photo Width',
          'description' => 'Enter the maximum width of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on "Article Photo View Page". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesarticle.mainwidth', 1600),
      ));
      $this->addElement('Text', "sesarticle_normalheight", array(
          'label' => 'Medium Photo Height',
          'description' => "Enter the maximum height of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesarticle.normalheight', 500),
      ));
      $this->addElement('Text', "sesarticle_normalwidth", array(
          'label' => 'Medium Photo Width',
          'description' => "Enter the maximum width of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesarticle.normalwidth', 500),
      ));


      $this->addElement('Radio', "sesarticle_other_modulearticles", array(
          'label' => 'Articles Created in Content Visibility',
          'description' => "Choose the visibility of the articles created in a content to only that content (module) or show in Home page, Browse page and other places of this plugin as well? (To enable users to create articles in a content or module, place the widget \"Content Profile Articles\" on the profile page of the desired content.)",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesarticle.other.modulearticles', 1),
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
      //article main photo
      if (count($default_photos_main) > 0) {
        $default_photos = array_merge(array('application/modules/Sesarticle/externals/images/nophoto_article_thumb_profile.png' => ''), $default_photos_main);
        $this->addElement('Select', 'sesarticle_default_photo', array(
            'label' => 'Main Default Photo for Articles',
            'description' => 'Choose Main default photo for the articles on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change article default photo.]',
            'multiOptions' => $default_photos,
            'value' => $settings->getSetting('sesarticle.article.default.photo'),
        ));
      } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo in the File & Media Manager for the main photo. Please upload the Photo to be chosen for main photo from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section.') . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'sesarticle_default_photo', array(
            'label' => 'Main Default Photo for Articles',
            'description' => $description,
        ));
      }
      $this->sesarticle_default_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Radio', 'sesarticle_enable_location', array(
          'label' => 'Enable Location',
          'description' => 'Do you want to enable location for articles on your website?',
          'multiOptions' => array(
              '1' => 'Yes,Enable Location',
              '0' => 'No,Don\'t Enable Location',
          ),
          'onclick' => 'showSearchType(this.value)',
          'value' => $settings->getSetting('sesarticle.enable.location', 1),
      ));

      $this->addElement('Radio', 'sesarticle_search_type', array(
          'label' => 'Proximity Search Unit',
          'description' => 'Choose the unit for proximity search of location of articles on your website.',
          'multiOptions' => array(
              1 => 'Miles',
              0 => 'Kilometres'
          ),
          'value' => $settings->getSetting('sesarticle.search.type', 1),
      ));

      $this->addElement('Radio', 'sesarticle_start_date', array(
          'label' => 'Enable Custom Article Publish Date',
          'description' => 'Do you want to allow users to choose a custom publish date for their articles. If you choose Yes, then articles on your website will display in activity feeds, various pages and widgets on their publish dates.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => $settings->getSetting('sesarticle.start.date', 1),
      ));
			$this->addElement('Radio', 'sesarticle_login_continuereading', array(
          'label' => 'Continue Reading Button Redirection for Non-logged in Users',
          'description' => 'Do you want to redirect non-logged in users to the login page of your website when they click on "Continue Reading" button on Article view pages? If you choose No, then users can see Full Article at the same page.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => $settings->getSetting('sesarticle.login.continuereading', 1),
      ));
			

      $this->addElement('Radio', 'sesarticle_category_enable', array(
          'label' => 'Make Article Categories Mandatory',
          'description' => 'Do you want to make category field mandatory when users create or edit their articles?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesarticle.category.enable', 1),
      ));
      $this->addElement('Radio', 'sesarticle_description_mandatory', array(
          'label' => 'Make Article Description Mandatory',
          'description' => 'Do you want to make description field mandatory when users create or edit their articles?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesarticle.description.mandatory', 1),
      ));
      $this->addElement('Radio', 'sesarticle_photo_mandatory', array(
          'label' => 'Make Article Main Photo Mandatory',
          'description' => 'Do you want to make main photo field mandatory when users create or edit their articles?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesarticle.photo.mandatory', 1),
      ));

      $this->addElement('Radio', 'sesarticle_enable_subarticle', array(
          'label' => 'Allow to create Sub Articles',
          'description' => 'Do you want to allow users to create sub articles on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesarticle.enable.subarticle', 1),
      ));

      $this->addElement('Radio', 'sesarticle_enable_favourite', array(
          'label' => 'Allow to Favourite Articles',
          'description' => 'Do you want to allow users to favourite articles on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesarticle.enable.favourite', 1),
      ));

      $this->addElement('Radio', 'sesarticle_enable_bounce', array(
          'label' => 'Allow to Bounce Marker for Sponsored Articles',
          'description' => 'Do you want to allow maker to bounce for sponsored articles on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesarticle.enable.bounce', 1),
      ));

      $this->addElement('Radio', 'sesarticle_enable_report', array(
          'label' => 'Allow to Report Articles',
          'description' => 'Do you want to allow users to report articles on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesarticle.enable.report', 1),
      ));

      $this->addElement('Radio', 'sesarticle_enable_sharing', array(
          'label' => 'Allow to Share Articles',
          'description' => 'Do you want to allow users to share articles on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesarticle.enable.sharing', 1),
      ));

      $this->addElement('Radio', 'sesarticle_enable_claim', array(
          'label' => 'Allow to Claim Articles',
          'description' => 'Do you want to allow users to claim articles on their website as their articles?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesarticle.enable.claim', 1),
      ));

      $this->addElement('Select', 'sesarticle_taboptions', array(
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
          'value' => $settings->getSetting('sesarticle.taboptions', 6),
      ));

      $this->addElement('Select', 'sesarticle_enablearticledesignview', array(
          'label' => 'Enable Article Profile Views',
          'description' => 'Do you want to enable users to choose views for their Articles? (If you choose No, then you can choose a default layout for the Article Profile pages on your website.)',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'onchange' => "enablearticledesignview(this.value)",
          'value' => $settings->getSetting('sesarticle.enablearticledesignview', 1),
      ));

      $chooselayout = $settings->getSetting('sesarticle.chooselayout', serialize(array(0 => 1, 1 => 2, 2 => 3, 3 => 4)));

      $chooselayoutVal = unserialize($chooselayout);

      $this->addElement('MultiCheckbox', 'sesarticle_chooselayout', array(
          'label' => 'Choose Article Profile Pages',
          'description' => 'Choose layout for the article profile pages which will be available to users while creating or editing their articles.',
          'multiOptions' => array(
              1 => 'Design 1',
              2 => 'Design 2',
              3 => 'Design 3',
              4 => 'Design 4',
          ),
          'value' => $chooselayoutVal,
      ));

      $this->addElement('Radio', 'sesarticle_defaultlayout', array(
          'label' => 'Default Article Profile Page',
          'description' => 'Choose default layout for the article profile pages.',
          'multiOptions' => array(
              1 => 'Design 1',
              2 => 'Design 2',
              3 => 'Design 3',
              4 => 'Design 4',
          ),
          'value' => $settings->getSetting('sesarticle.defaultlayout', 1),
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
