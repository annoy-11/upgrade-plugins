<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manage-tests.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/tinymce/tinymce.min.js'); ?>
<?php if(!$this->is_ajax_content  && !$this->is_search_ajax){ ?>
<script type="text/javascript">

  var currentOrder = 'is_approved';
  var currentOrderDirection = 'ASC';
  var changeOrder = function(order, default_direction){
    // Just change direction
    if( order == currentOrder ) {
      $('order_direction').value = ( currentOrderDirection == 'ASC' ? 'DESC' : 'ASC' );
    } else {
      $('order').value = order;
      $('order_direction').value = default_direction;
    }
    $('filter_form').submit();
  }
  function multiDelete() {
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected test entries?');?>");
  }
  function selectAll() {
    var i;
    var multidelete_form = $('multidelete_form');
    var inputs = multidelete_form.elements;
    for (i = 1; i < inputs.length; i++) {
      if (!inputs[i].disabled) {
	inputs[i].checked = inputs[0].checked;
      }
    }
  }
</script>
<?php
 echo $this->partial('dashboard/left-bar.tpl', 'courses', array(
	'course' => $this->course,
      ));	
?>
<div class="courses_dashboard_content sesbm sesbasic_clearfix">
  <?php  } ?>
  <div class="courses_dashboard_content_header">
    <h3><?php echo $this->translate("Manage Test"); ?></h3>
    <p><?php echo $this->translate("Here you can manage all test in this course."); ?></p>
  </div>
  <?php if(Engine_Api::_()->courses()->createTest($this->subject())){ ?>
   <?php if (!$this->createLimit): ?>
      <div class="tip">
        <span>
          <?php echo $this->translate('You have already uploaded the maximum number of entries allowed.');?>
         </span>
      </div>
  <?php elseif(Engine_Api::_()->getDbTable('courseroles','courses')->toCheckUserCourseRole($this->viewer()->getIdentity(),$this->subject()->getIdentity(),'create_test')): ?>
    <a href="<?php echo $this->url(array('action'=>'create','course_id'=>$this->subject()->getIdentity()),'tests_general',true); ?>" class="courses_link_btn sesbasic_button create_test_btn sessmoothbox"><i class="sesbasic_icon_add"></i><span><?php echo $this->translate("Create Test"); ?></span></a>
  <?php endif; ?>
  <?php if(count($this->tests) > 0): ?>
  <div class="courses_dashboard_table sesbasic_bxs">
  <?php foreach($this->tests as $test): ?>
    <div class="accordion"><?php echo $test->getTitle(); ?>
      <div class="_data"> <a href="<?php echo $this->url(array('test_id' => $test->test_id,'action'=>'edit'), 'tests_general', true); ?>" class="sesbasic_button sessmoothbox"><i class="fa fa-pencil"></i></a> <a href="javascript:;" data-url="<?php echo $this->url(array('test_id' => $test->test_id,'action'=>'delete-test'), 'tests_general', true); ?>" data-id="<?php echo $test->test_id; ?>" data-type="test" class="sesbasic_button delete-test-item"><i class="fa fa-trash-o"></i></a> 
      </div>
    </div>
    <div class="panel">
      <a href="<?php echo $this->url(array('test_id' => $test->test_id,'action'=>'add-question'), 'tests_general', true); ?>" class="sessmoothbox add_ques sesbasic_button"><i class="fa fa-plus"></i><?php echo $this->translate("Add Question");?></a>
      <div class="dashboard_test_box" id="dashboard_test_box_<?php echo $test->test_id; ?>">
      <?php $questions = Engine_Api::_()->getDbTable('testquestions', 'courses')->getQuestionsSelect(array('test_id'=>$test->test_id,'fetchAll'=>true)); ?>
      <?php foreach($questions as $question): ?>
        <div id="dashboard_test_question_<?php echo $question->testquestion_id; ?>" class="question_options">
          <div class="dashboard_test_question"  >
            <div class="_ques"><?php echo $question->question; ?> </div>
            <div class="_data"> 
              <?php $answers = Engine_Api::_()->getDbTable('testanswers', 'courses')->getAnswersSelect(array('testquestion_id'=>$question->testquestion_id,'fetchAll'=>true)); ?>
              <?php if(($question->answer_type == 1) && count($answers) > 0): ?>
                <a href="<?php echo $this->url(array('question_id' => $question->testquestion_id,'action'=>'add-answer'), 'tests_general', true); ?>" class="sessmoothbox sesbasic_button test_hidden_options dashboard_test_add_answer_<?php echo $question->testquestion_id; ?>" style="display:none;"><i class="fa fa-plus"></i> <?php echo $this->translate("Add Answer");?></a>
              <?php else: ?>
                <a href="<?php echo $this->url(array('question_id' => $question->testquestion_id,'action'=>'add-answer'), 'tests_general', true); ?>" class="sessmoothbox sesbasic_button dashboard_test_add_answer_<?php echo $question->testquestion_id; ?>"><i class="fa fa-plus"></i> <?php echo $this->translate("Add Answer");?></a> 
              <?php endif; ?>
              <a href="<?php echo $this->url(array('question_id' => $question->testquestion_id,'action'=>'edit-question'), 'tests_general', true); ?>" class="sessmoothbox sesbasic_button"><i class="fa fa-pencil"></i></a>
              <a href="javascript:;" data-url="<?php echo $this->url(array('question_id' => $question->testquestion_id,'action'=>'delete-question'), 'tests_general', true); ?>" data-id="<?php echo $question->testquestion_id; ?>" data-type="question" class="sesbasic_button delete-test-item"><i class="fa fa-trash-o"></i></a> 
            </div>
          </div>
          <?php foreach($answers as $answer): ?>
            <div class="dashboard_test_answer <?php  echo $answer->is_true ? "is_true" : ""; ?>" id ="dashboard_test_answer_<?php echo $answer->testanswer_id; ?>">
              <div class="_ans"><?php echo $answer->answer; ?></div>
              <div class="_data"> <a href="<?php echo $this->url(array('answer_id' => $answer->testanswer_id,'action'=>'edit-answer'), 'tests_general', true); ?>" class="sessmoothbox sesbasic_button"><i class="fa fa-pencil"></i></a> <a href="javascript:;" data-url="<?php echo  $this->url(array('answer_id' => $answer->testanswer_id,'action'=>'delete-answer'), 'tests_general', true); ?>" data-id="<?php echo $answer->testanswer_id; ?>" data-type="answer" class="sesbasic_button delete-test-item"><i class="fa fa-trash-o"></i></a> </div>
            </div>
         <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
      </div>
    </div>
  <?php endforeach; ?>
    </div>
  <?php else: ?>
    <?php  if(($this->tests->getTotalItemCount() == 0) && !$this->is_search_ajax):  ?>
        <div class="sesbasic_tip clearfix">
          <img src="application/modules/Courses/externals/images/no-test-created.png" alt="" />
          <span class="sesbasic_text_light">
            <?php echo $this->translate('You have not created any Test in your course. Please create Test for the course.') ?>
          </span>
        </div>
    <?php endif; ?>
    <?php  if(($this->tests->getTotalItemCount() == 0) && $this->is_search_ajax):  ?>
        <div class="sesbasic_tip clearfix">
          <img src="application/modules/Courses/externals/images/no-test-created.png" alt="" />
          <span class="sesbasic_text_light">
            <?php echo $this->translate('There are no results that match your search. Please try again.') ?>
          </span>
        </div>
    <?php endif; ?>
    
  <?php endif; ?>
  </div>
  <?php } ?>
  <?php if(!$this->is_ajax_content && !$this->is_search_ajax){ ?>
</div>
</div>
</div>
<script>
var acc = document.getElementsByClassName("accordion");
var i;
for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    /* Toggle between adding and removing the "active" class,
    to highlight the button that controls the panel */
    this.classList.toggle("active");
    /* Toggle between hiding and showing the active panel */
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}
</script>
<?php  } ?>
<script type="application/javascript">
function executeAfterLoad(){
	if(!sesBasicAutoScroll('#date-date_to').length )
		return;
	var FromEndDateOrder;
	var selectedDateOrder =  new Date(sesBasicAutoScroll('#date-date_to').val());
	sesBasicAutoScroll('#date-date_to').datepicker({
			format: 'yyyy-m-d',
			weekStart: 1,
			autoclose: true,
			endDate: FromEndDateOrder, 
	}).on('changeDate', function(ev){
		selectedDateOrder = ev.date;	
		sesBasicAutoScroll('#date-date_from').datepicker('setStartDate', selectedDateOrder);
	});
	sesBasicAutoScroll('#date-date_from').datepicker({
			format: 'yyyy-m-d',
			weekStart: 1,
			autoclose: true,
			startDate: selectedDateOrder,
	}).on('changeDate', function(ev){
		FromEndDateOrder	= ev.date;	
		 sesBasicAutoScroll('#date-date_to').datepicker('setEndDate', FromEndDateOrder);
	});	
}
executeAfterLoad();
sesJqueryObject(document).on('click','.sesevent_search_ticket_search',function(e){
	e.preventDefault();
	sendParamInSearch = sesJqueryObject(this).attr('data-rel');
	sesJqueryObject('#sesevent_search_ticket_search').trigger('click');
});
sesJqueryObject('#loadingimgcourses-wrapper').hide();

sesJqueryObject(document).on('click','.delete-test-item',function (e) {
    var itemObject = sesJqueryObject(this);
    var url  = itemObject.attr('data-url');
    var itemId = itemObject.attr('data-id');
    var itemType = itemObject.attr('data-type');
    var confirmDelete = confirm('Are you sure you want to delete?');
    if(url && confirmDelete){
      ajaxDeleteRequest = (new Request.HTML({
      method: 'post',
      format: 'html',
      'url': url,
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) { 
          var obj = jQuery.parseJSON(responseHTML);
          if(obj.status == "1"){ 
            if(itemType == "question")
              sesJqueryObject("#dashboard_test_question_"+itemId).remove();
            if(itemType == "answer") {
              sesJqueryObject("#dashboard_test_answer_"+itemId).parents('.question_options').find('.test_hidden_options').show();
              sesJqueryObject("#dashboard_test_answer_"+itemId).remove();
            }
            if(itemType == "test") { 
              sesJqueryObject("#dashboard_test_box_"+itemId).parents('.panel').prev().remove();
              sesJqueryObject("#dashboard_test_box_"+itemId).parents('.panel').remove();
            }
          } 
      }
      })).send();
    }
});
function makeEditorRich() {
  tinymce.init({
    mode: "specific_textareas",
    plugins: "table,fullscreen,media,preview,paste,code,image,textcolor,jbimages,link",
    theme: "modern",
    menubar: false,
    statusbar: false,
    toolbar1:  "undo,redo,removeformat,pastetext,|,code,media,image,jbimages,link,fullscreen,preview",
    toolbar2: "fontselect,fontsizeselect,bold,italic,underline,strikethrough,forecolor,backcolor,|,alignleft,aligncenter,alignright,alignjustify,|,bullist,numlist,|,outdent,indent,blockquote",
    toolbar3: "",
    element_format: "html",
    height: "225px",
    content_css: "bbcode.css",
    entity_encoding: "raw",
    add_unload_trigger: "0",
    remove_linebreaks: false,
    convert_urls: false,
    language: "<?php echo $this->language; ?>",
    directionality: "<?php echo $this->direction; ?>",
    upload_url: "<?php echo $this->url(array('module' => 'sesbasic', 'controller' => 'index', 'action' => 'upload-image'), 'default', true); ?>",
    editor_selector: "tinymce"
  });
}
</script>
<?php if($this->is_ajax_content && !$this->is_search_ajax) die; ?>
