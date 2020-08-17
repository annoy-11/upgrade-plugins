<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_Widget_PeopleLikeItemController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    if (!Engine_Api::_()->core()->hasSubject('eblog_blog'))
      return $this->setNoRender();

    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('eblog_blog');
    
    $this->getElement()->removeDecorator('Container');
		$this->view->title = $this->getElement()->getTitle();
		$this->view->limit_data = $this->_getParam('limit_data','11');
		
		$this->view->paginator = $paginator = Engine_Api::_()->eblog()->likeItemCore(array('id' => $subject->getIdentity(), 'type' => $subject->getType()));
		$paginator->setItemCountPerPage($this->view->limit_data);    
    if($paginator->getTotalItemCount() <= 0)
      return $this->setNoRender();
  }
}
