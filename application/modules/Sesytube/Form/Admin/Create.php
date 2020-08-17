<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Form_Admin_Create extends Engine_Form {

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
