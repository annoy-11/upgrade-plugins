<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ItemEdit.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmenu_Form_Admin_Menu_ItemEdit extends Engine_Form
{
  public function init()
  {
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', null);
	$menu =Engine_Api::_()->getItem('sesmenu_menuitem',$id);

    $this
      ->setTitle('Edit Menu Item')
      ->setAttrib('class', 'global_form_popup')
      ;
	$name = Zend_Controller_Front::getInstance()->getRequest()->getParam('menuName', null);

	$this->addElement('Text', 'label', array(
      'label' => 'Label',
	  'description' => 'Enter the Label for the menu item.',
      'required' => true,
      'allowEmpty' => false,
    ));

    $this->addElement('Text', 'uri', array(
      'label' => 'URL',
	  'description' => 'Enter the URL for the menu on which users get redirect after clicking.',
      'required' => true,
      'allowEmpty' => false,
      'style' => 'width: 300px',
    ));

    $this->addElement('Text', 'icon', array(
      'label' => 'Icon / Icon Class (Note: Not all menus support icons.)',
	  'description' => 'Enter the Icon Class for the menu item.',
      'style' => 'width: 500px',
    ));

    $this->addElement('Checkbox', 'target', array(
      'label' => 'Yes, open this menu in new window when users click on it.',
	  'description' => 'Open in a New Window?',
	  'checkedValue' => '_blank',
      'uncheckedValue' => '',
    ));

    $this->addElement('Checkbox', 'enabled', array(
      'label' => 'Yes, enable this menu item for the Main Navigation menu.',
	  'description' => 'Enable Menu Item?',
      'checkedValue' => '1',
      'uncheckedValue' => '0',
      'value' => '1',
    ));
    $levelOptions = array();
    $levelOptions[''] = 'Everyone';
    foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
        $levelOptions[$level->level_id] = $level->getTitle();
    }
    $this->addElement('Multiselect', 'privacy', array(
        'label' => 'Member Level View Privacy',
        'description' => 'Choose the member levels to which this slide will be displayed. (Press Ctrl + Click to select multiple member levels.)',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions' => $levelOptions,
        'value' => '',
    ));
    if(!in_array($menu->module, array('core', 'invite', 'user', 'chat','sespagebuilder','sesweather','seslike','sestestimonial'))) {

		$category_options['0']='Default';
    if(!in_array($menu->module, array('sesadvpoll','poll','sescredit')) && !$menu->custom) {
            $category_options['1']='Category';
    }
    if(!in_array($menu->module, array('sescredit')) && !$menu->custom) {
            $category_options['2']='Content w-wo category';
    }
    if(!$menu->custom ){
        $category_options['3']='Module Name only';
        $category_options['4']='Normal';
        $category_options['5']='Sub Menu';
    } else if($menu->custom)
        $category_options['6']='Custom';
    if(in_array($menu->module, array('sescommunityads')) && !$menu->custom) {
            $category_options = null;
            $category_options['5']='Sub Menu';
    }
		$this->addElement('Select', 'design_cat', array(
            'label' => 'Choose Design',
			'description' => 'Choose the design type for this menu item.',
            'multiOptions' => $category_options,
            'allowEmpty' => true,
            'required' => false,
			'onchange' => 'designselector(this.value);',
        ));
    }
	 $this->addElement('Radio', 'category_design', array(
            'label' => 'Choose Design',
			'description' => 'Choose the design layout for this menu item.',
            'multiOptions' => array('1' => 'Design 1','2' => 'Design 2','3' => 'Design 3','5' => 'Design 5','16' => 'Design 16','17' => 'Design 17'),
            'allowEmpty' => true,
            'required' => false,
			'onchange' => 'designSettings(this.value);',
     ));
     $contentDesignOptions = array('7' => 'Design 7','9' => 'Design 9','10' => 'Design 10','4' => 'Design 4','15' => 'Design 15');
     if(in_array($menu->module, array('sesproduct','estore')) && !$menu->custom) {
        $contentDesignOptions['8'] = 'Design 8';
    }
	 $this->addElement('Radio', 'content_design', array(
            'label' => 'Choose Design',
			'description' => 'Choose the design layout for this menu item.',
            'multiOptions' => $contentDesignOptions,
            'allowEmpty' => true,
            'required' => false,
			'onchange' => 'designSettings(this.value);',
     ));

	 $this->addElement('Radio', 'module_design', array(
            'label' => 'Choose Design',
			'description' => 'Choose the design layout for this menu item.',
            'multiOptions' => array('12' => 'Design 12','11' => 'Design 11'),
            'allowEmpty' => true,
            'required' => false,
			'onchange' => 'designSettings(this.value);',
     ));
	 $this->addElement('Radio', 'normal_design', array(
            'label' => 'Choose Design',
			'description' => 'Choose the design layout for this menu item.',
            'multiOptions' => array('6' => 'Design 6'),
            'allowEmpty' => true,
            'required' => false,
			'onchange' => 'designSettings(this.value);',
     ));
      $this->addElement('Radio', 'submenu_design', array(
            'label' => 'Choose Design',
			'description' => 'Choose the design layout for this menu item.',
            'multiOptions' => array('18' => 'Design 6'),
            'allowEmpty' => true,
            'required' => false,
			'onchange' => 'designSettings(this.value);',
     ));
	 $this->addElement('Radio', 'custom_design', array(
			'label' => 'Choose Design',
			'description' => 'Choose the design layout for this menu item.',
			'multiOptions' => array('13' => 'Design 13','14' => 'Design 14'),
			'allowEmpty' => true,
			'required' => false,
			'onchange' => 'designSettings(this.value);',
     ));
	$multiOptions= array(
		'creation_date' => 'Recent Tab',
		'like_count'          => 'Most Liked Tab',
		'comment_count'       => 'Most Commented Tab',
		'view_count' => "Most Viewed",
	);
    if(in_array($menu->module,array('sesblog','sesarticle','sesrecipe'))){
        $multiOptions['favourite_count'] ='Most Favourite';
    }
    if(in_array($menu->module,array('event','album','poll','classified','blog','member'))){

    }
    if(in_array($menu->module,array('sesrecipe','sesmenu'))){
        $multiOptions['rating'] ='Most Rated';
        $multiOptions['favourite_count'] ='Most Favourite';
    }
        $multiOptions['week'] ='This Week Tab';
        $multiOptions['month'] ='This Month Tab';


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

	  //Design 8
	//if($menu->design==8) {

		$this->addElement('Text', 'sc1_title', array(
			'label' => 'Section 1 heading name',
			'allowEmpty' => true,
			'required' => false,
			'value' => 'Section 1',
		));

		$this->addElement('Select', 'sc1_order', array(
			'label' => 'Choose option to show section 1',
			'multiOptions' => $multiOptions,
			'value' => 'creation_date',
		));

		$this->addElement('Text', 'sc1_count', array(
			'label' => 'How many content show in Section 1',
			'allowEmpty' => true,
			'required' => false,
			'validators' => array(
            array('Int', true),

			),
		));

		$this->addElement('Text', 'sc2_title', array(
			'label' => 'Section 2 heading name',
			'allowEmpty' => true,
			'required' => false,
			'value' => 'Section 2',
		));

		$this->addElement('Select', 'sc2_order', array(
			'label' => 'Choose option to show section 2',
			'multiOptions' => $multiOptions,
			'value' => 'creation_date',
		));

		$this->addElement('Text', 'sc2_count', array(
			'label' => 'How many content show in Section 2',
			'allowEmpty' => true,
			'required' => false,
			'validators' => array(
			  array('Int', true),
			),
		));

		$this->addElement('Select', 'first_photo', array(
            'label' => 'Photos 1',
            'description' => 'Choose photo 1. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to show.]',
            'multiOptions' => $default_photos_main,
        ));
		$this->first_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

		$this->addElement('Text', 'photo1_link', array(
			'label' => 'URL for Photo 1',
			'description' => 'Enter the URL of the page on which you want to redirect your users when they click on the Photo 1.'
		));

        $this->addElement('Select', 'second_photo', array(
            'label' => 'Photo 2',
			'description' => 'Choose photo 2. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to show.]',
            'multiOptions' => $default_photos_main,
        ));
		$this->second_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

		$this->addElement('Text', 'photo2_link', array(
			'label' => 'URL for Photo 2',
			'description' => 'Enter the URL of the page on which you want to redirect your users when they click on the Photo 2.'
		));

		$this->addElement('Select', 'third_photo', array(
            'label' => 'Photo 3',
            'multiOptions' => $default_photos_main,
        ));
		$this->third_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

		$this->addElement('Text', 'photo3_link', array(
			'label' => 'Url of which page that page you want to open when user click Photos 3',
		));

        $this->addDisplayGroup(array('sc1_title', 'sc1_order','sc1_count','sc2_title', 'sc2_order','sc2_count'),'design8settings');
        $this->addDisplayGroup(array('first_photo', 'photo1_link', 'second_photo', 'photo2_link'), 'design5settings');
        $this->addDisplayGroup(array('third_photo', 'photo3_link'),'design8advertice');

        //design 5
        $this->addElement('MultiCheckbox', 'enabled_tab', array(
			'label' => 'Show Selected Tab',
			'allowEmpty' => true,
			'multiOptions' => $multiOptions,
		));



		// Design 3 and 1
	//if($menu->design == 3 || $menu->design == 1) {
    $this->addElement('Select', 'show_count', array(
        'label' => 'Do you want to show total content count',
        'multiOptions' => array('1' => 'yes','0' => 'No'),
        'allowEmpty' => true,
        'required' => false,
    ));
	//}

	$this->addElement('Select', 'show_icon', array(
		'label' => 'Do you want to show icon',
		'description' => 'Do you want to show icon for this menu item?',
		'multiOptions' => array('1' => 'Yes','0' => 'No'),
		'allowEmpty' => true,
		'required' => false,
	));
    $this->addElement('Text', 'show_cat', array(
        'label' => 'Sub menus to show in single menu',
		'description' => 'Enter the number of sub menu items to show in the single menu.',
        'allowEmpty' => false,
        'required' => false,
        'value' => '1',
        array('Int', true),
    ));
	$this->addElement('Text', 'categories_count', array(
        'label' => 'Categories to show in single menu',
		'description' => 'Enter the number of categories to show in the single menu.',
        'allowEmpty' => true,
        'required' => false,
        'value' => '10',
    ));

    $this->addElement('Text', 'content_count', array(
		'label' => 'No. of content show in single menu',
		'description' => 'Enter the number of content to show in the single menu.',
		'allowEmpty' => true,
		'required' => false,
		  array('Int', true),
	));

    $this->addElement('Text', 'emptyfeild_txt', array(
        'label' => 'Text for empty field',
		'description' => 'Enter the text you want to show when the field is empty.',
        'allowEmpty' => false,
        'required' => false,
        'value' => 'Sorry Data is Not found',
    ));
    $this->addElement('Select', 'emptyfeild_img', array(
            'label' => 'Default image for empty field.',
			'description' => 'Choose the image you want to show when the field is empty.',
            'multiOptions' => $default_photos_main,
    ));
    $this->addDisplayGroup(array('emptyfeild_txt', 'emptyfeild_img'),'emptyfeild');

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }
}
