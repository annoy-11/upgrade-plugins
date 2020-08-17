<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Widget_ArticleCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->height = $this->_getParam('height', '150px');
    $this->view->width = $this->_getParam('width', '292px');
    
    $params['criteria'] = $this->_getParam('criteria', '');
		$params['limit'] = $this->_getParam('limit', 0);
		$params['article_required'] = $this->_getParam('article_required',0);
    $show_criterias = $this->_getParam('show_criteria', array('title', 'countArticles', 'icon'));
    if (in_array('countArticles', $show_criterias))
      $params['countArticles'] = true;
		if($params['article_required'])
			$params['articleRequired'] = true;
		$params['witharticle'] = $this->_getParam('video_required', '0')>0 ? true : false;
		//echo '<pre>';print_r($params);die;
		$this->view->show_criterias = $show_criterias;
    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;
    // Get videos
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'sesarticle')->getCategory($params);
    if (count($paginator) == 0)
      return;
  }

}
