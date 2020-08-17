<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sestwitterclone_Widget_LandingPageController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $settings = Engine_Api::_()->getApi('settings', 'core');
        $this->view->storage = Engine_Api::_()->storage();

        $this->view->landingpagelogo = $settings->getSetting('sestwitterclone.landingpagelogo', '');

        $this->view->textblock1 = $settings->getSetting('sestwitterclone.textblock1', 'Search your Interests.');
        $this->view->block1icon = $settings->getSetting('sestwitterclone.block1icon', '');

        $this->view->textblock2 = $settings->getSetting('sestwitterclone.textblock2', 'Share your Ideas with others.');
        $this->view->block2icon = $settings->getSetting('sestwitterclone.block2icon', '');

        $this->view->textblock3 = $settings->getSetting('sestwitterclone.textblock3', 'Join & Communicate with people.');
        $this->view->block3icon = $settings->getSetting('sestwitterclone.block3icon', '');

        $this->view->loginform  = $settings->getSetting('sestwitterclonetheme.loginform',1);
        $this->view->rightheading = $settings->getSetting('sestwitterclone.rightheading', 'Explore what\'s going on around in the outside world!');
        $this->view->rightdes = $settings->getSetting('sestwitterclone.rightdes', 'Start your first tweet');

    }
}
