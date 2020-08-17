<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslazyloadimage
 * @package    Seslazyloadimage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-02-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslazyloadimage_Form_Admin_Global extends Engine_Form {

    public function init() {

        $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

        $this->addElement('Radio', 'seslazyloadimage_enable', array(
            'label' => 'Eanble Lazyload for Image',
            'description' => "Do you want to enable lazy load for images?",
            'multiOptions' => array(
                '1' => 'Eanble',
                '0' => 'Disable',
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seslazyloadimage.enable', 1),
        ));

        // Add submit button
        $this->addElement('Button', 'submit', array(
            'label' => 'Save Changes',
            'type' => 'submit',
            'ignore' => true
        ));
    }
}
