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

class Sesqa_Widget_AboutUserController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if(!Engine_Api::_()->core()->hasSubject('sesqa_question'))
      return $this->setNoRender();
  
   $this->view->show_criteria = $this->_getParam('show_criteria',array('ownerPhoto','ownerTitle','askedQuestionCount','answerQuestionCount','totalUpquestionCount','totalDownquestionCount','totalFavoutiteQuestionCount','totalQuestionFollowCount'));
    
    
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();

    $this->view->owner = $subject->getOwner();

    //total question asked
    $questionTable = Engine_Api::_()->getItemTable('sesqa_question');
    $select = $questionTable->select()->where('owner_id =?',$this->view->owner->getIdentity())->where('draft =?',1);
    $this->view->totalQuestion = count($questionTable->fetchAll($select));    
    //total answers
    $answerTable = Engine_Api::_()->getItemTable('sesqa_answer');
    $select = $questionTable->select()->where('owner_id =?',$this->view->owner->getIdentity());
    $this->view->totalAnswer = count($answerTable->fetchAll($select));
    //total upvote
    $voteTable = Engine_Api::_()->getDbTable('voteupdowns','sesqa');
    $select = $voteTable->select()->where('user_id =?',$this->view->owner->getIdentity())->where('type =?','upvote');
    $this->view->totalUpvote = count($voteTable->fetchAll($select));
    //total downvote
    $select = $voteTable->select()->where('user_id =?',$this->view->owner->getIdentity())->where('type =?','downvote');
    $this->view->totalDownvote = count($voteTable->fetchAll($select));
    //total favourite
    $favTable = Engine_Api::_()->getDbTable('favourites','sesqa');
    $select = $favTable->select()->where('user_id =?',$this->view->owner->getIdentity())->where('resource_type =?','sesqa_question');
    $this->view->totalFavourite = count($favTable->fetchAll($select));
    //total follow
    $followTable = Engine_Api::_()->getDbTable('follows','sesqa');
    $select = $followTable->select()->where('user_id =?',$this->view->owner->getIdentity());
    $this->view->totalFollows = count($followTable->fetchAll($select));
  }
}