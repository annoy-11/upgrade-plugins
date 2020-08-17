<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Widget_ProfileTagsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $subject = Engine_Api::_()->core()->getSubject();
    $subject_id = $subject->getIdentity();
    if(empty($subject_id))
      return $this->setNoRender();
    
    $this->view->paginator = $paginator = Engine_Api::_()->sesrecipe()->tagCloudItemCore('', $subject_id);
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', '25'));
    $paginator->setCurrentPageNumber(1);			
    if( $paginator->getTotalItemCount() <= 0 ) 
      return $this->setNoRender();
  }
}
