<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroup_Form_Service_Edit extends Sesgroup_Form_Service_Add {

  public function init() {
    parent::init();
    $this->setTitle('Edit Service')
      ->setDescription('')
      ->setAttrib('name', 'sesgroupservice_addservice')
      ->setAttrib('class', 'sesgroupservice_formcheck global_form');
    $this->submit->setLabel('Save Changes');
  }
}