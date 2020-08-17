<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Creatememberrole.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Form_Admin_Creatememberrole extends Engine_Form {

  public function init() {

    parent::init();

    // My stuff
    $this->setTitle('Create Store Roles')
            ->setDescription('');
    $class = '';


    $this->addElement('Text', 'title', array(
        'label' => 'Store Role Title',
        'allowEmpty'=>false,
        'required'=>true,
        'description' => '',
    ));

     // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
