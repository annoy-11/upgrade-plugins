<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Widget_SlideshowController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->view_type = $this->_getParam('slideshowtype', 1);

  	$value['category_id'] = $this->_getParam('category','');
    $this->view->title_truncation = $this->_getParam('title_truncation', '45');
    $this->view->description_truncation = $this->_getParam('description_truncation', 200);
	 	$this->view->autoplay = $this->_getParam('autoplay',1);
		$this->view->speed = $this->_getParam('speed',2000);
		$this->view->height = $this->_getParam('height','400');

    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'title', 'socialSharing', 'view', 'rating', 'ratingStar', 'by','category','likeButton'));

    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $limit =  $this->_getParam('limit_data', 5);
    $value['criteria'] = $this->_getParam('criteria', 5);
    $value['info'] = $this->_getParam('info', 'recently_created');
   	$value['order'] = $this->_getParam('order', '');
    $value['fetchAll'] = true;
		$value['limit'] = $limit;

    $this->view->paginator = $paginator = Engine_Api::_()->getItemTable('crowdfunding')->getSescrowdfundingsPaginator($value);
    if($paginator->getTotalItemCount() <= 0)
      return $this->setNoRender();
	}
}
