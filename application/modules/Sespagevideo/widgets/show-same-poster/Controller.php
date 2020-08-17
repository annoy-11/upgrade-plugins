<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagevideo
 * @package    Sespagevideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagevideo_Widget_ShowSamePosterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('pagevideo')) {
      return $this->setNoRender();
    }

		if(Engine_Api::_()->core()->hasSubject('pagevideo'))
   	 $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('pagevideo');

    // Set default title
    if (!$this->getElement()->getTitle()) {
      $this->getElement()->setTitle('From the same member');
    }


    $value['limit'] = $this->_getParam('limit_data', 5);
    $tableName = $this->_getParam('tableName', 'video');
    $this->view->view_type = $this->_getParam('type','list');
		$this->view->viewTypeStyle = $this->_getParam('viewTypeStyle', 'mouseover');
		$this->view->viewTypeStyle = $viewTypeStyle = (isset($_POST['viewTypeStyle']) ? $_POST['viewTypeStyle'] : (isset($params['viewTypeStyle']) ? $params['viewTypeStyle'] : $this->_getParam('viewTypeStyle','fixed')));
    $this->view->{"height_".$this->view->view_type} = $this->_getParam('height', '60');
    $this->view->{"width_".$this->view->view_type} = $this->_getParam('width', '80');
    // Get likes
     $show_criterias = $this->_getParam('show_criteria', array('like', 'comment', 'rating', 'by', 'title', 'view','favourite','category','duration','watchLater'));
		if(is_array($show_criterias)){
				foreach ($show_criterias as $show_criteria)
					$this->view->{$show_criteria . 'Active'} = $show_criteria;
		}
      $this->view->{"title_truncation_".$this->view->view_type} = $this->_getParam('title_truncation', '45');

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('videos', 'sespagevideo')->getVideo(array('not_video_id'=>$subject->getIdentity(),'user_id'=>$subject->owner_id));

    // Set item count per page and current page number
    $paginator->setItemCountPerPage($value['limit']);
    $paginator->setCurrentPageNumber(1);


    // Hide if nothing to show
    if ($paginator->getTotalItemCount() <= 0) {
      return $this->setNoRender();
    }
  }

}
