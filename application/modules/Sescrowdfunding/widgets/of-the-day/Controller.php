<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sescrowdfunding_Widget_OfTheDayController extends Engine_Content_Widget_Abstract {

  public function indexAction() {  

    $this->view->height = $this->_getParam('height', '180');
    
    $this->view->width = $this->_getParam('width', '180');
    
    $this->view->limit_data = $this->_getParam('limit_data', '5');
    
    $this->view->title_truncation = $this->_getParam('title_truncation', '45');
    
    $this->view->description_truncation = $this->_getParam('description_truncation', '120');
     
    $show_criterias = $this->_getParam('show_criteria',array('like','comment','view', 'rating','ratingStar', 'by','title','socialSharing','favourite','featuredLabel','sponsoredLabel','verifiedLabel', 'favouriteButton','likeButton'));
    
    foreach($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
      
    $this->view->crowdfunding_id = $crowdfundingId = Engine_Api::_()->getDbTable('crowdfundings', 'sescrowdfunding')->getOfTheDayResults();
    if (empty($crowdfundingId))
      return $this->setNoRender();
  }  
}