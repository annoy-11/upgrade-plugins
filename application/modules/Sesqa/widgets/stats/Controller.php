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

class Sesqa_Widget_StatsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->show_criteria = $this->_getParam('show_criteria',array('totalQuestions','totalAnswers','totalBestAnswers'));
    //total questions
    $questions = Engine_Api::_()->getItemTable('sesqa_question');
    $select = $questions->select()->where('draft =?',1);
    $this->view->totalQuestion = count($questions->fetchAll($select));
    //total answers
    $answers = Engine_Api::_()->getItemTable('sesqa_answer');
    $select = $answers->select();
    $this->view->totalAnswers = count($answers->fetchAll($select));
    //total best answeres
    $select = $answers->select()->where('best_answer =?',1);
    $this->view->totalBestAnswers = count($answers->fetchAll($select));
  }
}