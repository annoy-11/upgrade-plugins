<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Photos.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Form_Album_Photos extends Engine_Form {

  public function init() {
  
    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    
    $this->addElement('Radio', 'cover', array(
      'label' => 'Album Cover',
    ));
    
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
    ));
  }
}