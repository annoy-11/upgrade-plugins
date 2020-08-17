<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: FilterAlbum.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroup_Form_Admin_Manage_FilterAlbum extends Engine_Form
{

	protected $_creationDate;
	protected $_albumTitle;
	//protected $_groupTitle;
	
// 	public function setGroupTitle($title) {
//   $this->_groupTitle = $title;
//     return $this;
//   }
//   
//   public function getGroupTitle() {
//     return $this->_groupTitle;
//   }

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
      ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'))
      ;

    $this
      ->setAttribs(array(
        'id' => 'filter_form',
        'class' => 'global_form_box',
      ))
      ->setMethod('GET');

    $titlename = new Zend_Form_Element_Text('title');
    $titlename
      ->setLabel('Title')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
      ->addDecorator('HtmlTag', array('tag' => 'div'));
      
    $grouptitlename = new Zend_Form_Element_Text('grouptitle');
    $grouptitlename
      ->setLabel('Group Title')
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
		$date = new Zend_Form_Element_Text('creation_date');
    $date
      ->setLabel('Creation Date: ex (2000-12-01)')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
      ->addDecorator('HtmlTag', array('tag' => 'div'));		
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
		$arrayItem = !empty($grouptitlename)?	array_merge($arrayItem,array($grouptitlename)) : '';
		$arrayItem = !empty($album_title) ?	array_merge($arrayItem,array($album_title)) : $arrayItem;
		$arrayItem = !empty($owner_name) ?	array_merge($arrayItem,array($owner_name)) : $arrayItem;
		$arrayItem = !empty($date)?	array_merge($arrayItem,array($date)) : $arrayItem;
		$arrayItem = !empty($submit)?	array_merge($arrayItem,array($submit)) : '';
    $this->addElements($arrayItem);
  }
}