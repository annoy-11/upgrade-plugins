<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ManagePhotos.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Form_Dashboard_ManagePhotos extends Engine_Form {

  public function init() {
  
    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    
//     $this->addElement('Radio', 'cover', array(
//       'label' => 'Main Photo',
//     ));
    
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
    ));
    
  }
}