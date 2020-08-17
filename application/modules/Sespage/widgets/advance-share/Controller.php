<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Widget_AdvanceShareController extends Engine_Content_Widget_Abstract {

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
