<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: raw-transaction-detail.tpl  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<h2 class="payment_transaction_detail_headline">
  <?php echo $this->translate("Raw Transaction Details") ?>
</h2>

<?php if( !is_array($this->data) ): ?>

  <div class="error">
    <span>
    <?php $this->translate('Order could not be found.') ?>
    </span>
  </div>

<?php else: ?>

  <dl class="payment_transaction_details">
    <?php foreach( $this->data as $key => $value ): ?>
      <dd>
        <?php echo $key ?>
      </dd>
      <dt>
        <?php echo $value ?>
      </dt>
    <?php endforeach; ?>
  </dl>

<?php endif; ?>