<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _updownvote.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php
  $item = !empty($answer) ? $answer : $this->question;
  $viewer = !empty($viewer) ? $viewer : $this->viewer();
  
  $isVote = Engine_Api::_()->getDbTable('voteupdowns','sesqa')->isVote(array('resource_id'=>$item->getIdentity(),'resource_type'=>$item->getType(),'user_id'=>$viewer->getIdentity(),'user_type'=>'user'));
  $classUp = $classDown = "";
  
  if($item->getType() == "sesqa_question"){
    $canCasteVote = Engine_Api::_()->authorization()->isAllowed('sesqa_question', null, 'vote_question');
  }else{
    $canCasteVote = Engine_Api::_()->authorization()->isAllowed('sesqa_question', null, 'vote_answer');
  }
  if(!empty($item) && $canCasteVote){
    $classUp = "sesqa_upvote_btn_a";
    $classDown = "sesqa_downvote_btn_a";
  }
  
?>
<div class="sesqa_vote">
   <a href="javascript:;" data-itemguid="<?php echo $item->getGuid(); ?>" data-userguid="<?php echo $viewer->getGuid(); ?>" title="<?php echo $this->translate('Up Vote'); ?>" class="<?php echo !empty($isVote) && $isVote->type == "upvote" ? '_disabled ' : ""; ?> <?php echo $classUp; ?> sesqa_upvote_btn"></a>
   <span class="vote_count light"><?php echo $item->upvote_count - $item->downvote_count ; ?></span>
   <a href="javascript:;" data-itemguid="<?php echo $item->getGuid(); ?>" data-userguid="<?php echo $viewer->getGuid(); ?>" title="<?php echo $this->translate('Down Vote'); ?>" class="<?php echo !empty($isVote) && $isVote->type == "downvote" ? '_disabled ' : ""; ?> <?php echo $classDown; ?> sesqa_downvote_btn"></a>
   
   <?php 
    if((!empty($markasBest) || !empty($this->markasBest))){
      if(empty($question))
        $question = Engine_Api::_()->getItem('sesqa_question',$item->question_id);
      $isOwner = $question->owner_id == $this->viewer()->getIdentity();
      if(($item->best_answer && !$isOwner) || $isOwner){
    ?>
    <br>
    <a href="javascript:;" class="sesqa_vote_btn <?php if($item->best_answer){ ?>vote_checked <?php } ?> <?php if(!empty($markasBest) && $isOwner){ ?> markbestsesqa <?php } ?>" data-id="<?php echo $item->getIdentity(); ?>">
    	<i class="fa"></i>
    </a>
    <?php } 
    } ?>
</div>