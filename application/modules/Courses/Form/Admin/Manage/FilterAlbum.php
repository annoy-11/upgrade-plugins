<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: FilterAlbum.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Form_Admin_Manage_FilterAlbum extends Engine_Form
{
  protected $_creationDate;
  protected $_albumTitle;
  public function setAlbumTitle($title) {
    $this->_albumTitle = $title;
     return $this;
  }
  public function getAlbumTitle() {
    return $this->_albumTitle;
  }
  public function setCreationDate($title) {
	  $this->_creationDate = $title;
    return $this;
  }
  public function getCreationDate() {
    return $this->_creationDate;
  }
  public function init()
  {
		parent::init();
    $this
      ->clearDecorators()
      ->addDecorator('FormElements')
      ->addDecorator('Form')
      ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
      ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'));
    $this
      ->setAttribs(array(
        'id' => 'filter_form',
        'class' => 'global_form_box',
      ))
      ->setMethod('GET');
	if($this->getAlbumTitle() == 'yes'){
		$text = 'Photo Title';
	}else{
		$text = 'Title';
	}
    $titlename = new Zend_Form_Element_Text('title');
    $titlename
      ->setLabel($text)
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
      ->addDecorator('HtmlTag', array('tag' => 'div'));

    $classroomtitlename = new Zend_Form_Element_Text('classroomtitle');
    $classroomtitlename
      ->setLabel('Classroom Title')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
      ->addDecorator('HtmlTag', array('tag' => 'div'));

	 if($this->getAlbumTitle() == 'yes'){
		$album_title = new Zend_Form_Element_Text('album_title');
    $album_title
      ->setLabel('Album Title')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
			->addDecorator('HtmlTag', array('tag' => 'div'));
	}
  $owner_name = new Zend_Form_Element_Text('owner_name');
  $owner_name
    ->setLabel('Owner Name')
    ->clearDecorators()
    ->addDecorator('ViewHelper')
    ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
    ->addDecorator('HtmlTag', array('tag' => 'div'));
	if($this->getCreationDate() != 'no'){
    $subform = new Engine_Form(array(
        'description' => 'Order Date Ex (yyyy-mm-dd)',
        'elementsBelongTo'=> 'date',
        'order'=>990,
        'decorators' => array(
            'FormElements',
            array('Description', array('placement' => 'PREPEND', 'tag' => 'label', 'class' => 'form-label')),
            array('HtmlTag', array('tag' => 'div', 'class' => 'form-wrapper', 'id' =>'integer-wrapper'))
        )
    ));
    $subform->addElement('Text', 'date_to', array('placeholder'=>'to','autocomplete'=>'off'));
    $subform->addElement('Text', 'date_from', array('placeholder'=>'from','autocomplete'=>'off'));
    $this->addSubForm($subform, 'date');
	}
  $submit = new Zend_Form_Element_Button('search', array('type' => 'submit'));
  $submit
    ->setLabel('Search')
    ->clearDecorators()
    ->addDecorator('ViewHelper')
    ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'buttons'))
    ->addDecorator('HtmlTag2', array('tag' => 'div'));
		$arrayItem = array();
		$arrayItem = !empty($titlename)?	array_merge($arrayItem,array($titlename)) : '';
		$arrayItem = !empty($classroomtitlename)?	array_merge($arrayItem,array($classroomtitlename)) : '';
		$arrayItem = !empty($album_title) ?	array_merge($arrayItem,array($album_title)) : $arrayItem;
		$arrayItem = !empty($owner_name) ?	array_merge($arrayItem,array($owner_name)) : $arrayItem;
		$arrayItem = !empty($date)?	array_merge($arrayItem,array($date)) : $arrayItem;
		$arrayItem = !empty($submit)?	array_merge($arrayItem,array($submit)) : '';
    $this->addElements($arrayItem);
  }
}
