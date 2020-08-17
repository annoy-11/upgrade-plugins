<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingteam
 * @package    Sescrowdfundingteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Editdesignation.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sescrowdfundingteam_Form_Editdesignation extends Sescrowdfundingteam_Form_Adddesignation {

  public function init() {

    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
    parent::init();
    $this->setTitle('Edit Designation')
      ->setDescription('')
      ->setAttrib('name', 'sescrowdfundingteam_adddesignation')
      ->setAttrib('class', 'sescrowdfundingteam_formcheck global_form');

    $this->submit->setLabel('Save Changes');
  }
}
