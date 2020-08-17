<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Edocument_Widget_FavouriteButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (empty($this->view->viewer_id))
      return $this->setNoRender();

    if (!Engine_Api::_()->core()->hasSubject('edocument') || !Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.favourite', 1))
      return $this->setNoRender();

    $this->view->edocument = Engine_Api::_()->core()->getSubject('edocument');
  }
}
