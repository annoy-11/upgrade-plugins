<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Widget_FavouriteButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->viewer_id = $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (empty($viewerId))
      return $this->setNoRender();
    if (!Engine_Api::_()->core()->hasSubject('stores') || !Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.favourite', 1))
      return $this->setNoRender();
    $this->view->subject = Engine_Api::_()->core()->getSubject('stores');
  }

}
