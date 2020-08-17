<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: detail-payment.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescrowdfunding/externals/styles/dashboard.css'); ?>

<div class="sescf_payment_details_popup sesbasic_bxs">
<?php $defaultCurrency = Engine_Api::_()->sescrowdfunding()->defaultCurrency(); ?>
  <h3> <?php echo $this->translate("Payment Details"); ?> </h3>
  <table class="sesbm">   
  	<tr>
      <td><?php echo $this->translate('Crowdfunding Name') ?>:</td>
      <td><a href="<?php echo $this->crowdfunding->getHref(); ?>" target="_blank"><?php echo $this->crowdfunding->title; ?></a>
     </td>
    </tr>
    <tr>
    	<?php $user = Engine_Api::_()->getItem('user', $this->item->owner_id); ?>
      <td><?php echo $this->translate('Owner') ?>:</td>
      <td><?php echo $this->htmlLink($user->getHref(), $user->getTitle(), array('target'=>'_blank')); ?></td>
    </tr>
     <tr>
      <td><?php echo $this->translate('Request Id') ?>:</td>
      <td><?php echo $this->item->userpayrequest_id ; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Requested Amount') ?>:</td>
      <td><?php echo Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($this->item->requested_amount,$defaultCurrency); ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Requested Date') ?>:</td>
      <td> <?php echo Engine_Api::_()->sesbasic()->dateFormat($this->item->creation_date	); ?></td>
    </tr>
   <tr>
      <td><?php echo $this->translate('Requested Message') ?>:</td>
      <td> <?php echo $this->item->user_message ? $this->viewMore($this->item->user_message) : '-'; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Released Amount') ?>:</td>
      <td><?php echo Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($this->item->release_amount,$defaultCurrency); ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Released Date') ?>:</td>
      <td> <?php echo $this->item->release_date && (bool)strtotime($this->item->release_date) ? Engine_Api::_()->sesbasic()->dateFormat($this->item->release_date) : '-'; ?></td>
    </tr>
   <tr>
      <td><?php echo $this->translate('Response Message') ?>:</td>
      <td> <?php echo $this->item->admin_message ? $this->viewMore($this->item->admin_message) : '-'; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Status') ?>:</td>
      <td><?php echo ucfirst($this->item->state); ?></td>
     </td>
    </tr>
  </table>
  <button onclick='javascript:parent.Smoothbox.close()'>
    <i class="fa fa-times"></i>
  </button>
</div>
<?php if( @$this->closeSmoothbox ): ?>
<script type="text/javascript">
  TB_close();
</script>
<?php endif; ?>
