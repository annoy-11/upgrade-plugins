<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembersubscription
 * @package    Sesmembersubscription
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmembersubscription_Form_SubscriberBenifit extends Engine_Form {

  public function init() {
  
    $this->setTitle('Add Subscriber Benefits')
          ->setDescription("Enter Subscriber Benefits for your  profile page.")
          ->setMethod('post');

    $this->addElement('TinyMce', 'subscriber_benifit', array(
      'description' => 'Enter Subscriber Benefits for your  profile page.',
      'required' => true,
      'editorOptions' => array(
        'html' => true,
      ),
      'allowEmpty' => false,        
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Add',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'onclick' => 'javascript:parent.Smoothbox.close()',
        'link' => true,
        'prependText' => ' or ',
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }
}