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

class Seslandingpage_Widget_Design5Widget6Controller extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $this->view->title = $this->_getParam('title', "MEET <span>MEMBERS</span></span>");
    $this->view->seeallbuttontext = $this->_getParam('seeallbuttontext', null);
    $this->view->seeallbuttonurl = $this->_getParam('seeallbuttonurl', null);
    $limit = $this->_getParam('limit', 8);
    $this->getElement()->removeDecorator('Title');
    $userTable = Engine_Api::_()->getDbtable('users', 'user');
    $select = $userTable->select()
                      ->where('search = ?', 1)
                      ->where('enabled = ?', 1)
                      ->where('photo_id != ?', 0)
                      ->order('Rand()');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage($limit);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    if ($paginator->getTotalItemCount() <= 0)
      return $this->setNoRender();
	
	}
}