<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagenote_Widget_ProfileInfoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    // Get subject and check auth
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('pagenote');
    if (!$subject)
      return $this->setNoRender();

    $this->view->pageTags = $subject->tags()->getTagMaps();
    $this->view->criteria = $this->_getParam('criteria', array('date', 'like', 'comment', 'favourite', 'view', 'owner','tag', 'creationDate'));
  }
}
