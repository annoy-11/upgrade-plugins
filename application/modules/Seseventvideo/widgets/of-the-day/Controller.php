<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventvideo
 * @package    Seseventvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seseventvideo_Widget_OfTheDayController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->view->type = $type = $this->_getParam('ofTheDayType', 'seseventvideo_video');
		$setting = Engine_Api::_()->getApi('settings', 'core');

    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);
    
    $this->view->height_grid = $this->view->height = $this->_getParam('height', '180');
    $this->view->width_grid = $this->view->width = $this->_getParam('width', '180');
    $this->view->view_type = 'grid';
		$this->view->viewTypeStyle = $viewTypeStyle = (isset($_POST['viewTypeStyle']) ? $_POST['viewTypeStyle'] : (isset($params['viewTypeStyle']) ? $params['viewTypeStyle'] : $this->_getParam('viewTypeStyle','fixed')));
    $this->view->title_truncation_grid = $this->_getParam('title_truncation', '45');
    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'rating', 'by', 'title', 'socialSharing', 'view', 'featuredLabel', 'sponsoredLabel', 'hotLabel', 'favouriteButton', 'likeButton'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $paginator = Engine_Api::_()->getDbTable('videos', 'seseventvideo')->getVideo(array('widgetName' => 'oftheday'));
    $this->view->paginator = $paginator;
		$paginator->setItemCountPerPage(1);
    $paginator->setCurrentPageNumber(1);
    if (!($paginator->getTotalItemCount())) {
      return $this->setNoRender();
    }
  }
}