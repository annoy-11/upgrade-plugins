<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _pollActivity.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php
  $this->headScript()
    ->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/scripts/core.js');
  $this->headTranslate(array(
    'Show Questions', 'Show Results', '%1$s%%', '%1$s vote',
  ));
?>

<script type="text/javascript">
  //<![CDATA[
  en4.core.runonce.add(function() {
    var initializeSesqaPoll = function() {
      en4.question.urls.voteSesqa = '<?php echo $this->url(array('action' => 'vote'), 'sesqa_general') ?>';
      en4.question.urls.login = '<?php echo $this->url(array(), 'user_login') ?>';
      en4.question.addPollDataSesqa(<?php echo $this->question->getIdentity() ?>, {
        canVote : <?php echo $this->canVote ? 'true' : 'false' ?>,
        canChangeVote : <?php echo $this->canChangeVote ? 'true' : 'false' ?>,
        hasVoted : <?php echo $this->hasVoted ? 'true' : 'false' ?>,
        csrfToken : '<?php echo $this->voteHashSesqa($this->question)->generateHash()?>',
        isClosed : <?php echo $this->question->open_close ? 'true' : 'false' ?>,
        hasMulti: <?php echo $this->multiVote ? 'true' : 'false' ?>,
      });
      if(<?php echo $this->canVote ? 'true' : 'false' ?> == false){
         sesJqueryObject('#question_form_' + <?php echo $this->question->getIdentity() ?>).find('.question_radio input').attr('disabled', 'disabled');  
          sesJqueryObject('#question_form_' + <?php echo $this->question->getIdentity() ?>).find('.question_radio input').attr('title','<?php echo $this->translate("You are not allowed to vote."); ?>');
      }
      $$('#question_form_<?php echo $this->question->getIdentity() ?> .question_radio input').removeEvents('click').addEvent('click', function(event) {
        en4.question.voteSesqa(<?php echo $this->question->getIdentity() ?>, event.target);
      });
    }

    // Dynamic loading for feed
    if( $type(en4) == 'object' && 'question' in en4 ) {
      initializeSesqaPoll();
    } else {
      new Asset.javascript(en4.core.staticBaseUrl + 'application/modules/Sesqa/externals/scripts/core.js', {
        onload: function() {
          initializeSesqaPoll();
        }
      });
    }
  });
  //]]>
</script>

<div class="sesqa_view_question_content sesbasic_clearfix">
	<?php if(!empty($this->question->code)){ ?>
    <div class="sesqa_view_question_code">
    	<?php echo $this->question->code; ?>
    </div>
	<?php } ?>
	<?php if(!empty($this->question->photo_id) && empty($this->question->code)){ ?>
    <div class="sesqa_view_question_img">
      <img src="<?php echo $this->question->getPhotoUrl(); ?>" >
    </div>
	<?php } ?>
	<?php if(empty($this->getTitle)){ ?>
    <div class="sesqa_view_question_title">
      <?php echo $this->htmlLink($this->question->getHref(), $this->question->getTitle()); ?>
    </div>
  <?php } ?>
  <div class="sesqa_view_question_des sesbasic_html_block">
    <?php //$this->viewMore
     echo (nl2br($this->question->getDescription())); ?>
  </div>
  <?php if(count($this->questionOptions)){ ?>  
  <form id="question_form_<?php echo $this->question->getIdentity() ?>" action="<?php echo $this->url() ?>" method="POST" onsubmit="return false;">
    <ul id="question_options_<?php echo $this->question->getIdentity() ?>" class="question_options">
      <?php foreach( $this->questionOptions as $i => $option ): ?>
      <li id="question_item_option_<?php echo $option->poll_option_id ?>">
        <div class="question_has_voted" <?php echo ( $this->hasVoted ? '' : 'style="display:none;"' ) ?>>
          <div class="question_option">
            <?php echo $option->poll_option ?>
          </div>
          <?php $pct = $this->question->vote_count
                     ? floor(100*($option->votes/$this->question->vote_count))
                     : 0;
                if (!$pct)
                  $pct = 1;
                // NOTE: question-answer graph & text is actually rendered via
                // javascript.  The following HTML is there as placeholders
                // and for javascript backwards compatibility (though
                // javascript is required for voting).
           ?>
          <div id="question-answer-<?php echo $option->poll_option_id ?>" class='question_answer question-answer-<?php echo (($i%8)+1) ?>' style='width: <?php echo .7*$pct; // set width to 70% of its real size to as to fit text label too ?>%;'>
            &nbsp;
          </div>
          <div class="question_answer_total">
            <?php echo $this->translate(array('%1$s vote', '%1$s votes', $option->votes), $this->locale()->toNumber($option->votes)) ?>
            (<?php echo $this->translate('%1$s%%', $this->locale()->toNumber($option->votes ? $pct : 0)) ?>)
          </div>
        </div>
        <div class="question_not_voted" <?php echo ($this->hasVoted?'style="display:none;"':'') ?> >
          <div class="question_radio" id="question_radio_<?php echo $option->poll_option_id ?>">
            <?php if(!$this->multiVote){ ?>
              <input id="question_option_<?php echo $option->poll_option_id ?>"
                   type="radio" name="question_options" value="<?php echo $option->poll_option_id ?>"
                   <?php if( in_array($option->poll_option_id,$this->hasVoted)): ?>checked="true"<?php endif; ?>
                   <?php if( ($this->hasVoted && !$this->canChangeVote) || $this->question->open_close ): ?>disabled="true"<?php endif; ?>
                   />
            <?php }else{ ?>
              <input id="question_option_<?php echo $option->poll_option_id ?>"
                   type="checkbox" name="question_options[]" value="<?php echo $option->poll_option_id ?>"
                   <?php if( in_array($option->poll_option_id,$this->hasVoted)): ?>checked="true"<?php endif; ?>
                   <?php if( ($this->hasVoted && !$this->canChangeVote) || $this->question->open_close ): ?>disabled="true"<?php endif; ?>
                   />
            <?php } ?>
                   
          </div>
          <label for="question_option_<?php echo $option->poll_option_id ?>">
            <?php echo $option->poll_option ?>
          </label>
        </div>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php if( empty($this->hideStats) ): ?>
    <div class="question_stats" <?php if($this->canChangeVote){ ?> style="display:block;" <?php } ?>>
      <a href='javascript:void(0);' onClick='en4.question.toggleResultsSesqa(<?php echo $this->question->getIdentity() ?>); this.blur();' class="question_toggleResultsLink">
        <?php echo $this->translate($this->hasVoted ? 'Show Questions' : 'Show Results' ) ?>
      </a>
      &nbsp;|&nbsp;
      <span class="question_vote_total">
        <?php echo $this->translate(array('%s vote', '%s votes', $this->question->vote_count), $this->locale()->toNumber($this->question->vote_count)) ?>
      </span>
      &nbsp;|&nbsp;
      <?php echo $this->translate(array('%s view', '%s views', $this->question->view_count), $this->locale()->toNumber($this->question->view_count)) ?>
    </div>
    <?php endif; ?>
  </form>
  <?php } ?>
</div>
