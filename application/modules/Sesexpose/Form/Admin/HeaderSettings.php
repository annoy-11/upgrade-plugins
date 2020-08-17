<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: HeaderSettings.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesexpose_Form_Admin_HeaderSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Manage Header Settings')
            ->setDescription('Here, you can configure the settings for the Header, Main and Mini navigation menus of your website. Below, you can choose from various header designs having vertical and horizontal placement of Main Navigation menu.');
            
            
    $this->addElement('Radio', 'exp_header_type', array(
      'label' => 'Header Design',
      'description' => 'Choose the design of the header from below options.',
      'multiOptions' => array(
          1 => '<img src="./application/modules/Sesexpose/externals/images/design/header-1.jpg" alt="Header Design - 1" />',
          2 => '<img src="./application/modules/Sesexpose/externals/images/design/header-2.jpg" alt="Header Design - 2" />',
          3 => '<img class="header-3-1" src="./application/modules/Sesexpose/externals/images/design/header-3.1.jpg" alt="Header Design - 3" /> <img class="header-3-2" src="./application/modules/Sesexpose/externals/images/design/header-3.2.jpg" alt="Header Design - 3" />',
      ),
      'escape' => false,
      'onchange' => 'showOption(this.value)',
      'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_header_type'),
    ));

    $this->addElement('Select', 'sesexpose_header_fixed', array(
        'label' => 'Fix Header',
        'description' => 'Do you want to fix the Header to the top of the page when users scroll down? If you choose "Yes", then users will need to scroll back to the top to view the header.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sesexpose.header.fixed', 1),
    ));
    
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
    $this->addElement('Select', 'sesexpose_logo', array(
        'label' => 'Choose Logo',
        'description' => 'Choose from below the logo image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show logo.]',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => $settings->getSetting('sesexpose.logo', ''),
    ));
    $this->sesexpose_logo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    
    $this->addElement('Text', "exp_menu_logo_top_space", array(
        'label' => 'Logo Top Margin',
        'description' => 'Enter the top margin for the logo of your website to be displayed in this header.(Ex: 30px)',
        'allowEmpty' => false,
        'required' => true,
        'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_menu_logo_top_space'),
    ));

    $this->addElement('Text', 'sesexpose_limit', array(
        'label' => 'Main Menu Item Count',
        'description' => 'Enter the number of menu items which will be shown in the Main Navigation Menu on your website.',
        'value' => $settings->getSetting('sesexpose.limit', 4),
    ));

    $this->addElement('Text', 'sesexpose_moretext', array(
        'label' => 'Text For "More" Button in Menu',
        'description' => 'Enter the text for the "More" button in the Main Navigation Menu. This text will come if there are more menus after the number of menu items selected in the "Main Menu Item Count" setting above.',
        'value' => $settings->getSetting('sesexpose.moretext', 'More'),
    ));
    $footerLink = $view->baseUrl() . '/admin/menus?name=sesexpose_extra_links_menu';
    $this->addElement('MultiCheckbox', 'sesexp_header_loggedin_options', array(
        'label' => 'Header Options for Logged In Members',
        'description' => 'Choose from below the header options that you want to be shown to Logged-in members on your website.',
        'multiOptions' => array(
            'search' => 'Search',
            'miniMenu' => 'Mini Menu',
            'mainMenu' =>'Main Menu',
            'logo' =>'Logo',
            'socialshare' => 'Extra Links in Mini Menu (<a href="'.$footerLink.'">Click here</a> to edit links)',
        ),
        'escape' => false,
        'value' => $settings->getSetting('sesexp.header.loggedin.options',array('search','miniMenu','mainMenu','logo', 'socialshare')),
    ));
    
    
    $this->addElement('MultiCheckbox', 'sesexp_header_nonloggedin_options', array(
        'label' => 'Header Options for Non-Logged In users',
        'description' => 'Choose from below the header options that you want to be shown to Non-Logged In users on your website.',
        'multiOptions' => array(
            'search' => 'Global Search (AJAX based)',
            'miniMenu' => 'Mini Navigation Menu',
            'mainMenu' =>'Main Navigation Menu',
            'logo' =>'Site Logo',
            'socialshare' => 'Extra Links in Mini Menu (<a href="'.$footerLink.'">Click here</a> to edit links)',
        ),
        'escape' => false,
        'value' => $settings->getSetting('sesexp.header.nonloggedin.options', array('search','miniMenu','mainMenu','logo', 'socialshare')),
    ));
    
    $this->addElement('Select', 'sesexp_enable_footer', array(
        'label' => 'Include Footer in Vertical Menu?',
        'description' => 'Do you want to include the Footer in the vertical bar? If you choose Yes, then the SocialEngine Footer menu will come in this widget and will show when the vertical menu is expanded. <a href="">Click here</a> to see screenshot of how the Footer will look.',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'escape' => false,
        'value' => $settings->getSetting('sesexp_enable_footer', 1),
    ));
    $this->sesexp_enable_footer->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    
    $this->addElement('Select', 'sesexpose_searchleftoption', array(
        'label' => 'Allow Searching in Modules',
        'description' => 'Do you want to allow users to search on the basis on various modules on your website via AJAX in the Global Search? [If you choose "Yes", then you can manage various modules from the "Manage Modules for Search" section of this plugin. Note: This setting will only work if you have enabled "Global Search" in Header.]',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'onclick' => 'showLimitOption(this.value);',
        'value' => $settings->getSetting('sesexpose.searchleftoption', 1),
    ));

    $this->addElement('Text', 'sesexpose_search_limit', array(
        'label' => 'Modules Count',
        'description' => 'Enter the number of modules to be shown in the Global Search on your website.',
        'value' => $settings->getSetting('sesexpose.search.limit', '8'),
    ));
    
    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
