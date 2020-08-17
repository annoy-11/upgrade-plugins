<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessvideo
 * @package    Sesbusinessvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusinessvideo_Widget_peopleFavouriteItemController extends Engine_Content_Widget_Abstract {
  public function indexAction() {

		if (!Engine_Api::_()->core()->hasSubject('businessvideo')) {
      return $this->setNoRender();
    }
		if(Engine_Api::_()->core()->hasSubject('businessvideo'))
   	 $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('businessvideo');
		$this->view->item_id = $param['id'] = $subject->getIdentity();
    $this->view->height = $this->_getParam('height', '48');
    $this->view->width = $this->_getParam('width', '48');
		$this->view->title = $this->getElement()->getTitle();
		$param['type'] = 'businessvideo';
		$param['resource_id'] = $subject->getIdentity();
   	$this->view->paginator = $paginator = Engine_Api::_()->getDbTable('videos', 'sesbusinessvideo')->getFavourite($param);
		$this->view->data_show = $limit_data = $this->_getParam('limit_data','11');
    // Set item count per page and current page number
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber(1);
		if($this->_getParam('removeDecorator'))
			$this->getElement()->removeDecorator('Container');
    // Do not render if nothing to show
    if( $paginator->getTotalItemCount() <= 0 ) {
      return $this->setNoRender();
    }
  }
}
