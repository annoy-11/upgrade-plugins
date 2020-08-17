<?php

class Widget_SespopmemController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $popularitycriteria = $this->_getParam('popularitycriteria', 'creation_date');
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

    $select = $table->select()
            ->where('search = ?', 1)
            ->where('enabled = ?', 1)
            //->where('photo_id != ?', 0)
            ->limit($member_count);
    if($params['popularitycriteria'] == 'random') {
      $select->order('Rand()');
    } else {
      $select->order($popularitycriteria . " DESC");
    }
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);

    // Set item count per page and current page number
    $paginator->setItemCountPerPage($this->_getParam('memberCount', 33));
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

    // Do not render if nothing to show
    if ($paginator->getTotalItemCount() <= 0)
      return $this->setNoRender();
  }
}
