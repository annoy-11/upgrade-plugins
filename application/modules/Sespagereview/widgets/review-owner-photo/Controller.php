<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagereview_Widget_ReviewOwnerPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->title = $this->_getParam('showTitle', 1);
    if (!Engine_Api::_()->core()->hasSubject('pagereview'))
      return $this->setNoRender();
    $this->view->item = $user  = Engine_Api::_()->getItem('user', Engine_Api::_()->core()->getSubject('pagereview')->owner_id);
    if (!$user) 
      return $this->setNoRender();
  }

}
