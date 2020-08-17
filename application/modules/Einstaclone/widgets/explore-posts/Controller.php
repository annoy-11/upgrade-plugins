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


class Einstaclone_Widget_ExplorePostsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);
      
    // Don't render this if not authorized 
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    
    $limit = isset($params['limit']) ? $params['limit'] : $this->_getParam('limit', 10);
    $this->view->paginationType = $paginationType = $this->_getParam('paginationType', 1);
    $this->view->viewmore = $this->_getParam('viewmore', 0);
    if ($this->view->viewmore)
      $this->getElement()->removeDecorator('Container');
      
    $this->view->all_params = $values = array('limit' => $limit, 'paginationType' => $paginationType);
    $einstaclone_browse = Zend_Registry::isRegistered('einstaclone_browse') ? Zend_Registry::get('einstaclone_browse') : null;
    if(empty($einstaclone_browse))
      return $this->setNoRender();
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesalbum')) {
        $photoTable = Engine_Api::_()->getDbTable('photos', 'sesalbum');
    } else {
      $photoTable = Engine_Api::_()->getDbTable('photos', 'album');
    }
    $photoTableName = $photoTable->info('name');
    
    $select = $photoTable->select()
                        ->from($photoTableName)
                        ->order('order DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage($limit);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    $this->view->count = $count = $paginator->getTotalItemCount();
    if($count == 0) 
      return $this->setNoRender();
  }
}
