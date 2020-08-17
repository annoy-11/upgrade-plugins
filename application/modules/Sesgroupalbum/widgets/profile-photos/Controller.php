<?php
class Sesgroupalbum_Widget_ProfilePhotosController extends Engine_Content_Widget_Abstract {

  protected $_childCount;
  
  public function indexAction() {

	  // Default param options
    if(isset($_POST['params']))
    $params = json_decode($_POST['params'],true);    
    if(isset($_POST['searchParams']) && $_POST['searchParams'])
    parse_str($_POST['searchParams'], $searchArray);
    $this->view->is_ajax = $value['is_ajax'] = isset($_POST['is_ajax']) ? true : false;
    $value['page'] = isset($_POST['page']) ? $_POST['page'] : 1 ;
    $this->view->album_parent_id =  $id = isset($params['album_parent_id']) ? $params['album_parent_id'] : Zend_Controller_Front::getInstance()->getRequest()->getParam('group_id', null);

    
    $this->view->group  = $subject = Engine_Api::_()->core()->getSubject();
    $this->view->group_id = $value['group_id'] = $subject->getIdentity(); //Engine_Api::_()->getDbtable('events', 'sesevent')->getEventId($id);
    $value['identityForWidget'] = $this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';

    $this->view->view_type =$view_type =isset($params['view_type']) ? $params['view_type'] : $this->_getParam('view_type', '1');
    $this->view->height = $value['defaultHeight'] =isset($params['height']) ? $params['height'] : $this->_getParam('height', '200');
    $this->view->width = $value['defaultWidth'] =isset($params['width']) ? $params['width'] : $this->_getParam('width', '200');
    $this->view->limit_data = $value['limit_data'] = isset($params['limit_data']) ? $params['limit_data'] : $this->_getParam('limit_data', '20');
    $this->view->load_content = $value['load_content'] = isset($params['load_content']) ? $params['load_content'] : $this->_getParam('load_content', 'auto_load');	
    $this->view->title_truncation = $value['title_truncation'] = isset($params['title_truncation']) ? $params['title_truncation'] : $this->_getParam('title_truncation', '45');
    $value['show_criterias'] = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria',array('like','comment','by','title','socialSharing','view','photoCount','featured','sponsored','likeButton'));
    $this->view->fixHover = $fixHover = isset($params['fixHover']) ? $params['fixHover'] :$this->_getParam('fixHover', 'fix');
    $this->view->insideOutside =  $insideOutside = isset($params['insideOutside']) ? $params['insideOutside'] : $this->_getParam('insideOutside', 'inside');
		if(count($value['show_criterias'])){
    	foreach($value['show_criterias'] as $show_criteria)
    		$this->view->$show_criteria = $show_criteria;
		}
    if(isset($value['sort']) && $value['sort'] != '')
    $value['getParamSort'] = str_replace('SP','_',$value['sort']);
    else
    $value['getParamSort'] = 'creation_date';
    switch($value['getParamSort']) {
      case 'most_viewed':
        $value['order'] = 'view_count';
        break;
      case 'most_liked':
			$value['order'] = 'like_count';
			break;
					case 'most_commented':
			$value['order'] = 'comment_count';
			break;
					case 'creation_date':
			default:
			$value['order'] = 'creation_date';
			break;
    }
    $this->view->viewer = Engine_Api::_()->user()->getViewer();
    $params = $this->view->params = array('album_parent_id' => $id,'width'=>$value['defaultWidth'],'height'=>$value['defaultHeight'],'limit_data' =>$value['limit_data'],'load_content'=>$value['load_content'],'show_criterias'=>$value['show_criterias'],'title_truncation'=>$value['title_truncation'],'insideOutside'=>$insideOutside,'fixHover'=>$fixHover,'view_type'=>$view_type);
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('albums', 'sesgroupalbum')->getAlbumSelect($value);
    // Set item count per page and current page number
    $paginator->setItemCountPerPage($value['limit_data']);
    $this->view->page = $value['page'] ;
    $paginator->setCurrentPageNumber($value['page']);
    if($value['is_ajax'])
    $this->getElement()->removeDecorator('Container');  
		$viewer = Engine_Api::_()->user()->getViewer();
    $this->view->canUpload = $canUpload = $subject->authorization()->isAllowed(null, 'photo');

    // Do not render if nothing to show and cannot upload
//     if ($paginator->getTotalItemCount() <= 0 && !$canUpload) {
//       return $this->setNoRender();
//     }
    // Add count to title if configured
    if ($paginator->getTotalItemCount() > 0) {
      $this->_childCount = $paginator->getTotalItemCount();
    }
  }
  public function getChildCount() {
    return $this->_childCount;
  }
}
