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
<?php if( count($this->subsubNavigation) ): ?>
  <div class='tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->subsubNavigation)->render();?>
  </div>
<?php endif; ?>
<?php $defaultCurrency = Engine_Api::_()->sescrowdfunding()->defaultCurrency(); ?>

<h3><?php echo $this->translate("Manage Payment Requests") ?></h3>
<p><?php echo $this->translate('This page lists all of the payment requests your users have made. You can use this page to monitor these requests and take appropriate action for each. Entering criteria into the filter fields will help you find specific payment request. Leaving the filter fields blank will show all the payment requests on your social network.<br>Below, you can approve / reject a payment request and see payment details.'); ?></p>
<br />
<div class='admin_search sesbasic_search_form'>
  <?php //echo $this->formFilter->render($this) ?>
</div>
<br />
<?php $counter = $this->paginator->getTotalItemCount(); ?> 
<?php if( count($this->paginator) ): ?>
  <div class="sesbasic_search_reasult">
    <?php echo $this->translate(array('%s payment request found.', '%s payment requests found.', $counter), $this->locale()->toNumber($counter)) ?>
  </div>
  <form method="post" >
    <div class="clear" style="overflow: auto;"> 
    <table class='admin_table'>
      <thead>
        <tr>
          <th><?php echo $this->translate("Id"); ?></th>
          <th><?php echo $this->translate("Crowdfunding Title"); ?></th>
          <th><?php echo $this->translate("Owner Name"); ?></th>
          <th title="Requested Amount"><?php echo $this->translate("R.Amount") ?></th>
          <th title="Requested Date"><?php echo $this->translate("R.Date") ?></th>
          <th><?php echo $this->translate("Released Amount") ?></th>
          <th><?php echo $this->translate("Released Date") ?></th>
          <th><?php echo $this->translate("Status") ?></th>
          <th><?php echo $this->translate("Options") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php 
          foreach ($this->paginator as $item): ?>
          <?php  $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $item->crowdfunding_id); 
            if(!$crowdfunding)
              continue;
          ?>
        <tr>
          <td><?php echo $item->userpayrequest_id; ?></td>
          <td><?php echo $this->htmlLink($crowdfunding->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($crowdfunding->getTitle(),16)), array('title' => $crowdfunding->getTitle(), 'target' => '_blank')); ?></td>
          <?php  $owner = Engine_Api::_()->getItem('user', $crowdfunding->owner_id); ?>
          <td><?php echo $this->htmlLink($owner->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($owner->getTitle(),16)), array('title' => $owner->getTitle(), 'target' => '_blank')); ?></td>
          <td><?php echo Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($item->requested_amount,$defaultCurrency); ?></td>
          <td><?php echo Engine_Api::_()->sesbasic()->dateFormat($item->creation_date	); ?></td> 
          <td><?php echo $item->state == 'pending' ? '-' : Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($item->release_amount	,$defaultCurrency); ?></td>
          <td><?php echo $item->release_date && (bool)strtotime($item->release_date) && $item->state != 'pending' ? Engine_Api::_()->sesbasic()->dateFormat($item->release_date) :  '-'; ?></td> 
          <td><?php echo ucfirst($item->state); ?></td>
          <td>
            <?php if ($item->state == 'pending') { ?>
              <?php echo $this->htmlLink($this->url(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'payment','crowdfunding_id' => $crowdfunding->crowdfunding_id,'action'=>'approve','id'=>$item->userpayrequest_id)), $this->translate("Approve"), array('class' => 'smoothbox')); ?> |
              <?php echo $this->htmlLink($this->url(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'payment','action' => 'cancel', 'id' => $item->userpayrequest_id, 'crowdfunding_id' => $crowdfunding->crowdfunding_id)), $this->translate("Reject"), array('class' => 'smoothbox')); ?> |
            <?php } ?>
            <?php echo $this->htmlLink($this->url(array('action' => 'payment-requests', 'crowdfunding_id' => $crowdfunding->custom_url), 'sescrowdfunding_dashboard', true), $this->translate("Edit"), array('class' => '','target'=>'_blank')); ?> |
            <?php echo $this->htmlLink($this->url(array('action' => 'detail-payment', 'id' => $item->userpayrequest_id, 'crowdfunding_id' => $crowdfunding->custom_url), 'sescrowdfunding_dashboard', true), $this->translate("Details"), array('class' => 'smoothbox')); ?>
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
      <?php echo $this->translate("There are no payment requests.") ?>
    </span>
  </div>
<?php endif; ?>
