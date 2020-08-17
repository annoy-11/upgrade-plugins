<?php
class Sescrowdfundingvideo_Form_Admin_Location extends Engine_Form {
  public function init() {
		$this->addElement('Text', 'location', array(
        'label' => 'Location',
        'id' => 'locationSesList',
    ));
    $this->addElement('Text', 'lat', array(
        'label' => 'Lat',
        'id' => 'latSesList',

    ));
    $this->addElement('Text', 'lng', array(
        'label' => 'Lng',
        'id' => 'lngSesList',

    ));
   $this->addElement('dummy', 'location-data', array(
		'decorators' => array(array('ViewScript', array(
				'viewScript' => 'application/modules/Sescrowdfundingvideo/views/scripts/location.tpl',
		)))
  ));
  }
}
