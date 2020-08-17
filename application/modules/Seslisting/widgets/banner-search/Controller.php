<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seslisting_Widget_BannerSearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->form = $form = new Seslisting_Form_BannerSearch(array('widgetId' => $this->view->identity));
    $this->view->params = Engine_Api::_()->seslisting()->getWidgetParams($this->view->identity);
    $this->view->categories = Engine_Api::_()->getDbTable('categories', 'seslisting')->getModuleCategory(array('column_name' => '*','category' => 1));
  }

}
