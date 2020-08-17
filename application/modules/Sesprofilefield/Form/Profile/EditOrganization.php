<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditOrganization.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_EditOrganization extends Sesprofilefield_Form_Profile_AddOrganization {

  public function init() {

    parent::init();
    $this->setTitle('Edit organization')
        ->setDescription('')
        ->setAttrib('name', 'sesprofilefield_addorganization');
    $this->submit->setLabel('Save Changes');
  }
}
