<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditProject.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_EditProject extends Sesprofilefield_Form_Profile_AddProject {

  public function init() {

    parent::init();
    $this->setTitle('Edit Project')
        ->setDescription('')
        ->setAttrib('name', 'sesprofilefield_addproject');
    $this->submit->setLabel('Save Changes');
  }
}
