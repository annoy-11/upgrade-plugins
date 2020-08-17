<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_Widget_ListingSocialshareController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('listing_id', null);
    $this->view->design_type = $this->_getParam('socialshare_design', 1);
    $listing_id = Engine_Api::_()->getDbtable('seslistings', 'seslisting')->getListingId($id);
    if(!Engine_Api::_()->core()->hasSubject())
    $this->view->seslisting = Engine_Api::_()->getItem('seslisting', $listing_id);
    else
    $this->view->seslisting = Engine_Api::_()->core()->getSubject();
  }

}
