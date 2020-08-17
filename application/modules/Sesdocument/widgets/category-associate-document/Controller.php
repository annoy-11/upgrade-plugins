<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesdocument_Widget_CategoryAssociateDocumentController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
		//Default option for tabbed widget
    if(isset($_POST['params']))
      $params = json_decode($_POST['params'],true);

    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $page = isset($_POST['page']) ? $_POST['page'] : 1 ;
    $this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';
    $this->view->loadOptionData = $loadOptionData = isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'auto_load');
    $this->view->category_limit = $category_limit =  isset($params['category_limit']) ? $params['category_limit'] : $this->_getParam('category_limit','10');
    $this->view->document_limit = $document_limit = isset($params['document_limit']) ? $params['document_limit'] : $this->_getParam('document_limit','8');
    $this->view->count_document = $count_document = isset($params['count_document']) ? $params['count_document'] : $this->_getParam('count_document','0');

    $this->view->popularity_document = $popularity_document = isset($params['popularity_document']) ? $params['popularity_document'] : $this->_getParam('popularity_document','most_liked');
    $this->view->height = $defaultHeight = isset($params['height']) ? $params['height'] : $this->_getParam('height', '200');
    $this->view->order = $order = isset($params['order']) ? $params['order'] : $this->_getParam('order', '');

    $this->view->socialshare_enable_plusicon = $socialshare_enable_plusicon = isset($params['socialshare_enable_plusicon']) ? $params['socialshare_enable_plusicon'] : $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $socialshare_icon_limit = isset($params['socialshare_icon_limit']) ? $params['socialshare_icon_limit'] : $this->_getParam('socialshare_icon_limit', 2);


    $this->view->width = $defaultWidth = isset($params['width']) ? $params['width'] : $this->_getParam('width', '200');
    $this->view->photo_height = $defaultPhotoHeight = isset($params['photo_height']) ? $params['photo_height'] : $this->_getParam('photo_height', '200');
    $this->view->photo_width = $defaultPhotoWidth = isset($params['photo_width']) ? $params['photo_width'] : $this->_getParam('photo_width', '200');
    $this->view->info_height = $defaultInfoHeight = isset($params['info_height']) ? $params['info_height'] : $this->_getParam('info_height', '200');
    $this->view->view_type = $view_type = isset($params['view_type']) ? $params['view_type'] : $this->_getParam('view_type','1');
    $this->view->seemore_text = $seemore_text = isset($params['seemore_text']) ? $params['seemore_text'] : $this->_getParam('seemore_text','+ See all [category_name]');
    $this->view->allignment_seeall = $allignment_seeall = isset($params['allignment_seeall']) ? $params['allignment_seeall'] : $this->_getParam('allignment_seeall','left');
    $criteriaData =  isset($params['criteria']) ? $params['criteria'] : $this->_getParam('criteria','alphabetical');
    $this->view->title_truncation = $title_truncation = isset($params['title_truncation']) ? $params['title_truncation'] :$this->_getParam('title_truncation', '100');
    $this->view->description_truncation = $description_truncation = isset($params['description_truncation']) ? $params['description_truncation'] :$this->_getParam('description_truncation', '150');
    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria',array('by','view','title','follow','followButton','featuredLabel','sponsoredLabel','description','documentPhoto','documentPhotos','photoThumbnail','documentCount','favourite'));

    foreach($show_criterias as $show_criteria)
      $this->view->{$show_criteria.'Active'} = $show_criteria;
		$this->view->documentPhotoActive = true;
    $params  = array('height'=>$defaultHeight,'width' => $defaultWidth, 'photo_height'=>$defaultPhotoHeight,'photo_width' => $defaultPhotoWidth, 'info_height'=>$defaultInfoHeight,'category_limit'=>$category_limit,'count_document'=>$count_document,'seemore_text'=>$seemore_text,'allignment_seeall'=>$allignment_seeall,'pagging'=>$loadOptionData,'show_criterias'=>$show_criterias,'title_truncation' =>$title_truncation,'description_truncation'=>$description_truncation,'document_limit'=>$document_limit,'criteria'=>$criteriaData,'popularity_document'=>$popularity_document,'view_type'=>$view_type, 'socialshare_enable_plusicon' => $socialshare_enable_plusicon, 'socialshare_icon_limit' => $socialshare_icon_limit,'order'=>$order);
    $this->view->widgetName = 'category-associate-document';
    $this->view->paginatorCategory = $paginatorCategory = Engine_Api::_()->getDbTable('categories', 'sesdocument')->getCategory(array('hasDocument'=> true,'criteria'=>$criteriaData,'documentDesc'=>'desc','paginator'=>'true','order'=>$order));
    $paginatorCategory->setItemCountPerPage($category_limit);
    $paginatorCategory->setCurrentPageNumber($page);
    $resultArray = array();
    if( $paginatorCategory->getTotalItemCount() > 0 ) {
        foreach($paginatorCategory as $key=>$valuePaginator) {
            $documentDatas = $resultArray['document_data'][$valuePaginator->category_id] =  Engine_Api::_()->getDbTable('sesdocuments', 'sesdocument')->getDocumentPaginator(array('category_id'=> $valuePaginator->category_id,'limit_data'=> $document_limit,'popularity_document' => $popularity_document,'getcategory0'=>true,'fetchAll'=>true,'order'=>$order),true);
        }
    }
    $this->view->resultArray = $resultArray;
    $this->view->page = $page ;
    $this->view->params = $params;
    if($is_ajax) {
        $this->getElement()->removeDecorator('Container');
    } else {
				$this->view->can_create = Engine_Api::_()->authorization()->isAllowed('document', null, 'create');
				// Do not render if nothing to show
				if( $paginatorCategory->getTotalItemCount() <= 0 ) {}
    }
  }
}
