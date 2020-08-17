<?php

class Sesgroupalbum_Widget_RecentlyViewedItemController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {  
		
		$this->view->type = $type  = $this->_getParam('category','album');
		$userId = Engine_Api::_()->user()->getViewer()->getIdentity();
		
		$params['limit'] = $limit =  $this->_getParam('limit_data',10);
		$params['criteria'] = $criteria = $this->_getParam('criteria','by_me');
		if(($criteria == 'by_me' || $criteria == 'by_myfriend') && $userId == 0){
				return $this->setNoRender();
		}
		$this->view->height = $defaultHeight =isset($params['height']) ? $params['height'] : $this->_getParam('height', '180');
		$this->view->width = $defaultWidth= isset($params['width']) ? $params['width'] :$this->_getParam('width', '180');
		$this->view->title_truncation = $title_truncation = isset($params['title_truncation']) ? $params['title_truncation'] :$this->_getParam('title_truncation', '45');
		$show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria',array('like','comment','rating','by','title','socialSharing','view','photoCount','favouriteCount','featured','sponsored','favouriteButton','likeButton','downloadCount'));
		$this->view->fixHover = $fixHover = isset($params['fixHover']) ? $params['fixHover'] :$this->_getParam('fixHover', 'fix');
		$this->view->insideOutside =  $insideOutside = isset($params['insideOutside']) ? $params['insideOutside'] : $this->_getParam('insideOutside', 'inside');
		foreach($show_criterias as $show_criteria)
			$this->view->$show_criteria = $show_criteria;
		
		if($type == 'album'){
		 $params = array('type'=>'sesgroupalbum_album','limit'=>$limit,'criteria'=>$criteria);
		}else if($type == 'photo'){
			 $params = array('type'=>'sesgroupalbum_photo','limit'=>$limit,'criteria'=>$criteria);
		}else
			return $this->setNoRender();
		
		$result = Engine_Api::_()->getDbtable('recentlyviewitems', 'sesgroupalbum')->getitem($params);
		if(count($result) == 0)
				return $this->setNoRender();
		$this->view->results = $result->toArray();
		$this->view->typeWidget = $type;
	}
}
