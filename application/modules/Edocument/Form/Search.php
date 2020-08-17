<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Search.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Form_Search extends Engine_Form {

  protected $_searchTitle;
  protected $_searchFor;
  protected $_browseBy;
  protected $_categoriesSearch;
  protected $_friendsSearch;
  protected $_hasPhoto;

  public function setFriendsSearch($title) {
    $this->_friendsSearch = $title;
    return $this;
  }
  public function getFriendsSearch() {
    return $this->_friendsSearch;
  }
  public function setSearchTitle($title) {
    $this->_searchTitle = $title;
    return $this;
  }
  public function getSearchTitle() {
    return $this->_searchTitle;
  }
  public function setSearchFor($title) {
    $this->_searchFor = $title;
    return $this;
  }
  public function getSearchFor() {
    return $this->_searchFor;
  }
  public function setBrowseBy($title) {
    $this->_browseBy = $title;
    return $this;
  }
  public function getBrowseBy() {
    return $this->_browseBy;
  }
  public function setCategoriesSearch($title) {
    $this->_categoriesSearch = $title;
    return $this;
  }
  public function getCategoriesSearch() {
    return $this->_categoriesSearch;
  }
  public function setHasPhoto($title) {
    $this->_hasPhoto = $title;
    return $this;
  }

  public function getHasPhoto() {
    return $this->_hasPhoto;
  }

  public function init() {

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

    $this->setAttribs(array('id' => 'filter_form','class' => 'global_form_box'))->setMethod('GET');

    $this->setAction($view->url(array('module' => 'edocument', 'controller' => 'index', 'action' => 'browse'), 'default', true));

    $viewer = Engine_Api::_()->user()->getViewer();

    if ($this->_searchTitle == 'yes') {
      $this->addElement('Text', 'search', array(
        'label' => 'Search Documents'
      ));
    }

    if ($this->_browseBy == 'yes') {
      $this->addElement('Select', 'sort', array(
        'label' => 'Browse By',
        'multiOptions' => array(),
      ));
    }

    if ($this->_friendsSearch == 'yes' && $viewer->getIdentity() != 0) {
      $this->addElement('Select', 'show', array(
        'label' => 'Show',
        'multiOptions' => array(
            '1' => 'Everyone\'s '.ucwords($this->getSearchFor()).'s',
            '2' => 'Only My Friend\'s '.ucwords($this->getSearchFor()).'s',
        ),
      ));
    }

    $categories = Engine_Api::_()->getDbtable('categories', 'edocument')->getCategoriesAssoc();
    if (count($categories) > 0 && $this->_categoriesSearch == 'yes') {
        $categories = array('0'=>'')+$categories;
        $this->addElement('Select', 'category_id', array(
            'label' => 'Category',
            'multiOptions' => $categories,
            'onchange' => "showSubCategory(this.value);",
        ));

        //Add Element: Sub Category
        $this->addElement('Select', 'subcat_id', array(
            'label' => "2nd-level Category",
            'allowEmpty' => true,
            'required' => false,
            'multiOptions' => array('0'=>''),
            'registerInArrayValidator' => false,
            'onchange' => "showSubSubCategory(this.value);"
        ));

        //Add Element: Sub Sub Category
        $this->addElement('Select', 'subsubcat_id', array(
            'label' => "3rd-level Category",
            'allowEmpty' => true,
            'registerInArrayValidator' => false,
            'required' => false,
            'multiOptions' => array('0'=>''),
        ));
    }

    $this->addElement('Hidden', 'page', array(
        'order' => 100
    ));

    $this->addElement('Hidden', 'tag', array(
        'order' => 101
    ));

    $this->addElement('Hidden', 'start_date', array(
        'order' => 102
    ));

    $this->addElement('Hidden', 'end_date', array(
        'order' => 103
    ));

    if ($this->getHasPhoto() != 'no') {
        $this->addElement('Checkbox', 'has_photo', array(
            'label' => 'Only Documents With Photos',
        ));
    }

    $this->addElement('Button', 'submit', array(
        'label' => 'Search',
        'type' => 'submit'
    ));
  }
}
