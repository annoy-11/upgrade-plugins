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
class Sesrecipe_Widget_ContentController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('recipe_id', null);
    $recipe_id = Engine_Api::_()->getDbtable('recipes', 'sesrecipe')->getRecipeId($id);
    if(!Engine_Api::_()->core()->hasSubject())
    $this->view->body = Engine_Api::_()->getItem('sesrecipe_recipe', $recipe_id)->body;
    else
    $this->view->body = Engine_Api::_()->core()->getSubject()->body;
  }
  
}