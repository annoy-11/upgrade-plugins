<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessegpay_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
   public function __construct($application) {
    parent::__construct($application);
    
    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Sessegpay_Plugin_Core);
    
    if(!class_exists('Payment_Model_DbTable_Packages', false))
        include_once APPLICATION_PATH .'/application/modules/Payment/Model/DbTable/Packages.php';
      Engine_Api::_()->getDbTable('packages', 'payment')->setRowClass('Sessegpay_Model_Package');
  }

  protected function _initFrontController() {
    $this->initActionHelperPath();
    include APPLICATION_PATH . '/application/modules/Sessegpay/controllers/Checklicense.php';
  }
}
