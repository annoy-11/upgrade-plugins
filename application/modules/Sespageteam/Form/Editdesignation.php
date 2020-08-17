<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageteam
 * @package    Sespageteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Editdesignation.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespageteam_Form_Editdesignation extends Sespageteam_Form_Adddesignation {

  public function init() {
  
    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
    parent::init();
    $this->setTitle('Edit Designation')
      ->setDescription('')
      ->setAttrib('name', 'sespageteam_adddesignation')
      ->setAttrib('class', 'sespageteam_formcheck global_form');

    $this->submit->setLabel('Save Changes');
  }
}