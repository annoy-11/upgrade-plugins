<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Addrule.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Form_Dashboard_Addrule extends Engine_Form {

  public function init() {
    $this->setTitle('Add New Rule')
            ->setDescription('Please compose your new rule below.')
            ->setAttrib('id', 'sesgroup_add_rule')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST")
            ->setAttrib('class', 'global_form sesgroup_smoothbox_create');
    // Add title
    $this->addElement('Text', 'title', array(
        'label' => 'Title',
        'required' => true,
        'allowEmpty' => false,
    ));
    $this->addElement('TinyMce', 'body', array(
        'label' => 'Body',
        'required' => true,
        'class' => 'tinymce',
        'editorOptions' => array(
            'html' => true,
        ),
        'allowEmpty' => false,
    ));
    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Add Rule',
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
