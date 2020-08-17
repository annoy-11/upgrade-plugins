<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupteam
 * @package    Sesgroupteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Editdesignation.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroupteam_Form_Editdesignation extends Sesgroupteam_Form_Adddesignation {

  public function init() {

    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
    parent::init();
    $this->setTitle('Edit Designation')
      ->setDescription('')
      ->setAttrib('name', 'sesgroupteam_adddesignation')
      ->setAttrib('class', 'sesgroupteam_formcheck global_form');

    $this->submit->setLabel('Save Changes');
  }
}
