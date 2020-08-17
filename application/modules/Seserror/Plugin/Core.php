<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seserror_Plugin_Core extends Zend_Controller_Plugin_Abstract {
  public function onRenderLayoutDefault($event, $mode = null) {
    $request = Zend_Controller_Front::getInstance()->getRequest();
    if ((substr($request->getPathInfo(), 1, 5) != "admin")) {
      $viewer = Engine_Api::_()->user()->getViewer();
      $comingsoon_enable = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.comingsoonenable', 0);
      $flag = 1;
      if($viewer->getIdentity()) {
        if($viewer->level_id == 1)
          $flag = 0;
      }
      if($comingsoon_enable && $flag && $viewer->getIdentity() == 0) {
        $moduleName = $request->getModuleName();
        $actionName = $request->getActionName();
        $controllerName = $request->getControllerName();
        if($actionName != 'contact') {
          $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
          $redirector->gotoRoute(array('module' => 'seserror', 'controller' => 'error', 'action' => 'comingsoon'), 'seserror_comingsoon', false);
        }
      }
    }
  }
}
