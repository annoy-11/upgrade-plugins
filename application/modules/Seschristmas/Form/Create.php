<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seschristmas_Form_Create extends Engine_Form {

  public function init() {
    $this
            ->setTitle('Make your wish from Santa Claus.')
            ->setMethod('POST')
            ->setAction($_SERVER['REQUEST_URI'])
            ->setAttrib('class', 'global_form');

    $this->addElement('Textarea', 'description', array(
        'label' => 'Description',
        'maxlength' => 200,
        'allowEmpty' => false,
        'required' => true,
        'placeholder' => 'Make your wish...',
        'filters' => array(
            new Engine_Filter_Censor(),
            new Engine_Filter_StringLength(array('max' => '200')),
        ),
    ));

    $this->addElement('Button', 'execute', array(
        'label' => 'Make a Wish',
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
        'execute',
        'cancel'
            ), 'buttons');
  }

}
