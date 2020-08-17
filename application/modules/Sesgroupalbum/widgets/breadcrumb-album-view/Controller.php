<?php

class Sesgroupalbum_Widget_BreadcrumbAlbumViewController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    if (!Engine_Api::_()->core()->hasSubject('sesgroupalbum_album'))
      return $this->setNoRender();
    $this->view->album = Engine_Api::_()->core()->getSubject('sesgroupalbum_album');

    $this->view->group = Engine_Api::_()->getItem('group', $this->view->album->group_id);
  }
}