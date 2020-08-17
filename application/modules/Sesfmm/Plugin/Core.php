<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfmm
 * @package    Sesfmm
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-01-03 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfmm_Plugin_Core extends Zend_Controller_Plugin_Abstract {

   public function routeShutdown(Zend_Controller_Request_Abstract $request) {

        if (substr($request->getPathInfo(), 1, 5) == "admin") {
            $params = $request->getParams();
            if($params['module'] == 'core' &&  $params['controller'] == "admin-files") {
                $request->setModuleName('sesfmm');
                $request->setControllerName('admin-files');
                $request->setActionName($params['action']);
                $request->setParam('moduleName', 'sesfmm');
            }
        }
   }
}
