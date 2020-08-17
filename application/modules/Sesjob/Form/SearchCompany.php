<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SearchCompany.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Form_SearchCompany extends Engine_Form {

  protected $_searchTitle;
  protected $_categoriesSearch;

  public function setSearchTitle($title) {
    $this->_searchTitle = $title;
    return $this;
  }
  public function getSearchTitle() {
    return $this->_searchTitle;
  }

  public function setCategoriesSearch($title) {
    $this->_categoriesSearch = $title;
    return $this;
  }
  public function getCategoriesSearch() {
    return $this->_categoriesSearch;
  }

  public function init() {

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $this->setAttribs(array('id' => 'filter_form','class' => 'global_form_box'))->setMethod('GET');
    $this->setAction($view->url(array('module' => 'sesjob', 'controller' => 'company', 'action' => 'browse'), 'default', true));

    $viewer = Engine_Api::_()->user()->getViewer();

    if ($this->_searchTitle == 'yes') {
      $this->addElement('Text', 'search', array(
	'label' => 'Search Company'
      ));
    }

    $categories = Engine_Api::_()->getDbtable('industries', 'sesjob')->getIndustriesAssoc();
    if (count($categories) > 0 && $this->_categoriesSearch == 'yes') {
      $categories = array('0'=>'')+$categories;
      $this->addElement('Select', 'industry_id', array(
            'label' => 'Industry',
            'multiOptions' => $categories,
      ));
    }

    $this->addElement('Hidden', 'page', array(
      'order' => 100
    ));

    $this->addElement('Hidden', 'tag', array(
      'order' => 101
    ));

    $this->addElement('Button', 'submit', array(
      'label' => 'Search',
      'type' => 'submit'
    ));
  }
}
