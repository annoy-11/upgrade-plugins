<?php

class Sesvideosell_Widget_ButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $subject = Engine_Api::_()->core()->getSubject();
    $this->view->subject_id = $subject_id = $subject->getIdentity();

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    
    if (empty($viewer->getIdentity()))
      return $this->setNoRender();

    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();
    
    $order_id = Engine_Api::_()->getDbTable('orders', 'sesvideosell')->getOrderId(array('video_id' => $subject_id, 'user_id' => $viewer_id));
    if($order_id)
      return $this->setNoRender();

    if(empty($subject->price))
      return $this->setNoRender();

    if($subject->owner_id == $viewer_id)
      return $this->setNoRender();
  }
}