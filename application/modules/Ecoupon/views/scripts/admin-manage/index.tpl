<?php
 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
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
<style>
#date-date_to{display:block !important;}
#date-date_from{display:block !important;}
</style>
<?php include APPLICATION_PATH .  '/application/modules/Ecoupon/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate("Manage Ecoupon") ?></h3>
<p><?php echo $this->translate('This page lists all of the Ecoupon your users have posted. You can use this page to monitor these Ecoupon and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific Ecoupon. Leaving the filter fields blank will show all the Ecoupon on your social network. <br /> <br />Below, you can also choose any number of Ecoupon as Course of the Day, Featured, Sponsored, Verified. You can also Approve and Disapprove Ecoupon.'); ?></p>
<br />
<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />
<?php if(count($this->paginator) ): ?>
  <?php $counter = $this->paginator->getTotalItemCount(); ?> 
  <div class="sesbasic_search_reasult">
    <?php echo $this->translate(array('%s Coupon found.', '%s Coupons found.', $counter), $this->locale()->toNumber($counter)) ?>
  </div>
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
    <div class="admin_table_form">
      <table class='admin_table'>
        <thead>
          <tr>
            <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
            <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('coupon_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('user_id', 'ASC');"><?php echo $this->translate("Owner") ?></a></th>
            <th><?php echo $this->translate("Coupon Code"); ?></th>
            <th><?php echo $this->translate("Entry Type"); ?></th>
            <th><?php echo $this->translate("Discount Type"); ?></th>
            <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('is_approved', 'ASC');" title="Approved"><?php echo $this->translate("A") ?></a></th>
            <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('featured', 'ASC');" title="Featured"><?php echo $this->translate("F") ?></a></th>
             <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('hot', 'ASC');" title="Hot"><?php echo $this->translate("H") ?></a></th>
            <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('offtheday', 'ASC');" title="Of the Day"><?php echo $this->translate("OTD") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'ASC');"><?php echo $this->translate("Creation Date") ?></a></th>
            <th><?php echo $this->translate("Options") ?></th>
          </tr>
        </thead>
        <tbody>
        <?php $api = Engine_Api::_()->ecoupon(); ?>
          <?php foreach ($this->paginator as $item):?>
          <tr>
            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->coupon_id; ?>' value="<?php echo $item->coupon_id; ?>" /></td>
            <td><?php echo $item->coupon_id; ?></td>
            <td><?php echo $this->htmlLink($item->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($item->getTitle(),16)), array('title' => $item->getTitle(), 'target' => '_blank')) ?></td>
            <td><?php echo $this->htmlLink($item->getOwner()->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($item->getOwner()->getTitle(),16)), array('title' => $this->translate($item->getOwner()->getTitle()), 'target' => '_blank')) ?></td>
            <td><?php echo $item->coupon_code; ?></td>
            <td><?php echo $api->getItemTitle($item->item_type); ?></td>
            <td>
              <?php if($item->discount_type == 0){ ?>
                <?php echo $this->translate("%s%s OFF",str_replace('.00','',$item->percentage_discount_value),"%"); ?>
              <?php } else { ?>
                      <?php echo $this->translate("%s OFF",$api->getCurrencyPrice($item->fixed_discount_value)); ?>
              <?php } ?>
            </td>
            <td class="admin_table_centered">
              <?php if($item->is_approved == 1):?> 
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'ecoupon', 'controller' => 'manage', 'action' => 'approved', 'coupon_id' => $item->coupon_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Approve')))) ?>
              <?php else: ?>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'ecoupon', 'controller' => 'manage', 'action' => 'approved', 'coupon_id' => $item->coupon_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Approve')))) ?>
              <?php endif; ?>
            </td>
             </td>
            <td class="admin_table_centered">
              <?php if($item->is_approved == 1){?>
                <?php if($item->featured == 1):?>
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'ecoupon', 'controller' => 'manage', 'action' => 'featured', 'coupon_id' => $item->coupon_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Featured')))) ?>
                <?php else: ?>
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'ecoupon', 'controller' => 'manage', 'action' => 'featured', 'coupon_id' => $item->coupon_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Featured')))) ?>
                <?php endif; ?>
              <?php }else{ ?>
                  -
              <?php } ?> 
            </td>
            <td class="admin_table_centered">
              <?php if($item->is_approved == 1){?>
                <?php if($item->hot == 1):?>
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'ecoupon', 'controller' => 'manage', 'action' => 'hot', 'coupon_id' => $item->coupon_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Hot')))) ?>
                <?php else: ?>
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'ecoupon', 'controller' => 'manage', 'action' => 'hot', 'coupon_id' => $item->coupon_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Hot')))) ?>
                <?php endif; ?> 
              <?php }else{ ?>
                  -
              <?php } ?>
            </td>
            <td class="admin_table_centered">
              <?php if($item->is_approved == 1){ ?>
                <?php if(strtotime($item->enddate) < strtotime(date('Y-m-d')) && $item->offtheday == 1):?>
                  <?php Engine_Api::_()->getDbTable('coupons', 'ecoupon')->update(array('offtheday' => 0,'startdate' =>'',
                            'enddate' =>''), array("coupon_id = ?" => $item->coupon_id));?>
                  <?php $itemofftheday = 0;?>
                <?php else:?>
                  <?php $itemofftheday = $item->offtheday; ?>
                <?php endif;?>
                <?php if($itemofftheday == 1):?>  
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'ecoupon', 'controller' => 'manage', 'action' => 'oftheday', 'coupon_id' => $item->coupon_id, 'param' => 0), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Edit Course of the Day'))), array('class' => 'smoothbox')); ?>
                <?php else: ?>
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'ecoupon', 'controller' => 'manage', 'action' => 'oftheday', 'coupon_id' => $item->coupon_id, 'param' => 1), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Make Course of the Day'))), array('class' => 'smoothbox')) ?>
                <?php endif; ?>
              <?php }else{ ?>
                  -
              <?php } ?>
            </td>
            <td><?php echo $item->creation_date ?></td>
            <td>
             <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'ecoupon', 'controller' => 'manage', 'action' => 'view', 'coupon_id' => $item->coupon_id), $this->translate("View Details"), array('class' => 'smoothbox')) ?>|
              <?php echo $this->htmlLink($item->getHref(), $this->translate("View"), array('target' => '_blank')); ?> |
              <?php echo $this->htmlLink(array('route' => 'admin_default','module' => 'ecoupon', 'controller' => 'manage','coupon_id'=> $item->coupon_id,'action'=>'delete'), $this->translate('Delete'), array('class' => 'smoothbox')); ?> |
              <?php if($item->is_package) { ?>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'ecoupon', 'controller' => 'coupon', 'action' => 'edit', 'coupon_id' => $item->coupon_id), $this->translate('Edit'), array('target'=> "_blank")); ?> 
              <?php } else { ?> 
                <?php echo $this->htmlLink(array('route' => 'ecoupon_general','action' => 'edit', 'coupon_id' => $item->coupon_id,'subject' => $item->getItemType()), $this->translate('Edit'), array('target'=> "_blank")); ?> 
              <?php } ?>|
              <?php echo $this->htmlLink(array('route' => 'ecoupon_general','subject' => $item->getItemType(),'coupon_id'=> $item->coupon_id,'action'=>'print'), $this->translate('Print'), array('target'=> "_blank")); ?> 
            </td>
          </tr>
          <?php endforeach; unset($api); ?>
        </tbody>
      </table>
      </div>
    <br />
    <div class='buttons'>
      <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
    </div>
  </form>
  <br/>
  <div>
    <?php echo $this->paginationControl($this->paginator,null,null,$this->urlParams); ?>
  </div>
<?php else:?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no coupon created by your members yet.") ?>
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
