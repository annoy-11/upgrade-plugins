<?php
class Sesstories_Widget_StoryController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->view->is_ajax = $isAjax = $this->_getParam('is_ajax',false);
    $page = $this->view->page = $this->_getParam('page',1);
    
    //fetch Results
    $paginator = Engine_Api::_()->getDbTable('stories','sesstories')->getUserStories(array('groupby'=>true));
    
    
  }
}
