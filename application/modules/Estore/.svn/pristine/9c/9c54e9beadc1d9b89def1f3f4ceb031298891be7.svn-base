<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/styles.css'); ?>
<?php ?>
<?php $checkClaimRequest = Engine_Api::_()->getDbTable('claims', 'estore')->claimCount();?>
<div class="estore_profile_tabs sesbasic_clearfix">
<div class="estore_profile_tabs_top claim_request  sesbasic_clearfix">
	<a href="<?php echo $this->url(array('action' => 'claim'), 'estore_general', true);?>"><i class=" fa fa-plus"></i><?php echo $this->translate('Claim New Store');?></a>
</div>
<?php if($checkClaimRequest):?>
	<div class="estore_profile_tabs_top claim_new_store active sesbasic_clearfix">
		<a href="<?php echo $this->url(array('action' => 'claim-requests'), 'estore_general', true);?>"><i class="fa fa-files-o"></i><?php echo $this->translate('Your Claim Requests');?></a>
	</div>
<?php endif;?>

</div>

<div class="estore_claims_con_store sesbasic_clearfix sesbasic_bxs">
<?php foreach($this->paginator as $claim):?>
<div class="estore_claims_contant sesbasic_clearfix">
<div class="estore_claims_cont_inner">
  <p class="claims-request_img"><?php $storeItem = Engine_Api::_()->getItem('stores', $claim->store_id);?>
  <?php echo $this->htmlLink($storeItem->getHref(), $this->itemPhoto($storeItem, 'thumb.profile', $storeItem->getTitle())) ?></p>
  <p class="claims-request_title"><?php echo $this->htmlLink($storeItem->getHref(), $storeItem->getTitle()) ?></p>
  <p class="claims_tegs claims_by"><?php echo $this->translate('Store Owner: <a href="">admin</a>');?></p>
  <p class="claims_tegs claims_date"><?php echo $this->translate('Claim Date: 14-06-2016');?></p>
  <p class="claims_tegs claims_status"><?php echo $this->translate('Claim Status: <span class="pending">Pending</span>');?></p>
  </div>
  </div>
<?php endforeach;?>
</div>
<script type="text/javascript">
	sesJqueryObject('.estore_main_claim').parent().addClass('active');
</script>