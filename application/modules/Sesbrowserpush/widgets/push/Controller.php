<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbrowserpush_Widget_PushController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $settings = Engine_Api::_()->getApi('settings', 'core');
        $server_key = $settings->getSetting('sesbrowserpush.serverkey');
        $code = $settings->getSetting('sesbrowserpush.snippet');
        if(empty($server_key) || empty($code))
            return $this->setNoRender();
        $sesbrowserpush_widget = Zend_Registry::isRegistered('sesbrowserpush_widget') ? Zend_Registry::get('sesbrowserpush_widget') : null;
        if(empty($sesbrowserpush_widget))
          return $this->setNoRender();
        $this->view->script = $settings->getSetting('sesbrowserpush.snippet');
        $this->view->siteSSL = 1; //(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? 1 : 0;
        if(!$this->view->script)
            $this->setNoRender();
        $this->view->type = $settings->getSetting('sesbrowserpush.type',0);
        $this->view->bellalways = $settings->getSetting('sesbrowserpush_bellalways', '1');
    }
}
