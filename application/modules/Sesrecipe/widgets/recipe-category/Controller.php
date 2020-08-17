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

class Sesrecipe_Widget_RecipeCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->height = $this->_getParam('height', '150px');
    $this->view->width = $this->_getParam('width', '292px');
    $params['criteria'] = $this->_getParam('criteria', '');
		$params['limit'] = $this->_getParam('limit', 0);
		$params['recipe_required'] = $this->_getParam('recipe_required',0);
    $show_criterias = $this->_getParam('show_criteria', array('title', 'countRecipes', 'icon'));
    if (in_array('countRecipes', $show_criterias))
      $params['countRecipes'] = true;
		if($params['recipe_required'])
			$params['recipeRequired'] = true;
		$this->view->show_criterias = $show_criterias;
    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;
    // Get videos
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'sesrecipe')->getCategory($params);
    if (count($paginator) == 0)
      return;
  }

}
