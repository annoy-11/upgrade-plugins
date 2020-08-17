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
class Sesrecipe_Widget_tagRecipesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->tagCloudData  = Engine_Api::_()->sesrecipe()->tagCloudItemCore('fetchAll');
    if( count($this->view->tagCloudData) <= 0 )
    return $this->setNoRender();
  }
}
