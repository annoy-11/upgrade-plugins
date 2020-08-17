<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Widget_AdvanceShareController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->view->viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject() ||  !Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.share.pet', 1))
    { return $this->setNoRender(); }
    $this->view->allowAdvShareOptions = $this->_getParam('advShareOptions',array('privateMessage','siteShare','quickShare','addThis'));
  }
}
