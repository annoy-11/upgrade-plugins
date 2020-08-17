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

class Sesbrowserpush_Widget_NotificationButtonController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $settings = Engine_Api::_()->getApi('settings', 'core');
//         if(!$settings->getSetting('sesbrowserpush.notificationpush',1))
//             return $this->setNoRender();

        $server_key = $settings->getSetting('sesbrowserpush.serverkey');
        $code = $settings->getSetting('sesbrowserpush.snippet');
        if(empty($server_key) || empty($code))
            return $this->setNoRender();
        $sesbrowserpush_widget = Zend_Registry::isRegistered('sesbrowserpush_widget') ? Zend_Registry::get('sesbrowserpush_widget') : null;
        if(empty($sesbrowserpush_widget))
          return $this->setNoRender();
        $this->view->type = $settings->getSetting('sesbrowserpush.type',0);
        $this->view->title = $settings->getSetting('sesbrowserpush.title', 'Would you like to receive notifications & stay updated always?');
        $this->view->descr = $settings->getSetting('sesbrowserpush.descr', 'Notifications can be turned off anytime from your browser settings.');
        $this->view->logo = $settings->getSetting('sesbrowserpush.logo', '');

        $this->view->showbell = $settings->getSetting('sesbrowserpush.bellalways','1');

        $this->view->width = $settings->getSetting('sesbrowserpush.width', '500');
        $this->view->height = $settings->getSetting('sesbrowserpush.height', '400');
    }
}
