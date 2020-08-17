<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventvideo
 * @package    Seseventvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seseventvideo_Widget_searchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->form = new Seseventvideo_Form_SearchAjax();
  }

}
