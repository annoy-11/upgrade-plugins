<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AlbumSearch.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Form_AlbumSearch extends Engine_Form {

  protected $_searchTitle;
	protected $_searchFor;
	protected $_browseBy;
	protected $_friendsSearch;
	
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

  public function init() {
  
    parent::init();

    $searchFor = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module'=>'sesgroup','controller'=>'album','action'=>'browse'));

    $this->setAttribs(array(
      'id' => 'filter_form',
      'class' => 'global_form_box',
    ))->setAction($searchFor);

    if ($this->_searchTitle == 'yes') {
      $this->addElement('Text', 'search', array(
        'label' => 'Search '.ucwords($this->getSearchFor()).'s'.'/Keyword:'
      ));
    }
	$filterOptions =  array('recentlySPcreated' => 'Recently Created','mostSPviewed' => 'Most Viewed','mostSPliked' => 'Most Liked', 'mostSPcommented' => 'Most Commented','mostSPfavourite'=>'Most Favourite');
	$arrayOptions = $filterOptions;
      $filterOptions = array();
      foreach ($arrayOptions as $filterOption) {
        $value = str_replace(array('SP',''), array(' ',' '), $filterOption);
        $filterOptions[$filterOption] = ucwords($value);
      }
      $filterOptions = array(''=>'')+$filterOptions;
	 $restapi=Zend_Controller_Front::getInstance()->getRequest()->getParam( 'restApi', null );
	if ($restapi == 'Sesapi'){
		if ($this->_browseBy == 'yes') {
		 $this->addElement('Select', 'sort', array(
        'label' => 'Browse By:',
        'multiOptions' => $filterOptions,
      ));
		}
	}else{
		 if ($this->_browseBy == 'yes') {
      $this->addElement('Select', 'sort', array(
        'label' => 'Browse By:',
        'multiOptions' => array(''),
      ));
		}
	}
   
    
		
		if ($this->_friendsSearch == 'yes' && Engine_Api::_()->user()->getViewer()->getIdentity() != 0) {
      $this->addElement('Select', 'show', array(
        'label' => 'View:',
        'multiOptions' => array(
            '1' => 'Everyone\'s '.ucwords($this->getSearchFor()).'s',
            '2' => 'Only My Friend\'s '.ucwords($this->getSearchFor()).'s',
        ),
      ));
    }

    $this->addElement('Button', 'submit', array(
      'label' => 'Search',
      'type' => 'submit'
    ));
		$this->addElement('Dummy','loading-img-sesgroup', array(
      'content' => '<img src="application/modules/Core/externals/images/loading.gif" id="sesgroup-category-widget-img" alt="Loading" />',
   ));
  }
}