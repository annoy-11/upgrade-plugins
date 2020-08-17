<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditEducation.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_EditEducation extends Sesprofilefield_Form_Profile_AddEducation {

  public function init() {
  
    parent::init();
    $this->setTitle('Edit Education')
      ->setDescription('')
      ->setAttrib('name', 'sesprofilefield_addeducation')
      ->setAttrib('class', 'sesprofilefield_formcheck global_form');

    $this->submit->setLabel('Save Changes');
  }
}