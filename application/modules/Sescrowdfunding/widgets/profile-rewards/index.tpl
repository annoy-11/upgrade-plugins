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
<?php $currency = Engine_Api::_()->sescrowdfunding()->getCurrentCurrency(); ?>
<div class="sescrowdfunding_profile_rewards sesbasic_bxs">
  <ul>
  <?php foreach($this->paginator as $reward):?>
    <?php $totalAmount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($reward->doner_amount, $currency); ?>
    <li class="_item">
      <div class="_img">
      <?php $photo = Engine_Api::_()->storage()->get($reward->photo_id, '');
      if($photo) {
      $photo = $photo->getPhotoUrl();
      } else { 
        $photo = 'give default photo path';
      } ?>
      <img alt="" src="<?php echo $photo; ?>" />
      </div>
      <div class="_title"><h3><?php echo $reward->title;?></h3></div>
      <div class="_date"><i class="sesbasic_text_light fa fa-calendar"></i>&nbsp;<span><?php echo $this->timestamp(strtotime($reward->creation_date)) ?></div>
      <div class="_amount"><?php echo $this->translate("Minimum Donation Amount:"); ?>  <b><?php echo $totalAmount;?></b></div>
      <div class="sesbasic_html_block _body">
        <p><?php echo $reward->body;?></p>
      </div>
    </li>
  <?php endforeach;?>
  </ul>
</div>
