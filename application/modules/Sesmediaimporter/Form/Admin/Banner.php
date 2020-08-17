<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Google.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmediaimporter_Form_Admin_Banner extends Engine_Form {
  public function init() {
    $headScript = new Zend_View_Helper_HeadScript();
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
		
     $this->addElement('Text', 'background_color', array(
        'label' => 'Banner Background Color',
        'class' => 'SEScolor',
        'value'=>'85b2f3',
    ));
    
    $this->addElement('Text', 'title_text', array(
        'label' => 'Title',
        'value'=>'Add and Import Photos',
    ));
    
    $this->addElement('Textarea', 'description_text', array(
        'label' => 'Description',
        'value'=>'Import, Add and Upload photos instantly from Facebook, Instagram, Flickr, Google, 500px and Zip Folder from any device and use them on our Site and Apps.',
    ));
    
    $this->addElement('Text', 'ios_url', array(
        'label' => 'iOS App URL',
    ));
    $this->addElement('Text', 'android_url', array(
        'label' => 'Android App URL',
    ));
		$this->addElement('Select', 'full_width', array(
        'label' => 'Show this widget in full width?',
				'multiOptions' => array(
					'1'=>'Yes, show this widget in full width',
					'0'=>'No, don\'t show this widget in full width'
				),
    ));    
  }
}