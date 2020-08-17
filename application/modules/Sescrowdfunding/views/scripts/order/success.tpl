<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: success.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<form method="get" action="<?php echo $this->escape($this->url(array('crowdfunding_id' => $this->resource->getIdentity(), 'user_id' => $this->resource->owner_id, 'slug' => $this->resource->getSlug()), 'sescrowdfunding_entry_view', true)) ?>" class="global_form" enctype="application/x-www-form-urlencoded">
  <div>
    <div>
      <h3>
        <?php echo $this->translate('Payment Completed') ?>
      </h3>
      <p class="form-description">
        <?php echo $this->translate('Thank you! Your payment has completed successfully.') ?>
      </p>
      <div class="form-elements">
        <div id="buttons-wrapper" class="form-wrapper">
          <button type="submit">
            <?php echo $this->translate('Continue') ?>
          </button>
        </div>
      </div>
    </div>
  </div>
</form>