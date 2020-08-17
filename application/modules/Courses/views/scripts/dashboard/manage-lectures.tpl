<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manage-lectures.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
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
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected lecture entries?');?>");
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
    <h3><?php echo $this->translate("Manage Lectures"); ?></h3>
    <p><?php echo $this->translate("Here you can manage all lectures in this course."); ?></p> 
    <?php if(Engine_Api::_()->courses()->createLecture($this->subject())){ ?>
  </div>  
  <?php if (!$this->createLimit): ?>
      <div class="tip">
        <span>
          <?php echo $this->translate('You have already uploaded the maximum number of entries allowed.');?>
         </span>
      </div>
  <?php elseif(Engine_Api::_()->getDbTable('courseroles','courses')->toCheckUserCourseRole($this->viewer()->getIdentity(),$this->subject()->getIdentity(),'upload_lecture_video')): ?>
    <a href="<?php echo $this->url(array('action'=>'create','course_id'=>$this->subject()->getIdentity()),'lecture_general',true); ?>" class="courses_link_btn sesbasic_button create_test_btn"><i class="sesbasic_icon_add"></i><span><?php echo $this->translate("Create Lecture"); ?></span></a>
  <?php endif; ?>
 <?php if( count($this->lectures) > 0): ?>
  <div class="courses_browse_search courses_browse_search_horizontal">
    <div class="courses_manage_lectures">
      <?php //echo $this->formFilter->render($this); ?>
    </div>
  </div>
  <div class="courses_dashboard_table sesbasic_bxs">
  <form method="post" id="multidelete_form" onsubmit="return multiDelete();" >
    <table class='admin_table'>
        <thead>
            <tr>
            <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
            <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('lecture_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('verified', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'ASC');"><?php echo $this->translate("Creation Date") ?></a></th>
            <th><?php echo $this->translate("Options") ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->lectures as $item): ?>
            <tr id="lecture_id_<?php echo $item->getIdentity(); ?>">
                <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->getIdentity(); ?>' value="<?php echo $item->getIdentity(); ?>" /></td>
                <td><?php echo $item->getIdentity() ?></td>
                <td>
                    <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
                </td>
                <td><?php echo $item->creation_date ?></td>
                <td>
                <?php echo $this->htmlLink($item->getHref(), $this->translate('View'), array('target'=> "_blank")) ?>
                |
                <?php echo $this->htmlLink(array('route' => 'lecture_general','lecture_id' => $item->lecture_id,'course_id' => $item->course_id,'action'=>'edit'), $this->translate('Edit'), array('target'=> "_blank","class"=>"sessmoothbox")) ?>
                |<a href="javascript:;" onclick="deleteLecture('<?php echo $item->lecture_id; ?>')" id="Lecture<?php echo $item->lecture_id; ?>"><?php echo $this->translate('Delete'); ?></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table><br/>
        <div class='buttons'>
            <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
        </div>
       </form>
    <?php else: ?>
      <?php  if(($this->lectures->getTotalItemCount() == 0) && !$this->is_search_ajax):  ?>
        <div class="sesbasic_tip clearfix">
          <img src="application/modules/Courses/externals/images/no-lecture-created.png" alt="" />
          <span class="sesbasic_text_light">
            <?php echo $this->translate('There are no lectures created by you.') ?>
          </span>
        </div>
      <?php endif; ?>
      <?php  if(($this->lectures->getTotalItemCount() == 0) && $this->is_search_ajax):  ?>
        <div class="sesbasic_tip clearfix">
          <img src="application/modules/Courses/externals/images/no-lecture-created.png" alt="" />
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

function deleteLecture(lectureId)
{
var confirmDelete = confirm('Are you sure you want to delete?');
if(confirmDelete){
    sesJqueryObject("#Lecture"+lectureId).html('<img src="application/modules/Core/externals/images/loading.gif" alt="Loading" />');
    ajaxDeleteRequest = (new Request.HTML({
	  method: 'post',
	  format: 'html',
	  'url': en4.core.baseUrl + 'courses/lecture/delete',
	  'data': {
        is_Ajax_Delete : 1,
        lecture_id : lectureId,
	  },
	  onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) { 
        var obj = jQuery.parseJSON(responseHTML);
        if(obj.status == "1"){ 
           sesJqueryObject("#lecture_id_"+lectureId).remove();
        } else {
           sesJqueryObject("#Lecture"+lectureId).html("Delete"); 
        }
        if(!sesJqueryObject('tbody').children().length)
          location.reload();
	  }
	})).send();
}
} 
</script>
<?php if($this->is_ajax_content && !$this->is_search_ajax) die; ?>
