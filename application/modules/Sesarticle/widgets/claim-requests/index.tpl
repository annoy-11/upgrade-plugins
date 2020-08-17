<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesarticle/externals/styles/styles.css'); ?>
<?php ?>
<?php $checkClaimRequest = Engine_Api::_()->getDbTable('claims', 'sesarticle')->claimCount();?>
<div class="sesarticle_profile_tebs sesbasic_clearfix">
<div class="sesarticle_profile_tabs_top claim_request  sesbasic_clearfix">
	<a href="<?php echo $this->url(array('action' => 'claim'), 'sesarticle_general', true);?>" class=" fa fa-plus"><?php echo $this->translate('Claim New Article');?></a>
</div>
<?php if($checkClaimRequest):?>
	<div class="sesarticle_profile_tabs_top claim_new_article active sesbasic_clearfix">
		<a href="<?php echo $this->url(array('action' => 'claim-requests'), 'sesarticle_general', true);?>" class="fa fa-files-o"><?php echo $this->translate('Your Claim Requests');?></a>
	</div>
<?php endif;?>

</div>

<div class="sesarticle_claims_con_article sesbasic_clearfix sesbasic_bxs">
<?php foreach($this->paginator as $claim):?>
<div class="sesarticle_claims_contant sesbasic_clearfix">
<div class="sesarticle_claims_cont_inner">
  <p class="claims-request_img"><?php $articleItem = Engine_Api::_()->getItem('sesarticle', $claim->article_id);?>
  <?php echo $this->htmlLink($articleItem->getHref(), $this->itemPhoto($articleItem, 'thumb.icon', $articleItem->getTitle())) ?></p>
  <p class="claims-request_title"><?php echo $this->htmlLink($articleItem->getHref(), $articleItem->getTitle()) ?></p>
  <p class="claims_tegs claims_by"><?php echo $this->translate('Article Owner: <a href="">admin</a>');?></p>
  <p class="claims_tegs claims_date"><?php echo $this->translate('Claim Date: 14-06-2016');?></p>
  <p class="claims_tegs claims_status"><?php echo $this->translate('Claim Status: <span class="pending">Pending</span>');?></p>
  </div>
  </div>
<?php endforeach;?>
</div>
<script type="text/javascript">
	sesJqueryObject('.sesarticle_main_claim').parent().addClass('active');
</script>
