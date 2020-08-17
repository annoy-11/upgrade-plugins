<?php

class Sesdocument_Widget_FeaturedSponsoredCarouselController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->ratings = $ratings= Engine_Api::_()->getApi('settings', 'core')->getSetting('rating','1');
    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);

    $this->view->height = $this->_getParam('height', '180');
		$this->view->imageheight = $this->_getParam('imageheight', '180');
    $this->view->width = $this->_getParam('width', '180');
    $this->view->title_truncation = $this->_getParam('title_truncation', '45');
    $this->view->viewType = $this->_getParam('viewType', 'horizontal');
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

		$this->view->view_type = $this->_getParam('view_type', 'list');
		$this->view->gridInsideOutside = $this->_getParam('gridInsideOutside', 'in');
		$this->view->mouseOver = $this->_getParam('mouseOver', 'over');


    $show_criterias = isset($value['show_criterias']) ? $value['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'by', 'title', 'socialSharing', 'featuredLabel', 'sponsoredLabel', 'verifiedLabel', 'likeButton'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $value['limit'] = $this->_getParam('limit_data', 5);
    $value['criteria'] = $this->_getParam('criteria', 5);
    $value['info'] = $this->_getParam('info', 'recently_created');
    $value['order'] = $this->_getParam('order', '');
    $value['fetchAll'] = true;

    $this->view->paginator = Engine_Api::_()->getDbTable('sesdocuments', 'sesdocument')->getDocumentSelect($value);
    if (count($this->view->paginator) <= 0)
      return $this->setNoRender();
  }
}
