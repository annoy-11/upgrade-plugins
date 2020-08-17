<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditRecord.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_EditRecord extends Sesprofilefield_Form_Profile_AddRecord {

  public function init() {
  
    parent::init();
    $this->setTitle('Edit Records')
      ->setDescription('')
      ->setAttrib('name', 'sesprofilefield_addrecord')
      ->setAttrib('class', 'sesprofilefield_formcheck global_form');

    $this->submit->setLabel('Save Changes');
  }
}