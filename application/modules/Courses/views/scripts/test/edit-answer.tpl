<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: edit-answer.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
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
  function editAnswer(formObject) { 
    var formData = new FormData(formObject);
    var answerId  = '<?php echo $this->answer_id ?>';
    formData.append('is_ajax', 1);
    formData.append('answer_id', '<?php echo $this->answer_id ?>');
    sesJqueryObject.ajax({
      url: "courses/test/edit-answer/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
          sesJqueryObject('#courses_edit_answer').html("<div id='answeruccess_message' class='classroomservice_success_message answeruccess_message'><i class='fa-check-circle-o'></i><span>Your Answer is successfully added.</span></div>");
          sesJqueryObject('#answeruccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
            }, 1000);
          });
          sesJqueryObject('#dashboard_test_answer_'+answerId).html(result.message);
          if(result.is_true)
            sesJqueryObject('#dashboard_test_answer_'+answerId).addClass('is_true');
          else 
            sesJqueryObject('#dashboard_test_answer_'+answerId).removeClass('is_true');
        }
      }
    });
  }
</script>

