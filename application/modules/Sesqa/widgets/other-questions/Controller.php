<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesqa_Widget_OtherQuestionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if(!Engine_Api::_()->core()->hasSubject('sesqa_question'))
      return $this->setNoRender();
    
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();
    
      
		$userId = Engine_Api::_()->user()->getViewer()->getIdentity();
		$params['limit'] = $this->_getParam('limit_data',10);
    $params['user_id'] = $subject->getOwner()->getIdentity();
    $params['notIn'] = $subject->getIdentity();
    $category_id = $this->_getParam('category_id',0);
    $params['locationEnable'] =  $this->_getParam('locationEnable','0');
		$this->view->height = $defaultHeight =isset($params['height']) ? $params['height'] : $this->_getParam('height', '180');
		$this->view->width = $defaultWidth= isset($params['width']) ? $params['width'] :$this->_getParam('width', '180');
		
    $this->view->socialshare_enable_plusicon = $socialshare_enable_plusicon = isset($params['socialshare_enable_plusicon']) ? $params['socialshare_enable_plusicon'] :$this->_getParam('socialshare_enable_plusicon', 1);
		$this->view->socialshare_icon_limit = $socialshare_icon_limit = isset($params['socialshare_icon_limit']) ? $params['socialshare_icon_limit'] :$this->_getParam('socialshare_icon_limit', 2);
		
		$this->view->title_truncation = $title_truncation = isset($params['title_truncation']) ? $params['title_truncation'] :$this->_getParam('title_truncation', '45');
		$this->view->show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria',array('like','comment','itemPhoto','by','date','title','socialSharing','view','favouriteCount','favouriteButton','likeButton','tags'));
		
		$params = array_merge($params, array('limit'=>$params['limit'],'category_id'=>$category_id,'notIn'=>$subject->question_id,'fetchAll'=>true));
		$result = Engine_Api::_()->getDbtable('questions', 'sesqa')->getQuestions($params);
		if(count($result) == 0)
				return $this->setNoRender();
		$this->view->results = $result;
  }
}