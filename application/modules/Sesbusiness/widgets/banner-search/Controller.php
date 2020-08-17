<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Widget_BannerSearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->form = $form = new Sesbusiness_Form_BannerSearch(array('widgetId' => $this->view->identity));
    $this->view->params = Engine_Api::_()->sesbusiness()->getWidgetParams($this->view->identity);
    $this->view->categories = Engine_Api::_()->getDbTable('categories', 'sesbusiness')->getModuleCategory(array('column_name' => '*','category' => 1));
  }

}
