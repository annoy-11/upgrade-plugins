<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageurl
 * @package    Sespageurl
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespageurl_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $this->addElement('Radio', 'sespage_enable_shorturl', array(
        'label' => 'Enable Short URL for Pages',
        'description' => 'Do you want to enable short URLs for the Pages on your website? If you choose Yes, then the Pages on your website will be opened directly by their Vanity (short) URL entering just after the site base URL.',
        'multiOptions' => array(
            1 => 'Yes, ',
            0 => 'No',
        ),
        'value' => $settings->getSetting('sespage.enable.shorturl', 0),
    ));
    $this->addElement('Radio', 'sespage_shorturl_onlike', array(
        'label' => 'Enable Shortening Based on Likes',
        'description' => 'Do you want to enable the URL shortening in Pages on your website based on the number of Likes they receive?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sespage.shorturl.onlike', 0),
    ));
    $this->addElement('Text', 'sespage_countlike', array(
        'label' => 'Likes Count for URL Shortening',
        'description' => 'Enter the number of Likes after which short URL will be enabled for Pages.',
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        ),
        'value' => $settings->getSetting('sespage.countlike', 10),
    ));
    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
