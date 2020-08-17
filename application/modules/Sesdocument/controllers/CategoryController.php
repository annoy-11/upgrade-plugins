<?php

class Sesdocument_CategoryController extends Core_Controller_Action_Standard {
  function init(){

  }
  public function browseAction() {
    $this->_helper->content->setEnabled();
  }

  //function to get images as per given album id.
  public function documentDataAction() {
          
    $document_id = $this->_getParam('sesdocument_id', false);
    if ($document_id) {
      //default params
      if (isset($_POST['params']))
        $params = json_decode($_POST['params'], true);
      $this->view->title_truncation = $title_truncation = isset($params['title_truncation']) ? $params['title_truncation'] : $this->_getParam('title_truncation', '100');
      $this->view->description_truncation = $description_truncation = isset($params['description_truncation']) ? $params['description_truncation'] : $this->_getParam('description_truncation', '150');die("hey");
      $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('by', 'view', 'title', 'follow', 'followButton', 'featuredLabel', 'sponsoredLabel', 'description', 'albumPhoto', 'albumPhotos', 'photoThumbnail', 'albumCount'));
      foreach ($show_criterias as $show_criteria)
        $this->view->{$show_criteria . 'Active'} = $show_criteria;
      $resultArray = array();
      $albumDatas = $resultArray['document_data'] =  Engine_Api::_()->getDbTable('sesdocuments', 'sesdocument')->getDocumentSelect(array('sesdocument_id'=> $document_id,'limit_data'=> 1, 'fetchAll' => 1)); 
      $this->view->resultArray = $resultArray;
    } else {
      $this->_forward('requireauth', 'error', 'core');
    }
  }

  public function indexAction() {

    $category_id = $this->_getParam('category_id', 0);

    if ($category_id)
      $category_id = Engine_Api::_()->getDbtable('categories', 'sesdocument')->getCategoryId($category_id);
    else
      return;

    $category = Engine_Api::_()->getItem('sesdocument_category', $category_id);
    if ($category)
      Engine_Api::_()->core()->setSubject($category);
    else
      $this->_forward('requireauth', 'error', 'core');
    
    // item is a type of object chanel
    // if this is sending a message id, the user is being directed from a coversation
    // check if member is part of the conversation
    $message_id = $this->getRequest()->getParam('message');
    $message_view = false;
    if ($message_id) {
      $conversation = Engine_Api::_()->getItem('messages_conversation', $message_id);
      if ($conversation->hasRecipient(Engine_Api::_()->user()->getViewer())) {
        $message_view = true;
      }
    }
    $this->view->message_view = $message_view;
    // Render
    $this->_helper->content->setEnabled();
  }

}
