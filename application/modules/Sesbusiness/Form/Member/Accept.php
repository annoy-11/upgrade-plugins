<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Accept.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Form_Member_Accept extends Engine_Form {

  public function init() {
    $this->setTitle('Accept Business Invitation')
            ->setDescription('Would you like to join this business?')
            ->setMethod('POST')
            ->setAction($_SERVER['REQUEST_URI']);

    $this->addElement('Hash', 'token');

    $this->addElement('Button', 'submit', array(
        'label' => 'Join Business',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
        'type' => 'submit'
    ));

    $this->addElement('Cancel', 'cancel', array(
        'prependText' => ' or ',
        'label' => 'cancel',
        'link' => true,
        'href' => '',
        'onclick' => 'sessmoothboxclose();',
        'decorators' => array(
            'ViewHelper'
        ),
    ));

    $this->addDisplayGroup(array(
        'submit',
        'cancel'
            ), 'buttons');
  }

}
