<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Widget_tagProductsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->widgetbgcolor = $this->_getParam('widgetbgcolor', '424242');

    $this->view->buttonbgcolor = $this->_getParam('buttonbgcolor', '000000');

    $this->view->textcolor = $this->_getParam('textcolor', 'ffffff');

    $this->view->show_count = $this->_getParam('show_count', 25);

    $this->view->tagCloudData  = Engine_Api::_()->sesproduct()->tagCloudItemCore('fetchAll');
    if( count($this->view->tagCloudData) <= 0 )
    return $this->setNoRender();
  }
}
