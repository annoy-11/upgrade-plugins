<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: add-answer.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
<div class="courses_test_create_container">
  <div class="courses_test_create_form sesbasic_bxs" style="position:relative;">
    <?php echo $this->form->render($this);?>
  </div>
</div>
<script type="application/javascript">
  function sessmoothboxcallbackclose() {
    tinymce.remove();
  }
  executetimesmoothboxTimeinterval = 400;
  executetimesmoothbox = true;
  en4.core.runonce.add(function() {
    makeEditorRich();
  });
</script>

<script type="application/javascript">
  function addAnswer(formObject) { 
    var formData = new FormData(formObject);
    var questionId  = '<?php echo $this->question_id ?>';
    formData.append('is_ajax', 1);
    formData.append('question_id', '<?php echo $this->question_id ?>');
    sesJqueryObject.ajax({
      url: "courses/test/add-answer/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
          sesJqueryObject('#courses_add_answer').html("<div id='answeruccess_message' class='classroomservice_success_message answeruccess_message'><i class='fa-check-circle-o'></i><span>Your Answer is successfully added.</span></div>");
          sesJqueryObject('#answeruccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
            }, 1000);
          });
          sesJqueryObject('#dashboard_test_question_'+questionId).append(result.message);
          sesJqueryObject('.dashboard_test_add_answer_'+questionId).remove();
          sesJqueryObject('#dashboard_test_question_'+questionId).find('.test_hidden_options').hide();
        } else if(result.status == 2) {
          sesJqueryObject('#courses_add_answer').html("<div id='answeruccess_message' class='classroomservice_success_message answeruccess_message'><i class='fa-check-circle-o'></i><span></span></div>");
          sesJqueryObject('#answeruccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
            }, 1000);
          });
        }
      }
    });
  }
</script>

