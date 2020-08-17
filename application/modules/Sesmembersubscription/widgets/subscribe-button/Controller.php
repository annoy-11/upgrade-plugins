<?php

class Sesmembersubscription_Widget_SubscribeButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $subject = Engine_Api::_()->core()->getSubject();
    $this->view->subject_id = $subject_id = $subject->getIdentity();

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
//     if (empty($viewer->getIdentity()))
//       return $this->setNoRender();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();
    
    if($viewer_id  == $subject_id)
      return $this->setNoRender();

    $sespaymentapi = Engine_Api::_()->getDbtable('packages', 'sespaymentapi');
    $package_id = $sespaymentapi->select()
                              ->from($sespaymentapi->info('name'), new Zend_Db_Expr('package_id'))
                              ->where('resource_id = ?', $subject_id)
                              ->where('resource_type = ?', 'user')
                              ->query()
                              ->fetchColumn();
    if(empty($package_id))
      return $this->setNoRender();
      
    $this->view->package = $package = Engine_Api::_()->getItem('sespaymentapi_package', $package_id);
    $this->view->package_id = $package->getIdentity();

    $this->view->transaction = Engine_Api::_()->getDbTable('transactions','sespaymentapi')->getItemTransaction(array('user_id' => $viewer_id,'resource_id' => $subject_id));
  }
}