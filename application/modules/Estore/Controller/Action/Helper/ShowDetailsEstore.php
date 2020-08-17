<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ShowDetails.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Controller_Action_Helper_ShowDetailsEstore extends Zend_Controller_Action_Helper_Abstract {
  public function preDispatch() {
    $front = Zend_Controller_Front::getInstance();
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    $package = 0;
    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('estorepackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('estorepackage.enable.package', 0)) {
      $package = 1;
    }
    define('ESTOREPACKAGE', $package);
    $contactDetail = 1;
    if (!$viewerId) {
      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.enable.contact.details', 0))
        $contactDetail = 0;
    }
    define('ESTORESHOWCONTACTDETAIL', $contactDetail);
  }
}
