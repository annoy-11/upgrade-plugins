<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ShowDetails.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Controller_Action_Helper_ShowDetailsSesgroup extends Zend_Controller_Action_Helper_Abstract {

  public function preDispatch() {
    $front = Zend_Controller_Front::getInstance();
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    $package = 0;
    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesgrouppackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppackage.enable.package', 0)) {
      $package = 1;
    }
    if (!defined('SESGROUPPACKAGE')) define('SESGROUPPACKAGE', $package);
    $contactDetail = 1;
    if (!$viewerId) {
      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.enable.contact.details', 0))
        $contactDetail = 0;
    }
    if (!defined('SESGROUPSHOWCONTACTDETAIL')) define('SESGROUPSHOWCONTACTDETAIL', $contactDetail);
  }

}
