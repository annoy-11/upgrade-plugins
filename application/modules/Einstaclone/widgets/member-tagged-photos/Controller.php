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


class Einstaclone_Widget_MemberTaggedPhotosController extends Engine_Content_Widget_Abstract {

  protected $_childCount;
  
  public function indexAction() {
  
    $this->view->viewmore = $viewmore = $this->_getParam('viewmore', 0);
    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);
    
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    
    if(empty($viewmore)) {
      // Don't render this if not authorized
      if( !Engine_Api::_()->core()->hasSubject() ) {
        return $this->setNoRender();
      }

      // Get subject and check auth
      $subject = Engine_Api::_()->core()->getSubject('user');
      if( !$subject->authorization()->isAllowed($viewer, 'view') ) {
        return $this->setNoRender();
      }
      $subject_id = $subject->getIdentity();
    } else {
      $subject_id = $params['subject_id'];
    }

    $limit = isset($params['limit']) ? $params['limit'] : $this->_getParam('limit', 10);
    $this->view->paginationType = $paginationType = $this->_getParam('paginationType', 1);
    
    if ($this->view->viewmore)
      $this->getElement()->removeDecorator('Container');
      
    $this->view->all_params = $values = array('subject_id' => $subject_id, 'limit' => $limit, 'paginationType' => $paginationType);
    
    $einstaclone_browse = Zend_Registry::isRegistered('einstaclone_browse') ? Zend_Registry::get('einstaclone_browse') : null;
    if(empty($einstaclone_browse))
      return $this->setNoRender();
      
    $tableTagmap = Engine_Api::_()->getDbtable('tagMaps', 'core');
    $tableTagName = $tableTagmap->info('name');
    
    $albumTable = Engine_Api::_()->getItemTable('album');
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesalbum')) {
      $albumTable = Engine_Api::_()->getDbTable('albums', 'sesalbum');
    } else {
      $albumTable = Engine_Api::_()->getDbTable('albums', 'album');
    }

    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesalbum')) {
      $photoTable = Engine_Api::_()->getDbTable('photos', 'sesalbum');
    } else {
      $photoTable = Engine_Api::_()->getDbTable('photos', 'album');
    }
    $photoTableName = $photoTable->info('name');
    
    $select = $tableTagmap->select()
            ->from($tableTagName)
            ->setIntegrityCheck(false)
            ->joinLeft($photoTableName, $tableTagName . '.resource_id=' . $photoTableName . '.photo_id')
            ->joinLeft($albumTableName, $albumTableName . '.album_id=' . $photoTableName . '.album_id', array())
            ->where($tableTagName . '.resource_type = ?', "album_photo")
            ->where($tableTagName . '.tag_id = ?', $subject_id)
            ->where($photoTableName . '.photo_id != ""')
            ->order($photoTableName.'.order DESC')
            ->group($photoTableName.'.photo_id');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage($limit);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    $this->view->count = $count = $paginator->getTotalItemCount();
    
    // Add count to title if configured
    $this->_childCount = $paginator->getTotalItemCount();
    
    if($count == 0)
      return $this->setNoRender();
  }
  
  public function getChildCount()
  {
    return $this->_childCount;
  }
}
