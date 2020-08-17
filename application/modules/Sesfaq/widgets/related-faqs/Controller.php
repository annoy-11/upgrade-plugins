<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfaq_Widget_RelatedFaqsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if(!Engine_Api::_()->core()->hasSubject())
      return $this->setNoRender();
    
    $subject = Engine_Api::_()->core()->getSubject();
    $this->view->showinformation = $this->_getParam('showinformation', array('likecount', 'viewcount', 'commentcount', 'description', 'ratingcount'));
    $params['order'] = $this->_getParam('faqcriteria', 'creation_date');
    $this->view->faqtitlelimit = $this->_getParam('faqtitlelimit', 25);
    $this->view->faqdescriptionlimit = $this->_getParam('faqdescriptionlimit', 50);
    $params['limit'] = $this->_getParam('limitdatafaq', 3);
    $params['fetchAll'] = 1;
    $params['category_id'] = $subject->category_id;
    $this->view->faqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->getFaqSelect($params);
    if(count($this->view->faqs) <= 0)
      return $this->setNoRender();
  }

}
