<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/styles.css'); ?>
<?php ?>
<?php $checkClaimRequest = Engine_Api::_()->getDbTable('claims', 'sespage')->claimCount();?>
<div class="sespage_profile_tabs sesbasic_clearfix">
<div class="sespage_profile_tabs_top claim_request  sesbasic_clearfix">
	<a href="<?php echo $this->url(array('action' => 'claim'), 'sespage_general', true);?>"><i class=" fa fa-plus"></i><?php echo $this->translate('Claim New Page');?></a>
</div>
<?php if($checkClaimRequest):?>
	<div class="sespage_profile_tabs_top claim_new_page active sesbasic_clearfix">
		<a href="<?php echo $this->url(array('action' => 'claim-requests'), 'sespage_general', true);?>"><i class="fa fa-files-o"></i><?php echo $this->translate('Your Claim Requests');?></a>
	</div>
<?php endif;?>

</div>

<div class="sespage_claims_con_page sesbasic_clearfix sesbasic_bxs">
<?php foreach($this->paginator as $claim):?>
<?php $pageItem = Engine_Api::_()->getItem('sespage_page', $claim->page_id);?>
<?php if(empty($pageItem)):?><?php continue;?><?php endif;?>
<div class="sespage_claims_contant sesbasic_clearfix">
<div class="sespage_claims_cont_inner">
  <p class="claims-request_img"><?php $pageItem = Engine_Api::_()->getItem('sespage_page', $claim->page_id);?>
  <?php echo $this->htmlLink($pageItem->getHref(), $this->itemPhoto($pageItem, 'thumb.profile', $pageItem->getTitle())) ?></p>
  <p class="claims-request_title"><?php echo $this->htmlLink($pageItem->getHref(), $pageItem->getTitle()) ?></p>
  <p class="claims_tegs claims_by"><?php echo $this->translate('Page Owner: ');?><a href="<?php echo $pageItem->getHref(); ?>"><?php echo $pageItem->getOwner()->getTitle(); ?></a></p>
  <!--<p class="claims_tegs claims_date"><?php //echo $this->translate('Claim Date: 14-06-2016');?></p>-->
  <p class="claims_tegs claims_status"><?php echo $this->translate('Claim Status: <span class="pending">Pending</span>');?></p>
  </div>
  </div>
<?php endforeach;?>
</div>
<script type="text/javascript">
	sesJqueryObject('.sespage_main_claim').parent().addClass('active');
</script>
