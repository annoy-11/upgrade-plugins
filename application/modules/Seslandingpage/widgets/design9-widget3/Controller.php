<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslandingpage_Widget_Design9Widget3Controller extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    //Left Side Block
    $leftresourcetype = $this->_getParam('leftsideresourcetype', '');
    $leftpopularitycriteria = $this->_getParam('leftsidepopularitycriteria', 'creation_date');
    if(!$leftresourcetype)
      return $this->setNoRender();
  
    //$this->getElement()->removeDecorator('Title');
    $this->view->backgroundimage = $this->_getParam('backgroundimage', '');
    $this->view->leftsideheading = $this->_getParam('leftsideheading', null);
    $this->view->leftsidedescription = $this->_getParam('leftsidedescription', '');
    $this->view->leftsidefonticon = $this->_getParam('leftsidefonticon', null);
    $this->view->leftsideseeallbuttontext = $this->_getParam('leftsideseeallbuttontext', null);
    $this->view->leftsideseeallbuttonurl = $this->_getParam('leftsideseeallbuttonurl', null);
    $leftsidelimit = $this->_getParam('leftsidelimit', 3);
    
    $this->view->leftsideresults = $leftsideresults = Engine_Api::_()->seslandingpage()->getContents(array('limit' => $leftsidelimit, 'popularitycriteria' => $leftpopularitycriteria, 'resourcetype' => $leftresourcetype));

    if(count($leftsideresults) == 0)
      return $this->setNoRender();
      
      
    //Right Side Block
    $rightresourcetype = $this->_getParam('rightsideresourcetype', '');
    $rightpopularitycriteria = $this->_getParam('rightsidepopularitycriteria', 'creation_date');
    if(!$rightresourcetype)
      return $this->setNoRender();

    $this->view->rightsideheading = $this->_getParam('rightsideheading', null);
    $this->view->rightsidedescription = $this->_getParam('rightsidedescription', '');
    $this->view->rightsidefonticon = $this->_getParam('rightsidefonticon', null);
    $this->view->rightsideseeallbuttontext = $this->_getParam('rightsideseeallbuttontext', null);
    $this->view->rightsideseeallbuttonurl = $this->_getParam('rightsideseeallbuttonurl', null);
    $rightsidelimit = $this->_getParam('rightsidelimit', 3);
    
    $this->view->rightsideresults = $rightsideresults = Engine_Api::_()->seslandingpage()->getContents(array('limit' => $rightsidelimit, 'popularitycriteria' => $rightpopularitycriteria, 'resourcetype' => $rightresourcetype));

    if(count($rightsideresults) == 0)
      return $this->setNoRender();
	
	}
}