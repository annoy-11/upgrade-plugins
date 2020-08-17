<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagevideo
 * @package    Sespagevideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagevideo_Widget_searchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->form = new Sespagevideo_Form_SearchAjax();
  }

}
