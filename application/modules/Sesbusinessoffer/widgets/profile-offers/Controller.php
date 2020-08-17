<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessoffer_Widget_ProfileOffersController extends Engine_Content_Widget_Abstract {

  protected $_childCount;

  public function indexAction() {

	  // Default param options
    if(isset($_POST['params']))
      $params = json_decode($_POST['params'],true);

    if(isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);

    $this->view->is_ajax = $value['is_ajax'] = isset($_POST['is_ajax']) ? true : false;

    $value['business'] = isset($_POST['business']) ? $_POST['business'] : 1 ;

    $this->view->offer_parent_id =  $id = isset($params['offer_parent_id']) ? $params['offer_parent_id'] : Zend_Controller_Front::getInstance()->getRequest()->getParam('id', null);

    $value['business_id'] = $this->view->business_id =  $business_id = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->getBusinessId($id);
    $this->view->businessItem  = $subject = Engine_Api::_()->getItem('businesses', $business_id);

    $value['identityForWidget'] = $this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';

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

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    $params = $this->view->params = array('offer_parent_id' => $id,'limit_data' =>@$value['limit_data'],'load_content'=>$value['load_content'],'show_criterias'=>$value['show_criterias'],'grid_title_truncation'=>$value['grid_title_truncation'], 'socialshare_enable_plusicon' => $value['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $value['socialshare_icon_limit']);

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('businessoffers', 'sesbusinessoffer')->getOffersPaginator($value);

    // Set item count per business and current business number
    $paginator->setItemCountPerPage(@$value['limit_data']);
    $this->view->business = $value['business'] ;
    $paginator->setCurrentPageNumber($value['business']);

    if($value['is_ajax'])
      $this->getElement()->removeDecorator('Container');

    $allowed = true;
    if (SESBUSINESSPACKAGE == 1) {
      if (isset($subject)) {
        $package = Engine_Api::_()->getItem('sesbusinesspackage_package', $subject->package_id);
      }
      if (!isset($package)) {
        $packageId = Engine_Api::_()->getDbTable('packages', 'sesbusinesspackage')->getDefaultPackage();
        $package = Engine_Api::_()->getItem('sesbusinesspackage_package', $packageId);
      }
      $params = json_decode($package->params, true);
      if (empty($params['offer'])) {
          return $this->setNoRender();
      }
    }

    $getBusinessRolePermission = Engine_Api::_()->sesbusiness()->getBusinessRolePermission($subject->getIdentity(),'post_content','offer',false);
    $canUpload = $getBusinessRolePermission ? $getBusinessRolePermission : $subject->authorization()->isAllowed($viewer, 'offer');
    $this->view->canUpload = !$allowed ? false : $canUpload;

    if($viewer->getIdentity()) {
        $this->view->canCreate = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'businessoffer', 'create');
        $this->view->canEdit = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'businessoffer', 'edit');
        $this->view->canDelete = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'businessoffer', 'delete');
        $this->view->business_offer_count = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'businessoffer', 'max');
    } else {
        $this->view->canCreate = 0;
        $this->view->canEdit = 0;
        $this->view->canDelete = 0;
        $this->view->business_note_count = 0;
    }

    //Manage Apps Check
    $isCheck = Engine_Api::_()->getDbTable('managebusinessapps', 'sesbusiness')->isCheck(array('business_id' => $business_id, 'columnname' => 'offers'));
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
