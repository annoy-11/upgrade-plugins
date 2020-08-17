<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: FooterSettings.php 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmaterial_Form_Admin_FooterSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Footer Settings')
            ->setDescription('These settings will affect the footer of your website.');


    $this->addElement('Text', 'sesmaterial_footer_aboutheading', array(
        'label' => 'About Heading',
        'description' => 'Enter About Heading',
        'value' => $settings->getSetting('sesmaterial.footer.aboutheading', 'About Us'),
    ));

    $this->addElement('Text', 'sesmaterial_footer_aboutdes', array(
        'label' => 'About Description',
        'description' => 'Enter About Description',
        'value' => $settings->getSetting('sesmaterial.footer.aboutdes', ''),
    ));

    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
