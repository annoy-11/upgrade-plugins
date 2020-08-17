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
class Sespagebuilder_Widget_AccordionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (strpos($_SERVER['REQUEST_URI'], 'admin') == 1)
      return $this->setNoRender();

    $tab_name = $this->_getParam('tabName');
    $this->view->urlOpen = $this->_getParam('urlOpen', '1');
    $this->view->tab_position = $this->_getParam('tab_position', 'center');
    $this->view->customcolor = $this->_getParam('customcolor');
    $this->view->accTabBgColor = $this->_getParam('accTabBgColor', 'fffff');
    $this->view->accTabTextColor = $this->_getParam('accTabTextColor', 'fffff');
    $this->view->accTabTextFontSize = $this->_getParam('accTabTextFontSize', '14');
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagebuilder.showpages'))
      return $this->setNoRender();
    $this->view->subaccTabBgColor = $this->_getParam('subaccTabBgColor', 'fffff');
    $this->view->subaccTabTextColor = $this->_getParam('subaccTabTextColor', 'fffff');
    $this->view->subaccTabTextFontSize = $this->_getParam('subaccTabTextFontSize', '14');
    $this->view->width = $this->_getParam('width', '100');
    $this->view->subaccorImage = $this->_getParam('subaccorImage', 1);
    $this->view->accorImage = $this->_getParam('accorImage', 1);
    $this->view->accordian_type = $this->_getParam('show_accordian', 1);

    if ($tab_name)
      $this->view->accordions = Engine_Api::_()->getDbtable('accordions', 'sespagebuilder')->getAccordion($tab_name);
    else
      return $this->setNoRender();
  }

}
