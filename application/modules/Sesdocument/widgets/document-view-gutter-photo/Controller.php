<?php

class Sesdocument_Widget_DocumentViewGutterPhotoController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $this->view->title = $this->_getParam('showTitle', 1);
        if (Engine_Api::_()->core()->hasSubject('sesdocument')) {
            $item = Engine_Api::_()->core()->getSubject();
            $user = Engine_Api::_()->getItem('user', $item->user_id);
        }
        $this->view->item = $user;
        if (!$item)
            return $this->setNoRender();
    }
}
