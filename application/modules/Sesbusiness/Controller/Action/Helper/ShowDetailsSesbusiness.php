<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ShowDetails.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Controller_Action_Helper_ShowDetailsSesbusiness extends Zend_Controller_Action_Helper_Abstract {

  public function preDispatch() {
    $front = Zend_Controller_Front::getInstance();
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    $package = 0;
    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesbusinesspackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspackage.enable.package', 0)) {
      $package = 1;
    }
    if (!defined('SESBUSINESSPACKAGE')) define('SESBUSINESSPACKAGE', $package);
    $contactDetail = 1;
    if (!$viewerId) {
      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.enable.contact.details', 0))
        $contactDetail = 0;
    }
    define('SESBUSINESSSHOWCONTACTDETAIL', $contactDetail);
  }

}
