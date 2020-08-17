<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Creatememberrole.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Form_Admin_Creatememberrole extends Engine_Form {

  public function init() {

    parent::init();

    // My stuff
    $this->setTitle('Create Page Roles')
            ->setDescription('');
    $class = '';
    
    
    $this->addElement('Text', 'title', array(
        'label' => 'Page Role Title',
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
