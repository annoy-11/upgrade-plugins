<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditCourse.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_EditCourse extends Sesprofilefield_Form_Profile_AddCourse {

  public function init() {

    parent::init();
    $this->setTitle('Edit Course')
        ->setDescription('')
        ->setAttrib('name', 'sesprofilefield_addcourse');
    $this->submit->setLabel('Save Changes');
  }
}
