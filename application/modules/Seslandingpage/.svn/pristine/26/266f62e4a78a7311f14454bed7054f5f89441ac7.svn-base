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

class Seslandingpage_Widget_Design6Widget3Controller extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $leftresourcetype = $this->_getParam('leftresourcetype', '');
    $leftpopularitycriteria = $this->_getParam('leftpopularitycriteria', 'creation_date');
    if(!$leftresourcetype)
      return $this->setNoRender();
  
    //$this->getElement()->removeDecorator('Title');
    $this->view->leftsideheading = $this->_getParam('leftsideheading', null);
    $this->view->backgroundimage = $this->_getParam('backgroundimage', '');
    $this->view->leftsidefonticon = $this->_getParam('leftsidefonticon', null);
    $this->view->leftseeallbuttontext = $this->_getParam('leftseeallbuttontext', null);
    $this->view->leftseeallbuttonurl = $this->_getParam('leftseeallbuttonurl', null);
    $limit = $this->_getParam('limit', 4);
    
    $this->view->leftsideresults = $leftsideresults = Engine_Api::_()->seslandingpage()->getContents(array('limit' => $limit, 'popularitycriteria' => $leftpopularitycriteria, 'resourcetype' => $leftresourcetype));

    if(count($leftsideresults) == 0)
      return $this->setNoRender();
      
      
    $rightresourcetype = $this->_getParam('rightresourcetype', '');
    $rightpopularitycriteria = $this->_getParam('rightpopularitycriteria', 'creation_date');
    if(!$rightresourcetype)
      return $this->setNoRender();

    $this->view->rightsideshowstats = $this->_getParam('rightsideshowstats', array());
    $this->view->rightsideheading = $this->_getParam('rightsideheading', null);
    $this->view->rightseeallbuttontext = $this->_getParam('rightseeallbuttontext', null);
    $this->view->rightseeallbuttonurl = $this->_getParam('rightseeallbuttonurl', null);
    $limit = $this->_getParam('limit', 4);
    
    $this->view->rightsideresults = $rightsideresults = Engine_Api::_()->seslandingpage()->getContents(array('limit' => $limit, 'popularitycriteria' => $rightpopularitycriteria, 'resourcetype' => $rightresourcetype));

    if(count($rightsideresults) == 0)
      return $this->setNoRender();
	}
}