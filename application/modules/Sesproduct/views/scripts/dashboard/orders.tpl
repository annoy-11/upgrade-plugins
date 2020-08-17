<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: orders.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sesproduct', array(
	'product' => $this->product,
      ));	
?>
	<div class="estore_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
    	<div class="estore_dashboard_form">
      <div class="sesproduct_seo_add_product">
    		<?php echo $this->form->render(); ?>
      </div>
<div class="estore_dashboard_table sesbasic_bxs">
<h3>Total Order found <?php echo count($this->paginator); ?></h3>
  <form id='multidelete_form' method="post">
    <table>
      <thead>
        <tr>
          <th class="centerT"><?php echo $this->translate("ID"); ?></th>
          <th><?php echo $this->translate("Buyer Name") ?></th>
           <th><?php echo $this->translate("Billing & Shipping Address") ?></th>
            <th><?php echo $this->translate("Total Amount") ?></th>
            <th><?php echo $this->translate("Commission") ?></th>
            <th><?php echo $this->translate("Status") ?></th>
            <th><?php echo $this->translate("Gateway Type") ?></th>
           <th><?php echo $this->translate("Order Date") ?></th>
          <th><?php echo $this->translate("Option") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($this->paginator as $item): ?>
        <tr>
        	<?php $store = Engine_Api::_()->getItem("stores", $item->store_id); ?>
        	<?php $user = Engine_Api::_()->getItem("user", $store->owner_id); ?>
          <td class="centerT">
          	<a class="openSmoothbox" href="<?php echo $this->url(array('store_id' => $store->custom_url,'action'=>'view','order_id'=>$item->order_id), 'estore_order', true); ?>"><?php echo '#'.$item->order_id ?></a></td>
          <td><?php echo $user->displayname; ?></td>
          <td><?php //echo $item->; ?></td>
          <td><?php echo $item->total; ?></td>
          <td><?php echo $item->commission_amount; ?></td>
          <td><?php echo $item->state; ?></td> 
          <td><?php echo $item->gateway_type; ?></td> 
         <td><?php echo $item->creation_date; ?></td>
          <td class="table_options">
            <?php echo $this->htmlLink($this->url(array('store_id' => $store->custom_url,'action'=>'view','order_id'=>$item->order_id), 'estore_order', true).'?order=view', $this->translate("View Order"), array('class' => 'openSmoothbox fa fa-eye')); ?>
            <?php echo $this->htmlLink($this->url(array('action' => 'view', 'order_id' => $item->order_id, 'store_id' => $store->custom_url,'format'=>'smoothbox'), 'estore_order', true), $this->translate("Print Invoice"), array('class' => 'fa fa-print','target'=>'_blank')); ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
   </form>
</div>
    
<?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
