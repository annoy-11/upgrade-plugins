<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesexpose_Widget_MemberCloudController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->heading = $this->_getParam('heading', 1);
    $this->view->showTitle = $this->_getParam('showTitle', 1);
    $this->view->height = $this->_getParam('height', 200);
    $this->view->width = $this->_getParam('width', 200);
    $member_count = $this->_getParam('memberCount', 33);

    $table = Engine_Api::_()->getDbtable('users', 'user');
    $info = $table->select()
            ->from($table, array('COUNT(*) AS count'))
            ->where('enabled = ?', true)
            ->query()
            ->fetch();
    $this->view->member_count = $info['count'];

    $select = $table->select()
            ->where('search = ?', 1)
            ->where('enabled = ?', 1)
            ->where('photo_id != ?', 0)
            ->order('Rand()');
    //->limit($member_count);

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);

    // Set item count per page and current page number
    $paginator->setItemCountPerPage($this->_getParam('memberCount', 33));
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

    // Do not render if nothing to show
    if ($paginator->getTotalItemCount() <= 0)
      return $this->setNoRender();
  }

}