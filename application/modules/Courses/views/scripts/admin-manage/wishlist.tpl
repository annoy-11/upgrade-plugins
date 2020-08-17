<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: wishlist.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
 <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/style_dashboard.css'); ?>
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
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected wishlists?');?>");
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
<h3><?php echo $this->translate('Manage Wishlists'); ?></h3>
<p>
  <?php echo $this->translate("This page lists all of the wishlists your users have created. You can use this page to monitor these wishlists and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific wishlists. Leaving the filter fields blank will show all the wishlists on your social network.") ?>
</p>

<br />

<div class='courses_wishlist_search_form courses_browse_search_horizontal courses_admin_search_form admin_search sesbasic_search_form sesbasic_bxs'>
  <div class="clear">
   <div class="search">
  <?php echo $this->formFilter->render($this); ?>
  </div>	
  </div>	
</div>	
<br />	
<br />
<?php $counter = $this->paginator->getTotalItemCount(); ?>
<?php if( count($this->paginator) ): ?>
	<div class="sesbasic_search_reasult">
		<?php echo $this->translate(array('%s Wishlist found.', '%s Wishlists found.', $counter), $this->locale()->toNumber($counter)) ?>
	</div>
<form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
<table class='admin_table'>
  <thead>
    <tr>
      <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
      <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('wishlist_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
      <th><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
      <th><a href="javascript:void(0);" onclick="javascript:changeOrder('owner_id', 'ASC');"><?php echo $this->translate("Owner") ?></a></th>
      <th align="center" title='<?php echo $this->translate("Featured") ?>'><a href="javascript:void(0);" onclick="javascript:changeOrder('is_featured', 'ASC');"><?php echo $this->translate("F") ?></a></th>
      <th align="center" title='<?php echo $this->translate("Sponsored") ?>'><a href="javascript:void(0);" onclick="javascript:changeOrder('is_sponsored', 'ASC');"><?php echo $this->translate("S") ?></a></th>
      <th align="center" title="<?php echo $this->translate("Private") ?>"><a href="javascript:void(0);" onclick="javascript:changeOrder('is_private', 'ASC');"><?php echo $this->translate("P") ?></a></th>
      <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('offtheday', 'ASC');" title="Of the Day"><?php echo $this->translate("OTD") ?></a></th>
      <th><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'ASC');"><?php echo $this->translate("Creation Date") ?></a></th>
      <th><?php echo $this->translate("Options") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->paginator as $item): ?>
      <tr>
        <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->getIdentity(); ?>' value="<?php echo $item->getIdentity(); ?>" /></td>
        <td><?php echo $item->getIdentity() ?></td>
				<td>
					<?php if(strlen($item->getTitle()) > 7):?>
						<?php $title = mb_substr($item->getTitle(),0,7).'...';?>
						<?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()));?>
					<?php else: ?>
						<?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
					<?php endif;?>
				</td>
        <td><a href="<?php echo $item->getOwner()->getHref(); ?>"><?php echo $item->getOwner()->getTitle() ?></a></td>
        <td class="admin_table_centered">
            <?php if($item->is_featured == 1):?>
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'courses', 'controller' => 'admin-manage', 'action' => 'featured', 'wishlist_id' => $item->wishlist_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Featured')))) ?>
            <?php else: ?>
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'courses', 'controller' => 'admin-manage', 'action' => 'featured', 'wishlist_id' => $item->wishlist_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Featured')))) ?>
            <?php endif; ?>
        </td>  
        <td class="admin_table_centered">
          <?php if($item->is_sponsored == 1):?>
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'courses', 'controller' => 'admin-manage', 'action' => 'sponsored', 'wishlist_id' => $item->wishlist_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Sponsored')))) ?>
          <?php else: ?>
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'courses', 'controller' => 'admin-manage', 'action' => 'sponsored', 'wishlist_id' => $item->wishlist_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Sponsored')))) ?>
          <?php endif; ?>
        </td>
        <td class="admin_table_centered">
            <?php if($item->is_private == 1): ?>
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'courses', 'controller' => 'admin-manage', 'action' => 'verify', 'wishlist_id' => $item->wishlist_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Private')))) ?>
            <?php else: ?>
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'courses', 'controller' => 'admin-manage', 'action' => 'verify', 'wishlist_id' => $item->wishlist_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Private')))) ?>
            <?php endif; ?>
        </td>
        <td class="admin_table_centered">
          <?php if(strtotime($item->enddate) < strtotime(date('Y-m-d')) && $item->offtheday == 1): ?>
            <?php Engine_Api::_()->getDbTable('wishlists', 'courses')->update(array('offtheday' => 0,'startdate' =>'',
                      'enddate' =>''), array("wishlist_id = ?" => $item->wishlist_id));?>
            <?php $itemofftheday = 0;?>
          <?php else:?>
            <?php $itemofftheday = $item->offtheday; ?>
          <?php endif;?>
          <?php if($itemofftheday == 1):?>  
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'courses', 'controller' => 'admin-manage', 'action' => 'oftheday', 'wishlist_id' => $item->wishlist_id, 'param' => 0), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Edit Wishlist of the Day'))), array('class' => 'smoothbox')); ?>
          <?php else: ?>
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'courses', 'controller' => 'admin-manage', 'action' => 'oftheday', 'wishlist_id' => $item->wishlist_id, 'param' => 1), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Make Wishlist of the Day'))), array('class' => 'smoothbox')) ?>
          <?php endif; ?>
        </td>
        
        <td><?php echo $item->creation_date ?></td>
        <td>
					<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'courses', 'controller' => 'admin-manage', 'action' => 'view-wishlist','id' => $item->wishlist_id), $this->translate("View Details"), array('class' => 'smoothbox')) ?>
          |
          <?php echo $this->htmlLink($item->getHref(), $this->translate('view'), array('target'=> "_blank")) ?>
          |
          <?php echo $this->htmlLink(array('route' => 'courses_wishlist_view', 'wishlist_id' => $item->wishlist_id,'action'=>'edit'), $this->translate('edit'), array('target'=> "_blank")) ?>
          |
          <?php echo $this->htmlLink(
                array('route' => 'default', 'module' => 'courses', 'controller' => 'admin-manage', 'action' => 'delete-wishlist', 'wishlist_id' => $item->wishlist_id),
                $this->translate("delete"),
                array('class' => 'smoothbox')) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<br />
<div class='buttons'>
  <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
</div>
</form>

<br/>
<div>
  <?php echo $this->paginationControl($this->paginator); ?>
</div>

<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no wishlists created by your members yet.") ?>
    </span>
  </div>
<?php endif; ?>

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
</script>
