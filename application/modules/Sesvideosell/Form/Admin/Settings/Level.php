<?php

class Sesvideosell_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {
  
    parent::init();

    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription('ALBUM_FORM_ADMIN_LEVEL_DESCRIPTION');

    if( !$this->isPublic() ) {
    
      $this->addElement('Text', 'sesvideosell_commison', array(
        'label' => 'Commission',
        'description' => 'Enter Commission for videos sold from your website (in Percentage).',
        'required' => true,
        'allowEmpty' => false,
        'validators' => array(
          array('int', true),
          new Engine_Validate_AtLeast(0),
        ),
        'value' => '5',
      ));      
    }
  }
}