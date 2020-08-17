<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: my-tests.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(!$this->is_ajax && !$this->is_search_ajax){ ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/style_dashboard.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
<script type="text/javascript">
  var currentOrder = '<?php echo $this->order ?>';
  var currentOrderDirection = '<?php echo $this->order_direction ?>';
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
<div class='admin_search courses_usertest_table'>
<?php } ?>
    <div class="courses_usertest_form">
        <h3><?php echo $this->translate('My Tests'); ?></h3>
    </div>
    <div class="admin_search courses_browse_search courses_browse_search_horizontal sesbasic_clearfix sesbasic_bxs">
        <?php echo $this->searchForm->render($this); ?>
    </div>	
    <div class="courses_dashboard_table sesbasic_bxs">
    <?php $counter = $this->paginator->getTotalItemCount(); ?>
    <?php if( count($this->paginator) ): ?>
        <div class="courses_search_reasult" data-count="<?php echo $counter; ?>">
            <?php echo $this->translate(array('%s Test found.', '%s Tests found.', $counter), $this->locale()->toNumber($counter)) ?>
        </div>
        <br/>
        <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
        <table class='admin_table'>
            <thead>
                <tr>
                    <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
                    <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('usertest_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
                    <th><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
                    <th><a href="javascript:void(0);" onclick="javascript:changeOrder('user_id', 'ASC');"><?php echo $this->translate("Owner") ?></a></th>
                    <th><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'ASC');"><?php echo $this->translate("Test Duration") ?></a></th>
                    <th><?php echo $this->translate("Options") ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->paginator as $item): ?>
                <tr id="usertest_id_<?php echo $item->usertest_id; ?>">
                    <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->usertest_id; ?>' value="<?php echo $item->usertest_id; ?>" /></td>
                    <?php $test = Engine_Api::_()->getItem('courses_test', $item->test_id); ?>
                    <td><?php echo $item->usertest_id; ?></td>
                    <td>
                    <?php if(strlen($test->getTitle()) > 7):?>
                        <?php $title = mb_substr($test->getTitle(),0,7).'...';?>
                        <?php echo $this->htmlLink($test->getHref(),$title,array('title'=>$test->getTitle()));?>
                    <?php else: ?>
                        <?php echo $this->htmlLink($test->getHref(),$test->getTitle(),array('title'=>$test->getTitle())  ) ?>
                    <?php endif;?>
                    </td>
                    <td><a href="<?php echo $item->getOwner()->getHref(); ?>"><?php echo $test->getOwner()->getTitle() ?></a></td>
                    <td><?php echo $this->translate(array('%s Min', '%s Min', $test->test_time), $this->locale()->toNumber($test->test_time)) ?></td>
                    <td>
                        <?php echo $this->htmlLink($item->getHref(), $this->translate('view'), array('target'=> "_blank")) ?>
                        |
                        <a href="javascript:void(0);" onclick="deleteUserTests('<?php echo $item->usertest_id; ?>',this)" id="usertest_<?php echo $item->usertest_id; ?>"><?php echo $this->translate("Delete"); ?></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class='buttons'>
        <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
    </div>
    </form>
    <br/>
    <div>
        <?php echo $this->paginationControl($this->paginator); ?>
    </div>
    <?php else: ?>
        <?php  if(($this->paginator->getTotalItemCount() == 0) && !$this->is_search_ajax):  ?>
          <div class="sesbasic_tip clearfix">
            <img src="application/modules/Courses/externals/images/no-test-give.png" alt="" />
            <span class="sesbasic_text_light">
              <?php echo $this->translate('You have not given any Tests. Please give a test and test your skills.') ?>
            </span>
          </div>
        <?php endif; ?>
        <?php  if(($this->paginator->getTotalItemCount() == 0) && $this->is_search_ajax):  ?>
          <div class="sesbasic_tip clearfix">
            <img src="application/modules/Courses/externals/images/no-test-give.png" alt="" />
            <span class="sesbasic_text_light">
              <?php echo $this->translate('There are no results that match your search. Please try again.') ?>
            </span>
          </div>
        <?php endif; ?>
    <?php endif; ?>
<?php if(!$this->is_ajax && !$this->is_search_ajax){ ?>
</div>
<?php } ?>
<script>
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
function deleteUserTests(usertest_id){
var confirmDelete = confirm('<?php echo $this->translate('Are you sure you want to delete the selected Test?'); ?>');
if(confirmDelete){
var count = sesJqueryObject(".courses_search_reasult").attr('data-count');
sesJqueryObject("#usertest_"+usertest_id).html('<img src="application/modules/Core/externals/images/loading.gif" alt="Loading" />');
    new Request.HTML({
			method: 'post',
			url:en4.core.baseUrl + 'courses/manage-account/my-tests/',
			data : {
        format : 'html',
        usertest_id :usertest_id,
        data_count : count,
        is_ajax:true,
			},
			onComplete: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				 var obj = jQuery.parseJSON(responseHTML);
            if(obj.status == "1"){ 
                sesJqueryObject("#usertest_id_"+usertest_id).remove();
                sesJqueryObject(".courses_search_reasult").html(obj.label);
                sesJqueryObject(".courses_search_reasult").attr('data-count',obj.data_count);
            } else {
                sesJqueryObject("#usertest_"+usertest_id).html("Delete"); 
            }
			}
	}).send();
}
}
sesJqueryObject('#loadingimgcourses-wrapper').hide();
 sesJqueryObject(document).on('submit','#manage_test_search_form',function(event){
	event.preventDefault();
	var searchFormData = sesJqueryObject(this).serialize();
	sesJqueryObject('#loadingimgcourses-wrapper').show();
	new Request.HTML({
			method: 'post',
			url :  en4.core.baseUrl + 'courses/manage-account/my-tests/',
			data : {
				format : 'html',
				searchParams :searchFormData, 
				is_search_ajax:true,
			},
			onComplete: function(response) {
				sesJqueryObject('#loadingimgcourses-wrapper').hide();
				sesJqueryObject('.courses_usertest_table').html(response);
			}
	}).send();
});
sesJqueryObject('#loadingimgcourses-wrapper').hide();
</script>
<?php if($this->is_ajax || $this->is_search_ajax) die(); ?>
