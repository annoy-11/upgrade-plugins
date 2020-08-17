<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: claim.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
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
</script>

<?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate("Claim Requests"); ?></h3>
<p>
  <?php echo $this->translate("This page lists all of the claim requests your users have made. You can use this page to monitor these requests and approve / decline them. Entering criteria into the filter fields will help you find specific claim request. Leaving the filter fields blank will show all the requests on your social network.") ?>
</p>

<br />

<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />	
<br />

<?php if( count($this->paginator) ): ?>
<table class='admin_table'>
  <thead>
    <tr>
      <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('course_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
      <th><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate("Course Title") ?></a></th>
      <th><?php echo $this->translate("Claimer") ?></th>
      <th align="center"><?php echo $this->translate("Status") ?></th>
      <th><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'ASC');"><?php echo $this->translate("Creation Date") ?></a></th>
      <th><?php echo $this->translate("Options") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->paginator as $item): ?>
      <tr>
        <?php $courseItem = Engine_Api::_()->getItem('courses', $item->course_id);?>
        <?php $UserItem = Engine_Api::_()->getItem('user', $item->user_id);?>
        <?php if(!$courseItem || !$UserItem) continue; ?>
        <td><?php echo $item->getIdentity() ?></td>
        <td><a href="<?php echo $courseItem->getHref(); ?>" target="_blank"><?php echo $courseItem->getTitle() ?></a></td>
        <td><a href="<?php echo $UserItem->getHref(); ?>" target="_blank"><?php echo $UserItem->getTitle() ?></a></td>
				<td class="admin_table_centered">
					<?php if($item->status == 1):?>
						<?php echo $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '');?>
					<?php else: ?>
						<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'courses', 'controller' => 'admin-manage', 'action' => 'approve-claim', 'id' => $item->claim_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Approve Claim Request'))), array('class' => 'smoothbox')) ?>
					<?php endif; ?>
				</td> 
        <td><?php echo date('Y-m-d H:i:s',strtotime($item->creation_date)) ?></td>
        <td>
	        <?php echo $this->htmlLink(
	  array('route' => 'default', 'module' => 'courses', 'controller' => 'admin-manage', 'action' => 'show-detail', 'id' => $item->claim_id),
	  $this->translate("Details"),
	  array('class' => 'smoothbox')) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<br/>
<div>
  <?php echo $this->paginationControl($this->paginator); ?>
</div>
<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no claim requests yet.") ?>
    </span>
  </div>
<?php endif; ?>
