<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesloginpopup
 * @package    Sesloginpopup
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesloginpopup_Widget_LoginSignupPopupController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_mini');

        $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
        $this->view->popupdesign = $this->_getParam('popupdesign',1);
        $this->view->poupup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesloginpopup.popupsign', 1);

        $this->view->loginsignup_logo = ''; //Engine_Api::_()->getApi('settings', 'core')->getSetting('sesloginpopup.loginsignuplogo', '');

        $this->view->form = $form = new Sesloginpopup_Form_Login();
        $this->view->storage = Engine_Api::_()->storage();

        $this->view->loginsignupbgimage = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesloginpoup.popup.photo', '');
    }
}
