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

class Sesrecipe_Widget_RecipeSocialshareController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('recipe_id', null);
    $this->view->design_type = $this->_getParam('socialshare_design', 1);
    $recipe_id = Engine_Api::_()->getDbtable('recipes', 'sesrecipe')->getRecipeId($id);
    if(!Engine_Api::_()->core()->hasSubject())
    $this->view->sesrecipe = Engine_Api::_()->getItem('sesrecipe_recipe', $recipe_id);
    else
    $this->view->sesrecipe = Engine_Api::_()->core()->getSubject();
  }
  
}