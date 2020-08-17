<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslandingpage_Widget_Design6Widget6Controller extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->getElement()->removeDecorator('Title');
    $this->view->title = $this->_getParam('title', "MEET MEMBERS");
    
    $popularitycriteria = $this->_getParam('popularitycriteria', 'creation_date');
    $limit = $this->_getParam('limit', 14);

    $this->view->paginator = $members = Engine_Api::_()->seslandingpage()->getMembers(array('limit' => $limit, 'popularitycriteria' => $popularitycriteria));
    if (count($members) == 0)
      return $this->setNoRender();
	}
}