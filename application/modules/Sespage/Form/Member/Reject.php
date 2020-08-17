<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Reject.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Form_Member_Reject extends Engine_Form {

  public function init() {
    
    $this
            ->setTitle('Reject Page Invitation')
            ->setDescription('Would you like to reject the invitation to this page?')
            ->setMethod('POST')
            ->setAction($_SERVER['REQUEST_URI']);

    //$this->addElement('Hash', 'token');

    $this->addElement('Button', 'submit', array(
        'label' => 'Reject Invitation',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
        'type' => 'submit'
    ));

    $this->addElement('Cancel', 'cancel', array(
        'prependText' => ' or ',
        'label' => 'cancel',
        'link' => true,
        'href' => '',
        'onclick' => 'parent.Smoothbox.close();',
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
