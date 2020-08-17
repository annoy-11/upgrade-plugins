<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Join.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Form_Member_Join extends Engine_Form {

  public function init() {
    $this->setTitle('Join Store')
            ->setDescription('Would you like to join this store?')
            ->setMethod('POST')
            ->setAction($_SERVER['REQUEST_URI']);
    $this->addElement('Button', 'submit', array(
        'label' => 'Join Store',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
        'type' => 'submit'
    ));
    $this->addElement('Cancel', 'cancel', array(
        'prependText' => ' or ',
        'label' => 'cancel',
        'link' => true,
        'href' => '',
        'onclick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        ),
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
