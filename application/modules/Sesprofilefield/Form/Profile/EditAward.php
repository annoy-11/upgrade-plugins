<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditAward.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_EditAward extends Sesprofilefield_Form_Profile_AddAward {

  public function init() {
  
    parent::init();
    $this->setTitle('Edit Honors & Awards')
        ->setDescription('')
        ->setAttrib('name', 'sesprofilefield_addaward');
    $this->submit->setLabel('Save Changes');
  }
}