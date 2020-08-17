<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: photos.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
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
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected photos ?');?>");
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
<h3>Manage Photos</h3>
<p>This page lists all of the photos your users have created. You can use this page to monitor these photos and delete offensive material if necessary. Entering criteria into the filter fields will help you find the specific photo. Leaving the filter fields blank will show all the photos on your social network.<br /><br /></p>
<?php
$settings = Engine_Api::_()->getApi('settings', 'core');?>
<br />
<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />
<?php $counter = $this->paginator->getTotalItemCount(); ?> 
<?php if( count($this->paginator) ): ?>
  <div class="sesbasic_search_reasult">
    <?php echo $this->translate(array('%s photo found.', '%s photos found.', $counter), $this->locale()->toNumber($counter)) ?>
  </div>
  <form id="multidelete_form" action="<?php echo $this->url();?>" onSubmit="return multiDelete()" method="POST">
    <table class='admin_table'>
      <thead>
        <tr>
          <th class='admin_table_short'><input onclick="selectAll()" type='checkbox' class='checkbox' /></th>
          <th class='admin_table_short'>ID</th>
          <th><?php echo $this->translate('Image') ?></th>
          <th><?php echo $this->translate('Album Title') ?></th>
          <th><?php echo $this->translate('Classroom Title') ?></th>
          <th><?php echo $this->translate('Owner') ?></th>
          <th><?php echo $this->translate('Featured') ?></th>
          <th><?php echo $this->translate('Sponsored') ?></th>
          <th><?php echo $this->translate('Options') ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($this->paginator as $item): ?>
        <tr>
          <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->photo_id;?>' value="<?php echo $item->photo_id ?>"/></td>
          <td><?php echo $item->getIdentity() ?></td>
          <td><img src="<?php echo $item->getPhotoUrl('thumb.normal'); ?>" style="height:75px; width:75px;"/></td>
          <?php $album = Engine_Api::_()->getItem('eclassroom_album',$item->album_id) ?>
          <td><?php echo $this->htmlLink($album->getHref(), $this->string()->truncate($album->getTitle(),30)); ?></td> 
          <?php $classroom = Engine_Api::_()->getItem('classroom',$item->classroom_id); ?>
          <td><?php echo !empty($classroom) ? $this->htmlLink($classroom->getHref(), $this->string()->truncate($classroom->getTitle(),30)) : "---"; ?></td> 
          <td><?php echo $this->htmlLink($item->getHref(), $item->getOwner()); ?></td>
            <td class="admin_table_centered">
              <?php if($item->featured == 1):?>
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'eclassroom', 'controller' => 'admin-manage-album', 'action' => 'featuredphoto', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Featured')))) ?>
              <?php else: ?>
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'eclassroom', 'controller' => 'admin-manage-album', 'action' => 'featuredphoto', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Featured')))) ?>
                <?php endif; ?>
            </td>
            <td class="admin_table_centered">
              <?php if($item->sponsored == 1):?>
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'eclassroom', 'controller' => 'admin-manage-album', 'action' => 'sponsoredphoto', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Sponsored')))) ?>
              <?php else: ?>
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'eclassroom', 'controller' => 'admin-manage-album', 'action' => 'sponsoredphoto', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Sponsored')))) ?>
              <?php endif; ?>
            </td>
          <td>
            <a href="<?php echo $item->getHref(); ?>" target="_blank"> <?php echo $this->translate('View') ?> </a>         
            |
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'eclassroom', 'controller' => 'admin-manage-album', 'action' => 'delete-photo', 'id' => $item->photo_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <br/>
    <div class='buttons'>
      <button type='submit'> <?php echo $this->translate('Delete Selected') ?> </button>
    </div>
  </form>
  <br />
  <div class="clear"> <?php echo $this->paginationControl($this->paginator); ?> </div>
<?php else: ?>
  <div class="tip"> <span> <?php echo $this->translate("There are no photos .") ?> </span> </div>
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
