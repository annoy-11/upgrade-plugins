<?php

class Sesdocument_Form_Filter_Browse extends Engine_Form {

  protected $_locationSearch;
  protected $_kilometerMiles;
  protected $_friendsSearch;
  protected $_searchTitle;
	protected $_alphabetSearch;
  protected $_searchType;
	protected $_friendType;
  protected $_browseBy;
  protected $_categoriesSearch;
	protected $_stateSearch;
	protected $_citySearch;
	protected $_countrySearch;
	protected $_zipSearch;
	protected $_venueSearch;
	protected $_endDate;
	protected $_startDate;

	public function setAlphabetSearch($title) {
    $this->_alphabetSearch = $title;
    return $this;
  }

  public function getAlphabetSearch() {
    return $this->_alphabetSearch;
  }

	public function setStartDate($title) {
    $this->_startDate = $title;
    return $this;
  }

  public function getStartDate() {
    return $this->_startDate;
  }
	public function setEndDate($title) {
    $this->_endDate = $title;
    return $this;
  }

  public function getEndDate() {
    return $this->_endDate;
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

  public function setFriendsSearch($title) {
    $this->_friendsSearch = $title;
    return $this;
  }
  public function getFriendsSearch() {
    return $this->_friendsSearch;
  }

	public function setFriendType($title) {
    $this->_friendType = $title;
    return $this;
  }

  public function getFriendType() {
    return $this->_friendType;
  }

  public function setSearchType($title) {
    $this->_searchType = $title;
    return $this;
  }

  public function getSearchType() {
    return $this->_searchType;
  }
  public function setSearchTitle($title) {
    $this->_searchTitle = $title;
    return $this;
  }

  public function getSearchTitle() {
    return $this->_searchTitle;
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




	 public function setCountrySearch($title) {
    $this->_countrySearch = $title;
    return $this;
  }

  public function getCountrySearch() {
    return $this->_countrySearch;
  }
	 public function setStateSearch($title) {
    $this->_stateSearch = $title;
    return $this;
  }

  public function getStateSearch() {
    return $this->_stateSearch;
  }
	 public function setCitySearch($title) {
    $this->_citySearch = $title;
    return $this;
  }

  public function getCitySearch() {
    return $this->_citySearch;
  }
	 public function setZipSearch($title) {
    $this->_zipSearch = $title;
    return $this;
  }

  public function getZipSearch() {
    return $this->_zipSearch;
  }
	 public function setVenueSearch($title) {
    $this->_venueSearch = $title;
    return $this;
  }

  public function getVenueSearch() {
    return $this->_venueSearch;
  }
  public function init() {

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$identity = $view->identity;
    $this
    ->setAttribs(array(
      'id' => 'filter_form',
      'class' => 'global_form_box',
    ))
    ->setMethod('GET')
    ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesdocument', 'controller' => 'index', 'action' => 'browse')));
 $hideClass = 'sesdocument_widget_advsearch_hide_'.$identity;

    if ($this->getSearchTitle() != 'no') {
      $this->addElement('Text', 'search_text', array(
												'label' => 'Search Documents/Keyword:',
												'class'=>$this->getSearchTitle() == 'hide' ? $hideClass : '',

      ));
    }

    if ($this->getBrowseBy() != 'no') {
      $filterOptions = $this->_searchType;
      $arrayOptions = $filterOptions;
      $filterOptions = array();
      foreach ($arrayOptions as $key => $filterOption) {
					$value = str_replace(array('SP',''), array(' ',' '), $filterOption);
					$optionKey = Engine_Api::_()->sesdocument()->getColumnName($value);
          if($value == "starttime"){
            $value = "Start Time";
          }
					$filterOptions[$optionKey] = ucwords($value);
      }
      $filterOptions = array(''=>'')+$filterOptions;
					$this->addElement('Select', 'order', array(
				'label' => 'Browse By:',
				'multiOptions' => $filterOptions,
				'class'=>$this->getBrowseBy() == 'hide' ? $hideClass : '',
      ));
    }

    if ($this->_friendsSearch != 'no') {
      $this->addElement('Select', 'view', array(
				'label' => 'View:',
				'multiOptions' => array(''),
				'class'=>$this->getFriendsSearch() == 'hide' ? $hideClass : '',
      ));
    }

    if ($this->_categoriesSearch != 'no') {
      $categories =  $categories = Engine_Api::_()->getDbtable('categories', 'sesdocument')->getCategoriesAssoc(array('uncategories'=>true));
      if (count($categories) > 0) {
				 $categories = array('' => 'All Category') + $categories;
			$this->addElement('Select', 'category_id', array(
					'label' => 'Category:',
					'multiOptions' => $categories,
					'onchange' => 'showSubCategory(this.value);',
					'class'=>$this->_categoriesSearch == 'hide' ? $hideClass : '',
			));
			$this->addElement('Select', 'subcat_id', array(
						'label' => "Sub Category",
						'allowEmpty' => true,
						'required' => false,
						'class'=>$this->_categoriesSearch == 'hide' ? $hideClass : '',
						'multiOptions' => array('0' => 'Please select sub category'),
						'registerInArrayValidator' => false,
						'onchange' => "showSubSubCategory(this.value);"
			));
			//Add Element: Sub Sub Category
			$this->addElement('Select', 'subsubcat_id', array(
					'label' => "3rd Category",
					'allowEmpty' => true,
					'registerInArrayValidator' => false,
					'class'=>$this->_categoriesSearch == 'hide' ? $hideClass : '',
					'required' => false,
					'multiOptions' => array('0' => 'Please select 3rd category'),
			));
      }
    }
		if($this->getAlphabetSearch() != 'no'){
			$alphabetArray[] = '';
			foreach (range('A', 'Z') as $char) {
					$alphabetArray[strtolower($char)] =  $char ;
			}
				$this->addElement('Select', 'alphabet', array(
      'label' => 'Alphabet:',
			 'multiOptions' => $alphabetArray,
			 'class'=>$this->getAlphabetSearch() == 'hide' ? $hideClass : '',
      'filters' => array(
				new Engine_Filter_Censor(),
				new Engine_Filter_HtmlSpecialChars(),
      ),
    ));
		}



		$this->addElement('Cancel', 'advanced_options_search_'.$identity, array(
        'label' => 'Show Advanced Settings',
        'link' => true,
				'class'=>'active',
        'href' => 'javascript:;',
        'onclick' => 'return false;',
        'decorators' => array(
            'ViewHelper'
        )
    	));

      $this->addElement('Button', 'submit', array(
	  'label' => 'Search',
	  'type' => 'submit'
      ));
    $this->addElement('Dummy','loading-img-sesdocument', array(
        'content' => '<img src="application/modules/Core/externals/images/loading.gif" alt="Loading" />',
   ));
  }

}
