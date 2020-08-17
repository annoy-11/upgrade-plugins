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

class Sespagereview_Widget_ReviewTakerPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->title = $this->_getParam('showTitle', 1);
    if (!Engine_Api::_()->core()->hasSubject('pagereview'))
      return $this->setNoRender();
    $this->view->item = $page  = Engine_Api::_()->getItem('sespage_page', Engine_Api::_()->core()->getSubject('pagereview')->page_id);
    if (!$page) 
      return $this->setNoRender();
  }

}
