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
class Sesrecipe_Widget_LikeButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();
		if (empty($viewerId))
		return $this->setNoRender();
		if (!Engine_Api::_()->core()->hasSubject('sesrecipe_recipe'))
		return $this->setNoRender();
		$this->view->subject = $recipeItem = Engine_Api::_()->core()->getSubject('sesrecipe_recipe');
		$this->view->recipe_id = $recipeItem->getIdentity();
		$this->view->is_like = Engine_Api::_()->getDbTable('likes', 'core')->isLike($recipeItem, $viewer);
  }

}