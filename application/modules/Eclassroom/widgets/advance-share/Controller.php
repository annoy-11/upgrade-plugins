<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Widget_AdvanceShareController extends Engine_Content_Widget_Abstract {
    public function indexAction() {
      
        $this->view->viewer = Engine_Api::_()->user()->getViewer();
        $viewer_id = $this->view->viewer->getIdentity();
        if (!Engine_Api::_()->core()->hasSubject())
            return $this->setNoRender();
        $this->view->allowAdvShareOptions = $allowAdvShareOptions = $this->_getParam('advShareOptions', array('privateMessage', 'siteShare', 'quickShare', 'addThis', 'tellAFriend'));
        if (empty($allowAdvShareOptions))
            return $this->setNoRender();
        if (!$viewer_id && !in_array('tellAFriend', $allowAdvShareOptions) && (!in_array('addThis', $allowAdvShareOptions) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.addthis', 0)))
            return $this->setNoRender();
    }
}
