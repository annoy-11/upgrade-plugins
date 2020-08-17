<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Egroupjoinfees/externals/styles/styles.css'); ?>

<?php if(!$this->is_ajax){ ?>
<h3><?php echo $this->translate("My Orders"); ?></h3>
<div class="layout_core_container_tabs">
  <div class="tabs_alt tabs_parent">
    <ul class="egroupjoinfees_manage_order_tabs">
      <li class="active">
      	<a href="javascript:;" data-id="current" class="switch_type"><?php echo $this->translate("Active Group Orders"); ?>
        <span><?php echo $this->currentOrderCount; ?></span></a>
      </li>
      <li><a href="javascript:;"  data-id="past" class="switch_type"><?php echo $this->translate("Ended Group Orders"); ?>
      	<span><?php echo $this->pastOrderCount; ?></span></a>
      </li>
    </ul>
	</div>
	<div class="egroupjoinfees_orders_content sesbasic_clearfix">
<?php } ?>
<?php if($this->paginator->getTotalItemCount() > 0){ ?>
<?php foreach($this->paginator as $order){ ?>
<?php $event = Engine_Api::_()->getItem('sesgroup_group', $order->group_id); ?>
	<div class="egroupjoinfees_manage_order_list sesbm sesbasic_bxs sesbasic_clearfix">
    <div class="egroupjoinfees_manage_order_list_photo">
    	<?php echo $this->htmlLink($event->getHref(), $this->itemPhoto($event, 'thumb.profile', '', array('align' => 'center'))) ?>
    </div>
    <div class="egroupjoinfees_manage_order_list_info">
    	<div class="egroupjoinfees_manage_order_list_info_title">
     		<?php echo $this->htmlLink($event->getHref(),$event->getTitle()); ?>
     	</div>   
      
      <div class="egroupjoinfees_manage_order_list_options">
        <div>
          <a href="<?php echo $this->url(array('action' => 'view', 'order_id' => $order->order_id, 'group_id' => $event->custom_url), 'egroupjoinfees_order', true) ?>">
            <i class="fa fa-eye sesbasic_text_light"></i><?php echo $this->translate("View Order"); ?>
          </a>
        </div>
        
        <div>
          <a href="<?php echo $this->url(array('action' => 'view', 'order_id' => $order->order_id, 'group_id' => $event->custom_url,'format'=>'smoothbox'), 'egroupjoinfees_order', true) ?>" target="_blank">
            <i class="fa fa-print sesbasic_text_light"></i><?php echo $this->translate("Print Invoice"); ?>
          </a>
        </div>
        
      </div>
    </div>
  </div>
<?php } ?>
<?php }else{ ?>
	<div class="tip"><span><?php echo $this->translate("There are no orders to display."); ?></span></div>
<?php } ?>
<?php if(!$this->is_ajax){ ?>
</div>
</div>

<script type="application/javascript">
sesJqueryObject(document).on('click','.switch_type',function(){
	var type = sesJqueryObject(this).attr('data-id');
	if(sesJqueryObject(this).parent().hasClass('active') || !type)
		return;
	sesJqueryObject('.egroupjoinfees_manage_order_tabs li').removeClass('active');
	sesJqueryObject(this).parent().addClass('active');
	sesJqueryObject('.egroupjoinfees_orders_content').html('<div class="sesbasic_loading_container"></div>');
	 new Request.HTML({
      method: 'post',
      url : en4.core.baseUrl + "widget/index/mod/egroupjoinfees/name/browse-order",
      data : {
        format : 'html',
				is_ajax:true,
				view_type:type,
      },
      onComplete: function(response) {
				sesJqueryObject('.egroupjoinfees_orders_content').html(response);
			}
    }).send();
});
</script>
<?php } ?>
