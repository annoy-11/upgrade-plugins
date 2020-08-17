<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manage-courses.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
?>
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
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected course entries?');?>");
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
 echo $this->partial('dashboard/left-bar.tpl', 'eclassroom', array(
	'classroom' => $this->classroom,
      ));	
?>
  <div class="classroom_dashboard_content sesbm sesbasic_clearfix">
  <div class="classroom_dashboard_content_header">
    <h3><?php echo $this->translate("Manage Courses"); ?></h3>
    <p><?php echo $this->translate("Here you can manage all courses in this classroom."); ?></p> 
  </div>  
  <?php if(Engine_Api::_()->courses()->createCourse($this->subject())){ ?>
    <a href="<?php echo $this->url(array('action'=>'create','classroom_id'=>$this->subject()->getIdentity(),'profile'=>1),'courses_general',true); ?>" class="classroom_link_btn sesbasic_button sessmoothbox" style="display:inline-block;"><i class="sesbasic_icon_add"></i><span><?php echo $this->translate("Create Course"); ?></span></a>
  <?php } ?> 
  <div class="classroom_browse_search classroom_browse_search_horizontal">
    <div class="classroom_manage_courses">
      <?php echo $this->formFilter->render($this); ?>
    </div>
  </div>
  <div class="classroom_dashboard_table sesbasic_bxs">
<?php  } ?>
<?php if(count($this->courses) > 0 && $this->classroom->course_count != 0): ?>
  <form method="post" id="multidelete_form" onsubmit="return multiDelete();" >
    <table class='admin_table'>
        <thead>
            <tr>
            <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
            <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('course_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('verified', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'ASC');"><?php echo $this->translate("Creation Date") ?></a></th>
            <th><?php echo $this->translate("Options") ?></th>
            </tr>
        </thead>
        <tbody id="manage_course_table">
            <?php foreach ($this->courses as $item): ?>
            <tr id="course_id_<?php echo $item->course_id; ?>">
                <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->getIdentity(); ?>' value="<?php echo $item->getIdentity(); ?>" /></td>
                <td><?php echo $item->getIdentity() ?></td>
                <td>
                    <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
                </td>
                <td><?php echo $item->creation_date ?></td>
                <td>
                <?php echo $this->htmlLink($item->getHref(), $this->translate('view'), array('target'=> "_blank")) ?>
                |
                <?php echo $this->htmlLink(array('route' => 'courses_dashboard', 'course_id' => $item->custom_url), $this->translate('edit'), array('target'=> "_blank")) ?>
                |<a href="javascript:;" onclick="deleteCourse('<?php echo $item->course_id; ?>')" id="Course<?php echo $item->course_id; ?>"><?php echo $this->translate('Delete'); ?></a>
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
        <?php  if(($this->courses->getTotalItemCount() == 0) && !$this->is_search_ajax):  ?>
          <div class="sesbasic_tip clearfix">
            <img src="application/modules/Courses/externals/images/courses-icon.png" alt="" />
            <span class="sesbasic_text_light">
              <?php echo $this->translate('You have not created any course under this classroom. Please click on the Create Course button and and start building your courses.') ?>
            </span>
          </div>
        <?php endif; ?>
        <?php  if(($this->courses->getTotalItemCount() == 0) && $this->is_search_ajax):  ?>
          <div class="sesbasic_tip clearfix">
            <img src="application/modules/Courses/externals/images/courses-icon.png" alt="" />
            <span class="sesbasic_text_light">
              <?php echo $this->translate('There are no results that match your search. Please try again.') ?>
            </span>
          </div>
        <?php endif; ?>
    <?php endif; ?>
<?php if(!$this->is_ajax_content && !$this->is_search_ajax){ ?>
    </div>  
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
sesJqueryObject('#loadingimgeclassroom-wrapper').hide();

function deleteCourse(courseId)
{
var confirmDelete = confirm('Are you sure you want to delete?');
if(confirmDelete){
    sesJqueryObject("#Course"+courseId).html('<img src="application/modules/Core/externals/images/loading.gif" alt="Loading" />');
    ajaxDeleteRequest = (new Request.HTML({
	  method: 'post',
	  format: 'html',
	  'url': en4.core.baseUrl + 'courses/dashboard/delete',
	  'data': {
        is_Ajax_Delete : 1,
        course_id : courseId,
	  },
	  onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) { 
        var obj = jQuery.parseJSON(responseHTML);
        if(obj.status == "1"){ 
           sesJqueryObject("#course_id_"+courseId).remove();
        } else {
           sesJqueryObject("#Course"+courseId).html("Delete"); 
        }
        if(sesJqueryObject('#manage_course_table').children().length < 1) 
          location.reload();
	  }
	})).send();
}
}
var CourseFilterTabRequested = false; 
sesJqueryObject(document).on('submit','#courses_filter_form',function(event){
	event.preventDefault();
	if(CourseFilterTabRequested)
    return false;
	var searchFormData = sesJqueryObject(this).serialize();
	sesJqueryObject('#courses-search-order-img').show();
	CourseFilterTabRequested = new Request.HTML({
			method: 'post',
			url :  '<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url, 'action'=>'manage-courses'), 'eclassroom_dashboard', true); ?>',
			data : {
				format : 'html',
				searchParams :searchFormData, 
				is_search_ajax:true,
			},
			onComplete: function(response) {
        CourseFilterTabRequested = false;
				sesJqueryObject('#courses-search-order-img').hide();
				sesJqueryObject('.classroom_dashboard_table').html(response);
				
			}
	}).send();
});

function showSubCategory(cat_id,selected) {
    var url = en4.core.baseUrl + 'courses/ajax/subcategory/category_id/' + cat_id + '/type/'+ 'search';
    new Request.HTML({
      url: url,
      data: {
        'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subcat_id') && responseHTML) {
          if ($('subcat_id-wrapper')) {
            $('subcat_id-wrapper').style.display = "inline-block";
          }
          $('subcat_id').innerHTML = responseHTML;
        } 
        else {
          if ($('subcat_id-wrapper')) {
            $('subcat_id-wrapper').style.display = "none";
            $('subcat_id').innerHTML = '';
          }
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "none";
            $('subsubcat_id').innerHTML = '';
          }
        }
      }
    }).send(); 
  }
  function showSubSubCategory(cat_id,selected) {
    if(cat_id == 0){
      if ($('subsubcat_id-wrapper')) {
        $('subsubcat_id-wrapper').style.display = "none";
        $('subsubcat_id').innerHTML = '';
      }	
      return false;
    }
    var url = en4.core.baseUrl + 'courses/ajax/subsubcategory/subcategory_id/' + cat_id + '/type/'+ 'search';;
    (new Request.HTML({
      url: url,
      data: {
        'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subsubcat_id') && responseHTML) {
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "inline-block";
          }
          $('subsubcat_id').innerHTML = responseHTML;
        } 
        else {
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "none";
            $('subsubcat_id').innerHTML = '';
          }
        }
      }
    })).send();  
  }  
</script>
<?php if($this->is_ajax_content && !$this->is_search_ajax) die; ?>
