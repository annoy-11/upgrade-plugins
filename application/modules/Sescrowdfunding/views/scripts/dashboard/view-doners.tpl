<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: view-doners.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(!$this->is_ajax) {
  echo $this->partial('dashboard/left-bar.tpl', 'sescrowdfunding', array('crowdfunding' => $this->crowdfunding));	
?>
	<div class="sescrowdfunding_dashboard_content sesbm sesbasic_clearfix">
<?php }  ?>
<div class="sescf_dashboard_announcements sesbasic_clearfix sesbasic_bxs">
  <div class="sescrowdfunding_dashboard_content_header">
    <h3><?php echo $this->translate("View Donors"); ?></h3>
  </div>
  <?php if( $this->paginator->count() > 0 ): ?>
    <?php echo $this->paginationControl($this->paginator); ?>
  <?php endif; ?>
  <?php if( $this->paginator->count() > 0 ): ?>
    <div class="sesbasic_clearfix">
      <ul class="sescf_dashboard_donors_list sesbasic_clearfix">
        <?php foreach( $this->paginator as $result ): ?>
          <?php $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $result->crowdfunding_id); 
                $user = Engine_Api::_()->getItem('user', $result->user_id);
          ?>
          <li class="sesbasic_clearfix">
            <div class="sescf_dashboard_donors_list_photo">
              <a href="<?php echo $user->getHref(); ?>"><?php echo $this->itemPhoto($user, 'thumb.profile'); ?></a>
            </div>
            <div class="sescf_dashboard_donors_list_cont">
              <div class="sescf_dashboard_donors_list_name">
                <a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a>
                <span class="floatR"><a href="<?php echo $this->url(array('action' => 'messageowner', 'user_id' => $user->user_id, 'crowdfunding_id' => $result->crowdfunding_id), 'sescrowdfunding_general', true); ?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("Say Thank You"); ?></a></span>
              </div>
              <div class="sescf_dashboard_donors_list_date">
                <?php $currency = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($result->total_useramount, $result->currency_symbol);  ?>
                <b><?php echo $currency; ?></b>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $this->translate("Ordered On %s", $result->creation_date); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $this->translate("Order Id:"); ?> <b><?php echo $result->order_id; ?></b>
              </div>
            </div>  
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php else: ?>
    <div class="tip">
      <span>
        <?php echo $this->translate("There are no donor yet.") ?>
      </span>
    </div>
  <?php endif; ?>
  <?php if( $this->paginator->count() > 0 ): ?>
    <br />
    <?php echo $this->paginationControl($this->paginator); ?>
  <?php endif; ?>
</div>
<?php if(!$this->is_ajax) { ?>
    </div>
  </div>
</div>
<?php } ?>
