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

class Sesproduct_Widget_ProfileTagsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $subject = Engine_Api::_()->core()->getSubject();
    $subject_id = $subject->getIdentity();
    if(empty($subject_id))
      return $this->setNoRender();

    $this->view->paginator = $paginator = Engine_Api::_()->sesproduct()->tagCloudItemCore('', $subject_id);
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', '25'));
    $paginator->setCurrentPageNumber(1);
    if( $paginator->getTotalItemCount() <= 0 )
      return $this->setNoRender();
  }
}
