<?php

class Sessubscribeuser_Widget_ButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $subject = Engine_Api::_()->core()->getSubject();
    $this->view->subject_id = $subject_id = $subject->getIdentity();

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    
    if (empty($viewer->getIdentity()))
      return $this->setNoRender();

    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();
    
    if($viewer_id  == $subject_id)
      return $this->setNoRender();
    
    $sessubscribeuser = Engine_Api::_()->getDbtable('packages', 'sessubscribeuser');
    $result = $sessubscribeuser->select()
                              ->from($sessubscribeuser->info('name'), new Zend_Db_Expr('package_id'))
                              ->where('user_id = ?', $subject_id)
                              ->query()
                              ->fetchColumn();
    if(empty($result))
      return $this->setNoRender();
    $this->view->package = $package = Engine_Api::_()->getItem('sessubscribeuser_package', $result);
    $this->view->package_id = $package->getIdentity();
    
    $this->view->transaction = Engine_Api::_()->getDbTable('transactions','sessubscribeuser')->getItemTransaction(array('user_id' => $viewer_id,'subject_id' => $subject_id));
    
    if (empty($result))
      return $this->setNoRender();
  }

}
