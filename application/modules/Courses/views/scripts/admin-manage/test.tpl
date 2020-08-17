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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/style_dashboard.css'); ?>
<style>
#date-date_to{display:block !important;}
#date-date_from{display:block !important;}
</style>
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
    return confirm("<?php echo $this->translate('Are you sure you want to delete selected Test?');?>");
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
<?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate("Manage Tests") ?></h3>
<p><?php echo $this->translate('This page lists all the tests your users have created. You can use this page to monitor these tests and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific tests. Leaving the filter fields blank will show all the tests created on your website.'); ?></p>
<br />
<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />
 <?php $defaultCurrency = Engine_Api::_()->courses()->defaultCurrency(); ?>
<?php $counter = $this->paginator->getTotalItemCount(); ?> 
<?php if( count($this->paginator) ): ?>
  <div class="sesbasic_search_reasult">
    <?php echo $this->translate(array('%s Test found.', '%s Tests found.', $counter), $this->locale()->toNumber($counter)) ?>
  </div>
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
    <div class="admin_table_form">
      <table class='admin_table'>
        <thead>
          <tr>
            <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
            <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('test_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('course_id', 'ASC');"><?php echo $this->translate("Course") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('owner_id', 'ASC');"><?php echo $this->translate("Owner") ?></a></th>  
            <th><?php echo $this->translate("Total Questions") ?></th>
            <th><?php echo $this->translate("Test Time(In Minutes)") ?></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'ASC');"><?php echo $this->translate("Creation Date") ?></a></th>
            <th><?php echo $this->translate("Options") ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($this->paginator as $item):?>
          <tr>
            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->test_id; ?>' value="<?php echo $item->test_id; ?>" /></td>
            <td><?php echo $item->test_id ?></td>
            <td><?php echo $this->htmlLink($item->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($item->getTitle(),16)), array('title' => $item->getTitle(), 'target' => '_blank')) ?></td>
            <?php $course = Engine_Api::_()->getItem('courses', $item->course_id); ?>
            <td><?php echo $this->htmlLink($course->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($course->getTitle(),16)), array('title' => $this->translate($course->getTitle()), 'target' => '_blank')) ?></td>
            <td><?php echo $this->htmlLink($item->getOwner()->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($item->getOwner()->getTitle(),16)), array('title' => $this->translate($item->getOwner()->getTitle()), 'target' => '_blank')) ?></td>
            <td><?php echo $item->total_questions; ?></td>
            <td><?php echo $item->test_time; ?></td>
            <td><?php echo $item->creation_date; ?></td>
            <td>
              <?php echo $this->htmlLink($item->getHref(), $this->translate("View"), array('target' => '_blank')); ?> |
              <?php echo $this->htmlLink($this->url(array('test_id' => $item->test_id,'action'=>'edit'), 'tests_general', true), $this->translate("Edit"), array('target' => '_blank')); ?> |
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'courses', 'controller' => 'admin-manage', 'action' => 'test-delete','test_id' => $item->test_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
    <br />
    <div class='buttons'>
      <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
    </div>
  </form>
  <br/>
  <div>
    <?php echo $this->paginationControl($this->paginator,null,null,$this->urlParams); ?>
  </div>
<?php else:?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no course created by your members yet.") ?>
    </span>
  </div>
<?php endif; ?>

<script type="text/javascript">
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
</script>
