<?php

class Sesgroupalbum_Widget_BreadcrumbPhotoViewController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    if (!Engine_Api::_()->core()->hasSubject('sesgroupalbum_photo'))
      return $this->setNoRender();
    $this->view->photo = Engine_Api::_()->core()->getSubject('sesgroupalbum_photo');
    $this->view->album = Engine_Api::_()->getItem('sesgroupalbum_album', $this->view->photo->album_id);
    $this->view->group = Engine_Api::_()->getItem('group', $this->view->photo->group_id);
  }
}