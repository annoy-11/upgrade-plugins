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

class Sestestimonial_Widget_ViewPageController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $viewer = Engine_Api::_()->user()->getViewer();

        $this->view->stats = $this->_getParam('stats', array('likecount', 'commentcount', 'viewcount', 'rating'));

        $this->view->viewer_id = $viewer->getIdentity();

        if($this->view->viewer_id) {
          $this->view->editTesti   = Engine_Api::_()->authorization()->getPermission($viewer,'testimonial', 'edit');

          $this->view->deleteTesti  = Engine_Api::_()->authorization()->getPermission($viewer,'testimonial', 'delete');

          $this->view->canhelpful = Engine_Api::_()->authorization()->isAllowed('testimonial', $viewer, 'helpful');
        } else {
          $this->view->editTesti = $this->view->deleteTesti = $this->view->canhelpful = 0;
        }

        //$this->view->testimonial = $testimonial = Engine_Api::_()->getItem('testimonial', $this->_getParam('testimonial_id'));
        if(Engine_Api::_()->core()->hasSubject()){
           $this->view->testimonial = $testimonial = Engine_Api::_()->core()->getSubject();
        }

        $this->view->viewer = $viewer;
    }
}
