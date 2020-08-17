<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-payment-event-owner.tpl  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $baseURL = $this->layout()->staticBaseUrl; ?>
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
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected tickets?');?>");
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
<?php include APPLICATION_PATH .  '/application/modules/Sescontest/views/scripts/dismiss_message.tpl';?>

<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
    <?php endif; ?>
    <div class="sesbasic-form-cont">
    <?php if( count($this->subsubNavigation) ): ?>
      <div class='tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subsubNavigation)->render();?>
      </div>
    <?php endif; ?>
    <h3><?php echo $this->translate("Payments Made to Group Owners") ?></h3>
    <p><?php echo $this->translate('This page lists all of the payments made to the contest owners on your website. You can use this page to monitor these payments made. Entering criteria into the filter fields will help you find specific payment detail. Leaving the filter fields blank will show all the payments made to contest owners on your social network.'); ?></p>
    <br />
    <div class='admin_search sesbasic_search_form'>
      <?php echo $this->formFilter->render($this) ?>
    </div>
    <br />
    <?php $counter = $this->paginator->getTotalItemCount(); ?> 
    <?php if( count($this->paginator) ): ?>
      <div class="sesbasic_search_reasult">
        <?php echo $this->translate(array('%s Payment found.', '%s Payments found.', $counter), $this->locale()->toNumber($counter)) ?>
      </div>
      <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
        <div class="clear" style="overflow:auto;">
        <table class='admin_table'>
          <thead>
            <tr>
              <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('userpayrequest_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
              
              <th><?php echo $this->translate("Group Title") ?></th>          
              <th><?php echo $this->translate("Owner Name") ?></th>
              <th><?php echo $this->translate("Requested Amount") ?></th>
              <th><?php echo $this->translate("Release Amount"); ?></th>
              <th><?php echo $this->translate("Released Date"); ?></th> 
              <th><?php echo $this->translate("Currency") ?></th>
              <th><?php echo $this->translate("Gateway Type"); ?></th>  
              <th><?php echo $this->translate("Payment Request Date"); ?></th>          
              <th><?php echo $this->translate("Options") ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($this->paginator as $item): ?>
              <?php $event = Engine_Api::_()->getItem('contest',$item->contest_id); 
              	if(!$event)
                	continue;
              ?>
            <tr>
              <td><?php echo $item->userpayrequest_id ?></td>
              <td><a href="<?php echo $event->getHref(); ?>" target="_blank"><?php echo $event->getTitle(); ?></a></td>
              <td><?php echo $item->getOwner(); ?></td>
              <td><?php echo round($item->requested_amount,2); ?></td>
              <td><?php echo round($item->release_amount,2); ?></td>
              <td><?php echo $item->release_date; ?></td>
              <td><?php echo $item->currency_symbol; ?></td>
              <td><?php echo $item->gateway_type; ?></td>
              <td><?php echo $item->creation_date; ?></td>
              <td>
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'egroupjoinfees', 'controller' => 'admin-settings', 'action' => 'view-paymentrequest', 'id' => $item->userpayrequest_id), $this->translate("View Details"), array('class' => 'smoothbox')) ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        </div>
      </form>
      <br/>
      <div>
        <?php echo $this->paginationControl($this->paginator); ?>
      </div>
    <?php else:?>
      <div class="tip">
        <span>
          <?php echo $this->translate("No payments have been made yet.") ?>
        </span>
      </div>
    <?php endif; ?>
    </div>
  </div>
</div>
