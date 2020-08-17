<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ShowDetails.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Controller_Action_Helper_ShowDetails extends Zend_Controller_Action_Helper_Abstract {

  public function preDispatch() {
    $front = Zend_Controller_Front::getInstance();
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    $package = 0;
    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sespagepackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagepackage.enable.package', 0)) {
      $package = 1;
    }
    if (!defined('SESPAGEPACKAGE')) define('SESPAGEPACKAGE', $package);
    $contactDetail = 1;
    if (!$viewerId) {
      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.enable.contact.details', 0))
        $contactDetail = 0;
    }
    if (!defined('SESPAGESHOWCONTACTDETAIL')) define('SESPAGESHOWCONTACTDETAIL', $contactDetail);
  }

}
