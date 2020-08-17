<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppackage
 * @package    Sesgrouppackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Delete.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgrouppackage_Form_Admin_Package_Delete extends Engine_Form {

  public function init() {
    $this->setTitle('Delete Package')
         ->setDescription('Are you sure you want to delete this package?')
         ->setAttrib('class', 'global_form_popup');
    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Delete Package',
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
