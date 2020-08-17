<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditLink.php 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfooter_Form_Admin_EditLink extends Engine_Form {

  public function init() {

    $this->setMethod('POST');
    
		$footerlink_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('footerlink_id');
		
		$options[] = '';
    $path = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
    foreach ($path as $file) {
      if ($file->isDot() || !$file->isFile())
        continue;
      $base_name = basename($file->getFilename());
      if (!($pos = strrpos($base_name, '.')))
        continue;
      $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
      if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png')))
        continue;
      $options['public/admin/' . $base_name] = $base_name;
    }
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $fileLink = $view->baseUrl() . '/admin/files/';
		
    $this->addElement('Text', "name", array(
        'label' => 'Enter link name.',
        'allowEmpty' => false,
        'required' => true,
    ));
    
		$footerLinkIds = array('1','2', '3', '4', '5','6');
		
    if(in_array($footerlink_id, $footerLinkIds)) {
		  $this->addElement('Select', 'footer_headingicon', array(
	        'label' => 'Footer Heading Icon',
	        'description' => 'Choose from below the footer background image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want any footer background image.]',
	        'multiOptions' => $options,
	        'escape' => false,
	    ));
	    $this->footer_headingicon->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    }
    
    
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
