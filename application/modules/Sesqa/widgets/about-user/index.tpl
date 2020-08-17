<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/styles.css'); ?>
<div class="sesqa_about_user sesbasic_bxs sesbasic_clearfix">
  <?php if(in_array('ownerPhoto',$this->show_criteria)){ ?>
    <div class="_photo"> <a href="<?php echo $this->owner->getHref(); ?>"><?php echo $this->itemPhoto($this->owner); ?></a> </div>
  <?php } ?>
  <?php if(in_array('ownerTitle',$this->show_criteria)){ ?>
    <div class="_name centerT"><a href="<?php echo $this->owner->getHref(); ?>"><?php echo $this->owner->getTitle(); ?></a></div>
  <?php } ?>
  <div class="_info">
    <?php if(in_array('askedQuestionCount',$this->show_criteria)){ ?>
      <p class="sesbasic_clearfix">
      	<span><?php echo $this->translate(array('Question Asked', 'Questions Asked',  $this->totalQuestion));?></span>
      	<span><?php echo $this->locale()->toNumber( $this->totalQuestion);?></span>
      </p>
    <?php } ?>
      <?php if(in_array('answerQuestionCount',$this->show_criteria)){ ?>
      <p class="sesbasic_clearfix">
      	<span><?php echo $this->translate(array('Answer Given', 'Answers Given', $this->totalAnswer));?></span>
        <span><?php echo  $this->locale()->toNumber($this->totalAnswer);?></span>
      </p>
    <?php } ?>
  </div>
  <div class="_stats sesbasic_text_light">
    <?php if(in_array('totalUpquestionCount',$this->show_criteria)){ ?>
    	<span title="<?php echo $this->translate(array('%s up vote', '%s up votes', $this->totalUpvote), $this->locale()->toNumber($this->totalUpvote))?>"><i class="fa fa-thumbs-up"></i><?php echo $this->totalUpvote; ?></span>
    <?php } ?>
    <?php if(in_array('totalDownquestionCount',$this->show_criteria)){ ?>
    	<span title="<?php echo $this->translate(array('%s down vote', '%s down votes', $this->totalDownvote), $this->locale()->toNumber($this->totalDownvote))?>"><i class="fa fa-thumbs-down"></i><?php echo $this->totalDownvote; ?></span>
    <?php } ?>
    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.allow.favourite', 1) && in_array('totalFavoutiteQuestionCount',$this->show_criteria)){ ?>
    	<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $this->totalFavourite), $this->locale()->toNumber( $this->totalFavourite))?>"><i class="fa fa-heart"></i><?php echo $this->totalFavourite; ?></span>
    <?php } ?>
    <?php if(in_array('totalQuestionFollowCount',$this->show_criteria)){ ?>
    	<span title="<?php echo $this->translate(array('%s follow', '%s follows',$this->totalFollows), $this->locale()->toNumber($this->totalFollows))?>"><i class="fa fa-check"></i><?php echo $this->totalFollows; ?></span>
    <?php } ?>
  </div>
</div>
