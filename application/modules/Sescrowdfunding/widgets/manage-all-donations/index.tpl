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
	<div class="sescf_donations_head"><?php echo $this->translate("My all Donations"); ?></div>
	 <div class="sescf_donations_des"><?php echo $this->translate("This page lists all the donations you have made on various crowdfundings on this site."); ?></div>
  <div class="sescf_donations_des"></div>
  
  <?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
    <!--List View Start Here-->
    <ul class="sesbasic_clearfix sescf_donations_list">
      <?php 
        $currency = Engine_Api::_()->sescrowdfunding()->getCurrentCurrency();
        foreach($this->paginator as $result):
        $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $result->crowdfunding_id);
        $donationAmount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($result->total_useramount);
        ?>
        <li class="sesbasic_clearfix sescf_donations_list_item">
          <div class="sescf_donations_list_item_photo">
            <a href="<?php echo $crowdfunding->getHref(); ?>"><img class="sescf_grid_item_img" src="<?php echo $crowdfunding->getPhotoUrl(); ?>" alt="" /></a>
          </div> 
          <div class="sescf_donations_list_item_cont sesbasic_clearfix">
            <div class="sescf_donations_list_item_title">
              <a href="<?php echo $crowdfunding->getHref(); ?>"><?php echo $crowdfunding->title; ?></a>
            </div>
            <div class="sescf_donations_list_item_stats sesbasic_clearfix">
              <span class="sescf_list_item_owner">
                <i class="fa fa-user-circle sesbasic_text_light"></i>
                <span><?php echo $this->translate("Created by "); ?><a href="<?php echo $crowdfunding->getOwner()->getHref(); ?>"><?php echo $crowdfunding->getOwner()->getTitle(); ?></a></span>
              </span>
              <?php if($crowdfunding->category_id): ?>
                <?php $category = Engine_Api::_()->getItem('sescrowdfunding_category', $crowdfunding->category_id); ?>
                <span class="sescf_list_item_category">
                  <i class="fa fa-folder-open sesbasic_text_light"></i>
                  <span><a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a></span> 
                </span>
              <?php endif; ?>
            </div>
            <div class="sescf_donations_list_item_amount">
            	<?php echo $this->translate("You have donated %s", $donationAmount); ?>            
          	</div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
    <!--List View End Here-->
  <?php else: ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('You have not donated yet.');?>
      </span>
    </div>
  <?php endif; ?>

	<?php echo $this->paginationControl($this->paginator, null, null, array('pageAsQuery' => true, 'query' => $this->formValues)); ?>
</div>
