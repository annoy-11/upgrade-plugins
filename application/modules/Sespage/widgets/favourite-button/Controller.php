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
class Sespage_Widget_FavouriteButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->viewer_id = $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (empty($viewerId))
      return $this->setNoRender();
    if (!Engine_Api::_()->core()->hasSubject('sespage_page') || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.allow.favourite', 1))
      return $this->setNoRender();
    $this->view->subject = $page = Engine_Api::_()->core()->getSubject('sespage_page');
  }

}
