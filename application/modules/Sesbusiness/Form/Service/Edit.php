<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Form_Service_Edit extends Sesbusiness_Form_Service_Add {

  public function init() {
    parent::init();
    $this->setTitle('Edit Service')
      ->setDescription('')
      ->setAttrib('name', 'sesbusinesseservice_addservice')
      ->setAttrib('class', 'sesbusinesseservice_formcheck global_form');
    $this->submit->setLabel('Save Changes');
  }
}
