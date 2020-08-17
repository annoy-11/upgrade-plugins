<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Tabbed.php 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesdocument_Form_Admin_Photo extends Engine_Form {

  public function init() {


    $this->addElement('Radio', "shape", array(
        'label' => 'Choose the shape of Photo.',
       	'multiOptions' => array(
            'circle' => 'Circle',
            'photo' => 'Photo',				
        ),
        'value' => 'photo',
   ));

	
    $this->addElement('Text', "title_truncation", array(
        'label' => 'Truncation limit for "About User" information .',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
		
  
  }

}
