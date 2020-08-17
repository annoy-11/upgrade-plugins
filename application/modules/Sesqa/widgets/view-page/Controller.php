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

class Sesqa_Widget_ViewPageController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $question_id = $this->_getParam('question_id',0);
    $this->view->is_answer_ajax = $is_answer_ajax = $this->_getParam('is_answer_ajax',0);
    $is_paging_content = 0;
    if(!$question_id && !$this->_getParam('question','') && !Engine_Api::_()->core()->hasSubject('sesqa_question')){
      return $this->setNoRender();
    }
    if(!$question_id)
      $this->view->question = $question = ($this->_getParam('question','')) ? $this->_getParam('question','') : Engine_Api::_()->core()->getSubject('sesqa_question');
    else{
      $this->view->is_answer_ajax = $is_answer_ajax = 1;
      $this->view->is_paging_content = 1;
      $this->view->question = $question = Engine_Api::_()->getItem('sesqa_question',$question_id);
    }
    $sesqa_widget = Zend_Registry::isRegistered('sesqa_widget') ? Zend_Registry::get('sesqa_widget') : null;
    if(empty($sesqa_widget)) {
      return $this->setNoRender();
    }
    $this->view->show_criteria = $this->_getParam('show_criteria',array());

    $this->view->socialshare_enable_plusicon =  $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);

    $this->view->answer_show_criteria = $is_answer_ajax ? json_decode($this->_getParam('answer_show_criteria',array())) : $this->_getParam('answer_show_criteria',array());
    $this->view->tinymce = $this->_getParam('tinymce',1);

    $this->view->owner = $owner = $question->getOwner();
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->questionOptions = $question->getOptions();
    $this->view->hasVoted = $question->viewerVoted();
    $this->view->multiVote = $question->multi;
    $this->view->showPieChart = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.showpiechart', false);
    $this->view->canVote = $question->authorization()->isAllowed($viewer, 'answer');
    $this->view->canChangeVote = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.canchangevote', true);
    $this->view->hideLinks = true;
    $this->view->getTitle = true;
    $layoutOri = $this->view->layout()->orientation;
		if ($layoutOri == 'right-to-left') {
				$this->view->direction = 'rtl';
		} else {
				$this->view->direction = 'ltr';
		}

		$language = explode('_', $this->view->locale()->getLocale()->__toString());
		$this->view->language = $language[0];
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('answers','sesqa')->getAnswersPaginator(array('question_id'=>$question->getIdentity(),'paginator'=>true,'answer_id'=>$this->_getParam('answer_id','')));
    $limit_data = $this->view->limit_data = $this->_getParam('limit_data', 5);
    // Set item count per page and current page number
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber($this->_getParam('pageAnswer', 1));

    $this->view->can_edit = 0;
		$this->view->can_delete = 0;
		if($viewer->getIdentity() != 0){
			$this->view->can_edit = $question->authorization()->isAllowed($viewer, 'edit');
			$this->view->can_delete = $question->authorization()->isAllowed($viewer, 'delete');
		}
    $this->view->canCasteAnswerVote = Engine_Api::_()->authorization()->isAllowed('sesqa_question', null, 'vote_answer');
    $this->view->canCasteQuestionVote = Engine_Api::_()->authorization()->isAllowed('sesqa_question', null, 'vote_question');
    if($is_answer_ajax || $is_paging_content){
         $this->getElement()->removeDecorator('Container');
    }
    $this->view->tags = $question->tags()->getTagMaps();

  }
}
