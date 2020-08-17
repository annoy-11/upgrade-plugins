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
class Sespoke_Widget_SuggestionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->showType = $this->_getParam('showType', null);
    $this->view->action = $action = $this->_getParam('action', null);
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_level_id = $viewer->level_id;
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();
    $limit = $this->_getParam('itemCount', 3);
    if (empty($this->view->viewer_id))
      return $this->setNoRender();

    $this->view->manageactions = $manageactions = Engine_Api::_()->getDbtable('manageactions', 'sespoke')->getResults(array('name' => $action, 'enabled' => 1));
    $results = Engine_Api::_()->getDbtable('pokes', 'sespoke')->getResults(array('manageaction_id' => $manageactions[0]['manageaction_id'], 'limit' => $limit, 'user_id' => $viewer_id));
    $userIds = array();
    foreach ($results as $result) {
      $userIds[] = $result['receiver_id'];
    }

    $usersTable = Engine_Api::_()->getDbtable('users', 'user');
    $usersTableName = $usersTable->info('name');
    $select = $usersTable->select()
            ->from($usersTableName, array('user_id'))
            ->where('user_id <> ?', $viewer_id)
            ->limit($limit)
            ->order('RAND()');
    if ($userIds)
      $select->where('user_id NOT IN(?)', $userIds);

    $this->view->results = $results = $select->query()->fetchAll();

    if (count($results) <= 0)
      return $this->setNoRender();
  }

}
