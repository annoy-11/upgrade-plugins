<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sestestimonial_Widget_SidebarAlldesignsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->all_params = $all_params = $this->_getAllParams();

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('testimonials', 'sestestimonial')->getTestimonials($all_params);
    $paginator->setItemCountPerPage($limit);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    $this->view->count = $paginator->getTotalItemCount();
  }
}
