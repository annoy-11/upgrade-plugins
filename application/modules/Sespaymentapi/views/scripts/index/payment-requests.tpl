<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: payment-requests.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php echo $this->partial('_navigation.tpl', 'sespaymentapi', array('navigation' => $this->navigation)); ?>
<div class="headline">
  <div class="tabs">
    <?php
      // Render the menu
      echo $this->navigation()
        ->menu()
        ->setContainer($this->subnavigation)
        ->render();
    ?>
  </div>
</div>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/dashboard.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespaymentapi/externals/styles/styles.css'); ?>
<div class="layout_middle">
  <div class="layout_generic_contanier">
    <div class="sesbasic_dashboard_content sesbm sesbasic_clearfix">
      <?php $defaultCurrency = Engine_Api::_()->sespaymentapi()->defaultCurrency(); ?>
      <div class="sesbasic_dashboard_content_header sesbasic_clearfix">
        <h3><?php echo $this->translate("Make Payment Request"); ?></h3>
        <?php if($this->thresholdAmount > 0){ ?>
          <div class="sespaymentapi_dashboard_threshold_amt"><?php echo $this->translate("Threshold Amount:"); ?> <b><?php echo Engine_Api::_()->sespaymentapi()->getCurrencyPrice($this->thresholdAmount,$defaultCurrency); ?></b></div>
        <?php } ?>
      </div>
      <?php if(!count($this->userGateway)) { ?>
        <div class="tip">
          <span>
            <?php echo $this->translate('You can not request to redeem payment because you have not entered the payment account details. %1$sClick Here%2$s to enter the details now.', '<a href="'.$this->url(array('action'=>'account-details'), 'sespaymentapi_extended', true).'">', '</a>'); ?>
          </span>
        </div>
      <?php } ?>
      
      <?php $orderDetails = $this->orderDetails; ?>
      <div class="sespaymentapi_sale_stats_container sesbasic_bxs sesbasic_clearfix">
        <div class="sespaymentapi_sale_stats">
        	<div>
            <span><?php echo $this->translate("Total Orders"); ?></span>
            <span><?php echo $orderDetails['totalOrder'];?></span>
        	</div>
        </div>
        <div class="sespaymentapi_sale_stats">
        	<div>
            <span><?php echo $this->translate("Total Amount"); ?></span>
            <span><?php echo Engine_Api::_()->sespaymentapi()->getCurrencyPrice($orderDetails['totalAmountSale'],$defaultCurrency); ?></span>
        	</div>
        </div>
        <div class="sespaymentapi_sale_stats">
          <div>
            <span><?php echo $this->translate("Total Commission Amount"); ?></span>
            <span><?php echo Engine_Api::_()->sespaymentapi()->getCurrencyPrice($orderDetails['commission_amount'],$defaultCurrency); ?></span>
        	</div>
        </div>
        <div class="sespaymentapi_sale_stats">
        	<div>
            <span><?php echo $this->translate("Total Remaining Amount"); ?></span>
            <span><?php echo Engine_Api::_()->sespaymentapi()->getCurrencyPrice($this->remainingAmount,$defaultCurrency); ?></span>
        	</div>
        </div>
      </div>

      <?php if($this->remainingAmount >= $this->thresholdAmount && count($this->userGateway) && !count($this->isAlreadyRequests)) { ?>
        <div class="sespaymentapi_request_payment_link ">	
          <a href="<?php echo $this->url(array('resource_id' => $this->viewer->getIdentity(), 'resource_type' => $this->viewer->getType(), 'module' => 'sespaymentapi', 'controller' => "index", 'action' => 'payment-request'), 'default', true); ?>" class="openSmoothbox sesbasic_button"><i class="fa fa-money"></i><span><?php echo $this->translate("Make Request For Payment"); ?></span></a>
        </div>
      <?php } ?>
      <?php if(isset($this->paymentRequests) && count($this->paymentRequests) > 0): ?>
        <div class="sesbasic_dashboard_table sesbasic_bxs">
          <form method="post" >
            <table>
              <thead>
                <tr>
                  <th class="centerT"><?php echo $this->translate("Request Id"); ?></th>
                   <th><?php echo $this->translate("Amount Requested") ?></th>
                  <th><?php echo $this->translate("Requested Date") ?></th>
                  <th><?php echo $this->translate("Release Amount") ?></th>
                  <th><?php echo $this->translate("Release Date") ?></th>
                  <th><?php echo $this->translate("Status") ?></th>
                  <th><?php echo $this->translate("Options") ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($this->paymentRequests as $item): ?>
                  <tr>
                    <td class="centerT"><?php echo $item->userpayrequest_id; ?></td>
                    <td class="centerT"><?php echo Engine_Api::_()->sespaymentapi()->getCurrencyPrice($item->requested_amount,$defaultCurrency); ?></td>
                    <td><?php echo $item->creation_date; ?></td> 
                    <td class="centerT"><?php echo $item->state != 'pending' ? Engine_Api::_()->sespaymentapi()->getCurrencyPrice($item->release_amount	,$defaultCurrency) :  "-"; ?></td>
                    <td><?php echo $item->release_date && (bool)strtotime($item->release_date) && $item->state != 'pending' ? $item->release_date :  '-'; ?></td> 
                    <td><?php echo ucfirst($item->state); ?></td>
                    <td class="table_options">
                      <?php if ($item->state == 'pending'){ ?>
                        <?php echo $this->htmlLink($this->url(array('resource_id' => $this->viewer->getIdentity(), 'resource_type' => $this->viewer->getType(), 'module' => 'sespaymentapi', 'controller' => "index", 'action' => 'payment-request'), 'default', true), $this->translate(""), array('class' => 'openSmoothbox fa fa-pencil','title'=>$this->translate("Edit Request"))); ?>
                        <?php echo $this->htmlLink($this->url(array('module' => 'sespaymentapi', 'controller' => "index", 'action' => 'delete-payment-request', 'id' => $item->userpayrequest_id), 'default', true), $this->translate(""), array('class' => 'openSmoothbox fa fa-trash','title'=>$this->translate("Delete Request"))); ?>
                      <?php } ?>
                      <?php echo $this->htmlLink($this->url(array('module' => 'sespaymentapi', 'controller' => 'index', 'action' => 'detail-payment', 'id' => $item->userpayrequest_id), 'default', true), $this->translate(""), array('class' => 'openSmoothbox fa fa-eye','title'=>$this->translate("View Details"))); ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
           </form>
        </div>
      <?php else: ?>
        <div class="tip">
          <span>
            <?php echo $this->translate("You do not have any pending payment request yet.") ?>
          </span>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>