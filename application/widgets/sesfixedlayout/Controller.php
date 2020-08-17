<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Widgets
 * @package    Sesfixedlayout
 * @copyright  Copyright 2019 - 2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.tpl  2018-07-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Widget_SesfixedlayoutController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    $this->view->fixedheader = $this->_getParam('fixedheader', 1);
  }
}
