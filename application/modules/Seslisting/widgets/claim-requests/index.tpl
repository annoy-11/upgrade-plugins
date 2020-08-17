<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslisting/externals/styles/styles.css'); ?>
<?php ?>
<?php $checkClaimRequest = Engine_Api::_()->getDbTable('claims', 'seslisting')->claimCount();?>
<div class="seslisting_profile_tebs sesbasic_clearfix">
<div class="seslisting_profile_tabs_top claim_request  sesbasic_clearfix">
	<a href="<?php echo $this->url(array('action' => 'claim'), 'seslisting_general', true);?>" class=" fa fa-plus"><?php echo $this->translate('Claim New Listing');?></a>
</div>
<?php if($checkClaimRequest):?>
	<div class="seslisting_profile_tabs_top claim_new_listing active sesbasic_clearfix">
		<a href="<?php echo $this->url(array('action' => 'claim-requests'), 'seslisting_general', true);?>" class="fa fa-files-o"><?php echo $this->translate('Your Claim Requests');?></a>
	</div>
<?php endif;?>

</div>

<div class="seslisting_claims_con_listing sesbasic_clearfix sesbasic_bxs">
<?php foreach($this->paginator as $claim):?>
<div class="seslisting_claims_contant sesbasic_clearfix">
<div class="seslisting_claims_cont_inner">
  <p class="claims-request_img"><?php $listingItem = Engine_Api::_()->getItem('seslisting', $claim->listing_id);?>
  <?php echo $this->htmlLink($listingItem->getHref(), $this->itemPhoto($listingItem, 'thumb.icon', $listingItem->getTitle())) ?></p>
  <p class="claims-request_title"><?php echo $this->htmlLink($listingItem->getHref(), $listingItem->getTitle()) ?></p>
  <p class="claims_tegs claims_by"><?php echo $this->translate('Listing Owner: <a href="">admin</a>');?></p>
  <p class="claims_tegs claims_date"><?php echo $this->translate('Claim Date: 14-06-2016');?></p>
  <p class="claims_tegs claims_status"><?php echo $this->translate('Claim Status: <span class="pending">Pending</span>');?></p>
  </div>
  </div>
<?php endforeach;?>
</div>
<script type="text/javascript">
	sesJqueryObject('.seslisting_main_claim').parent().addClass('active');
</script>
