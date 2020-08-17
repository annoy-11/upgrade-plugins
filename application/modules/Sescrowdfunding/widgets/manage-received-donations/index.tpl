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

<div class="sescf_donations_page sesbasic_clearfix sesbasic_bxs">
	<div class="sescf_donations_head"><?php echo $this->translate("Manage Received Donations"); ?></div>
  <div class="sescf_donations_des"><?php echo $this->translate("This page lists all the donations received by you on your crowdfunding campaigns."); ?></div>
  <?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
    <!--List View Start Here-->
    <ul class="sesbasic_clearfix sescf_donations_list">
      <?php 
        $currency = Engine_Api::_()->sescrowdfunding()->getCurrentCurrency();
        foreach($this->paginator as $result):
        $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $result->crowdfunding_id);
        $user = Engine_Api::_()->getItem('user', $result->user_id);

        $donationAmount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($result->total_useramount,$currency);
        ?>
        <li class="sesbasic_clearfix sescf_donations_list_item">
          <div class="sescf_donations_list_item_photo">
            <a href="<?php echo $crowdfunding->getHref(); ?>"><img class="sescf_grid_item_img" src="<?php echo $crowdfunding->getPhotoUrl(); ?>" alt="" /></a>
          </div> 
          <div class="sescf_donations_list_item_cont sesbasic_clearfix">
            <div class="sescf_donations_list_item_title">
              <a href="<?php echo $crowdfunding->getHref(); ?>"><?php echo $crowdfunding->getTitle(); ?></a>
            </div>
            <div class="sescf_donations_list_item_stats sesbasic_clearfix">
              <span class="sescf_list_item_owner">
              	<i class="fa fa-user-circle sesbasic_text_light"></i>
                <span><?php echo $this->translate("Donated by "); ?><a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a></span>
              </span>
              <span>
              	<i class="fa fa-clock-o"></i>
                <span><?php echo $this->translate("on %s", $this->timestamp(strtotime($result->creation_date))); ?></span>
              </span>
            </div>
            <div class="sescf_donations_list_item_amount">
              <?php echo $this->translate("Donation Amount %s", $donationAmount); ?>            
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
    <!--List View End Here-->
  <?php else: ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('You have not received any donation yet.');?>
      </span>
    </div>
  <?php endif; ?>
</div>
<?php echo $this->paginationControl($this->paginator, null, null, array('pageAsQuery' => true, 'query' => $this->formValues)); ?>
</div>
