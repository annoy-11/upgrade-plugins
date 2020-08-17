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
<?php $randonNumber = $this->widgetId ? $this->widgetId : $randonNumber; ?>
<?php  $settings = Engine_Api::_()->getApi('settings', 'core'); $settings = array_flip($settings->getSetting('courses.result.tests', 1)); ?>
<?php if(!$this->is_ajax){ ?>
 <?php  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<div class="courses_test_result sesbasic_bxs sesbasic_clearfix">
  <div class="courses_test_result_inner">
    <h3 class="courses_test_result_head"><?php echo $this->translate('TEST RESULT'); ?></h3>
    <div class="courses_test_result_header">
      <span class="_name"><?php echo $this->test->getTitle(); ?></span>
      <?php  $totalquestion = Engine_Api::_()->getDbTable('testquestions', 'courses')->countQuestions($this->test->test_id); ?>
      <span><?php echo $this->translate(array('Total Question: %s', 'Total Questions: %s', $totalquestion), $this->locale()->toNumber($totalquestion)); ?></span>
    </div>
    <div class="courses_test_result_body" id="test-result_<?php echo $randonNumber; ?>">
<?php } ?>
    <?php $counter = ($this->limit_data*($this->paginator->getCurrentPageNumber()-1))+1; $class="";?>
    <?php foreach($this->paginator as $question): ?>
      <?php $isTrue = $question->is_true ? 'application/modules/Courses/externals/images/tick.png':'application/modules/Courses/externals/images/cross.png'; ?>
      <?php if(!$question->is_attempt): ?>
        <?php $class = "border"; ?>
      <?php endif; ?>
      <?php $testquestion = Engine_Api::_()->getItem('courses_testquestion',$question->testquestion_id); ?>
        <div class="courses_test_result_box <?php echo $class; ?>">
          <div class="courses_test_result_ques">
            <span class="ques_num"><?php echo $this->translate('Q %s',$counter); ?></span><?php echo $testquestion->question; ?>
          </div>
          <div class="courses_test_result_answer sesbasic_text_light">
            <?php if(is_array(json_decode($question->testanswers,true))): ?>
              <?php $providedAnswers = Engine_Api::_()->getItemMulti('courses_testanswer',json_decode($question->testanswers,true)); ?>
              <?php if(!empty($providedAnswers)): ?>
                <?php foreach($providedAnswers as $providedAnswer):  ?>
                  <div class="_ans"><?php echo $providedAnswer->answer; ?><img src="<?php echo (in_array($providedAnswer->testanswer_id,json_decode($question->testanswers,true)) && $providedAnswer->is_true) ? 'application/modules/Courses/externals/images/tick.png' : 'application/modules/Courses/externals/images/cross.png'; ?>" /></div>
                <?php endforeach;  ?>
              <?php endif; ?>
            <?php elseif(is_numeric(json_decode($question->testanswers,true))): ?>
            <?php $providedAnswers = Engine_Api::_()->getItem('courses_testanswer',json_decode($question->testanswers,true)); ?>
                <div class="_ans"><?php echo $providedAnswers->answer; ?><img src="<?php echo $isTrue; ?>" /></div>
            <?php endif; ?>
            <?php if(isset($settings['result'])) { ?> 
            <?php  $currectAnswers = Engine_Api::_()->getDbTable('testanswers', 'courses')->getAnswersPaginator(array('testquestion_id'=>$question->testquestion_id,'is_true'=>true)); ?>
              <?php foreach($currectAnswers as $currectAnswer):  ?>
                <div class="correct_ans"><?php echo $this->translate('Correct Answer is :'); ?> <?php echo $currectAnswer->answer; ?></div>
              <?php endforeach;  ?>
            <?php } ?> 
          </div>
        </div>
    <?php $counter++; endforeach;  ?>
<?php if(!$this->is_ajax){ ?>
  </div>
    <?php if($this->params['pagging'] != 'pagging' && (!isset($this->params['show_limited_data']) || $this->params['show_limited_data'] == 'no')):?>
      <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
        <a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa  fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
      </div>  
      <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
    <?php endif;?>
     <?php $attemptQuestionCount = Engine_Api::_()->courses()->getIsUserTestDetails(array('usertest_id'=>$this->usertest_id,'test_id'=>$this->test->test_id,'currect_answer'=>true));?>
    <?php if(isset($settings['print'])): ?>
     <?php echo $this->htmlLink($this->url(array('action' => 'print-result', 'test_id' => $this->test->test_id,'usertest_id'=>$this->usertest_id,'format'=>'smoothbox'), 'tests_general', true), $this->translate("Print Result"), array('class' => 'courses_basicbtn sesbasic_button fa fa-print','target'=>'_blank')); ?>
    <?php endif; ?>
      <div class="courses_total_Score"><?php echo $this->translate('Answered %s Out of %s Correctly',($attemptQuestionCount),$totalquestion); ?></div>
      <div class="courses_pass_fail">
        <?php if($this->usertest->is_passed): ?>
          <div><?php echo $this->test->success_message; ?></div>
          <span class="passed"><img src="application/modules/Courses/externals/images/passed.png" /><?php echo $this->translate('PASSED'); ?> </span>
        <?php else: ?>
          <div><?php echo $this->test->failure_message; ?></div>
          <span class="failed"><img src="application/modules/Courses/externals/images/failed.png" /><?php echo $this->translate('FAILED'); ?> </span>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php } ?>
<script type="text/javascript">
  var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
  var requestViewMore_<?php echo $randonNumber; ?>;
  var params<?php echo $randonNumber; ?> = <?php echo json_encode($this->params); ?>;
  var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
  var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
  var searchParams<?php echo $randonNumber; ?> ;
  var is_search_<?php echo $randonNumber;?> = 0;
  <?php if($this->params['pagging'] != 'pagging'){ ?>
    viewMoreHide_<?php echo $randonNumber; ?>();	
    function viewMoreHide_<?php echo $randonNumber; ?>() {
      if ($('view_more_<?php echo $randonNumber; ?>'))
      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
    }
    function viewMore_<?php echo $randonNumber; ?> (){
      sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
      sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
      var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';  
      requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + "widget/index/mod/courses/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>",
        'data': {
          format: 'html',
          page: page<?php echo $randonNumber; ?>,    
          params : params<?php echo $randonNumber; ?>, 
          is_ajax : 1,
          view_more:1,
          test_id:'<?php echo $this->test->test_id; ?>',
          usertest_id:'<?php echo $this->usertest_id; ?>',
          widget_id: '<?php echo $this->widgetId;?>',
          identityObject:'<?php echo isset($this->identityObject) ? $this->identityObject : "" ?>',
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          if($("loading_image_<?php echo $randonNumber; ?>"))
            document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
          console.log(document.getElementById('test-result_<?php echo $randonNumber; ?>').innerHTML);
          document.getElementById('test-result_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('test-result_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
        }
      });
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
    }
  <?php }else{ ?>
      function paggingNumber<?php echo $randonNumber; ?>(pageNum){
      sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
      var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
      requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + "widget/index/mod/courses/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>",
        'data': {
          format: 'html',
          page: pageNum,    
          params :params<?php echo $randonNumber; ?> , 
          test_id:'<?php echo $this->test->test_id; ?>',
          usertest_id:'<?php echo $this->test->usertest_id; ?>',
          is_ajax : 1,
          widget_id: '<?php echo $this->widgetId;?>',
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgecourse-wrapper'))
            sesJqueryObject('#loadingimgecourse-wrapper').hide();
          sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
          document.getElementById('test-result_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
        }
      }));
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
    }
  <?php } ?>
</script>
