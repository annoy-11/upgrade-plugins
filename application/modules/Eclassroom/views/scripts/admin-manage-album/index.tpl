<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
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

<?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/dismiss_message.tpl';?>
<script type="text/javascript">
function multiDelete()
{
  return confirm("<?php echo $this->translate('Are you sure you want to delete the selected photo albums?');?>");
}
function selectAll()
{
  var i;
  var multidelete_form = $('multidelete_form');
  var inputs = multidelete_form.elements;
  for (i = 1; i < inputs.length - 1; i++) {
    inputs[i].checked = inputs[0].checked;
  }
}
</script>
<h3><?php echo $this->translate("Manage Albums") ?></h3>
<p>This page lists all of the albums your users have created. You can use this page to monitor these albums and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific album. Leaving the filter fields blank will show all the albums on your social network.<br /><br /></p>
<br />
<?php
$settings = Engine_Api::_()->getApi('settings', 'core');?>	
<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />
<?php $counter = $this->paginator->getTotalItemCount(); ?> 
<?php if( count($this->paginator) ): ?>
  <div class="sesbasic_search_reasult">
    <?php echo $this->translate(array('%s album found.', '%s albums found.', $counter), $this->locale()->toNumber($counter)) ?>
  </div>
<form id="multidelete_form" action="<?php echo $this->url();?>" onSubmit="return multiDelete()" method="POST">
  <table class='admin_table'>
    <thead>
      <tr>
        <th class='admin_table_short'><input onclick="selectAll()" type='checkbox' class='checkbox' /></th>
        <th class='admin_table_short'>ID</th>
        <th><?php echo $this->translate('Album Title') ?></th>
        <th><?php echo $this->translate('Classroom Title') ?></th>
        <th><?php echo $this->translate('Owner') ?></th>
        <th><?php echo $this->translate('Photos') ?></th>
        <th><?php echo $this->translate('Featured') ?></th>
        <th><?php echo $this->translate('Sponsored') ?></th>
        <th><?php echo $this->translate('Options') ?></th>
      </tr>
    </thead>
    <tbody>
        <?php foreach ($this->paginator as $item): ?>
          <tr>
            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->album_id;?>' value="<?php echo $item->album_id ?>"/></td>
            <td><?php echo $item->getIdentity() ?></td>
            <td><?php echo $this->htmlLink($item->getHref(), $item->getTitle()); ?></td>
            <?php if($item->classroom_id) { ?>
              <?php $classroom = Engine_Api::_()->getItem('classroom', $item->classroom_id); ?>
              <?php if($classroom) { ?>
              <td><?php echo $this->htmlLink($classroom->getHref(), $classroom->getTitle()); ?></td> 
              <?php } else { ?>
                <td><?php echo "---"; ?></td>
              <?php } ?>
            <?php } else { ?>
              <td><?php echo "---"; ?></td>
            <?php } ?>
            <td><?php echo $this->htmlLink($item->getHref(), $item->getOwner()); ?></td>
            <?php $countPhotos = Engine_Api::_()->getDbTable('photos', 'eclassroom')->countAlbumPhotos($item->getIdentity()); ?>
            <td><?php echo $countPhotos; ?></td>
            <td class="admin_table_centered">
              <?php if($item->featured == 1):?>
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'eclassroom', 'controller' => 'admin-manage-album', 'action' => 'featuredalbum', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Featured')))) ?>
              <?php else: ?>
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'eclassroom', 'controller' => 'admin-manage-album', 'action' => 'featuredalbum', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Featured')))) ?>
                <?php endif; ?>
            </td>
            <td class="admin_table_centered">
              <?php if($item->sponsored == 1):?>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'eclassroom', 'controller' => 'manage-album', 'action' => 'sponsoredalbum', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Sponsored')))) ?>
              <?php else: ?>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'eclassroom', 'controller' => 'manage-album', 'action' => 'sponsoredalbum', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Sponsored')))) ?>
              <?php endif; ?>
            </td>
            <td>
              <a href="<?php echo $this->url(array('album_id' => $item->getIdentity()), 'eclassroom_specific_album') ?>" target="_blank">
                <?php echo $this->translate('View') ?>
              </a>
              |
              <a href="<?php echo $this->url(array('module' => 'eclassroom', 'action' => 'edit', 'album_id' => $item->album_id), 'eclassroom_specific_album', true); ?>"><?php echo $this->translate('Edit'); ?></a>
              |
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'eclassroom', 'controller' => 'admin-manage-album', 'action' => 'delete', 'id' => $item->album_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
            </td>
          </tr>
        <?php endforeach; ?>
    </tbody>
  </table>
  <br/>
  <div class='buttons'>
    <button type='submit'>
      <?php echo $this->translate('Delete Selected') ?>
    </button>
  </div>
</form>
<br />
<div>
  <?php echo $this->paginationControl($this->paginator); ?>
</div>
<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no albums posted by your members yet.") ?>
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
