<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesminify
 * @package    Sesminify
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Ignorecss.php  2017-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesminify_Form_Admin_Settings_Ignorecss extends Engine_Form {

  public function init() {
  
    $settings = Engine_Api::_()->getApi('settings', 'core');
    
    $this->setTitle('Ignore CSS Files')
            ->setDescription('Enter the CSS files URLs (paths) which you do not want to be minified by this plugin on your website. (Separate CSS files with commas)');
         
      $this->addElement('Textarea', 'sesminify_ignorecss', array(
          'label' => '',
          'description' => '',
          'value' => $settings->getSetting('sesminify.ignorecss', ''),
      ));
           
      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
    
  }
}