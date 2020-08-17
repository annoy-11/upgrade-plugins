<?php

class Sesgroupalbum_Widget_tagCloudAlbumsController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
			$countItem = $this->_getParam('itemCountPerPage', '25');
			$this->view->height =  $this->_getParam('height', '300');
			$this->view->color =  $this->_getParam('color', '#00f');
			$this->view->textHeight =  $this->_getParam('text_height', '15');
		  $paginator = Engine_Api::_()->sesgroupalbum()->tagCloudItemCore();
			$this->view->paginator = $paginator ;
			$paginator->setItemCountPerPage($countItem);
			$paginator->setCurrentPageNumber(1);			
			// Do not render if nothing to show
			if( $paginator->getTotalItemCount() <= 0 ) {
				return $this->setNoRender();
			}
	}
}
