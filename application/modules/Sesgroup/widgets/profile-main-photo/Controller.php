<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesgroup_Widget_ProfileMainPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (!Engine_Api::_()->core()->hasSubject('sesgroup_group')) {
      return $this->setNoRender();
    }
    // Prepare data
    $this->view->group = Engine_Api::_()->core()->getSubject();
    $show_criterias = $this->_getParam('criteria', array('photo','title','groupUrl','tab'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
  }

}
