<?php

class Sesmembersubscription_Widget_SubscriptionBenefitsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    if (!Engine_Api::_()->core()->hasSubject('user')) {
      $this->view->user = $user = $viewer;
    } else {
      $this->view->user = $user = Engine_Api::_()->core()->getSubject('user');
    }
    
    $subject_id = $user->getIdentity();
    
    $this->view->edit = $user->authorization()->isAllowed($viewer, 'edit');
    
    $this->view->adminMessage = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembersubscription.message', "This member has enable subscription to view the profile. So, please click on “Subscribe to This Profile” button to subscribe to this member's profile.");
    
    //Subscribe Plan Value
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