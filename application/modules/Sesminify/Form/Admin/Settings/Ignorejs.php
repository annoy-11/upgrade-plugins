<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesminify
 * @package    Sesminify
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Ignorejs.php  2017-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesminify_Form_Admin_Settings_Ignorejs extends Engine_Form {
  public function init() {
  
    $settings = Engine_Api::_()->getApi('settings', 'core');
    
    $this->setTitle('Ignore JS Files')
            ->setDescription('Enter the JS files URLs (paths) which you do not want to be minified by this plugin on your website. (Separate JS files with commas)');
         
      $this->addElement('Textarea', 'sesminify_ignorejs', array(
          'label' => '',
          'description' => '',
          'value' => $settings->getSetting('sesminify.ignorejs', ''),
      ));
           
      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
    
  }  
}