<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesbusiness_Widget_ProfileTagsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $subject = Engine_Api::_()->core()->getSubject();
    $subject_id = $subject->getIdentity();
    if(empty($subject_id))
      return $this->setNoRender();

    $this->view->paginator = $paginator = Engine_Api::_()->sesbusiness()->tagCloudItemCore('', $subject_id);
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', '25'));
    $paginator->setCurrentPageNumber (1);
    if( $paginator->getTotalItemCount() <= 0 )
      return $this->setNoRender();
  }
}
