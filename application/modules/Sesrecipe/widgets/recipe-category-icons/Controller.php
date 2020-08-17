<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Widget_RecipeCategoryIconsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->height = $this->_getParam('height', '200');
    $this->view->width = $this->_getParam('width', '200');
    $this->view->alignContent = $this->_getParam('alignContent', 'center');
    $this->view->titleC = $this->_getParam('titleC','What are you in the mood for?');
    $params['criteria'] = $this->_getParam('criteria', '');
    $show_criterias = $this->_getParam('show_criteria', array('title', 'countRecipes', 'icon'));
    $sesrecipe_categoryrecipe = Zend_Registry::isRegistered('sesrecipe_categoryrecipe') ? Zend_Registry::get('sesrecipe_categoryrecipe') : null;
    if(0) {
      return $this->setNoRender();
    }
    if (in_array('countRecipes', $show_criterias) || $params['criteria'] == 'most_recipe')
      $params['countRecipes'] = true;

    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;
		$params['limit'] = $this->_getParam('limit_data',10);
    // Get recipes category
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'sesrecipe')->getCategory($params);

    if (count($paginator) == 0)
      return;
  }

}
