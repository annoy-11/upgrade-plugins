<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespaymentapi
 * @package    Sespaymentapi
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sespaymentapi/views/scripts/dismiss_message.tpl';?>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
    <?php endif; ?>
    <div class="sesbasic-form-cont">
    <?php $defaultCurrency = Engine_Api::_()->sespaymentapi()->defaultCurrency(); ?>
    <h3><?php echo $this->translate("Manage Payment Requests") ?></h3>
    <p><?php echo $this->translate('This page lists all of the payment requests your users have made in each content (compatible with this plugin). You can use this page to monitor these requests and take appropriate action for each. Entering criteria into the filter fields will help you find specific payment request. Leaving the filter fields blank will show all the payment requests on your social network.<br />Below, you can approve / reject a payment request and see payment details.'); ?></p>
    <br />
		<div class='admin_search sesbasic_search_form'>
      <?php echo $this->formFilter->render($this) ?>
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
              <th><?php echo $this->translate("Content Title"); ?></th>
              <th><?php echo $this->translate("Owner Name"); ?></th>
              <th title="Requested Amount"><?php echo $this->translate("R.Amount") ?></th>
              <th title="Requested Date"><?php echo $this->translate("R.Date") ?></th>
              <!--<th><?php echo $this->translate("Requested Message") ?></th>-->
              <th><?php echo $this->translate("Released Amount") ?></th>
              <th><?php echo $this->translate("Released Date") ?></th>
              <!--<th><?php echo $this->translate("Release Message") ?></th>-->
              <th><?php echo $this->translate("Status") ?></th>
              <th><?php echo $this->translate("Options") ?></th>
            </tr>
          </thead>
          <tbody>
            <?php 
              foreach ($this->paginator as $item): ?>
              <?php  $event = Engine_Api::_()->getItem($item->resource_type, $item->resource_id); 
         				if(!$event)
                	continue;
         			?>
            <tr>
              <td><?php echo $item->userpayrequest_id; ?></td>
              <td><?php echo $this->htmlLink($event->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($event->getTitle(),16)), array('title' => $event->getTitle(), 'target' => '_blank')); ?></td>
          <?php  $owner = Engine_Api::_()->getItem('user', $event->user_id); ?>
          <td><?php echo $this->htmlLink($owner->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($owner->getTitle(),16)), array('title' => $owner->getTitle(), 'target' => '_blank')); ?></td>
              <td><?php echo Engine_Api::_()->sespaymentapi()->getCurrencyPrice($item->requested_amount,$defaultCurrency); ?></td>
              <td><?php echo $item->creation_date; ?></td> 
              <!--<td><?php echo $this->string()->truncate(empty($item->user_message) ? '-' : $item->user_message, 30) ?></td>-->
              <td><?php echo $item->state == 'pending' ? '-' : Engine_Api::_()->sespaymentapi()->getCurrencyPrice($item->release_amount	,$defaultCurrency); ?></td>
              <td><?php echo $item->release_date && (bool)strtotime($item->release_date) && $item->state != 'pending' ? $item->release_date :  '-'; ?></td> 
              <!--<td><?php echo $this->string()->truncate(empty($item->admin_message	) ? '-' : $item->admin_message, 30) ?></td>-->
              <td><?php echo ucfirst($item->state); ?></td>
              <td>
                <?php if ($item->state == 'pending') { ?>
                  <?php echo $this->htmlLink($this->url(array('module' => 'sespaymentapi', 'controller' => 'payment', 'action'=> 'approve','resource_id' => $item->resource_id, 'resource_type' => $item->resource_type, 'owner_id' => $item->owner_id, 'id' => $item->userpayrequest_id), 'admin_default', true), $this->translate("Approve"), array('class' => 'smoothbox')); ?> |
                  
                  <?php echo $this->htmlLink($this->url(array('module' => 'sespaymentapi', 'controller' => 'payment', 'action' => 'cancel','resource_id' => $item->resource_id, 'resource_type' => $item->resource_type, 'owner_id' => $item->owner_id, 'id' => $item->userpayrequest_id), 'admin_default', true), $this->translate("Reject"), array('class' => 'smoothbox')); ?> |
                <?php } ?>
                
                <?php //echo $this->htmlLink($this->url(array('action' => 'payment-requests', 'event_id' => $event->custom_url), 'sesevent_dashboard', true), $this->translate("Edit"), array('class' => '','target'=>'_blank')); ?>
                
                <?php echo $this->htmlLink($this->url(array('module' => 'sespaymentapi', 'controller' => 'index', 'action' => 'detail-payment', 'id' => $item->userpayrequest_id), 'default', true), $this->translate("View Details"), array('class' => 'openSmoothbox')); ?>
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
    </div>
  </div>
</div>