<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Widget_ProfileTagsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $subject_id = Engine_Api::_()->core()->getSubject()->getIdentity();
    if(empty($subject_id))
      return $this->setNoRender();

    $this->view->paginator = $paginator = Engine_Api::_()->edocument()->tagCloudItemCore('', $subject_id);
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', '25'));
    $paginator->setCurrentPageNumber(1);

    if( $paginator->getTotalItemCount() <= 0 )
      return $this->setNoRender();
  }
}
