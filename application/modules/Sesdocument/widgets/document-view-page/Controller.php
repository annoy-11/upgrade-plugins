<?php

class Sesdocument_Widget_DocumentViewPageController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $this->view->widgetParams = $this->_getAllParams();

        $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
        $this->view->ratings = $ratings= Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.rating','1');
        $this->view->sharings = $sharings= Engine_Api::_()->getApi('settings', 'core')->getSetting('sharing','1');

        $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('sesdocument_id', null);
        $document_id = Engine_Api::_()->getDbTable('sesdocuments', 'sesdocument')->getDocumentId($id);

        $this->view->document  = Engine_Api::_()->getItem('sesdocument', $document_id);
        $document = Engine_Api::_()->core()->getSubject('sesdocument');
        $this->view->subject = $this->view->subject();
        $this->view->viewer_id = $viewer->getIdentity();
        $this->view->viewer_id = $viewer->getIdentity();
        $this->view->rating_count = Engine_Api::_()->sesdocument()->ratingCount($document->getIdentity());
        $this->view->document = $document;
        $this->view->rated = Engine_Api::_()->sesdocument()->checkRated($document->getIdentity(), $viewer->getIdentity());
        $this->view->can_edit = $can_edit =  Engine_Api::_()->authorization()->isAllowed($document, $viewer, 'edit');
        $this->view->can_delete = $can_delete =  Engine_Api::_()->authorization()->isAllowed($document, $viewer, 'delete');
    }
}
