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

class Seserror_Form_Admin_Maintenancemode_Design extends Engine_Form {

  public function init() {

    $this->setTitle('Maintenance Mode Page - Design Template')
            ->setDescription('Below are the pre configured design templates for the Maintenance Mode page on your website. Here, you can change the image for the active template. If you want the default image of template, then simply remove your image.');

    $this->addElement('Radio', 'seserror_maintenancemodeactivate', array(
      'multiOptions' => array(
          1 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/1.png" alt="" />',
          2 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/2.png" alt="" />',
          3 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/3.png" alt="" />',
          4 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/4.png" alt="" />',
          5 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/5.png" alt="" />',
          6 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/6.png" alt="" />',
          7 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/7.png" alt="" />',
          8 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/8.png" alt="" />',
					10 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/10.png" alt="" />',
					11 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/11.png" alt="" />',
					12 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/12.png" alt="" />',
					13 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/13.png" alt="" />',
					14 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/14.png" alt="" />',
					15 => '<img src="./application/modules/Seserror/externals/images/page-scheme/maintenance/15.png" alt="" />',
		  		9 => '<div class="seserror_activate_9_content"><h2>Need Custom Error Pages</h2><p>Hire our Experts to get pert your page look just as you Want!</p> <a href="https://www.socialenginesolutions.com/social-engine/socialengine-error-pages-customization/" target="_blank">Click Here</a></div>',
      ),
      'escape' => false,
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.maintenancemodeactivate', 1),
    ));

    $this->addElement('File', 'seserror_maintenancemodeID', array(
        'label' => 'Upload Image',
        'description' => 'Choose an image for the active template. The image will only display in the templates which supports it. If you want the default image of template, then simply remove your image.'
    ));
    $this->seserror_maintenancemodeID->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG');

    $maintenancemodeID = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.maintenancemodeID', 0);
    if ($maintenancemodeID) {
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
