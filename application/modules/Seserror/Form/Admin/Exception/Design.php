<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Design.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seserror_Form_Admin_Exception_Design extends Engine_Form {

  public function init() {

    $this->setTitle('Exception Mode Page - Design Template')
            ->setDescription('Below are the pre configured design templates for the Exception Mode page on your website. Here, you can change the image for the active template. If you want the default image of template, then simply remove your image.');

    $this->addElement('Radio', 'seserror_exceptionactivate', array(
      'multiOptions' => array(
          1 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/1.png" alt="" />',
          2 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/2.png" alt="" />',
          3 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/3.png" alt="" />',
          4 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/4.png" alt="" />',
          5 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/5.png" alt="" />',
          9 => '<div class="seserror_activate_9_content"><h2>Need Custom Error Pages</h2><p>Hire our Experts to get pert your page look just as you Want!</p> <a href="https://www.socialenginesolutions.com/social-engine/socialengine-error-pages-customization/" target="_blank">Click Here</a></div>',
      ),
      'escape' => false,
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.exceptionactivate', 1),
    ));

    $this->addElement('File', 'seserror_exceptionID', array(
        'label' => 'Upload Image',
        'description' => 'Choose an image for the active template. The image will only display in the templates which supports it. If you want the default image of template, then simply remove your image.'
    ));
    $this->seserror_exceptionID->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG');

    $exceptionID = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.exceptionID', 0);
    if ($exceptionID) {
      $this->addElement('Checkbox', 'remove_image', array(
          'label' => 'Remove photo.'
      ));
    }

    // Element: execute
    $this->addElement('Button', 'execute', array(
        'label' => 'Save Settings',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
    ));
  }
}
