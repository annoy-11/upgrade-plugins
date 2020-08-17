<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesqa_Widget_ProfileWidgetController extends Engine_Content_Widget_Abstract {
  protected $_childCount;
  public function indexAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax',false);
    // Default option
    if (isset($_POST['params']))
      $params = json_decode($_POST['params'],true);
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);
    $viewer = Engine_Api::_()->user()->getViewer();
    if(!$is_ajax){
      if( !Engine_Api::_()->core()->hasSubject() ) {
        return $this->setNoRender();
      }
      // Get subject and check auth
      $subject = Engine_Api::_()->core()->getSubject();
      if( !$subject->authorization()->isAllowed($viewer, 'view') ) {
        return $this->setNoRender();
      }
    }else{
      $subject = Engine_Api::_()->getItem('user',$params['user_id']);
    }

    $this->view->viewType = $value['viewType'] = isset($params['viewType']) ? $params['viewType'] : $this->_getParam('viewType','list1');
    $this->view->title = isset($params['title']) ? $params['title'] : $this->_getParam('title','');
    $this->view->showOptions = $showOptions = $defaultOptionsArray = $value['showOptions'] = isset($params['showOptions']) ? $params['showOptions'] : $this->_getParam('show_criteria',array('like','favourite','tags','vote','answer','view','recentactivity','likeBtn','favBtn','share'));
    if(!$showOptions){
        $this->view->showOptions = $showOptions = $defaultOptionsArray = $value['showOptions'] = array();
    }


    $this->view->loadOptionData = $value['pagging'] = $loadOptionData = isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'pagging');
    $this->view->titleTruncateLimit = $value['title_truncate'] = isset($params['title_truncate']) ? $params['title_truncate'] : $this->_getParam('title_truncate',200);
    $this->view->widgetIdentity = $this->_getParam('widgetIdentity', $this->view->identity);
    $this->view->show_limited_data = false;
    //search data

   // $value['locationEnable'] =  isset($searchArray['locationEnable']) ? $searchArray['locationEnable'] : (isset($_GET['locationEnable']) ? $_GET['locationEnable'] : (isset($params['locationEnable']) ? $params['locationEnable'] : $this->_getParam('locationEnable','0')));

    $this->view->height = $value['height'] =  isset($searchArray['height']) ? $searchArray['height'] : (isset($_GET['height']) ? $_GET['height'] : (isset($params['height']) ? $params['height'] : $this->_getParam('height','')));
    $this->view->width = $value['width'] =  isset($searchArray['width']) ? $searchArray['width'] : (isset($_GET['width']) ? $_GET['width'] : (isset($params['width']) ? $params['width'] : $this->_getParam('width','')));

     $this->view->socialshare_enable_plusicon = $value['socialshare_enable_plusicon'] = isset($params['socialshare_enable_plusicon']) ? $params['socialshare_enable_plusicon'] : $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $value['socialshare_icon_limit'] = isset($params['socialshare_icon_limit']) ? $params['socialshare_icon_limit'] : $this->_getParam('socialshare_icon_limit', 2);

    $page = $this->view->page = $this->_getParam('page', 1);
    $limit = isset($params['limit']) ? $params['limit'] : $this->_getParam('limit', '10');
    $user_id =$subject->user_id;
    $paginator = $this->view->paginator = Engine_Api::_()->getDbTable('questions','sesqa')->getQuestionPaginator(array('user_id'=>$user_id,'locationEnable'=>@$value['locationEnable']));
    $this->view->widgetName = "profile-widget";
    $paginator->setItemCountPerPage($limit);
    $paginator->setCurrentPageNumber($page);
    $value['user_id'] = $subject->getIdentity();
    $this->view->params = $value;
    $this->view->canCreate =  Engine_Api::_()->authorization()->isAllowed('sesqa_question', null, 'create');
    if($is_ajax){
      $this->getElement()->removeDecorator('Container');
    }
    // Add count to title if configured
    if( $this->_getParam('titleCount', true) && $paginator->getTotalItemCount() > 0 ) {
      $this->_childCount = $paginator->getTotalItemCount();
    }
  }
   public function getChildCount()
  {
    return $this->_childCount;
  }
}
