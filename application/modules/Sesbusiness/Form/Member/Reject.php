<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Reject.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Form_Member_Reject extends Engine_Form {

  public function init() {

    $this
            ->setTitle('Reject Business Invitation')
            ->setDescription('Would you like to reject the invitation to this business?')
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
