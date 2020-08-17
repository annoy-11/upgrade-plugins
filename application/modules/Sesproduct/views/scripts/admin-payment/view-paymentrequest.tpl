<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: view-paymentrequest.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $baseURL = $this->layout()->staticBaseUrl; ?>
<div class="sesbasic_view_stats_popup">
  <h3>Statics of this entry </h3>
  <table>
    <tr>
      <?php $store = Engine_Api::_()->getItem('stores', $this->item->store_id); ?>
      <td><?php echo $this->translate('Store Title') ?>:</td>
      <td><?php if(!is_null($store->title) && $store->title != '') { ?>
       <a href="<?php echo $store->getHref(); ?>" target="_blank"><?php echo $store->getTitle(); ?></a>
       <?php
        } else { 
        echo "-";
        } ?>
      </td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Owner Name') ?>:</td>
      <td><?php echo $this->item->getOwner() ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Requested Amount') ?>:</td>
      <td><?php echo $this->item->currency_symbol.' '.$this->item->requested_amount ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Release Amount') ?>:</td>
      <td><?php echo $this->item->currency_symbol.' '.$this->item->release_amount ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('User Message') ?>:</td>
      <td><?php echo $this->item->user_message ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Admin Message') ?>:</td>
      <td><?php echo $this->item->admin_message ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('State') ?>:</td>
      <td><?php echo $this->item->state ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Gateway Type') ?>:</td>
      <td><?php echo $this->item->gateway_type ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Currency') ?>:</td>
      <td><?php echo $this->item->currency_symbol ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Creation Date') ?>:</td>
      <td><?php echo $this->item->creation_date; ;?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Release Date') ?>:</td>
      <td><?php echo $this->item->release_date; ;?></td>
    </tr>
  </table>
  <br />
  <button onclick='javascript:parent.Smoothbox.close()'>
    <?php echo $this->translate("Close") ?>
  </button>
</div>