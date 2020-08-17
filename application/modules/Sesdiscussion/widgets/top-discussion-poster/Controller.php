<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesdiscussion_Widget_TopDiscussionPosterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->height = $this->_getParam('height', '48');
    $this->view->width = $this->_getParam('width', '48');

    $userTable = Engine_Api::_()->getItemTable('user');
    $userTableName = $userTable->info('name');

    $discussionTable = Engine_Api::_()->getDbTable('discussions', 'sesdiscussion');
    $discussionTableName = $discussionTable->info('name');

    $select = $userTable->select()
                      ->from($userTable, array('COUNT(*) AS discussion_count', 'user_id', 'displayname'))
                      ->setIntegrityCheck(false)
                      ->join($discussionTableName, $discussionTableName . '.owner_id=' . $userTableName . '.user_id')
                      ->group($userTableName . '.user_id')
                      ->order('discussion_count DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
		$this->view->data_show = $limit_data = $this->_getParam('limit_data','11');
    // Set item count per page and current page number
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber(1);
		if($this->_getParam('removeDecorator'))
			$this->getElement()->removeDecorator('Container');
    // Do not render if nothing to show
    if( $paginator->getTotalItemCount() <= 0 ) {
      return $this->setNoRender();
    }
  }
}
