<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Form_Admin_Global extends Engine_Form
{
  public function init()
  {

    $this
      ->setTitle('Global Settings')
      ->setDescription('These settings affect all members in your community.');

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesrecipe_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesrecipe.licensekey'),
    ));
    $this->getElement('sesrecipe_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if ($settings->getSetting('sesrecipe.pluginactivated')) {

      if(!$settings->getSetting('sesrecipe.changelanding', 0)) {
        $this->addElement('Radio', 'sesrecipe_changelanding', array(
          'label' => 'Set Welcome Page as Landing Page',
          'description' => 'Do you want to set the Default Welcome Page of this plugin as Landing page of your website? [This is a one time setting, so if you choose ‘Yes’ and save changes, then later you can manually make changes in the Landing page from Layout Editor.]',
          'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
          ),
        'value' => $settings->getSetting('sesrecipe.changelanding', 0),
        ));
      }

      $this->addElement('Radio', 'sesrecipe_subscription', array(
        'label' => 'Enable Subscription',
        'description' => 'Do you want to allow users to subscribe recipe owners? If you choose Yes, then members will get notifications when new recipes are posted by members they have subscribed.',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
      'value' => $settings->getSetting('sesrecipe.subscription', 0),
      ));

      $this->addElement('Text', 'sesrecipe_text_singular', array(
        'label' => 'Singular Text for "Recipe"',
        'description' => 'Enter the text which you want to show in place of "Recipe" at various places in this plugin like activity feeds, etc.',
        'value' => $settings->getSetting('sesrecipe.text.singular', 'recipe'),
      ));

      $this->addElement('Text', 'sesrecipe_text_plural', array(
        'label' => 'Plural Text for "Recipe"',
        'description' => 'Enter the text which you want to show in place of "Recipes" at various places in this plugin like search form, navigation menu, etc.',
        'value' => $settings->getSetting('sesrecipe.text.plural', 'recipes'),
      ));

      $this->addElement('Text', 'sesrecipe_recipe_manifest', array(
        'label' => 'Singular "recipe" Text in URL',
        'description' => 'Enter the text which you want to show in place of "recipe" in the URLs of this plugin.',
        'value' => $settings->getSetting('sesrecipe.recipe.manifest', 'recipe'),
      ));

      $this->addElement('Text', 'sesrecipe_recipes_manifest', array(
        'label' => 'Plural "recipes" Text in URL',
        'description' => 'Enter the text which you want to show in place of "recipes" in the URLs of this plugin.',
        'value' => $settings->getSetting('sesrecipe.recipes.manifest', 'recipes'),
      ));

      $this->addElement('Radio', 'sesrecipe_check_welcome', array(
          'label' => 'Welcome Page Visibility',
          'description' => 'Choose from below the users who will see the Welcome page of this plugin?',
          'multiOptions' => array(
              0 => 'Only logged in users',
              1 => 'Only non-logged in users',
              2 => 'Both, logged-in and non-logged in users',
          ),
          'value' => $settings->getSetting('sesrecipe.check.welcome', 2),
      ));

      $this->addElement('Radio', 'sesrecipe_enable_welcome', array(
        'label' => 'Recipe Main Menu Redirection',
        'description' => 'Choose from below where do you want to redirect users when Recipes Menu item is clicked in the Main Navigation Menu Bar.',
        'multiOptions' => array(
          1 => 'Recipe Welcome Page',
          0 => 'Recipe Home Page',
          2 => 'Recipe Browse Page',
        ),
        'value' => $settings->getSetting('sesrecipe.enable.welcome', 1),
      ));
      $this->addElement('Radio', 'sesrecipe_redirect_creation', array(
          'label' => 'Redirection After Recipe Creation',
          'description' => 'Choose from below where do you want to redirect users after a recipe is successfully created.',
          'multiOptions' => array('1'=>'On Recipe Dashboard Page','0'=>'On Recipe Profile Page'),
          'value' => $settings->getSetting('sesrecipe.redirect.creation', 1),
      ));



      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $this->addElement('Radio', 'sesrecipe_watermark_enable', array(
          'label' => 'Add Watermark to Photos',
          'description' => 'Do you want to add watermark to photos (from this plugin) on your website? If you choose Yes, then you can upload watermark image to be added to the photos from the <a href="' . $view->baseUrl() . "/admin/sesrecipe/level" . '">Member Level Settings</a>.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onclick' => 'show_position(this.value)',
          'value' => $settings->getSetting('sesrecipe.watermark.enable', 0),
      ));
      $this->addElement('Select', 'sesrecipe_position_watermark', array(
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
          'value' => $settings->getSetting('sesrecipe.position.watermark', 0),
      ));
      $this->sesrecipe_watermark_enable->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Text', "sesrecipe_mainheight", array(
          'label' => 'Large Photo Height',
          'description' => 'Enter the maximum height of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on "Recipe Photo View Page". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesrecipe.mainheight', 1600),
      ));
      $this->addElement('Text', "sesrecipe_mainwidth", array(
          'label' => 'Large Photo Width',
          'description' => 'Enter the maximum width of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on "Recipe Photo View Page". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesrecipe.mainwidth', 1600),
      ));
      $this->addElement('Text', "sesrecipe_normalheight", array(
          'label' => 'Medium Photo Height',
          'description' => "Enter the maximum height of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesrecipe.normalheight', 500),
      ));
      $this->addElement('Text', "sesrecipe_normalwidth", array(
          'label' => 'Medium Photo Width',
          'description' => "Enter the maximum width of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesrecipe.normalwidth', 500),
      ));

      $this->addElement('Radio', "sesrecipe_other_modulerecipes", array(
        'label' => 'Recipes Created in Content Visibility',
        'description' => "Choose the visibility of the recipes created in a content to only that content (module) or show in Home page, Browse page and other places of this plugin as well? (To enable users to create recipes in a content or module, place the widget \"Content Profile Recipes\" on the profile page of the desired content.)",
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesrecipe.other.modulerecipes', 1),
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
      //recipe main photo
      if (count($default_photos_main) > 0) {
        $default_photos = array_merge(array('application/modules/Sesrecipe/externals/images/nophoto_recipe_thumb_profile.png'=>''),$default_photos_main);
        $this->addElement('Select', 'sesrecipe_recipe_default_photo', array(
            'label' => 'Main Default Photo for Recipes',
            'description' => 'Choose Main default photo for the recipes on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change recipe default photo.]',
            'multiOptions' => $default_photos,
            'value' => $settings->getSetting('sesrecipe.recipe.default.photo'),
        ));
      } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo in the File & Media Manager for the main photo. Please upload the Photo to be chosen for main photo from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section.') . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'sesrecipe_recipe_default_photo', array(
            'label' => 'Main Default Photo for Recipes',
            'description' => $description,
        ));
      }
      $this->sesrecipe_recipe_default_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Radio', 'sesrecipe_enable_location', array(
        'label' => 'Enable Location',
        'description' => 'Do you want to enable location for recipes on your website?',
        'multiOptions' => array(
          '1' => 'Yes,Enable Location',
          '0' => 'No,Don\'t Enable Location',
        ),
        'onclick' => 'showSearchType(this.value)',
        'value' => $settings->getSetting('sesrecipe.enable.location', 1),
      ));

      $this->addElement('Radio', 'sesrecipe_search_type', array(
        'label' => 'Proximity Search Unit',
        'description' => 'Choose the unit for proximity search of location of recipes on your website.',
        'multiOptions' => array(
          1 => 'Miles',
          0 => 'Kilometres'
        ),
        'value' => $settings->getSetting('sesrecipe.search.type', 1),
      ));

      $this->addElement('Radio', 'sesrecipe_start_date', array(
        'label' => 'Enable Custom Recipe Publish Date',
        'description' => 'Do you want to allow users to choose a custom publish date for their recipes. If you choose Yes, then recipes on your website will display in activity feeds, various pages and widgets on their publish dates.',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No',
        ),
        'value' => $settings->getSetting('sesrecipe.start.date', 1),
      ));

      $this->addElement('Radio', 'sesrecipe_category_enable', array(
            'label' => 'Make Recipe Categories Mandatory',
            'description' => 'Do you want to make category field mandatory when users create or edit their recipes?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'value' => $settings->getSetting('sesrecipe.category.enable', 1),
        ));
      $this->addElement('Radio', 'sesrecipe_description_mandatory', array(
            'label' => 'Make Recipe Description Mandatory',
            'description' => 'Do you want to make description field mandatory when users create or edit their recipes?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'value' => $settings->getSetting('sesrecipe.description.mandatory', 1),
        ));
      $this->addElement('Radio', 'sesrecipe_photo_mandatory', array(
        'label' => 'Make Recipe Main Photo Mandatory',
        'description' => 'Do you want to make main photo field mandatory when users create or edit their recipes?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sesrecipe.photo.mandatory', 1),
      ));

      $this->addElement('Radio', 'sesrecipe_enable_subrecipe', array(
        'label' => 'Allow to create Sub Recipes',
        'description' => 'Do you want to allow users to create sub recipes on your website?',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => $settings->getSetting('sesrecipe.enable.subrecipe', 1),
      ));

      $this->addElement('Radio', 'sesrecipe_enable_favourite', array(
        'label' => 'Allow to Favourite Recipes',
        'description' => 'Do you want to allow users to favourite recipes on your website?',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => $settings->getSetting('sesrecipe.enable.favourite', 1),
      ));

      $this->addElement('Radio', 'sesrecipe_enable_bounce', array(
        'label' => 'Allow to Bounce Marker for Sponsored Recipes',
        'description' => 'Do you want to allow maker to bounce for sponsored recipes on your website?',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => $settings->getSetting('sesrecipe.enable.bounce', 1),
      ));

      $this->addElement('Radio', 'sesrecipe_enable_report', array(
        'label' => 'Allow to Report Recipes',
        'description' => 'Do you want to allow users to report recipes on your website?',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => $settings->getSetting('sesrecipe.enable.report', 1),
      ));

      $this->addElement('Radio', 'sesrecipe_enable_sharing', array(
        'label' => 'Allow to Share Recipes',
        'description' => 'Do you want to allow users to share recipes on your website?',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => $settings->getSetting('sesrecipe.enable.sharing', 1),
      ));

      $this->addElement('Radio', 'sesrecipe_enable_claim', array(
        'label' => 'Allow to Claim Recipes',
        'description' => 'Do you want to allow users to claim recipes on their website as their recipes?',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => $settings->getSetting('sesrecipe.enable.claim', 1),
      ));

      $this->addElement('Select', 'sesrecipe_taboptions', array(
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
        'value' => $settings->getSetting('sesrecipe.taboptions', 6),
      ));

      $this->addElement('Select', 'sesrecipe_enablerecipedesignview', array(
        'label' => 'Enable Recipe Profile Views',
        'description' => 'Do you want to enable users to choose views for their Recipes? (If you choose No, then you can choose a default layout for the Recipe Profile pages on your website.)',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No',
        ),
        'onchange' => "enablerecipedesignview(this.value)",
        'value' => $settings->getSetting('sesrecipe.enablerecipedesignview', 1),
      ));

      $chooselayout = $settings->getSetting('sesrecipe.chooselayout', 'a:4:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";}');
      $chooselayoutVal = unserialize($chooselayout);

			$this->addElement('MultiCheckbox', 'sesrecipe_chooselayout', array(
        'label' => 'Choose Recipe Profile Pages',
        'description' => 'Choose layout for the recipe profile pages which will be available to users while creating or editing their recipes.',
        'multiOptions' => array(
          1 => 'Design 1',
          2 => 'Design 2',
          3 => 'Design 3',
          4 => 'Design 4',
        ),
        'value' => $chooselayoutVal,
      ));

			$this->addElement('Radio', 'sesrecipe_defaultlayout', array(
        'label' => 'Default Recipe Profile Page',
        'description' => 'Choose default layout for the recipe profile pages.',
        'multiOptions' => array(
          1 => 'Design 1',
          2 => 'Design 2',
          3 =>'Design 3',
          4 =>'Design 4',
        ),
        'value' => $settings->getSetting('sesrecipe.defaultlayout', 1),
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
