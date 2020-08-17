<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecentlogin
 * @package    Sesrecentlogin
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesrecentlogin_Widget_RecentLoginsController extends Engine_Content_Widget_Abstract {

    public function indexAction() {
        $this->view->viewer_id = $viewer = Engine_Api::_()->user()->getViewer()->getIdentity();
        $sesrecentlogin_widget = Zend_Registry::isRegistered('sesrecentlogin_widget') ? Zend_Registry::get('sesrecentlogin_widget') : null;
        if(empty($sesrecentlogin_widget)) {
        return $this->setNoRender();
        }
    }
}
