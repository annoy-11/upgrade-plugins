<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Einstaclone_Widget_ExplorePeopleController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $limit = $this->_getParam('limit', 30);
    
    $table = Engine_Api::_()->getDbtable('users', 'user');
    $select = $table->select()
            ->where('search = ?', 1)
            ->where('enabled = ?', 1)
            ->order('Rand()')
            ->limit($limit);
    if($viewer_id) {
      $select->where('user_id <> ?', $viewer_id);
    }
    $einstaclone_browse = Zend_Registry::isRegistered('einstaclone_browse') ? Zend_Registry::get('einstaclone_browse') : null;
    if(empty($einstaclone_browse))
      return $this->setNoRender();
    $this->view->results = $results = $table->fetchAll($select);
    if(count($results) == 0) 
      return $this->setNoRender();
  }
}
