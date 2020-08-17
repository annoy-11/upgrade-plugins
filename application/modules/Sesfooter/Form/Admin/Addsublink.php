<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Addsublink.php 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfooter_Form_Admin_Addsublink extends Engine_Form {

  public function init() {

    $this->setMethod('POST');

    $this->addElement('Text', "name", array(
        'label' => 'Enter link name.',
        'allowEmpty' => false,
        'required' => true,
    ));

    $footerLinkIds = array('2', '3', '4', '5','6');
    if(!in_array($footerlink_id, $footerLinkIds)) {
    
	    $this->addElement('Text', "url", array(
	        'label' => 'Enter the URL for this link for non-logged in users',
	    ));

	    $this->addElement('Select', "nonloginenabled", array(
	        'label' => 'Enable this link for non-logged in users',
	        'multiOptions' => array(
	            '1' => 'Yes',
	            '0' => "No",
	        ),
	    ));
	    
	    $this->addElement('Select', "nonlogintarget", array(
	        'label' => 'Open this URL in new tab for non-logged in users',
	        'multiOptions' => array(
	            '0' => "No",
	            '1' => 'Yes',
	        ),
	    ));

	    $this->addElement('Text', "loginurl", array(
	        'label' => 'Enter the URL for this link for logged in members',
	    ));
	    
	    $this->addElement('Select', "loginenabled", array(
	        'label' => 'Enable this link for logged in members',
	        'multiOptions' => array(
	            '1' => 'Yes',
	            '0' => "No",
	        ),
	    ));
	    
	    $this->addElement('Select', "logintarget", array(
	        'label' => 'Open this URL in new tab for logged in members',
	        'multiOptions' => array(
	            '0' => "No",
	            '1' => 'Yes',
	        ),
	    ));
    }

    $this->addElement('Button', 'button', array(
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'onclick' => 'javascript:parent.Smoothbox.close()',
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('button', 'cancel'), 'buttons');
  }

}
