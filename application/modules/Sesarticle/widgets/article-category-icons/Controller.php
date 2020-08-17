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

class Sesarticle_Widget_ArticleCategoryIconsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->height = $this->_getParam('height', '200');
    $this->view->width = $this->_getParam('width', '200');
    $this->view->alignContent = $this->_getParam('alignContent', 'center');
    $this->view->titleC = $this->_getParam('titleC','What are you in the mood for?');
    $params['criteria'] = $this->_getParam('criteria', '');
    $show_criterias = $this->_getParam('show_criteria', array('title', 'countArticles', 'icon'));
    $sesarticle_categoryarticle = Zend_Registry::isRegistered('sesarticle_categoryarticle') ? Zend_Registry::get('sesarticle_categoryarticle') : null;
    if(0) {
      return $this->setNoRender();
    }
    if (in_array('countArticles', $show_criterias) || $params['criteria'] == 'most_article')
      $params['countArticles'] = true;

    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;
		$params['limit'] = $this->_getParam('limit_data',10);
    // Get articles category
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'sesarticle')->getCategory($params);

    if (count($paginator) == 0)
      return;
  }

}
