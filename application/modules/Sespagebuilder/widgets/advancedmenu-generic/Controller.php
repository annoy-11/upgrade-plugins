<?php 

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Widget_AdvancedmenuGenericController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $this->view->title = $this->_getParam('title', null);

    $show = $this->_getParam('show', 2);
    if ($show == 0 && !empty($viewer_id))
      return $this->setNoRender();
    elseif ($show == 1 && empty($viewer_id))
      return $this->setNoRender();

    $this->view->menuName = $name = $this->_getParam('menu');
    if (!$name)
      return $this->setNoRender();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation($name);
    if (count($navigation) <= 0)
      return $this->setNoRender();

    $this->view->show_type = $this->_getParam('show_type', 0);
    $this->view->show_menu_icon = $this->_getParam('show_menu_icon', 1);
    $this->view->show_menu = $this->_getParam('show_menu', 0);
    $this->view->customcolor = $this->_getParam('customcolor', 0);
    $this->view->menuBgColor = $this->_getParam('menuBgColor', 'fffff');
    $this->view->menuTextColor = $this->_getParam('menuTextColor', 'fffff');
    $this->view->menuTextFontSize = $this->_getParam('menuTextFontSize', '14');
    $this->view->menuHoverBgColor = $this->_getParam('menuHoverBgColor', 'fffff');
    $this->view->menuHoverTextColor = $this->_getParam('menuHoverTextColor', 'fffff');
    $this->view->menuBorderColor = $this->_getParam('menuBorderColor', 'fffff');

    // Get menu name
    $this->view->menuname = $this->_getParam('menuname');

    // Get menu count
    $this->view->menucount = $this->_getParam('menucount', 6);
  }

}
