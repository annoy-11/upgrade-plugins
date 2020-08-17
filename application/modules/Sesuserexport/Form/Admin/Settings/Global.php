<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesuserexport
 * @package    Sesuserexport
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-11-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesuserexport_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
        ->setTitle('Global Settings')
        ->setDescription('These settings affect all members in your community.');

    if ($settings->getSetting('sesuserexport.pluginactivated')) {
    } else {

      //Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Activate your plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }

}
