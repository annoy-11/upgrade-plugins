<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Cancel.php  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessegpay_Form_Admin_Subscription_Cancel extends Engine_Form
{
  public function init()
  {
    $this
      ->setTitle('Cancel Subscription')
      ->setDescription('Note: this will attempt to cancel the ' .
          'recurring payment regardless of current subscription status.')
      ->setAttrib('class', 'global_form_popup')
      ;

    // Token
    $this->addElement('Hash', 'token');

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Cancel Subscription',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onclick' => 'parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));

    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');
  }
}