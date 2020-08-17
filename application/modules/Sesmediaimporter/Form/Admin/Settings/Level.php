<?php
class Sesmediaimporter_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract
{
  public function init()
  {
    parent::init();

    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription('These settings are applied on a per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level below.');

    

    if( !$this->isPublic() ) {    
      // Element: auth_tag
      $this->addElement('MultiCheckbox', 'allow_service', array(
        'label' => 'Services',
        'description' => 'Select the services that you want to allow.',
        'multiOptions' => array(
        'facebook'     => 'Facebook',
        'instagram'    => 'Instagram',
        'flickr'       => 'Flickr',
        'google'       => 'Google',
        'px500'        => '500px',
        'zip'          => 'Zip Upload'
        ),
        'value' => array('facebook', 'instagram','flickr', 'google', 'px500','zip'),
      ));    
    }
  }
}
