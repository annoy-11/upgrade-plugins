<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesultimateslide
 * @package Sesultimateslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: Gallery.php 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */

class Sesultimateslide_Form_Admin_Gallery extends Engine_Form {

  public function init() {

      $this->setTitle('Create New Slideshow.')->setDescription('Fill out the form below to create new slideshow for your website.');


    $this->setMethod('post');

    $this->addElement('Text', 'title', array(
        'label' => 'Banner Title',
        'description' =>'Enter the title for this slideshow.',
        'allowEmpty' => false,
        'required' => true,
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Create',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => '',
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
