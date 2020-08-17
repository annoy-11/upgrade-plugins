<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sessportz_Widget_MembersController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->heading = $this->_getParam('heading', 1);
    $this->view->height = $this->_getParam('height', 150);
    $this->view->width = $this->_getParam('width', 148);
    $this->view->showTitle = $this->_getParam('showTitle', 1);
		$this->view->showType = $this->_getParam('showType', 1);
    $member_count = $this->_getParam('memberCount', 33);

    $table = Engine_Api::_()->getDbtable('users', 'user');
    $info = $table->select()
            ->from($table, array('COUNT(*) AS count'))
            ->where('enabled = ?', true)
            ->query()
            ->fetch();
    $this->view->member_count = $info['count'];
    $sessportz_widget = Zend_Registry::isRegistered('sessportz_widget') ? Zend_Registry::get('sessportz_widget') : null;
    if(empty($sessportz_widget)) {
      return $this->setNoRender();
    }
    $select = $table->select()
            ->where('search = ?', 1)
            ->where('enabled = ?', 1)
            ->where('photo_id != ?', 0)
            ->order('Rand()')
            ->limit($member_count);

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);

    // Set item count per page and current page number
    $paginator->setItemCountPerPage($this->_getParam('memberCount', 33));
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

    // Do not render if nothing to show
    if ($paginator->getTotalItemCount() <= 0)
      return $this->setNoRender();
  }

}
