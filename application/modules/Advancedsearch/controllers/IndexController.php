<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Advancedsearch_IndexController extends Core_Controller_Action_Standard
{
  public function init()
  {
      $request = Zend_Controller_Front::getInstance()->getRequest();
      $moduleName = $request->getModuleName();
      $actionName = $request->getActionName();
      $controllerName = $request->getControllerName();
      $params = $request->getParams();
      $type = !empty($params["resource_type"]) ? $params["resource_type"] : "";
      if(!empty($params["query"])){
          $_POST['search'] = $_GET['search'] = $_POST['search_text'] = $_GET['search_text'] =  $_GET['title_name']
              = $_GET['title_name'] = $_POST['title_name']  = $_POST['title_song']
              = $_GET['title_song'] = $_POST['searchText'] = $_GET['searchText'] = $_POST['sesteam_title']
              = $_GET['sesteam_title'] = $_GET['search'] = $params['query'];
      }
      //check page exists
      $pages = Engine_Api::_()->getDbTable('pages','core');
      $select = $pages->select()->where("name =?",'advancedsearch_index_'.$type);
      $isPage = $pages->fetchRow($select);
      if($isPage){
          if($type == "user") {
              if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled("sesmember")) {
                  $type = "sesmember";
              }
          }
        $name = 'advancedsearch_index_'.$type;
        $this->searchPages($name);
        return;
      }elseif (isset($params["resource_type"]) && $type != "all"){
          $this->searchOtherModuleResults();
          return;
      }
  }
  function searchOtherModuleResults(){
      $this->_helper->content->setContentName("advancedsearch_index_search-other-module-results")->setNoRender()->setEnabled();
  }
  function searchPages($name){
      $this->_helper->content->setContentName($name)->setNoRender()->setEnabled();
  }
  function getResultsAction(){
      $searchApi = Engine_Api::_()->getApi('core', 'advancedsearch');
      // Check form validity?
      $values = array();
      $this->view->query = $query = (string) $this->_getParam('query');
      $this->view->type = $type = (string) @$this->_getParam('type');
      $this->view->page = $page = (int) $this->_getParam('page');
      if ($query) {
          $params["type"] = $type;
          $this->view->paginator = $searchApi->getSelect($query, $params);
          $this->view->paginator->setCurrentPageNumber($page);
      }

      $resultCount = Engine_Api::_()->getApi('settings', 'core')->getSetting('advancedsearch.max',3);

      $results = array();
      if (is_array($this->view->paginator) || is_object($this->view->paginator)) {
          $counter = 0;
          $break = true;
          foreach ($this->view->paginator as $item) {
              if($counter == $resultCount) {
                  $break = true;
                  break;
              }
              $item = $this->view->item($item->type, $item->id);
              if(!$item) continue;
              $type = $item->getShortType();

              if(!$item->getTitle())
                  continue;
              $shortType = $type == "user" ? $this->view->translate("Member") : $this->view->translate(ucfirst($type));
              if ($item->getPhotoUrl() != '')
                  $photo = $this->view->itemPhoto($item, 'thumb.icon');
              else
                  $photo = "<img src='" . $this->view->layout()->staticBaseUrl . "application/modules/Advancedsearch/externals/images/nophoto_item.png' alt='' />";
              if($this->_getParam('direct')){
                  $photo = "";
                  $shortType = "";
              }
              $results[] = array(
                  'icon' => $photo,
                  'label' => $item->getTitle(),
                  'href' => $item->getHref(),
                  'id' => $item->getIdentity() ,
                  'shortType' => $shortType,
              );
              $counter++;
          }
          $table = Engine_Api::_()->getDbTable('modules','advancedsearch');
          $select = $table->select()->where('show_on_search =?',1)->order('order ASC');
          $modules = $table->fetchAll($select);
          if($break && !$this->_getParam('direct')){
            foreach($modules as $item){
                if(!Engine_Api::_()->sesbasic()->isModuleEnable($item->module_name))
                    continue;
                $photo = "<img src='" . $item->getPhotoUrl() ."' alt='' />";
                $title = $this->view->translate('Find all %s with %s',$this->view->translate($item->title),"\"$query\"");
                $results[] = array(
                    'icon' => $photo,
                    'label' => $title,
                    'text' => $query,
                    'res_type' => $item->resource_type,
                );
            }
          }
      }
      echo json_encode($results);
      exit;
  }
  function allResultsAction(){
     $this->view->searchParams = $this->_getParam('searchParams');
     $this->view->randonNumber = $this->_getParam('randonNumber','');
     $this->view->loadmore = $loadmore = $this->_getParam('loadmore');
     $this->view->loading_data = $this->_getParam('loading_data',false);
     $this->view->limit = $limit = $this->_getParam('limit',10);
     $searchApi = Engine_Api::_()->getApi('core', 'advancedsearch');

      // Check form validity?
      $values = array();
      $this->view->query = $query = (string) $this->_getParam('query');
      $this->view->page = $page = (int) $this->_getParam('page');
      $params["type"] = 'all';
      $this->view->paginator = $paginator = $searchApi->getSelect($query, $params);
      $this->view->paginator->setCurrentPageNumber($page);
      $paginator->setItemCountPerPage($limit);
      $this->view->page = $page +1;
  }
  function indexAction(){

      $this->_helper->content
          ->setNoRender()
          ->setEnabled();
  }
}
