<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Eblog_Widget_AdvanceShareController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject() ||  !Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1))
      return $this->setNoRender();
      
    $this->view->allowAdvShareOptions = $this->_getParam('advShareOptions',array('privateMessage','siteShare','quickShare','addThis'));
  }
}
