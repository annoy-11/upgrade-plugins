<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslike_Form_Admin_Settings_Global extends Engine_Form {

    public function init() {

        $settings = Engine_Api::_()->getApi('settings', 'core');
        $this
            ->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');


        $this->addElement('Radio', 'seslike_userlike', array(
            'label' => 'Enable User Profile Like',
            'description' => 'Do you want to enable user profile like button? If yes then you need to place "Like Button for Content Profile Page" widget at Member Profile Page.',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'onchange' => "userlike(this.value)",
            'value' => $settings->getSetting('seslike.userlike', 0),
        ));

        $this->addElement('Radio', 'seslike_bydefaultuserlike', array(
            'label' => 'Enable Default Profile Like Settings',
            'description' => 'Do you want to enable default Like Settings for your profile so that users can like your Profile?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'value' => $settings->getSetting('seslike.bydefaultuserlike', 0),
        ));

        // Add submit button
        $this->addElement('Button', 'submit', array(
            'label' => 'Save Changes',
            'type' => 'submit',
            'ignore' => true
        ));
    }
}
