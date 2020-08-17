<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespoke_Widget_ButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->showIconText = $this->_getParam('showIconText', 1);
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    
    if (empty($viewer->getIdentity()))
      return $this->setNoRender();
      
    $this->view->viewer_level_id = $viewer->level_id;
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->item = $item = Engine_Api::_()->core()->getSubject();
    $this->view->type = $item->getType();
    $this->view->id = $id = $item->getIdentity();

    if ($viewer_id == $id)
      return $this->setNoRender();

    $this->view->results = $results = Engine_Api::_()->getDbtable('manageactions', 'sespoke')->getResults(array('enabled' => 1));
    if (count($results) < 0)
      return $this->setNoRender();
  }

}
