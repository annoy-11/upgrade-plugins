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
<?php include APPLICATION_PATH .  '/application/modules/Sescrowdfunding/views/scripts/dismiss_message.tpl';?>
<h2><?php echo $this->translate("Manage Crowdfunding Orders"); ?></h2>
<p><?php echo $this->translate("Here, you can see all crowdfunding order by members.") ?></p>
<br />
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

function multiModify()
{
  var multimodify_form = $('multimodify_form');
  if (multimodify_form.submit_button.value == 'delete')
  {
    return confirm('<?php echo $this->string()->escapeJavascript($this->translate("Are you sure you want to delete the selected user accounts?")) ?>');
  }
}

function selectAll()
{
  var i;
  var multimodify_form = $('multimodify_form');
  var inputs = multimodify_form.elements;
  for (i = 1; i < inputs.length - 1; i++) {
    if (!inputs[i].disabled) {
      inputs[i].checked = inputs[0].checked;
    }
  }
}

function loginAsUser(id) {
  if( !confirm('<?php echo $this->translate('Note that you will be logged out of your current account if you click ok.') ?>') ) {
    return;
  }
  var url = '<?php echo $this->url(array('action' => 'login')) ?>';
  var baseUrl = '<?php echo $this->url(array(), 'default', true) ?>';
  (new Request.JSON({
    url : url,
    data : {
      format : 'json',
      id : id
    },
    onSuccess : function() {
      window.location.replace( baseUrl );
    }
  })).send();
}

<?php if( $this->openUser ): ?>
window.addEvent('load', function() {
  $$('#multimodify_form .admin_table_options a').each(function(el) {
    if( -1 < el.get('href').indexOf('/edit/') ) {
      el.click();
      //el.fireEvent('click');
    }
  });
});
<?php endif ?>
</script>

<div class='admin_search'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />

<div class='admin_results'>
  <div>
    <?php $count = $this->paginator->getTotalItemCount() ?>
    <?php echo $this->translate(array("%s crowdfunding order found", "%s crowdfunding orders found", $count),
        $this->locale()->toNumber($count)) ?>
  </div>
  <div>
    <?php echo $this->paginationControl($this->paginator, null, null, array(
      'pageAsQuery' => true,
      'query' => $this->formValues,
      //'params' => $this->formValues,
    )); ?>
  </div>
</div>

<br />

<div class="admin_table_form">
<form id='multimodify_form' method="post" action="<?php echo $this->url(array('action'=>'multi-modify'));?>" onSubmit="multiModify()">
  <table class='admin_table'>
    <thead>
      <tr>
        <!--<th style='width: 1%;'><input onclick="selectAll()" type='checkbox' class='checkbox'></th>-->
        <th style='width: 1%;'><a href="javascript:void(0);" onclick="javascript:changeOrder('order_id', 'DESC');"><?php echo $this->translate("Order ID") ?></a></th>
        <th><?php echo $this->translate("Crowdfunding Title") ?></th>
        <th><?php echo $this->translate("Crowdfunding Owner Name") ?></th>
        <th><?php echo $this->translate("Donor Email") ?></th>
        <th><?php echo $this->translate("Donor Name") ?></th>
        <th><?php echo $this->translate("Donation Amount") ?></th>
        <th><?php echo $this->translate("Commission") ?></th>
        <th style='width: 1%;'><?php echo $this->translate("Ordered Date") ?></th>
        <th style='width: 1%;' class='admin_table_options'><?php echo $this->translate("Options") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php if( count($this->paginator) ): ?>
        <?php foreach( $this->paginator as $item ):
          $crowdfunding = $this->item('crowdfunding', $item->crowdfunding_id);
          $user = $this->item('user', $item->user_id);
          $total_amount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($item->total_amount, $item->currency_symbol);
          $total_useramount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($item->total_useramount, $item->currency_symbol);
          $commission_amount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($item->commission_amount, $item->currency_symbol);
          ?>
          <tr>
            <!--<td><input name='modify_<?php //echo $item->getIdentity();?>' value=<?php //echo $item->getIdentity();?> type='checkbox' class='checkbox'></td>-->
            
            <td><?php echo $item->order_id ?></td>
            <td class='admin_table_bold'>
              <?php echo $this->htmlLink($crowdfunding->getHref(), $this->string()->truncate($crowdfunding->getTitle(), 10), array('target' => '_blank')); ?>
            </td>
            <td class='admin_table_bold'>
              <?php echo $this->htmlLink($crowdfunding->getOwner()->getHref(), $this->string()->truncate($crowdfunding->getOwner()->getTitle(), 10), array('target' => '_blank')); ?>
            </td>
            <td class='admin_table_bold'>
              <?php echo $item->email; ?>
            </td>
            <td class='admin_table_bold'>
              <?php echo $this->htmlLink($user->getHref(), $this->string()->truncate($user->getTitle(), 10), array('target' => '_blank')); ?>
            </td>
            <td class='admin_table_centered'><?php echo $total_amount; ?></td>
            <td class='admin_table_centered'><?php echo $commission_amount; ?></td>
            <td class="nowrap">
              <?php echo $item->creation_date ?>
            </td>
            <td class='admin_table_options'>
              <a href='<?php echo $crowdfunding->getHref(); ?>' target="_blank"><?php echo $this->translate("View Crowdfunding") ?></a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
  <br />
</form>
</div>
