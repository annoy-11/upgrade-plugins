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
class Advancedsearch_Widget_SearchResultsController extends Engine_Content_Widget_Abstract
{
  public function indexAction(){
    $this->view->title = $this->_getParam('title','Search');
    $this->view->more = $this->_getParam('more_tab','8');
    $this->view->show_criteria = $this->_getParam('show_criteria',array('view','likes','comment','contentType','postedBy','rating','photo','review','followers','description','category','location','sponsored','featured','hot'));
    $this->view->loadmore  = $this->_getParam('pagging','loadmore');
    $this->view->limit = $limit  = $this->_getParam('itemCountPerPage','10');
		if(!$limit)
		  $this->view->limit = $limit  = 10;

    $advancedsearch_browse = Zend_Registry::isRegistered('advancedsearch_browse') ? Zend_Registry::get('advancedsearch_browse') : null;
    if(empty($advancedsearch_browse)) {
      return $this->setNoRender();
    }
    $this->view->page = $page  = $this->_getParam('page','1');
    $this->view->resType = !empty($_GET['type']) ? $_GET['type'] :"";
      $this->view->text = !empty($_GET['query']) ? $_GET['query'] :"";
    $tableModule = Engine_Api::_()->getDbTable('modules','advancedsearch');
    $select = $tableModule->select()->where('create_tab =?',1)->order('order ASC');
    $this->view->modules = $modules = $tableModule->fetchAll($select);
  }
}
