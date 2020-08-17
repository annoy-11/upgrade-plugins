<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Search.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Form_Search extends Engine_Form {
  protected $_searchTitle;
  protected $_industry;
  protected $_educationlevel;
  protected $_employmenttype;
  protected $_searchcompTitle;
  protected $_searchFor;
  protected $_browseBy;
  protected $_categoriesSearch;
  protected $_locationSearch;
  protected $_kilometerMiles;
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

  public function getEmploymenttype() {
    return $this->_employmenttype;
  }
  public function setEmploymenttype($title) {
    $this->_employmenttype = $title;
    return $this;
  }

  public function getEducationlevel() {
    return $this->_educationlevel;
  }
  public function setEducationlevel($title) {
    $this->_educationlevel = $title;
    return $this;
  }

  public function getIndustry() {
    return $this->_industry;
  }
  public function setIndustry($title) {
    $this->_industry = $title;
    return $this;
  }

  public function getSearchcompTitle() {
    return $this->_searchcompTitle;
  }
  public function setSearchcompTitle($title) {
    $this->_searchcompTitle = $title;
    return $this;
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
  public function setLocationSearch($title) {
    $this->_locationSearch = $title;
    return $this;
  }
  public function getLocationSearch() {
    return $this->_locationSearch;
  }
  public function setKilometerMiles($title) {
    $this->_kilometerMiles = $title;
    return $this;
  }
  public function getKilometerMiles() {
    return $this->_kilometerMiles;
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
    $this->setAction($view->url(array('module' => 'sesjob', 'controller' => 'index', 'action' => 'browse'), 'default', true));

    $viewer = Engine_Api::_()->user()->getViewer();

    if ($this->_searchTitle == 'yes') {
      $this->addElement('Text', 'search', array(
	'label' => 'Search Jobs'
      ));
    }

    if ($this->_searchcompTitle == 'yes') {
        $this->addElement('Text', 'search_company', array(
            'label' => 'Search Company'
        ));
    }

    if ($this->_industry == 'yes') {
        $industries = Engine_Api::_()->getDbTable('industries', 'sesjob')->getIndustriesAssoc();
        if(count($industries) > 0) {
            $industries = array('' => '') + $industries;
            $this->addElement('Select', 'industry_id', array(
                'label' => 'Industry',
                'multiOptions' => $industries,
            ));
        }
    }

    if($this->_employmenttype == 'yes') {
        $employments = Engine_Api::_()->getDbTable('employments', 'sesjob')->getEmploymentsAssoc();
        if(count($employments) > 0) {
            $employments = array('' => '') + $employments;
            $this->addElement('Select', 'employment_id', array(
                'label' => 'Employment Type',
                'multiOptions' => $employments,
            ));
        }
    }

//     if($this->_educationlevel == 'yes') {
//         $educations = Engine_Api::_()->getDbTable('educations', 'sesjob')->getEducationsAssoc();
//         if(count($educations) > 0) {
//             $this->addElement('MultiCheckbox', 'education_id', array(
//                 'label' => 'Education Level',
//                 'multiOptions' => $educations,
//             ));
//         }
//     }


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

    $categories = Engine_Api::_()->getDbtable('categories', 'sesjob')->getCategoriesAssoc();
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

    $this->addElement('Hidden', 'company_id', array(
      'order' => 110
    ));

    if ($this->_locationSearch == 'yes' && $this->getSearchFor() == 'job') {
      /*Location Elements*/
      $this->addElement('Text', 'location', array(
	'label' => 'Location',
	'id' =>'locationSesList',
	'filters' => array(
	  new Engine_Filter_Censor(),
	  new Engine_Filter_HtmlSpecialChars(),
	),
      ));
      $this->addElement('Text', 'lat', array(
	'label' => 'Lat',
	'id' =>'latSesList',
	'filters' => array(
	  new Engine_Filter_Censor(),
	  new Engine_Filter_HtmlSpecialChars(),
	),
      ));
      $this->addElement('Text', 'lng', array(
	'label' => 'Lng',
	'id' =>'lngSesList',
	'filters' => array(
	  new Engine_Filter_Censor(),
	  new Engine_Filter_HtmlSpecialChars(),
	),
      ));
      if ($this->_kilometerMiles == 'yes') {
	if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.search.type',1) == 1)
	$searchType = 'Miles';
	else
	$searchType = 'Kilometer:';
	$this->addElement('Select', 'miles', array(
	'label' => $searchType,
	'allowEmpty' => true,
	'required' => false,
	'multiOptions' => array('0'=>'','1'=>'1','5'=>'5','10'=>'10','20'=>'20','50'=>'50','100'=>'100','200'=>'200','500'=>'500','1000'=>'1000'),
	'value'=>'1000',
	'registerInArrayValidator' => false,
	));
      }
    }

    if ($this->getHasPhoto() != 'no') {
      $this->addElement('Checkbox', 'has_photo', array(
          'label' => 'Only Jobs With Photos',
         // 'class' => $this->getHasPhoto() == 'hide' ? $hideClass : '',
      ));
    }

    $this->addElement('Button', 'submit', array(
      'label' => 'Search',
      'type' => 'submit'
    ));
  }
}
