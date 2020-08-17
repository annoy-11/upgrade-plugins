<?php

class Sesdocument_Widget_tagDocumentsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->tagCloudData = Engine_Api::_()->sesdocument()->tagCloudItemCore('fetchAll', array('type' => 'sesdocument'));

    if (count($this->view->tagCloudData) <= 0)
      return $this->setNoRender();
  }

}
