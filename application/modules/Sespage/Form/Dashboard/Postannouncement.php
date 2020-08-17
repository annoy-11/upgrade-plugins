<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Postannouncement.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Form_Dashboard_Postannouncement extends Engine_Form {

  public function init() {
    $this->setTitle('Post New Announcement')
            ->setDescription('Please compose your new announcement below.')
            ->setAttrib('id', 'sespage_add_announcement')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST")
            ->setAttrib('class', 'global_form sespage_smoothbox_create');
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
        'label' => 'Post Announcement',
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
