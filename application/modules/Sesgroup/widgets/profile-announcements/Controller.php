<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesgroup_Widget_ProfileAnnouncementsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (!Engine_Api::_()->core()->hasSubject())
      return $this->setNoRender();
    $group = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('announcements', 'sesgroup')
            ->getGroupAnnouncementPaginator(array('group_id' => $group->group_id));
    $paginator->setItemCountPerPage($this->_getParam('limit_data', 5));
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
    if ($paginator->getTotalItemCount() < 1)
      return $this->setNoRender();
  }

}
