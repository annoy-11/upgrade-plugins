<?php

/**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Core.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Emessages_Plugin_Core extends Zend_Controller_Plugin_Abstract
{

    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        if (substr($request->getPathInfo(), 1, 8) == "messages") {
            /*$usersAllowed = Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('messages', Engine_Api::_()->user()->getViewer()->level_id, 'auth');
            if ($usersAllowed!="none") {*/
            $params = $request->getParams();
            $action = !isset($params['action']) || empty($params['action']) || strchr($params['action'], '|') || $params['action'] == 'view' || $params['action'] == 'compose' || $params['action'] == 'inbox' ? 'index' : $params['action'];
            if ($params['module'] == 'messages' && $params['controller'] == "messages" && empty($_GET['format'])) {
                $request->setModuleName('emessages');
                $request->setControllerName('messages');
                $request->setActionName($action);
                $request->setParam('moduleName', 'emessages');
            }
            //	}
            /*	else
                {
                    return false;
                }*/
        }

    }
}
