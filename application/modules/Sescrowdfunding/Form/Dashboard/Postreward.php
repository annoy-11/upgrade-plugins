<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Postreward.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sescrowdfunding_Form_Dashboard_Postreward extends Engine_Form {

  public function init() {
    $this->setTitle('Post New Reward')
            ->setDescription('Please enter details for reward below.')
            ->setAttrib('id', 'sescrowdfunding_add_reward')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST")
            ->setAttrib('class', 'global_form sescrowdfunding_smoothbox_create');
    // Add title
    $this->addElement('Text', 'title', array(
        'label' => 'Title',
        'required' => true,
        'allowEmpty' => false,
    ));
    $this->addElement('Textarea', 'body', array(
        'label' => 'Body',
        'required' => true,
        'allowEmpty' => false,
    ));
    $this->addElement('Text', 'doner_amount', array(
        'label' => 'Minimum Donor Amount ',
        'required' => true,
        'allowEmpty' => false,
    ));
    $this->addElement('File', 'photo_file', array(
        'label' => 'Main Photo',
        'required' => false,
        'allowEmpty' => true,
    ));
    $this->photo_file->addValidator('Extension', false, 'jpg,png,gif,jpeg');


    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Post Reward',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'href' => '',
        'prependText' => ' or ',
        'onclick' => 'sessmoothboxclose();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        ),
    ));
  }

}
