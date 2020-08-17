<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_Widget_ProfileTagsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    if(!Engine_Api::_()->core()->hasSubject())  
      return $this->setNoRender();
    
    $subject = Engine_Api::_()->core()->getSubject();
    
    $this->view->paginator = Engine_Api::_()->eblog()->tagCloudItemCore('', $subject->getIdentity());
    //$paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', '25'));
    
    if(count($this->view->paginator) == 0) 
		return $this->setNoRender();
  }
}
