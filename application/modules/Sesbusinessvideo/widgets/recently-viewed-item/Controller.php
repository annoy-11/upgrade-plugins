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

class Sesbusinessvideo_Widget_RecentlyViewedItemController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $type = $this->_getParam('category', 'video');
    $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (($type == 'by_me' || $type == 'by_myfriend') && $userId == 0)
      return $this->setNoRender();

    $limit = $this->_getParam('limit_data', 10);
    $this->view->type = $criteria = $this->_getParam('criteria', 'by_me');
    $this->view->view_type = $this->_getParam('type','list');
		$this->view->viewTypeStyle = $viewTypeStyle = (isset($_POST['viewTypeStyle']) ? $_POST['viewTypeStyle'] : (isset($params['viewTypeStyle']) ? $params['viewTypeStyle'] : $this->_getParam('viewTypeStyle','fixed')));
    $this->view->{"height_".$this->view->view_type} = $this->_getParam('height', '60');
    $this->view->{"width_".$this->view->view_type} = $this->_getParam('width', '80');
		$this->view->{"title_truncation_".$this->view->view_type} = $this->_getParam('title_truncation', '45');

    $show_criterias = $this->_getParam('show_criteria', array('like', 'comment', 'rating', 'by', 'title', 'view','favourite','category','duration','watchLater'));

    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $params = array('type' => 'businessvideo', 'limit' => $limit, 'criteria' => $criteria);
		$this->view->res = true;
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('recentlyviewitems', 'sesbusinessvideo')->getitem($params);
		$paginator->setItemCountPerPage($limit);
    $paginator->setCurrentPageNumber(1);
		if($type == 'video'){
			$this->view->getVideoItem = 'getVideoItem';
		}
    if (empty($paginator))
      return $this->setNoRender();
  }

}
