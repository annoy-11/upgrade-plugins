<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-product.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if(!$this->is_ajax_content  && !$this->is_search_ajax){ ?>
<script type="text/javascript">

  var currentOrder = 'is_approved';
  var currentOrderDirection = 'ASC';
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
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected product entries?');?>");
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
<?php $isEnablePackage = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesproductpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproductpackage.enable.package', 1);  
 echo $this->partial('dashboard/left-bar.tpl', 'estore', array(
	'store' => $this->store,
      ));	
?>
  <div class="estore_dashboard_content sesbm sesbasic_clearfix">
  <?php  } ?>
  <div class="estore_dashboard_content_header">
    <h3><?php echo $this->translate("Manage Products"); ?></h3>
    <p><?php echo $this->translate("Here you can manage all products in this store."); ?></p> 
    <?php if(Engine_Api::_()->sesproduct()->createProduct($this->subject())){ ?>
  </div>  
  <?php if($this->shippingMethods->getTotalItemCount()) { ?>
      <a href="<?php echo $this->url(array('action'=>'create','store_id'=>$this->subject()->getIdentity()),'sesproduct_general',true); ?>" class="estore_link_btn"><i class="sesbasic_icon_add"></i><span><?php echo $this->translate("Create Product"); ?></span></a>
  <?php } else {  ?>
  	<?php $shipping_method = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'shipping_method')); ?>
    	<?php if($shipping_method->enabled): ?>
        <div>
          <a id="estore_search_member_search" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'shippings'), 'estore_dashboard', true); ?>" class="estore_dashboard_nopropagate_content estore_link_btn"><i class="fa fa-truck"></i><span><?php echo $this->translate($shipping_method->title); ?></span></a>
        </div>
      <?php endif; ?>
      <div class="tip">
        <span>
          <?php echo $this->translate("No Shipping method created in this store."); ?>
        </span>
      </div>
    <?php } ?>  
 <?php if( count($this->products) > 0 && $this->store->product_count != 0): ?>
  <div class="estore_browse_search estore_browse_search_horizontal">
    <div class="estore_manage_products">
      <?php echo $this->formFilter->render($this); ?>
    </div>
  </div>
  <div class="estore_dashboard_table sesbasic_bxs">
    
  <form method="post" id="multidelete_form" onsubmit="return multiDelete();" >
    <table class='admin_table'>
        <thead>
            <tr>
            <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
            <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('product_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('verified', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
                <?php if($isEnablePackage){ ?>
            <th><?php echo $this->translate("Package"); ?></th>
            <th><?php echo $this->translate("Price"); ?></th>
            <th><?php echo $this->translate("Expiration Date"); ?></th>
            <?php } ?>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'ASC');"><?php echo $this->translate("Creation Date") ?></a></th>
            <th><?php echo $this->translate("Options") ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->products as $item): ?>
            <tr id="product_id_<?php echo $item->product_id; ?>">
                <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->getIdentity(); ?>' value="<?php echo $item->getIdentity(); ?>" /></td>
                <td><?php echo $item->getIdentity() ?></td>
                <td>
                    <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
                </td>

            <?php if($isEnablePackage){ 
                $package = $item->getPackage();
            ?>
                <td><a href="javascript:;"><?php echo $package->getTitle(); ?></a></td>
                <td>
                <?php if($package->price < 1){
                    echo "FREE";
                }else{ 
                    $currentCurrency = Engine_Api::_()->sesproduct()->getCurrentCurrency();
                    echo $package->getPackageDescription();
                } ?>
                </td>
                <td>
                <?php if($package->price < 1){
                    echo "Never Expires";
                }else{ 
                    $transaction = $item->getTransaction();
                    if(!$transaction){
                    if($item->orderspackage_id){
                        $table = Engine_Api::_()->getDbTable('transactions','sesproductpackage');
                        $tableName = $table->info('name');
                        $select = $table->select()->from($tableName)->where('orderspackage_id =?',$item->orderspackage_id)->where('gateway_profile_id !=?','')->where('state = "pending" || state = "complete" || state = "okay" || state = "active"')->limit(1);
                        $transaction =  $table->fetchRow($select);
                        if($transaction){
                        echo date('Y-m-d H:i:s');
                        }else{
                        echo "Unlimited";
                        }
                    }else{
                        echo "Unlimited";	
                    }
                    }else{
                    echo date('Y-m-d H:i:s');
                    }
                }
                ?>
                </td>
            <?php } ?>
                <td><?php echo $item->creation_date ?></td>
                <td>
                <?php echo $this->htmlLink($item->getHref(), $this->translate('view'), array('target'=> "_blank")) ?>
                |
                <?php echo $this->htmlLink(array('route' => 'sesproduct_dashboard', 'product_id' => $item->custom_url), $this->translate('edit'), array('target'=> "_blank")) ?>
                |<a href="javascript:;" onclick="deleteProduct('<?php echo $item->product_id; ?>')" id="Product<?php echo $item->product_id; ?>">Delete</a>
               
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table><br/>
        <div class='buttons'>
            <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
        </div>
       </form>
    <?php else: ?>
      <div class="tip">
        <span>
          <?php echo $this->translate("You do not have created any product in this store, so this store will not be visible on this website. Please create at least 1 product to search to the audience on this site."); ?>
        </span>
      </div>
    <?php endif; ?>
    </div>
<?php } ?>   
<?php if(!$this->is_ajax_content && !$this->is_search_ajax){ ?>
  </div>
</div>
</div>
<?php  } ?>
<script type="application/javascript">
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
sesJqueryObject(document).on('click','.sesevent_search_ticket_search',function(e){
	e.preventDefault();
	sendParamInSearch = sesJqueryObject(this).attr('data-rel');
	sesJqueryObject('#sesevent_search_ticket_search').trigger('click');
});
sesJqueryObject('#loadingimgestore-wrapper').hide();

function deleteProduct(productId)
{
var confirmDelete = confirm('Are you sure you want to delete?');
if(confirmDelete){
    sesJqueryObject("#Product"+productId).html('<img src="application/modules/Core/externals/images/loading.gif" alt="Loading" />');
    ajaxDeleteRequest = (new Request.HTML({
	  method: 'post',
	  format: 'html',
	  'url': en4.core.baseUrl + 'sesproduct/dashboard/delete',
	  'data': {
        is_Ajax_Delete : 1,
        product_id : productId,
	  },
	  onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) { 
        var obj = jQuery.parseJSON(responseHTML);
        if(obj.status == "1"){ 
           sesJqueryObject("#product_id_"+productId).remove();
        } else {
           sesJqueryObject("#Product"+productId).html("Delete"); 
        }
      
	  }
	})).send();
}
} 
</script>
<?php if($this->is_ajax_content && !$this->is_search_ajax) die; ?>
