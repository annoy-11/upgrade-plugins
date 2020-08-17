<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspackage
 * @package    Sesbusinesspackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinesspackage_Widget_BusinessRenewButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $business_id = $this->_getParam('business_id', false);
    if ((!Engine_Api::_()->core()->hasSubject() && !$business_id ) || !Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesbusinesspackage')) {
      return $this->setNoRender();
    }
    if ($business_id)
      $business = $this->view->business = Engine_Api::_()->getItem('businesses', $business_id);
    else
      $business = $this->view->business = Engine_Api::_()->core()->getSubject();

    $this->view->transaction = Engine_Api::_()->getDbTable('transactions', 'sesbusinesspackage')->getItemTransaction(array('order_package_id' => $business->orderspackage_id, 'business' => $business));
    $this->view->package = Engine_Api::_()->getItem('sesbusinesspackage_package', $business->package_id);
    if (!$this->view->package)
      return $this->setNoRender();
  }

}
