<?php

class Sesgroupalbum_Widget_AlbumHomeErrorController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('albums', 'sesgroupalbum')->getAlbumPaginator(array());
		$this->view->canCreate = Engine_Api::_()->authorization()->isAllowed('sesgroupalbum_album', null, 'create');
		$this->view->itemType = $this->_getParam('itemType','album');
    if (count($paginator) > 0)
      return $this->setNoRender();
  }

}