<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesrecipe_Widget_searchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->form = new Sesrecipe_Form_AjaxSearch();
    $this->view->allParams = $this->_getAllParams();
  }

}