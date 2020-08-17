<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessvideo
 * @package    Sesbusinessvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Location.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusinessvideo_Form_Admin_Location extends Engine_Form {
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
				'viewScript' => 'application/modules/Sesbusinessvideo/views/scripts/location.tpl',
		)))
  ));
  }
}