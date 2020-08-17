<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditCertification.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_EditCertification extends Sesprofilefield_Form_Profile_AddCertification {

  public function init() {
  
    parent::init();
    $this->setTitle('Edit Certification')
        ->setDescription('')
        ->setAttrib('name', 'sesprofilefield_addcertification')
        ->setAttrib('class', 'sesprofilefield_formcheck global_form');
    $this->submit->setLabel('Save Changes');
  }
}