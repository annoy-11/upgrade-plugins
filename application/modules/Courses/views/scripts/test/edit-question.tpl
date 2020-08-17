<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: edit-question.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
<?php if (0): ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('You have already uploaded the maximum number of entries allowed.');?>
      <?php echo $this->translate('If you would like to upload a new entry, please <a href="%1$s">delete</a> an old one first.', $this->url(array('action' => 'manage'), 'test_general'));?>
    </span>
  </div>
  <br/>
<?php else: ?>
<div class="courses_test_create_container">
  <div class="courses_test_create_form sesbasic_bxs" style="position:relative;">
    <?php echo $this->form->render($this);?>
  </div>
</div>
<?php endif; ?>
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
  function editQuestion(formObject) {
    var formData = new FormData(formObject);
    var testId  = '<?php echo $this->test_id ?>';
    var questionId = '<?php echo $this->question_id ?>';
    formData.append('is_ajax', 1);
    formData.append('question_id', '<?php echo $this->question_id ?>');
    sesJqueryObject.ajax({
      url: "courses/test/edit-question/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
          sesJqueryObject('#courses_edit_question').html("<div id='questionsuccess_message' class='classroomservice_success_message questionsuccess_message'><i class='fa-check-circle-o'></i><span>Your Question is successfully added.</span></div>");
          sesJqueryObject('#questionsuccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
            }, 1000);
          });
          sesJqueryObject('#dashboard_test_question_'+questionId).children().find('._ques').html(result.title);
        }
      }
    });
  }
</script>

