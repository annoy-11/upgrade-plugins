<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Advancedsearch_Widget_CoreContentController extends Engine_Content_Widget_Abstract
{
  public function indexAction(){
     //

      $this->view->searchParams = $this->_getParam('show_criteria',array('view','likes','comment','postedBy','photo'));
      $this->view->randonNumber = $this->_getParam('randonNumber','');
      $this->view->loadmore = $loadmore = $this->_getParam('pagging','loadmore');
      $this->view->loading_data = $this->_getParam('loading_data',false);
      $this->view->limit = $limit = $this->_getParam('itemCountPerPage',$this->_getParam('limit',10));
      // Check form validity?
      $values = array();
      $this->view->type = $type = $_POST['resource_type'];
      if(!$this->view->type)
          return $this->setNoRender();
      $this->view->query = $query = (string) $_POST['query'];
      if(!empty($_POST['search']))
            $this->view->query = $query = (string) $_POST['search'];
      $this->view->page = $page = (int) $this->_getParam('page');
        if($type != "music")
            $select = Engine_Api::_()->getItemTable($type)->select();
        else
            $select = Engine_Api::_()->getDbTable('playlists','music')->select();
      if(!empty($query))
            $select->where('title LIKE "%'.$query.'%"');
      if(!empty($_POST['category_id']))
          $select->where('category_id =?',$_POST['category_id']);

      $this->view->paginator = $paginator = Zend_Paginator::factory($select);
      $this->view->paginator->setCurrentPageNumber($page);
      $paginator->setItemCountPerPage($limit);
      $this->view->page = $page +1;
      if($this->view->loading_data )
          $this->getElement()->removeDecorator('Container');
  }
}