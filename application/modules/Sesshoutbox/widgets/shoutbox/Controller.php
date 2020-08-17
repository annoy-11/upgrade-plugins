<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox
 * @package    Sesshoutbox
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesshoutbox_Widget_ShoutboxController extends Engine_Content_Widget_Abstract {

    public function indexAction(){

        $this->view->allParams = $allParams = $this->_getAllParams();
        if(empty($allParams['shoutbox_id']))
            return $this->setNoRender();

        $this->view->viewer = Engine_Api::_()->user()->getViewer();
        $this->view->viewer_id = $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();

        $this->view->shoutbox = $shoutbox = Engine_Api::_()->getItem('sesshoutbox_shoutbox', $allParams['shoutbox_id']);
        if(empty($shoutbox->shoutbox_id))
            return $this->setNoRender();

        $this->view->contents = Engine_Api::_()->getDbTable('contents', 'sesshoutbox')->getShoutboxContents(array('shoutbox_id' => $allParams['shoutbox_id'], 'limit' => 10));

        $this->view->shoutbox_rule = Engine_Api::_()->getApi('settings', 'core')->getSetting("sesshoutbox.rules", '');

        $returnValue = Engine_Api::_()->sesshoutbox()->checkPrivacySetting($shoutbox->getIdentity());
        if ($returnValue == false) {
            return $this->setNoRender();
        }
    }
}
