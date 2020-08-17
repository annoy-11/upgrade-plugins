<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditExperience.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_EditExperience extends Sesprofilefield_Form_Profile_AddExperience {

  public function init() {
  
    parent::init();
    $this->setTitle('Edit experience')
        ->setDescription('')
        ->setAttrib('name', 'sesprofilefield_addexperience');
    $this->submit->setLabel('Save Changes');
  }
}