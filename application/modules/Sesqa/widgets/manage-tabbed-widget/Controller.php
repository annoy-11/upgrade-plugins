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
class Sesqa_Widget_ManageTabbedWidgetController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    // Default option
    if (isset($_POST['params']))
      $params = json_decode($_POST['params'],true);
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax',false);
    $this->view->viewType = $value['viewType'] = isset($params['viewType']) ? $params['viewType'] : $this->_getParam('viewType','list1');
    $this->view->title = isset($params['title']) ? $params['title'] : $this->_getParam('title','');
    $this->view->showOptions = $showOptions = $defaultOptionsArray = $value['showOptions'] = isset($params['showOptions']) ? $params['showOptions'] : $this->_getParam('show_criteria',array('like','favourite','tags','vote','answer','view','recentactivity','likeBtn','favBtn','share'));
    if(!$showOptions){
        $this->view->showOptions = $showOptions = $defaultOptionsArray = $value['showOptions'] = array();
    }

    $defaultOptionsArray = $this->_getParam('search_type',array('mySPquestions','questionSPanswered','questionSPupvoted','questionSPdownvoted','questionSPvoted','questionSPliked','questionSPfavourite','questionSPfollow'));

    if (!$is_ajax && is_array($defaultOptionsArray)) {
			$this->view->tab_option = $this->_getParam('showTabType','advance');
      $defaultOptions = $arrayOptions = array();
      foreach ($defaultOptionsArray as $key => $defaultValue) {
        if ($this->_getParam($defaultValue . '_order'))
          $order = $this->_getParam($defaultValue . '_order') ;
        else
          $order = (777 + $key);
        if ($this->_getParam($defaultValue . '_label'))
          $valueLabel = $this->_getParam($defaultValue . '_label'). '||' . $defaultValue;
        else {
          if($defaultValue == "mySPquestions")
             $valueLabel = 'My Questions'. '||' . $defaultValue;
					if ($defaultValue == 'questionSPanswered')
            $valueLabel = 'Answered Questions'. '||' . $defaultValue;
					else if ($defaultValue == 'questionSPvoted')
            $valueLabel = 'Voted Questions'. '||' . $defaultValue;
          else if ($defaultValue == 'questionSPupvoted')
            $valueLabel = 'Up Voted Questions'. '||' . $defaultValue;
          else if ($defaultValue == 'questionSPdownvoted')
            $valueLabel = 'Down Voted Questions'. '||' . $defaultValue;
					else if ($defaultValue == 'questionSPliked')
            $valueLabel = 'Liked Questions'. '||' . $defaultValue;
					else if ($defaultValue == 'questionSPfavourite')
            $valueLabel = 'Favourite Questions'. '||' . $defaultValue;
					else if ($defaultValue == 'questionSPfollow')
            $valueLabel = 'Question Followed'. '||' . $defaultValue;
        }
        $arrayOptions[$order] = $valueLabel;
      }
      ksort($arrayOptions);
      $counter = 0;
      foreach ($arrayOptions as $key => $valueOption) {
        $key = explode('||', $valueOption);
        if ($counter == 0)
          $this->view->defaultOpenTab = $defaultOpenTab = $key[1];
        $defaultOptions[$key[1]] = $key[0];
        $counter++;
      }
      $this->view->defaultOptions = $defaultOptions;
    }
    $sesqa_widget = Zend_Registry::isRegistered('sesqa_widget') ? Zend_Registry::get('sesqa_widget') : null;
    if(empty($sesqa_widget)) {
      return $this->setNoRender();
    }
    if (isset($_GET['openTab']) || $is_ajax) {
      $this->view->defaultOpenTab = $defaultOpenTab = isset($searchArray['order']) ? $searchArray['order'] : ($this->_getParam('defaultOpenTab',false) ? $this->_getParam('defaultOpenTab') : (isset($params['order']) ? $params['order'] : ''));
    }

    $this->view->loadOptionData = $value['pagging'] = $loadOptionData = isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'pagging');
    $this->view->titleTruncateLimit = $value['title_truncate'] = isset($params['title_truncate']) ? $params['title_truncate'] : $this->_getParam('title_truncate',200);
    $this->view->widgetIdentity = $this->_getParam('widgetIdentity', $this->view->identity);
    $this->view->show_limited_data = false;
    //search data

    $this->view->height = $value['height'] =  isset($searchArray['height']) ? $searchArray['height'] : (isset($_GET['height']) ? $_GET['height'] : (isset($params['height']) ? $params['height'] : $this->_getParam('height','')));
    $this->view->width = $value['width'] =  isset($searchArray['width']) ? $searchArray['width'] : (isset($_GET['width']) ? $_GET['width'] : (isset($params['width']) ? $params['width'] : $this->_getParam('width','')));

     $this->view->socialshare_enable_plusicon = $value['socialshare_enable_plusicon'] = isset($params['socialshare_enable_plusicon']) ? $params['socialshare_enable_plusicon'] : $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $value['socialshare_icon_limit'] = isset($params['socialshare_icon_limit']) ? $params['socialshare_icon_limit'] : $this->_getParam('socialshare_icon_limit', 2);

    if (isset($defaultOpenTab) && $defaultOpenTab != '') {
      $value['getParamSort'] = str_replace('SP', '_', $defaultOpenTab);
    } else
      $value['getParamSort'] = 'my_questions';
    $page = $this->view->page = $this->_getParam('page', 1);
    $limit = isset($params['limit']) ? $params['limit'] : $this->_getParam('limit', '10');
    $user_id = Engine_Api::_()->user()->getViewer()->getIdentity();

    if (isset($value['getParamSort'])) {
      switch ($value['getParamSort']) {
        case 'my_questions':
          $paginator = $this->view->paginator = Engine_Api::_()->getDbTable('questions','sesqa')->getQuestionPaginator(array('user_id'=>$user_id,'managePage'=>true));
          break;
        case 'question_answered':
          $questionTable = Engine_Api::_()->getDbTable('questions','sesqa');
          $answerTable = Engine_Api::_()->getDbTable('answers','sesqa');
          $customSelect = $questionTable->info('name').'.question_id IN (SELECT question_id FROM '.$answerTable->info('name').' WHERE owner_id = '.$user_id.')';
          $select = $questionTable->select()->where($customSelect);
          $paginator = $this->view->paginator = Zend_Paginator::factory($select);
          break;
        case 'question_voted':
          $questionTable = Engine_Api::_()->getDbTable('questions','sesqa');
          $votesTable = Engine_Api::_()->getDbTable('votes','sesqa');
          $customSelect = $questionTable->info('name').'.question_id IN (SELECT question_id FROM '.$votesTable->info('name').' WHERE user_id = '.$user_id.' GROUP BY question_id)';
          $select = $questionTable->select()->where($customSelect);
          $paginator = $this->view->paginator = Zend_Paginator::factory($select);
          break;
        case 'question_upvoted':
          $questionTable = Engine_Api::_()->getDbTable('questions','sesqa');
          $votesTable = Engine_Api::_()->getDbTable('voteupdowns','sesqa');
          $customSelect = $questionTable->info('name').'.question_id IN (SELECT resource_id FROM '.$votesTable->info('name').' WHERE user_id = '.$user_id.' AND resource_type = "sesqa_question" AND type = "upvote")';
          $select = $questionTable->select()->where($customSelect);
          $paginator = $this->view->paginator = Zend_Paginator::factory($select);
        break;
        case 'question_downvoted':
          $questionTable = Engine_Api::_()->getDbTable('questions','sesqa');
          $votesTable = Engine_Api::_()->getDbTable('voteupdowns','sesqa');
          $customSelect = $questionTable->info('name').'.question_id IN (SELECT resource_id FROM '.$votesTable->info('name').' WHERE user_id = '.$user_id.' AND resource_type = "sesqa_question" AND type = "downvote")';
          $select = $questionTable->select()->where($customSelect);
          $paginator = $this->view->paginator = Zend_Paginator::factory($select);
        break;
        case 'question_liked':
          $questionTable = Engine_Api::_()->getDbTable('questions','sesqa');
          $likesTable = Engine_Api::_()->getDbTable('likes','core');
          $customSelect = $questionTable->info('name').'.question_id IN (SELECT resource_id FROM '.$likesTable->info('name').' WHERE poster_id = '.$user_id.' AND resource_type = "sesqa_question" AND poster_type = "user")';
          $select = $questionTable->select()->where($customSelect);
          $paginator = $this->view->paginator = Zend_Paginator::factory($select);
          break;
        case 'question_favourite':
          $questionTable = Engine_Api::_()->getDbTable('questions','sesqa');
          $favTable = Engine_Api::_()->getDbTable('favourites','sesqa');
          $customSelect = $questionTable->info('name').'.question_id IN (SELECT resource_id FROM '.$favTable->info('name').' WHERE user_id = '.$user_id.' AND resource_type = "sesqa_question")';
          $select = $questionTable->select()->where($customSelect);
          $paginator = $this->view->paginator = Zend_Paginator::factory($select);
          break;
        case 'question_follow':
          $questionTable = Engine_Api::_()->getDbTable('questions','sesqa');
          $followsTable = Engine_Api::_()->getDbTable('follows','sesqa');
          $customSelect = $questionTable->info('name').'.question_id IN (SELECT resource_id FROM '.$followsTable->info('name').' WHERE user_id = '.$user_id.')';
          $select = $questionTable->select()->where($customSelect);
          $paginator = $this->view->paginator = Zend_Paginator::factory($select);
          break;
        default:
          return $this->setNoRender();
          break;
      }
    }
    $this->view->widgetName = "manage-tabbed-widget";
    $paginator->setItemCountPerPage($limit);
    $paginator->setCurrentPageNumber($page);
    $this->view->params = $value;
    $this->view->canCreate =  Engine_Api::_()->authorization()->isAllowed('sesqa_question', null, 'create');
    if($is_ajax){
      $this->getElement()->removeDecorator('Container');
    }
  }
}
