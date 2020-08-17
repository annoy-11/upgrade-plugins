<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $currency = Engine_Api::_()->sescrowdfunding()->getCurrentCurrency(); ?>
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
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected reward entries?');?>");
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

<?php include APPLICATION_PATH .  '/application/modules/Sescrowdfunding/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate('Manage Rewards'); ?></h3>
<p>
  <?php echo $this->translate("This page lists all of the reward your users have created. You can use this page to monitor these rewards and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific reward entries. Leaving the filter fields blank will show all the reward entries on your social network.") ?>
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
		<?php echo $this->translate(array('%s reward found.', '%s rewards found.', $counter), $this->locale()->toNumber($counter)) ?>
	</div>
<form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
<table class='admin_table'>
  <thead>
    <tr>
      <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
      <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('crowdfunding_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
      <th><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
      <th><?php echo $this->translate("Crowdfunding Title") ?></th>
      <th><?php echo $this->translate("Owner") ?></th>
      <th><?php echo $this->translate("Amount") ?></th>
      <th><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'ASC');"><?php echo $this->translate("Creation Date") ?></a></th>
      <th><?php echo $this->translate("Option") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->paginator as $item): ?>
      <?php $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $item->crowdfunding_id); ?>
      <?php $totalAmount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($item->doner_amount, $currency); ?>
      <?php $user = Engine_Api::_()->getItem('user', $crowdfunding->owner_id); ?>
      <tr>
        <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->getIdentity(); ?>' value="<?php echo $item->getIdentity(); ?>" /></td>
        <td><?php echo $item->getIdentity() ?></td>
				<td>
					<?php if(strlen($item->getTitle()) > 16):?>
						<?php $title = mb_substr($item->getTitle(),0,16).'...';?>
						<?php echo $title;?>
					<?php else: ?>
						<?php echo $item->getTitle(); ?>
					<?php endif;?>
				</td>
				<td>
					<?php if(strlen($crowdfunding->getTitle()) > 16):?>
						<?php $title = mb_substr($crowdfunding->getTitle(),0,16).'...';?>
						<?php echo $this->htmlLink($crowdfunding->getHref(),$title,array('title'=>$crowdfunding->getTitle()));?>
					<?php else: ?>
						<?php echo $this->htmlLink($crowdfunding->getHref(),$crowdfunding->getTitle(),array('title'=>$crowdfunding->getTitle())  ) ?>
					<?php endif;?>
				</td>
        <td>
          <a href="<?php echo $crowdfunding->getOwner()->getHref(); ?>"><?php echo $crowdfunding->getOwner()->getTitle() ?></a>
        </td>
        <td>
          <?php echo $totalAmount; ?>
        </td>
        <td><?php echo $item->creation_date ?></td>
        <td>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'admin-manage-rewards', 'action' => 'delete', 'id' => $item->crowdfunding_id), $this->translate("Delete"),array('class' => 'smoothbox')) ?>
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
      <?php echo $this->translate("There are no reward entries by your members yet.") ?>
    </span>
  </div>
<?php endif; ?>
