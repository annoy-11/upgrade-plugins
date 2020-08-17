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

class Seslandingpage_Widget_Design3Widget7Controller extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->getElement()->removeDecorator('Title');
    $this->view->title = $this->_getParam('title', "MEET MEMBERS");
    
    // Tab 1 Work
    $this->view->tabtitle1 = $this->_getParam('tabtitle1', 'All');
    $popularitycriteria1 = $this->_getParam('popularitycriteria1', 'creation_date');
    $limit1 = $this->_getParam('limit1', 14);
    $this->view->paginator1 = Engine_Api::_()->seslandingpage()->getMembers(array('limit' => $limit1, 'popularitycriteria' => $popularitycriteria1));
    
    // Tab 2 Work
    $this->view->tabtitle2 = $this->_getParam('tabtitle2', 'All');
    $popularitycriteria2 = $this->_getParam('popularitycriteria2', 'creation_date');
    $limit2 = $this->_getParam('limit2', 8);
    $this->view->paginator2 = Engine_Api::_()->seslandingpage()->getMembers(array('limit' => $limit2, 'popularitycriteria' => $popularitycriteria2));
    
    
    // Tab 3 Work
    $this->view->tabtitle3 = $this->_getParam('tabtitle3', 'All');
    $popularitycriteria3 = $this->_getParam('popularitycriteria3', 'creation_date');
    $limit3 = $this->_getParam('limit3', 8);
    $this->view->paginator3 = Engine_Api::_()->seslandingpage()->getMembers(array('limit' => $limit3, 'popularitycriteria' => $popularitycriteria3));
    
    if(count($this->view->paginator1) == 0 || count($this->view->paginator2) == 0 || count($this->view->paginator1) == 0)
      return $this->setNoRender();
	
	}
}