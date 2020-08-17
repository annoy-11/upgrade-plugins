<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $baseURL = $this->layout()->staticBaseUrl;
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
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

<?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/dismiss_message.tpl';?>

  <div>
<h3><?php echo $this->translate("Manage Orders") ?></h3>
<p><?php echo $this->translate('This page lists all of the orders which are purchased from your website. You can use this page to monitor these orders. Entering criteria into the filter fields will help you find specific ticket order. Leaving the filter fields blank will show all the orders on your social network.'); ?></p>
<br />
    <div class='estore_admin_search_form sesbasic_bxs'>
      <?php echo $this->formFilter->render($this) ?>
    </div>
    <br />

    <?php $counter = $this->paginator->getTotalItemCount(); ?>
    <?php if( count($this->paginator)): ?>
      <div class="sesbasic_search_reasult">
        <?php echo $this->translate(array('%s order found.', '%s orders found.', $counter), $this->locale()->toNumber($counter)) ?>
      </div>
        <div class="clear" style="overflow: auto;">
         <form id='multidelete_form' method="post">
        <table class='admin_table'>
          <thead>
            <tr>
              <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
              <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('order_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
              <th><?php echo $this->translate("Store Title") ?></th>
              <th><?php echo $this->translate("Owner Name") ?></th>
              <th class="admin_table_centered"><?php echo $this->translate("Product Quantity") ?></th>
              <th class="admin_table_centered"><?php echo $this->translate("Delivery Time"); ?></th>
              <th class="admin_table_centered"><?php echo $this->translate("Billing Name") ?></th>
              <th class="admin_table_centered"><?php echo $this->translate("Shipping Name") ?></th>
              <th class="admin_table_centered"><?php echo $this->translate("Status") ?></th>
              <th class="admin_table_centered"><?php echo $this->translate("Payment Type") ?></th>
              <th class="admin_table_centered"><?php echo $this->translate("Total Amount"); ?></th>
              <th class="admin_table_centered"><?php echo $this->translate("Commission Amount"); ?></th>

              <th class="admin_table_centered"><?php echo $this->translate("Ordered Date"); ?></th>
              <th><?php echo $this->translate("Options") ?></th>
            </tr>
          </thead>
          <?php $defaultCurrency = Engine_Api::_()->estore()->defaultCurrency(); ?>
          <tbody>
            <?php foreach ($this->paginator as $item): ?>
            <tr>
            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->order_id;?>' value="<?php echo $item->order_id; ?>" /></td>
              <?php $store = Engine_Api::_()->getItem('stores',$item->store_id); ?>
              <td><?php echo $this->htmlLink($this->url(array('store_id' => $store->custom_url,'action'=>'view','order_id'=>$item->order_id), 'estore_order', true).'?order=view', $item->order_id, array('title' => $this->translate($item->order_id), 'class' => 'smoothbox')); ?></td>

              <td class="admin_table_centered">
                <a href="<?php echo $store->getHref(); ?>" target="_blank"><?php echo $store->getTitle(); ?></a>
              </td>
              <td class="admin_table_centered">
                <?php
                  echo Engine_Api::_()->getItem('user',$item->user_id);
                ?>
              </td>
              <td class="admin_table_centered"><?php echo $item->item_count; ?></td>
              <td class="admin_table_centered"><?php echo $item->shipping_delivery_tile; ?></td>
              <td class="admin_table_centered"><?php echo $item->billing_name; ?></td>
              <td class="admin_table_centered"><?php echo $item->shipping_name; ?></td>
              <td class="admin_table_centered">
                <?php echo $this->partial('orderStatus.tpl','sesproduct',array('item'=>$item)); ?>
              </td>
              <td class="admin_table_centered">
                <?php echo $item->gateway_type; ?>
              </td>
              <td class="admin_table_centered">
                <?php echo Engine_Api::_()->estore()->getCurrencyPrice(round($item->total,2),$defaultCurrency); ?>
              </td>
              <td class="admin_table_centered">
                <?php echo Engine_Api::_()->estore()->getCurrencyPrice(round($item->commission_amount,2),$defaultCurrency); ?>
              </td>

              <td class="admin_table_centered">
                <?php echo $item->creation_date; ?>
              </td>
              <td class="admin_table_centered">

              <?php if(($item->gateway_id == 20 || $item->gateway_id == 21) && $item->state == "processing"){ ?>
                <?php echo $this->htmlLink($this->url(array('action'=>'payment-approve','order_id'=>$item->order_id,'module'=>'sesproduct','controller'=>'orders'), 'admin_default', true), $this->translate("Approve Payment"), array('title' => $this->translate("Approve Payment"), 'class' => 'smoothbox')); ?>
                |
              <?php } ?>
                <?php echo $this->htmlLink($this->url(array('store_id' => $store->custom_url,'action'=>'view','order_id'=>$item->order_id), 'estore_order', true).'?order=view', $this->translate("View Order"), array('title' => $this->translate("View Order"), 'class' => 'smoothbox')); ?>
                |
                <?php echo $this->htmlLink($this->url(array('store_id' => $store->custom_url,'action'=>'view','order_id'=>$item->order_id), 'estore_order', true), $this->translate("Print Invoice"), array('title' => $this->translate("Print Invoice"), 'target' => '_blank')); ?>

                <?php if($item->state == "Processing"){ ?>
                |
                <?php echo $this->htmlLink($this->url(array('action'=>'payment-cancel','order_id'=>$item->order_id,'module'=>'sesproduct','controller'=>'orders'), 'admin_default', true), $this->translate("Cancel Order"), array('title' => $this->translate("Cancel Order"), 'class' => 'smoothbox')); ?>
                <?php } ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table><br/>
        <div class='buttons'>
            <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
        </div>
   </form>
        </div>
      <script type="application/javascript">
        function changeOrderStatus(order_id,object) {
            sesJqueryObject('img_'+order_id).show();
            var formData = new FormData(sesJqueryObject(object).closest('form')[0]);
            var form = sesJqueryObject(object);
            sesJqueryObject.ajax({
                type:'POST',
                dataType:'html',
                url: 'admin/sesproduct/orders/change-order-status/order_id/'+order_id,
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(response){
                    sesJqueryObject('img_'+order_id).hide();
                    var data = sesJqueryObject.parseJSON(response);
                    if(data.status == 1){
                        sesJqueryObject(object).closest('td').html(data.message);
                    }else{
                        alert('Something went wrong, please try again later');
                    }
                },
                error: function(data){
                    //silence
                    sesJqueryObject('img_'+order_id).hide();
                    alert('Something went wrong, please try again later');
                }
            });
        }
        sesJqueryObject(document).on('click','.sesproduct_change_type',function () {
          if(sesJqueryObject(this).hasClass('active')){
              sesJqueryObject(this).removeClass('active');
              sesJqueryObject(this).parent().parent().find('form').hide();
              return;
          }else{
              sesJqueryObject(this).addClass('active');
              sesJqueryObject(this).parent().parent().find('form').show();
              return;
          }
        });
      </script>
      <br/>
      <div>
        <?php echo $this->paginationControl($this->paginator); ?>
      </div>
    <?php else:?>
      <div class="tip">
        <span>
          <?php echo $this->translate("Nobody has placed an order yet on your website.") ?>
        </span>
      </div>
    <?php endif; ?>
    </div>
</div>
