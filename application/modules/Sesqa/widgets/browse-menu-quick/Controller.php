<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesqa_Widget_BrowseMenuQuickController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    // Get quick navigation
    $this->view->title = $this->_getParam('title','Post New Question');

  }
}
