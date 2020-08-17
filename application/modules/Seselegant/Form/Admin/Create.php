<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seselegant_Form_Admin_Create extends Engine_Form {

  public function init() {
    $this->setTitle('Add New Slide Photo')
            ->setDescription('')
            ->setAttrib('name', 'photo_create');

    $this->addElement('File', 'photo', array(
        'label' => 'Slide Photo'
    ));
    $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');

    // Element: execute
    $this->addElement('Button', 'execute', array(
        'label' => 'Post Listing',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
  }

}