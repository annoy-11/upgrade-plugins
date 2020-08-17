<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: HeaderSettings.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvancedheader_Form_Admin_HeaderSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Manage Header Settings')
            ->setDescription('Here, you can configure the settings for the Header, Main and Mini navigation menus of your website. Below, you can choose to place the Main Navigation menu vertically or horizontally.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

    $banner_options[] = '';
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
      $banner_options['public/admin/' . $base_name] = $base_name;
    }
    $fileLink = $view->baseUrl() . '/admin/files/';

    $templated = array();
    for($i=1;$i<16;$i++)
      $templated[$i] = 'Template '.$i;

    $this->addElement('Radio', 'sesadvheader_design', array(
        'label' => 'Header design template',
        'description' => 'Choose from below the design template for header',
				'multiOptions' => array(
					1 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-design/1.png" alt="" />',
					2 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-design/2.png" alt="" />',
					3 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-design/3.png" alt="" />',
					4 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-design/4.png" alt="" />',
					5 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-design/5.png" alt="" />',
					6 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-design/6.png" alt="" />',
					7 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-design/7.png" alt="" />',
					8 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-design/8.png" alt="" />',
					9 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-design/9.png" alt="" />',
					10 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-design/10.png" alt="" />',
					11 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-design/11.png" alt="" />',
					12 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-design/12.png" alt="" />',
					13 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-design/13.png" alt="" />',
					14 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-design/14.png" alt="" />',
					15 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-design/15.png" alt="" />',
				),
        'escape' => false,
        'value' => $settings->getSetting('sesadvheader.design', '1'),
        'onchange' => 'showOptions(this.value)',
    ));
    $this->sesadvheader_design->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

    $this->addElement('Select', 'sesadvancedheader_mainmenualignment', array(
      'label' => 'Main Menu Alignment',
      'description' => 'Choose the alignment of the Main Menu in the header of your website.',
      'multiOptions' => array(
        'left' => 'Left',
        'right' => 'Right',
        'center' => 'Center',
        'justified' => 'Justified',
      ),
      'value' => $settings->getSetting('sesadvancedheader.mainmenualignment', 'left'),
    ));

    $this->addElement('Select', 'sesadvancedheader_mainmenueffect', array(
      'label' => 'Main Menu Panel Effects',
      'description' => 'Choose effect from below for main menu panel.',
      'multiOptions' => array(
        'overlay' => 'Overlay',
        'pusher' => 'Pusher',
        'slide' => 'Slide',
      ),
      'onchange' => 'mainmenueffect(this.value)',
      'value' => $settings->getSetting('sesadvancedheader.mainmenueffect', 'overlay'),
    ));

    $this->addElement('Select', 'sesadvancedheader_slideeffect', array(
      'label' => 'Slide Effects',
      'description' => 'Choose effect for slide.',
      'multiOptions' => array(
        'menu_slide_showhide' => 'Always Hide',
        'menu_slide_alwayshow' => 'Always Show',
        'menu_slide_expand' => 'Always Expand',
        'menu_slide_collaps' => 'Always Collapse',

        'menu_slide_along' => 'Slide Along',
        'menu_slide_scaleup' => 'Slide Scaleup',
        'menu_slide_falldown' => 'Slide Fall Down',
        'menu_slide_3drotate_in' => 'Slide 3D Rotate In',
        'menu_slide_reveal' => 'Slide Reveal',
      ),
      'value' => $settings->getSetting('sesadvancedheader.slideeffect', 'menu_alwayshow'),
    ));

    $this->addElement('Select', 'sesadvancedheader_overlayeffect', array(
      'label' => 'Overlay Effects',
      'description' => 'Choose effect for overlay.',
      'multiOptions' => array(
        'menu_overlay' => 'Overlay',
        'menu_slide_falldown' => 'Slide Fall Down',
      ),
      'value' => $settings->getSetting('sesadvancedheader.overlayeffect', 'menu_overlay'),
    ));

    $this->addElement('Select', 'sesadvancedheader_pushereffect', array(
      'label' => 'Pusher Effects',
      'description' => 'Choose effect for pusher.',
      'multiOptions' => array(
        'menu_pusher' => 'Pusher',
        'menu_pusher_rotate' => 'Pusher Rotate',
      ),
      'value' => $settings->getSetting('sesadvancedheader.pushereffect', 'menu_pusher'),
    ));

    $this->addElement('Select', 'sesadvancedheader_logo', array(
        'label' => 'Logo in Header',
        'description' => 'Choose from below the logo image for the header of your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => $settings->getSetting('sesadvancedheader.logo', ''),
    ));
    $this->sesadvancedheader_logo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

    $this->addElement('Select', 'sesadvancedheader_minimenu_transparent', array(
        'label' => 'Mini menu icon transparent',
        'description' => 'Do you want to make mini menu icon transparent',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No',
        ),
        'value' => $settings->getSetting('sesadvancedheader.minimenu.transparent', '0'),
    ));
    $this->sesadvancedheader_minimenu_transparent->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

    $footerLink = $view->baseUrl() . '/admin/menus?name=sesadvancedheader_extra_menu';

    $this->addElement('MultiCheckbox', 'sesadvancedheader_header_loggedin_options', array(
        'label' => 'Header Options for Logged In Members',
        'description' => 'Choose from below the options to be available in header to the logged in members on your website.',
        'multiOptions' => array(
            'search' => 'Search Bar',
            'miniMenu' => 'Mini Menu Items',
            'mainMenu' =>'Main Menu Items',
            'logo' =>'Website Logo',
            'ads' =>'Ads [These will come in header design 1, 3, 10, 11 and 14.]',
            'socialshare' => 'Extra Links in Mini Menu (<a href="'.$footerLink.'" target="_blank">Click here</a> to edit links). These will come in header design 9, 10, 13 and 14.',
        ),
        'escape' => false,
        'value' => $settings->getSetting('sesadvancedheader.header.loggedin.options',array('search','miniMenu','mainMenu','logo')),
    ));

    $this->addElement('MultiCheckbox', 'sesadvancedheader_header_nonloggedin_options', array(
        'label' => 'Header Options for Non-Logged In Members',
        'description' => 'Choose from below the options to be available in header to the non-logged in members on your website.',
        'multiOptions' => array(
            'search' => 'Search Bar',
            'miniMenu' => 'Mini Menu Items',
            'mainMenu' =>'Main Menu Items',
            'logo' =>'Website Logo',
            'ads' =>'Ads [These will come in header design 1, 3, 10, 11 and 14.]',
            'socialshare' => 'Extra Links in Mini Menu (<a href="'.$footerLink.'" target="_blank">Click here</a> to edit links). These will come in header design 9, 10, 13 and 14.',
        ),
        'escape' => false,
        'value' => $settings->getSetting('sesadvancedheader.header.nonloggedin.options', array('search','miniMenu','mainMenu','logo')),
    ));

    $this->addElement('Text', 'sesadvancedheader_header_logoheight', array(
      'label' => 'Logo Height',
      'description' => 'Enter the height of logo (in px).',

      'value' => $settings->getSetting('sesadvancedheader.header.logoheight', 27),
    ));
    $this->addElement('Text', 'sesadvancedheader_header_logomargintop', array(
      'label' => 'Logo Margin Top',
      'description' => 'Enter the margin top of logo (in px).',

      'value' => $settings->getSetting('sesadvancedheader.header.logomargintop', 0),
    ));

    $this->addElement('Text', 'sesadvancedheader_limit', array(
        'label' => 'Menu Count',
        'description' => 'Choose number of menu items to be displayed before â€œMoreâ€? dropdown menu occurs?',
        'value' => $settings->getSetting('sesadvancedheader.limit', 6),
    ));

    $this->addElement('Text', 'sesadvancedheader_moretext', array(
        'label' => '"More" Button Text',
        'description' => 'Enter "More" Button Text',
        'value' => $settings->getSetting('sesadvancedheader.moretext', 'More'),
    ));

     $this->addElement('Select', 'sesadvancedheader_header_fixed', array(
      'label' => 'Fixed header',
      'onchange' => 'headerFixed(this.value);',
      'description' => 'Do you want to make the header fixed?',
      'multiOptions' => array(
          1 => 'Yes',
          0 => 'No',
      ),
      'value' => $settings->getSetting('sesadvancedheader.header.fixed', 0),
    ));
    $this->addElement('Select', 'sesadvancedheader_fixed_logo', array(
        'label' => 'Logo in Fixed Header',
        'description' => 'Choose from below the logo image for the header of your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => $settings->getSetting('sesadvancedheader.fixed.logo', ''),
    ));
    $this->sesadvancedheader_fixed_logo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    $this->addElement('Text', 'sesadvancedheader_header_opacity', array(
      'label' => 'Fixed header Opacity',
      'description' => '',
      'value' => $settings->getSetting('sesadvancedheader.header.opacity', "0.5"),
    ));
    $this->addElement('Text', 'sesadvancedheader_header_bgcolor', array(
      'label' => 'Fixed header Background Color',
      'description' => '',
      'class' => 'SESColor',
      'value' => $settings->getSetting('sesadvancedheader.header.bgcolor', "000"),
    ));
		$this->addElement('Text', 'sesadvancedheader_header_textcolor', array(
      'label' => 'Fixed header Font Color',
      'description' => '',
      'class' => 'SESColor',
      'value' => $settings->getSetting('sesadvancedheader.header.textcolor', "fff"),
    ));

    $this->addElement('Text', 'sesadvancedheader_fixed_limit', array(
        'label' => 'Header Fixed Menu Count',
        'description' => 'Choose number of menu items to be displayed before â€œMoreâ€? dropdown menu occurs?',
        'value' => $settings->getSetting('sesadvancedheader_fixed_limit', 7),
    ));

    $this->addElement('Text', 'sesadvancedheader_fixed_moretext', array(
        'label' => 'Header Fixed "More" Button Text',
        'description' => 'Enter "More" Button Text',
        'value' => $settings->getSetting('sesadvancedheader_fixed_moretext', 'More'),
    ));

    $this->addElement('Text', 'sesadvancedheader_fixed_height', array(
        'label' => 'Header Fixed Logo Height',
        'description' => 'Enter the height of site logo(in px)',
        'value' => $settings->getSetting('sesadvancedheader_fixed_height', 34),
    ));
    $this->addElement('Text', 'sesadvancedheader_fixed_margintop', array(
        'label' => 'Header Fixed Logo Margin Top',
        'description' => 'Enter the Logo margin top(in px)',
        'value' => $settings->getSetting('sesadvancedheader_fixed_margintop', 0),
    ));

    $this->addElement('Select', 'sesadvancedheader_header_submenu', array(
      'label' => 'Sub Menus',
      'description' => 'Do you want to show plugin sub-menus in drop down.',
      'multiOptions' => array(
          1 => 'Yes',
          0 => 'No',
      ),
      'value' => $settings->getSetting('sesadvancedheader.header.submenu', 1),
    ));

    //ads code
    $campaigns = Engine_Api::_()->getDbtable('adcampaigns', 'core')->fetchAll();
    if( count($campaigns) > 0 ) {
      // Element: adcampaign_id
      $this->addElement('Select', 'sesadvancedheader_adcampaignid', array(
        'label' => 'Choose Ad Campaign',
        'description' => 'Choose an ad campaign.',
      ));
      foreach( $campaigns as $campaign ) {
        $this->sesadvancedheader_adcampaignid->addMultiOption($campaign->adcampaign_id, $campaign->name);
      }
      $this->sesadvancedheader_adcampaignid->setValue($settings->getSetting('sesadvancedheader.adcampaignid', ''));
    } else{
      $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('You have not created any Ads Campaign yet, <a href="admin/ads/create" target="_blank">Create New Campaign</a>') . "</span></div>";
      //Add Element: Dummy
      $this->addElement('Dummy', 'sesadvancedheader_noadcampaignid', array(
          'label' => 'Campaign Id',
          'description' => $description,
      ));
      $this->sesadvancedheader_noadcampaignid->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    }

    $this->addElement('Select', 'sesadvancedheader_menuinformation_img', array(
        'label' => 'Background Image for User in Main Menu',
        'description' => 'Choose from below the background image for the user section in Main Menu. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.] If you have the <a href="http://www.socialenginesolutions.com/social-engine/advanced-members-plugin/" target="_blank">Advanced Members plugin</a>, then the user?s Cover Photo will show up in this section, instead of this background cover photo.',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => $settings->getSetting('sesadvancedheader.menuinformation.img', ''),
    ));
    $this->sesadvancedheader_menuinformation_img->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

    $this->addElement('Select', 'sesadvancedheader_menu_img', array(
        'label' => 'Background Image for Menu Items in Main Menu',
        'description' => 'Choose from below the background image for the menu section in Main Menu. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => $settings->getSetting('sesadvancedheader.menu.img', ''),
    ));
    $this->sesadvancedheader_menu_img->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


    $this->addElement('Select', 'sesadvancedheader_cta_enable', array(
      'label' => 'CTA Button',
      'description' => 'Do you want to show CTA button?',
      'multiOptions' => array(
          1 => 'Yes',
          0 => 'No',
      ),
      'onChange'=>"ctaaction(this.value)",
      'value' => $settings->getSetting('sesadvancedheader_cta_enable', 0),
    ));

    $requiredCTA = false;
    $emptyCTA = true;
    if(count($_POST) && $_POST['sesadvancedheader_cta_enable'] == 1){
        $requiredCTA = TRUE;
        $emptyCTA = FALSE;
    }
    $this->addElement('Text', 'sesadvancedheader_cta_text', array(
        'label' => 'CTA Button Text',
        'required'=>$requiredCTA,
        'allowEmpty' => $emptyCTA,
        'description' => 'Enter the CTA Button text',
        'value' => $settings->getSetting('sesadvancedheader_cta_text', ""),
    ));

    $this->addElement('Text', 'sesadvancedheader_cta_url', array(
        'label' => 'CTA Button URL',
        'required'=>$requiredCTA,
        'allowEmpty' => $emptyCTA,
        'description' => 'Enter the CTA Button URL.',
        'value' => $settings->getSetting('sesadvancedheader_cta_url', ""),
    ));


    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
