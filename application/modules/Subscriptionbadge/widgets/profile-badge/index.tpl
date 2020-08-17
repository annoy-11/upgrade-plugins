<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Subscriptionbadge
 * @package    Subscriptionbadge
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="usersubscription_badge_block">
  <?php $photoUrl = $this->baseUrl() . '/' . $this->badge_photo; ?>
  <?php if($this->showbadge && $photoUrl && $this->badge_photo) { ?>
    <div class="_badgeimg"><img src="<?php echo $photoUrl; ?>" /></div>
  <?php } ?>
  <?php if(!empty($this->level->title) && $this->showlevel) { ?>
		<div class="badge_expdate"><?php echo $this->level->title; ?></div>
  <?php } ?>
  <?php if($this->viewer_id == $this->subject_id) { ?>
    <?php if( empty($this->currentSubscription->expiration_date) || $this->currentSubscription->expiration_date == '0000-00-00 00:00:00'): ?>
      <!--<div class="badge_expdate"><?php //echo $this->translate('N/A') ?></div>-->
    <?php else: ?>
      <div class="badge_expdate"><?php echo $this->translate("Expiring on "); ?><?php echo $this->locale()->toDateTime($this->currentSubscription->expiration_date) ?></div>
    <?php endif; ?>
    <?php //if($this->currentPackage) { ?>
      <?php if(count($this->packages) > 1 && $this->showupgrade) { ?>
        <div class="upgrade_button"><a href="payment/settings" class="button"><?php echo $this->translate("Upgrade Now"); ?></a></div>
      <?php //} ?>
    <?php } ?>
  <?php } ?>
</div>
