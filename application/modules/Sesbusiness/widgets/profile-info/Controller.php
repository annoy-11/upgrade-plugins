<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Widget_ProfileInfoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Get subject and check auth
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('businesses');
    if (!$subject)
      return $this->setNoRender();

    $this->view->businessTags = $subject->tags()->getTagMaps();
    $this->view->criteria = $this->_getParam('criteria', array('date', 'categories', 'like', 'comment', 'favourite', 'view', 'follow', 'owner','tag', 'creationDate'));
  }

}
