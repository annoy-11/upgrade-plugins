<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagenote_Widget_ProfileNotesController extends Engine_Content_Widget_Abstract {

  protected $_childCount;

  public function indexAction() {

	  // Default param options
    if(isset($_POST['params']))
      $params = json_decode($_POST['params'],true);

    if(isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);

    $this->view->is_ajax = $value['is_ajax'] = isset($_POST['is_ajax']) ? true : false;

    $value['page'] = isset($_POST['page']) ? $_POST['page'] : 1 ;

    $this->view->note_parent_id =  $id = isset($params['note_parent_id']) ? $params['note_parent_id'] : Zend_Controller_Front::getInstance()->getRequest()->getParam('id', null);

    $value['page_id'] = $this->view->page_id =  $page_id = Engine_Api::_()->getDbTable('pages', 'sespage')->getPageId($id);
    $this->view->pageItem  = $subject = Engine_Api::_()->getItem('sespage_page', $page_id);

    $value['identityForWidget'] = $this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';
    
    $sespagenote_widget = Zend_Registry::isRegistered('sespagenote_widget') ? Zend_Registry::get('sespagenote_widget') : null;
    if(empty($sespagenote_widget))
      return $this->setNoRender();
      
    $this->view->socialshare_enable_plusicon = $value['socialshare_enable_plusicon'] =isset($params['socialshare_enable_plusicon']) ? $params['socialshare_enable_plusicon'] : $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $value['socialshare_icon_limit'] = isset($params['socialshare_icon_limit']) ? $params['socialshare_icon_limit'] : $this->_getParam('socialshare_icon_limit', 2);


    $this->view->load_content = $value['load_content'] = isset($params['load_content']) ? $params['load_content'] : $this->_getParam('load_content', 'auto_load');

    $this->view->grid_title_truncation = $value['grid_title_truncation'] = isset($params['grid_title_truncation']) ? $params['grid_title_truncation'] : $this->_getParam('grid_title_truncation', '45');

    $this->view->grid_description_truncation = $value['grid_description_truncation'] = isset($params['grid_description_truncation']) ? $params['grid_description_truncation'] : $this->_getParam('grid_description_truncation', '100');

    $value['show_criterias'] = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria',array('like','comment','by','socialSharing','view','featured','sponsored','likeButton'));

    if(count($value['show_criterias']) > 0){
      foreach($value['show_criterias'] as $show_criteria)
        $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }
    $value['search'] = $this->_getParam('search', null);

    $value['order'] = isset($params['sort']) ? $params['sort'] : $this->_getParam('sort', 'creation_date');
    $value['limit_data'] = isset($params['limit_data']) ? $params['limit_data'] : $this->_getParam('limit_data', '10');

//     if(isset($value['sort']) && $value['sort'] != '')
//         $value['getParamSort'] = str_replace('SP','_',$value['sort']);
//     else
//         $value['getParamSort'] = 'creation_date';
//
//     $sort = $this->_getParam('sort', null);
//     if($sort) {
//         $value['getParamSort'] = $sort;
//     }
//     switch($value['getParamSort']) {
//         case 'most_viewed':
//             $value['order'] = 'view_count';
//         break;
//         case 'most_liked':
//             $value['order'] = 'like_count';
//         break;
//         case 'most_commented':
//             $value['order'] = 'comment_count';
//         break;
//         case 'creation_date':
//         default:
//             $value['order'] = 'creation_date';
//         break;
//     }

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    $params = $this->view->params = array('note_parent_id' => $id,'limit_data' =>@$value['limit_data'],'load_content'=>$value['load_content'],'show_criterias'=>$value['show_criterias'],'grid_title_truncation'=>$value['grid_title_truncation'], 'socialshare_enable_plusicon' => $value['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $value['socialshare_icon_limit']);

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('pagenotes', 'sespagenote')->getNotesPaginator($value);

    // Set item count per page and current page number
    $paginator->setItemCountPerPage(@$value['limit_data']);
    $this->view->page = $value['page'] ;
    $paginator->setCurrentPageNumber($value['page']);

    if($value['is_ajax'])
      $this->getElement()->removeDecorator('Container');

    $allowed = true;
    if (SESPAGEPACKAGE == 1) {
      if (isset($subject)) {
        $package = Engine_Api::_()->getItem('sespagepackage_package', $subject->package_id);
      }
      if (!isset($package)) {
        $packageId = Engine_Api::_()->getDbTable('packages', 'sespagepackage')->getDefaultPackage();
        $package = Engine_Api::_()->getItem('sespagepackage_package', $packageId);
      }
      $params = json_decode($package->params, true);
      if (empty($params['note'])) {
          return $this->setNoRender();
      }
    }

    $getPageRolePermission = Engine_Api::_()->sespage()->getPageRolePermission($subject->getIdentity(),'post_content','note',false);
    $canUpload = $getPageRolePermission ? $getPageRolePermission : Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'note');
    //$subject->authorization()->isAllowed($viewer, 'note');
    $this->view->canUpload = !$allowed ? false : $canUpload;
    if($viewer->getIdentity()) {
        $this->view->canCreate = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'pagenote', 'create');
        $this->view->canEdit = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'pagenote', 'edit');
        $this->view->canDelete = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'pagenote', 'delete');
        $this->view->page_note_count = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'pagenote', 'max');
    } else {
        $this->view->canCreate = 0;
        $this->view->canEdit = 0;
        $this->view->canDelete = 0;
        $this->view->page_note_count = 0;
    }


    //Manage Apps Check
    $isCheck = Engine_Api::_()->getDbTable('managepageapps', 'sespage')->isCheck(array('page_id' => $page_id, 'columnname' => 'notes'));
    if(empty($isCheck))
      return $this->setNoRender();

    // Add count to title if configured
    if ($paginator->getTotalItemCount() > 0) {
      $this->_childCount = $paginator->getTotalItemCount();
    }
  }

  public function getChildCount() {
    return $this->_childCount;
  }
}
