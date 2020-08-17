<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Itemdesign.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmenu_Form_Admin_Menu_ItemDesign extends Engine_Form
{
  public function init()
  {
	$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', null);
	$menu =Engine_Api::_()->getItem('sesmenu_menuitem',$id);
	
	
	$this
    ->setTitle('Change Item Design')
    ->setAttrib('class', 'global_form_popup')
      ;
	$multiOptions= array(
		'creation_date' => 'Recent Tab',
		'like_count'          => 'Most Liked Tab',
		'comment_count'       => 'Most Commented Tab',
		'view_count' => "Most Viewed",
		'week' => 'This Week Tab',
		'month'        => 'This Month Tab',
	);
	//default photos
	  $default_photos_main = array(''=>'');
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
		$default_photos_main['public/admin/' . $base_name] = $base_name;
	  }
	  $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
	  $fileLink = $view->baseUrl() . '/admin/files/';
	if($menu->design==8) {
		
		$this->addElement('Text', 'sc1_title', array(
			'label' => 'Section 1 heading name',
			'allowEmpty' => false,
			'required' => true,
			'value' => 'Section 1',
		));
	
		$this->addElement('Select', 'sc1_order', array(
			'label' => 'Choose option to show section 1',
			'multiOptions' => $multiOptions,
			'value' => 'creation_date',
		));
		
		$this->addElement('Text', 'sc1_count', array(
			'label' => 'How many content show in Section 1',
			'allowEmpty' => false,
			'required' => true,
			'validators' => array(
			  array('Int', true),
			  new Engine_Validate_AtLeast(1),
			),
		));		
		
		$this->addElement('Text', 'sc2_title', array(
			'label' => 'Section 2 heading name',
			'allowEmpty' => false,
			'required' => true,
			'value' => 'Section 2',
		));
	
		$this->addElement('Select', 'sc2_order', array(
			'label' => 'Choose option to show section 2',
			'multiOptions' => $multiOptions,
			'value' => 'creation_date',
		));
		
		$this->addElement('Text', 'sc2_count', array(
			'label' => 'How many content show in Section 2',
			'allowEmpty' => false,
			'required' => true,
			'validators' => array(
			  array('Int', true),
			  new Engine_Validate_AtLeast(1),
			),
		));
		
		$this->addElement('Select', 'first_photo', array(
            'label' => 'Photos',
            'description' => 'Choose photo 1. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to show.]',
            'multiOptions' => $default_photos_main,
        ));
		$this->first_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
		
		$this->addElement('Text', 'photo1_link', array(
			'label' => 'Url of Section 1 Ad',
		));
		
        $this->addElement('Select', 'second_photo', array(
            'label' => 'Photo 2',
            'multiOptions' => $default_photos_main,
        ));
		$this->second_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
		
		$this->addElement('Text', 'photo2_link', array(
			'label' => 'Url of Section 2 Ad',
		));

		$this->addElement('Select', 'third_photo', array(
            'label' => 'Photo 3',
            'multiOptions' => $default_photos_main,
        ));
		$this->second_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
		
		$this->addElement('Text', 'photo3_link', array(
			'label' => 'Url of Section 2 Ad',
		));
		
		$this->addElement('Select', 'show_cat', array(
			'label' => 'Do you want to show categories',
			'multiOptions' => array('1' => 'yes','0' => 'No'),
			'allowEmpty' => false,
			'required' => false,
			'value' => '1',
		));
	}
	$this->addElement('Text', 'categories_count', array(
        'label' => 'How many categories show in single page',
        'allowEmpty' => false,
        'required' => true,
        'value' => '10',
    ));
	if($menu->design == 3 || $menu->design == 1)
	{
		$this->addElement('Select', 'show_count', array(
			'label' => 'Do you want to show total content count',
			'multiOptions' => array('1' => 'yes','0' => 'No'),
			'allowEmpty' => false,
			'required' => false,
			'value' => '1',
		));
	}
	if($menu->design==4 || $menu->design == 10)
	{

		if(in_array($menu->module,array('sesblog','sesarticle','sesrecipe'))){
			$multiOptions['rating'] = 'Most Rated';
		}
			
		$this->addElement('MultiCheckbox', 'enabled_tab', array(
			'label' => 'Show Selected Tab',
			'multiOptions' => $multiOptions,
			'value' => array('creation_date', 'like_count', 'comment_count', 'view_count','most_favourite','week','month'),
		));
	}
	if ($menu->design==5) {
      
        $this->addElement('Select', 'first_photo', array(
            'label' => 'Photo 1',
            'description' => 'Choose photo 1. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to show.]',
            'multiOptions' => $default_photos_main,
        ));
		$this->first_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
		
		$this->addElement('Text', 'photo1_link', array(
			'label' => 'Url of Section 1 Ad',
		));
		
		
        $this->addElement('Select', 'second_photo', array(
            'label' => 'Photo 2',
            'description' => 'Choose photo 2. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to show.]',
            'multiOptions' => $default_photos_main,
        ));
		$this->second_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
		
		$this->addElement('Text', 'photo2_link', array(
			'label' => 'Url of Section 2 Ad',
		));
	}

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'save',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onclick' => 'parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }
}