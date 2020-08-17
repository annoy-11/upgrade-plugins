<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
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

  function multiDelete() {
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected entries?');?>");
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

<?php include APPLICATION_PATH .  '/application/modules/Sesjob/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate('Manage Job Applications'); ?></h3>
<p>
  <?php echo $this->translate("This page lists all of the job applications posted by members. You can use this page to monitor these applications. Entering criteria into the filter fields will help you find specific application entries. Leaving the filter fields blank will show all the application entries on your social network.<br />") ?>
</p>
<br />
<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />
<br />
<?php $counter = $this->paginator->getTotalItemCount(); ?>
<?php if( count($this->paginator) ): ?>
	<div class="sesbasic_search_reasult">
		<?php echo $this->translate(array('%s application found.', '%s applications found.', $counter), $this->locale()->toNumber($counter)) ?>
	</div>
<form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
<table class='admin_table'>
  <thead>
    <tr>
      <!--<th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>-->
      <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('application_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
      <th><?php echo $this->translate("Job Title") ?></th>
      <th><?php echo $this->translate("Name") ?></th>
      <th><?php echo $this->translate("Email") ?></th>
      <th><?php echo $this->translate("Mobile Number") ?></th>
      <th><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'ASC');"><?php echo $this->translate("Creation Date") ?></a></th>
      <th><?php echo $this->translate("Options") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->paginator as $item): //print_r($item->toArray());die; ?>
      <tr>
        <!--<td><input type='checkbox' class='checkbox' name='delete_<?php //echo $item->getIdentity(); ?>' value="<?php //echo $item->getIdentity(); ?>" /></td>-->
        <td><?php echo $item->getIdentity() ?></td>
				<td>
				  <?php if(!empty($item->job_id)) { ?>
            <?php $job = Engine_Api::_()->getItem('sesjob_job', $item->job_id); ?>
            <?php if($job && strlen($job->getTitle()) > 7):?>
              <?php $title = mb_substr($job->getTitle(),0,7).'...';?>
              <?php echo $this->htmlLink($job->getHref(),$title,array('title'=>$job->getTitle(), 'target' => "_blank"));?>
            <?php elseif($job): ?>
              <?php echo $this->htmlLink($job->getHref(),$job->getTitle(),array('title'=>$job->getTitle(), 'target' => "_blank")); ?>
            <?php endif;?>
					<?php } else { ?>
            <?php echo "---"; ?>
					<?php } ?>
				</td>
				<td>
				<?php if($item->owner_id) { ?>
          <a href="<?php echo $item->getOwner()->getHref(); ?>"><?php echo $item->name; ?></a>
				<?php } else { ?> 
          <?php echo $item->name; ?>
				<?php } ?>
				</td>
        <td><?php echo $item->email; ?></td>
        <td><?php echo $item->mobile_number; ?></td>
        <td><?php echo $item->creation_date ?></td>
        <td>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesjob', 'controller' => 'admin-manage-applications', 'action' => 'download', 'id' => $item->application_id), $this->translate("Download Resume"), array()) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<br />
<div class='buttons'>
 <!-- <button type='submit'><?php //echo $this->translate("Delete Selected") ?></button>-->
</div>
</form>
<br/>
<div>
  <?php echo $this->paginationControl($this->paginator); ?>
</div>

<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no application entries yet.") ?>
    </span>
  </div>
<?php endif; ?>
