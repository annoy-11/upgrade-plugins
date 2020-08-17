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
class Sespoke_Widget_RecentTopController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->showType = $this->_getParam('showType', 0);
    $this->view->popularity = $this->_getParam('popularity', 'recent');
    $this->view->action = $action = $this->_getParam('action', null);
    $limit = $this->_getParam('itemCount', 3);
    $this->view->count = lcfirst($action) . '_count'; 
    if ($this->view->popularity == 'top') {
      $this->view->results = $results = Engine_Api::_()->getDbtable('userinfos', 'sespoke')->getResults(array('count' => $this->view->count, 'limit' => $limit, 'action' => 'recent'));
    } else {
      $manageactions = Engine_Api::_()->getDbtable('manageactions', 'sespoke')->getResults(array('name' => $action, 'enabled' => 1));
      $this->view->results = $results = Engine_Api::_()->getDbtable('pokes', 'sespoke')->getResults(array('manageaction_id' => $manageactions[0]['manageaction_id'], 'limit' => $limit));
    }
    if (count($results) <= 0)
      return $this->setNoRender();
  }

}
