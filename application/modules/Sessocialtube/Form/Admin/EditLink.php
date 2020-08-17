<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditLink.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialtube_Form_Admin_EditLink extends Engine_Form {

  public function init() {

    $this->setMethod('POST');
    
    $footerlink_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('footerlink_id');
    $sublink = Zend_Controller_Front::getInstance()->getRequest()->getParam('sublink');

    $this->addElement('Text', "name", array(
        'label' => 'Enter link name.',
        'allowEmpty' => false,
        'required' => true,
    ));

    if($sublink) {
    
	    $this->addElement('Text', "url", array(
	        'label' => 'Enter the URL for this link for non-logged in members',
	    ));
	    
	    $this->addElement('Select', "nonloginenabled", array(
	        'label' => 'Enable this link for non-logged in members',
	        'multiOptions' => array(
	            '1' => 'Yes',
	            '0' => "No",
	        ),
	    ));
	    
	    $this->addElement('Select', "nonlogintarget", array(
	        'label' => 'Open this URL in new tab for non-logged in members',
	        'multiOptions' => array(
	            '1' => 'Yes',
	            '0' => "No",
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
	        'label' => 'Open this URL in new tab for non-logged in members',
	        'multiOptions' => array(
	            '1' => 'Yes',
	            '0' => "No",
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
