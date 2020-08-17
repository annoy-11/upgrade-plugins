<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Form_Service_Edit extends Estore_Form_Service_Add {

  public function init() {
    parent::init();
    $this->setTitle('Edit Service')
      ->setDescription('')
      ->setAttrib('name', 'estoreservice_addservice')
      ->setAttrib('class', 'estoreservice_formcheck global_form');
    $this->submit->setLabel('Save Changes');
  }
}
