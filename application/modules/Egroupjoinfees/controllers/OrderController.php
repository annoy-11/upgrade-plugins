<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: OrderController.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Egroupjoinfees_OrderController extends Core_Controller_Action_Standard {
	public function init() {
	 if (!$this->_helper->requireUser->isValid())
			return;
    $id = $this->_getParam('order_id', null);
    $order = Engine_Api::_()->getItem('egroupjoinfees_order', $id);
    if ($order) {
        Engine_Api::_()->core()->setSubject($order);
    }else{
			 return $this->_forward('requireauth', 'error', 'core');	
		}
	}
	public function viewAction(){
		$order_id = $this->_getParam('order_id', null);
    $this->view->order = $order = Engine_Api::_()->core()->getSubject();
		if(!$order_id || !$order)
			return $this->_forward('notfound', 'error', 'core');
		$this->view->format = $this->_getParam('format','');
		$id = $order->group_id;
		$group = null;
    if ($id) {
      $group = Engine_Api::_()->getItem('sesgroup_group', $id);
      if ($group) {
     	 $this->view->group = $group;
      }else
				return $this->_forward('notfound', 'error', 'core');
		}
		if(!$group)
			return $this->_forward('notfound', 'error', 'core');	
		$this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
	}
}
