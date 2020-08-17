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
    return confirm("<?php echo $this->translate('Are you sure you want to delete selected Lecture?');?>");
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
<h3><?php echo $this->translate("Manage Lectures") ?></h3>
<p><?php echo $this->translate('This page lists all the lectures your users have created. You can use this page to monitor these lectures and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific video entries. Leaving the filter fields blank will show all the lecture types created on your website.'); ?></p>
<br />
<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />
 <?php $defaultCurrency = Engine_Api::_()->courses()->defaultCurrency(); ?>
<?php $counter = $this->paginator->getTotalItemCount(); ?> 
<?php if( count($this->paginator) ): ?>
  <div class="sesbasic_search_reasult">
    <?php echo $this->translate(array('%s Lecture found.', '%s Lecture found.', $counter), $this->locale()->toNumber($counter)) ?>
  </div>
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
    <div class="admin_table_form">
      <table class='admin_table'>
        <thead>
          <tr>
            <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
            <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('lecture_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('owner_id', 'ASC');"><?php echo $this->translate("Instructor") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('course_id', 'ASC');"><?php echo $this->translate("Course") ?></a></th>
            <th><?php echo $this->translate("View Count") ?></th>
            <th><?php echo $this->translate("Lecture Type") ?></th>
            <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('is_approved', 'ASC');" title="Approved"><?php echo $this->translate("A") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'ASC');"><?php echo $this->translate("Creation Date") ?></a></th>
            <th><?php echo $this->translate("Options") ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($this->paginator as $item):  ?>
          <tr>
            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->lecture_id; ?>' value="<?php echo $item->lecture_id; ?>" /></td>
            <td><?php echo $item->lecture_id ?></td>
            <?php $course = Engine_Api::_()->getItem('courses', $item->course_id); ?>
            <td><?php echo $this->htmlLink($item->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($item->getTitle(),16)), array('title' => $item->getTitle(), 'target' => '_blank')) ?></td>
            <td><?php echo $this->htmlLink($item->getOwner()->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($item->getOwner()->getTitle(),16)), array('title' => $this->translate($item->getOwner()->getTitle()), 'target' => '_blank')) ?></td>
            <td><?php echo $this->htmlLink($course->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($course->getTitle(),16)), array('title' => $this->translate($course->getTitle()), 'target' => '_blank')) ?></td>
            <td><?php echo $item->view_count; ?></td>
            <td><?php echo $item->type; ?></td>
            <td>
              <?php if($item->is_approved == 1):?>
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'courses', 'controller' => 'admin-manage', 'action' => 'lecture-approved', 'lecture_id' => $item->lecture_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Approve')))) ?>
              <?php else: ?>
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'courses', 'controller' => 'admin-manage', 'action' => 'lecture-approved', 'lecture_id' => $item->lecture_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Approve')))) ?>
              <?php endif; ?>
            </td>
            <td><?php echo $item->creation_date ?></td>
            <td>
              <?php echo $this->htmlLink($item->getHref(), $this->translate("View"), array('target' => '_blank')); ?> |
              <?php echo $this->htmlLink(array('route' => 'lecture_general','lecture_id' => $item->lecture_id,'course_id' => $item->course_id,'action'=>'edit'), $this->translate('Edit'), array('target'=> "_blank"))  ?> |
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'courses', 'controller' => 'admin-manage', 'action' => 'lecture-delete','lecture_id' => $item->lecture_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
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
