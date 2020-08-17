<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/dismiss_message.tpl';?>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <div class="sesbasic-form-cont">
    <?php if( count($this->subsubNavigation) ): ?>
      <div class='tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subsubNavigation)->render();?>
      </div>
    <?php endif; ?>
    <?php $defaultCurrency = Engine_Api::_()->courses()->defaultCurrency(); ?>
    <h3><?php echo $this->translate("Manage Payment Requests") ?></h3>
<p><?php echo $this->translate('This page lists all of the payment requests your users have made. You can use this page to monitor these requests and take appropriate action for each. Entering criteria into the filter fields will help you find specific payment request. Leaving the filter fields blank will show all the payment requests on your social network.<br>Below, you can approve / reject a payment request and see payment details.'); ?></p>
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
              <th><?php echo $this->translate("Classroom Title"); ?></th>
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
            <tr>
              <td><?php echo $item->userpayrequest_id; ?></td>
              <td><?php echo $this->htmlLink($item->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($item->getTitle(),16)), array('title' => $item->getTitle(), 'target' => '_blank')); ?></td>
          <?php  $owner = Engine_Api::_()->getItem('user', $item->owner_id); ?>
          <td><?php echo $this->htmlLink($owner->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($owner->getTitle(),16)), array('title' => $owner->getTitle(), 'target' => '_blank')); ?></td>
              <td><?php echo Engine_Api::_()->courses()->getCurrencyPrice($item->requested_amount,$defaultCurrency); ?></td>
              <td><?php echo Engine_Api::_()->courses()->dateFormat($item->creation_date	); ?></td>
              <td><?php echo $item->state == 'pending' ? '-' : Engine_Api::_()->sesevent()->getCurrencyPrice($item->release_amount	,$defaultCurrency); ?></td>
              <td><?php echo $item->release_date && (bool)strtotime($item->release_date) && $item->state != 'pending' ? ($item->release_date) :  '-'; ?></td>
              <td><?php echo ucfirst($item->state); ?></td>
              <td>
                <?php if ($item->state == 'pending'){ ?>
                    <?php echo $this->htmlLink($this->url(array('route' => 'default', 'module' => 'courses', 'controller' => 'payment','course_id' => $item->course_id,'action'=>'approve','id'=>$item->userpayrequest_id)), $this->translate("Approve"), array('class' => 'smoothbox')); ?> |
                    <?php echo $this->htmlLink($this->url(array('route' => 'default', 'module' => 'courses', 'controller' => 'payment','action' => 'cancel', 'id' => $item->userpayrequest_id, 'course_id' => $item->course_id)), $this->translate("Reject"), array('class' => 'smoothbox')); ?> |
                <?php } ?>
                <?php echo $this->htmlLink($this->url(array('action' => 'payment-requests', 'course_id' => $item->custom_url), 'courses_dashboard', true), $this->translate("Edit"), array('class' => '','target'=>'_blank')); ?> |
                    <?php echo $this->htmlLink($this->url(array('action' => 'detail-payment', 'id' => $item->userpayrequest_id, 'course_id' => $item->custom_url), 'courses_dashboard', true), $this->translate("Details"), array('class' => 'smoothbox')); ?>
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
