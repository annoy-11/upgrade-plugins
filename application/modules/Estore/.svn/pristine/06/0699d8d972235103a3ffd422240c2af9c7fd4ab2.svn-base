<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Widget_ProfileMainPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (!Engine_Api::_()->core()->hasSubject('stores')) {
      return $this->setNoRender();
    }
    // Prepare data
    $this->view->store = Engine_Api::_()->core()->getSubject();
    $this->view->limit_data = $limit_data = $this->_getParam('limit_data',5);
    $this->view->height = $height = $this->_getParam('height',230);
     $this->view->width = $width = $this->_getParam('width',260);
    $show_criterias = $this->_getParam('criteria', array('photo','title','storeUrl','tab'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
  }

}
