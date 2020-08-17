<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespaymentapi
 * @package    Sespaymentapi
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: payment-transaction.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
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
<div class="layout_middle">
  <div class="layout_generic_contanier">
    <div class="sesbasic_dashboard_content sesbm sesbasic_clearfix">
      <?php $defaultCurrency = Engine_Api::_()->sespaymentapi()->defaultCurrency(); ?>
      <div class="sesbasic_dashboard_content_header sesbasic_clearfix">	
        <h3><?php echo $this->translate("Payments Received"); ?></h3>
        <p><?php echo $this->translate('This page list payments received by you from this site.') ?></p>
      </div>
      <?php if( isset($this->paymentRequests) && count($this->paymentRequests) > 0): ?>
        <div class="sesbasic_dashboard_table sesbasic_bxs">
          <form method="post" >
            <table>
              <thead>
                <tr>
                  <th><?php echo $this->translate("Requested Amount") ?></th>
                  <th><?php echo $this->translate("Released Amount") ?></th>
                  <th><?php echo $this->translate("Released Date") ?></th>
                  <th><?php echo $this->translate("Response Message") ?></th>
                  <th><?php echo $this->translate("Status") ?></th>
                  <th><?php echo $this->translate("Options") ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($this->paymentRequests as $item): ?>
                  <tr>
                    <td class="centerT"><?php echo Engine_Api::_()->sespaymentapi()->getCurrencyPrice($item->requested_amount,$defaultCurrency); ?></td>
                    <td class="centerT"><?php echo Engine_Api::_()->sespaymentapi()->getCurrencyPrice($item->release_amount	,$defaultCurrency); ?></td>
                    <td><?php echo $item->release_date ? $item->release_date :  '-'; ?></td> 
                    <td class="centerT"><?php echo $this->string()->truncate(empty($item->admin_message	) ? '-' : $item->admin_message, 30) ?></td>
                    <td><?php echo ucfirst($item->state); ?></td>
                    <td class="table_options">
                      <?php echo $this->htmlLink($this->url(array('module' => 'sespaymentapi', 'controller' => 'index', 'action' => 'detail-payment', 'id' => $item->userpayrequest_id), 'default', true), $this->translate(""), array('title' => $this->translate("View Details"), 'class' => 'openSmoothbox fa fa-eye')); ?>
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
            <?php echo $this->translate("No payments have been received yet.") ?>
          </span>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>