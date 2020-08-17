<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagepoll
 * @package    Sespagepoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Search.php  2018-10-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagepoll_Form_Search extends Engine_Form{
	protected $_searchTitle;
	public function getSearchTitle() {
		return $this->_searchTitle;
	}
  public function init(){
			$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $this->setAttribs(array(
        'id' => 'filter_form',
        'class' => 'global_form_box',
      ))
      ->setMethod('GET')
			//->setAction()
      ->setAction($view->url(array('action'=>'browse'),'sespagepoll_general',true))
	  
    ;
    parent::init();
    $this->addElement('Text', 'search', array(
      'label' => 'Search Polls:',
    ));
    $this->addElement('Text', 'searchpage', array(
      'label' => 'Search Pages:',
	  'class'=>$this->getSearchTitle() == 'hide' ? $hideClass : '',
	  
    ));
    $this->addElement('Select', 'show', array(
      'label' => 'Show',
      'multiOptions' => array(
        '1' => 'Everyone\'s Polls',
        '2' => 'Only My Friends\' Polls',
      ),
    ));

    $this->addElement('Select', 'closed', array(
      'label' => 'Status',
      'multiOptions' => array(
        '' => 'All Polls',
        '0' => 'Only Open Polls',
        '1' => 'Only Closed Polls',
      ),
    ));
    $this->addElement('Select', 'order', array(
      'label' => 'Browse By:',
      'multiOptions' => array(
        'recently_created' => 'Most Recent',
        'most_viewed' => 'Most viewed',
        'most_commented' => 'Most commented',
        'most_liked' => 'Most liked',
        'most_favourite' => 'Most favourite',
        'most_voted' => 'Most voted',
      ),
    ));
    $this->addElement('Button', 'find', array(
      'type' => 'submit',
      'label' => 'Search',
      'ignore' => true,
      'order' => 10000001,
    ));
  }
}
