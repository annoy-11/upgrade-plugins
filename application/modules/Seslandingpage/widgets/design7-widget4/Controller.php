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

class Seslandingpage_Widget_Design7Widget4Controller extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->resourcetype = $resourcetype = $this->_getParam('resourcetype', '');
    if(!$resourcetype)
      return $this->setNoRender();
  
    $this->getElement()->removeDecorator('Title');
    $this->view->title = $this->_getParam('title', null);
    $this->view->description = $this->_getParam('description', null);
    $this->view->seeallbuttontext = $this->_getParam('seeallbuttontext', null);
    $this->view->seeallbuttonurl = $this->_getParam('seeallbuttonurl', null);
    $popularitycriteria = $this->_getParam('popularitycriteria', 'creation_date');
    $this->view->fonticon = $this->_getParam('fonticon', null);
    $this->view->descriptiontruncation = $this->_getParam('descriptiontruncation', 100);
    $this->view->showstats = $this->_getParam('showstats', array());
    $limit = $this->_getParam('limit', 2);
    
    $this->view->results = $result = Engine_Api::_()->seslandingpage()->getContents(array('limit' => $limit, 'popularitycriteria' => $popularitycriteria, 'resourcetype' => $resourcetype));
    if(count($result) == 0)
      return $this->setNoRender();
	
	}
}