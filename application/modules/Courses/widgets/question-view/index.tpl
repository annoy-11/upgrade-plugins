<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?> 
<?php if(!$this->ajax) { ?>
<div class="courses_question_view sesbasic_clearfix sesbasic_bxs">
   <div class="courses_question_view_inner">
      <span class="_timer"></span>
      <div class="courses_test_question_box" id="test_question_box">
<?php } ?>
        <form id="submit_form" method="post">
          <?php $questionIds = array(); ?>
          <div class="_head"><?php echo $this->translate(array('Question %s of %s', 'Questions %s of %s', $this->paginator->getCurrentPageNumber()), $this->locale()->toNumber($this->paginator->getCurrentPageNumber()),$this->paginator->count()); ?></div>
          <?php foreach($this->paginator as $question): ?>
            <div class="_ques">
              <span><?php echo $question->question; ?></span>
            </div>
            <div class="_ans <?php echo  $question->answer_type == 3 ? 'mc_ans': ''; ?>">
            <?php 
              $questionIds[] = $question->testquestion_id; 
              $answers = Engine_Api::_()->getDbTable('testanswers', 'courses')->getAnswersSelect(array('testquestion_id'=>$question->testquestion_id,'fetchAll'=>true)); ?>
            <?php if(($question->answer_type == 2) || ($question->answer_type == 3)):
                    $answer_type ='radio'; 
                  if($question->answer_type == 2){
                    $answer_type = 'radio';
                    $name = 'radio_'.$question->testquestion_id;
                  }else if($question->answer_type == 3){
                    $answer_type = 'checkbox';
                    $name = 'checkbox_'.$question->testquestion_id.'[]';
                  }
                ?>
                <?php foreach($answers as $answer): ?>
                  <label > <?php echo $answer->answer; ?><input type="<?php echo $answer_type; ?>" name="<?php echo $name; ?>" value="<?php echo $answer->testanswer_id; ?>"><span class="checkmark"></span></label>
                <?php endforeach; ?>
              <?php elseif($question->answer_type == 1): $name = 'isTrue_'.$question->testquestion_id; ?>
                <?php foreach($answers as $answer): ?>
                  <?php if($answer->is_true): $isTrue = 1; ?>
                    <label><?php echo $this->translate('TRUE'); ?><input type="radio" name="<?php echo $name; ?>" value="<?php echo $answer->testanswer_id; ?>"><span class="checkmark"></span></label>
                  <?php else: ?>
                    <label><?php echo $this->translate('FALSE'); ?><input type="radio" name="<?php echo $name; ?>" value="<?php echo $answer->testanswer_id; ?>"><span class="checkmark"></span></label>
                   <?php endif; ?>
                <?php endforeach; ?>
                <?php if(count($answer) == 1): ?>
                  <?php if(!$isTrue): ?>
                    <label><?php echo $this->translate('TRUE'); ?><input type="radio" name="<?php echo $name; ?>" value="0"><span class="checkmark"></span></label>
                  <?php else: ?>
                    <label><?php echo $this->translate('FALSE'); ?><input type="radio" name="<?php echo $name; ?>" value="0"><span class="checkmark"></span></label>
                  <?php endif; ?>
                <?php endif; ?>
              <?php elseif($question->answer_type == 4): $name = 'sortAnswer_'.$question->testquestion_id; ?>
                <?php echo $this->translate('Write Short Answer'); ?><textarea name="<?php echo $name; ?>" rows="4" cols="50"></textarea>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
          <?php $buttonText = $this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'Submit' : 'Next >'; ?>
          <div class="_next_skip">
              <a href="javascript:;" class="_next_ques" data-page="<?php echo $this->page+1; ?>" data-questionIds ="<?php echo implode(',',$questionIds); ?>"><?php echo $this->translate($buttonText); ?></a>
            <?php if($this->paginator->count() != $this->paginator->getCurrentPageNumber()): ?>
              <a href="javascript:;" class="_skip_ques" data-page="<?php echo $this->page+1; ?>"><?php echo $this->translate('Skip >>'); ?></a>
            <?php endif; ?>
          </div>
        </form>
<?php if(!$this->ajax) { ?>
      </div>
   </div>
</div>
<script type="text/javascript">
  var timeover = 0;
  sesJqueryObject(document).ready(function(){
    var $target = sesJqueryObject("._timer");
    var startTime = '<?php echo $_SESSION['user_test'][$this->test->test_id]['start_time']; ?>';
    var startTestTime = new Date(startTime).getTime();
    var endTime = '<?php echo $this->Timediff; ?>';
    var now = new Date();
      now.setMinutes(now.getMinutes() + parseInt(endTime)); // timestamp
    var endTesttime = new Date(now); // Date object
    var classes = ['hide', 'show'];
    var current = 0;
    setTimer = setInterval(function() {
    var now = new Date().getTime();
    var distance = endTesttime - now; 
    if(endTesttime < now) {
        timeover = 1;
        userTest();
        clearInterval(setTimer);
        return false;
    }
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    // Display the result in the element with id="demo"
    var time = days + "d " + hours + "h "+ minutes + "m " + seconds + "s ";
    $target.html(time);
      $target.removeClass(classes[current]);
      current = (current+1)%classes.length;
      $target.addClass(classes[current]);
    }, 1000); // 1000 ms loop
  });
  var next = 0;
  var skip = 0;
  var formData = 0; 
  var page = 1;
  var questionIds = 0;
  sesJqueryObject(document).on('click', '._next_ques', function () { 
        formData = sesJqueryObject('#submit_form').serialize();
        if(!formData) {
          alert('Please select answer');
          return false;
        }
        page = sesJqueryObject(this).attr('data-page');
        questionIds = sesJqueryObject('._next_ques').attr('data-questionIds');
        next = 1;
        skip = 0;
        userTest();
  });
  sesJqueryObject(document).on('click', '._skip_ques', function () {
    page = sesJqueryObject(this).attr('data-page');
    questionIds = sesJqueryObject('._next_ques').attr('data-questionIds');
    skip = 1;
    next = 0;
    userTest();
  });
</script>
<?php } ?>
<script>
  function userTest() {
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/courses/name/question-view",
      'data': {
        format: 'html',
        is_ajax:1,
        page: page,
        test_id : <?php echo $this->test->test_id; ?>,
        questionIds: sesJqueryObject('._next_ques').attr('data-questionIds'),
        skip: skip,
        next:next,
        timeover: timeover,
        submit:'<?php echo $this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 1 : 0; ?>',
        formData:formData,
      },
      onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('test_question_box').innerHTML = responseHTML;
        <?php if(($this->paginator->count() == $this->paginator->getCurrentPageNumber())): ?>
          var response = jQuery.parseJSON(sesJqueryObject('#test_question_box').children('span').html()); 
          if(response.status == 1){
              window.location.href = response.url;
          }
        <?php endif; ?>
        if(timeover){
          var response = jQuery.parseJSON(sesJqueryObject('#test_question_box').children('span').html());
          if(response.status == 1){
              window.location.href = response.url;
          }
        }
        return true;
      }
    })).send();
  }
</script>

