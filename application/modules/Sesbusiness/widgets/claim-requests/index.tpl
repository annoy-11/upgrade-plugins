<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusiness/externals/styles/styles.css'); ?>
<?php ?>
<?php $checkClaimRequest = Engine_Api::_()->getDbTable('claims', 'sesbusiness')->claimCount();?>
<div class="sesbusiness_profile_tabs sesbasic_clearfix">
<div class="sesbusiness_profile_tabs_top claim_request  sesbasic_clearfix">
	<a href="<?php echo $this->url(array('action' => 'claim'), 'sesbusiness_general', true);?>"><i class=" fa fa-plus"></i><?php echo $this->translate('Claim New Business');?></a>
</div>
<?php if($checkClaimRequest):?>
	<div class="sesbusiness_profile_tabs_top claim_new_business active sesbasic_clearfix">
		<a href="<?php echo $this->url(array('action' => 'claim-requests'), 'sesbusiness_general', true);?>"><i class="fa fa-files-o"></i><?php echo $this->translate('Your Claim Requests');?></a>
	</div>
<?php endif;?>

</div>

<div class="sesbusiness_claims_con_business sesbasic_clearfix sesbasic_bxs">
<?php foreach($this->paginator as $claim):?>
<div class="sesbusiness_claims_contant sesbasic_clearfix">
<div class="sesbusiness_claims_cont_inner">
  <p class="claims-request_img"><?php $businessItem = Engine_Api::_()->getItem('businesses', $claim->business_id);?>
  <?php echo $this->htmlLink($businessItem->getHref(), $this->itemPhoto($businessItem, 'thumb.profile', $businessItem->getTitle())) ?></p>
  <p class="claims-request_title"><?php echo $this->htmlLink($businessItem->getHref(), $businessItem->getTitle()) ?></p>
  <p class="claims_tegs claims_by"><?php echo $this->translate('Business Owner: <a href="">admin</a>');?></p>
  <p class="claims_tegs claims_date"><?php echo $this->translate('Claim Date: 14-06-2016');?></p>
  <p class="claims_tegs claims_status"><?php echo $this->translate('Claim Status: <span class="pending">Pending</span>');?></p>
  </div>
  </div>
<?php endforeach;?>
</div>
<script type="text/javascript">
	sesJqueryObject('.sesbusiness_main_claim').parent().addClass('active');
</script>