<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesrecipe/externals/styles/styles.css'); ?>
<?php ?>
<?php $checkClaimRequest = Engine_Api::_()->getDbTable('claims', 'sesrecipe')->claimCount();?>
<div class="sesrecipe_profile_tebs sesbasic_clearfix">
<div class="sesrecipe_profile_tabs_top claim_request  sesbasic_clearfix">
	<a href="<?php echo $this->url(array('action' => 'claim'), 'sesrecipe_general', true);?>" class=" fa fa-plus"><?php echo $this->translate('Claim New Recipe');?></a>
</div>
<?php if($checkClaimRequest):?>
	<div class="sesrecipe_profile_tabs_top claim_new_recipe active sesbasic_clearfix">
		<a href="<?php echo $this->url(array('action' => 'claim-requests'), 'sesrecipe_general', true);?>" class="fa fa-files-o"><?php echo $this->translate('Your Claim Requests');?></a>
	</div>
<?php endif;?>

</div>

<div class="sesrecipe_claims_con_recipe sesbasic_clearfix sesbasic_bxs">
<?php foreach($this->paginator as $claim):?>
<div class="sesrecipe_claims_contant sesbasic_clearfix">
<div class="sesrecipe_claims_cont_inner">
  <p class="claims-request_img"><?php $recipeItem = Engine_Api::_()->getItem('sesrecipe_recipe', $claim->recipe_id);?>
  <?php echo $this->htmlLink($recipeItem->getHref(), $this->itemPhoto($recipeItem, 'thumb.icon', $recipeItem->getTitle())) ?></p>
  <p class="claims-request_title"><?php echo $this->htmlLink($recipeItem->getHref(), $recipeItem->getTitle()) ?></p>
  <p class="claims_tegs claims_by"><?php echo $this->translate('Recipe Owner: <a href="">admin</a>');?></p>
  <p class="claims_tegs claims_date"><?php echo $this->translate('Claim Date: 14-06-2016');?></p>
  <p class="claims_tegs claims_status"><?php echo $this->translate('Claim Status: <span class="pending">Pending</span>');?></p>
  </div>
  </div>
<?php endforeach;?>
</div>
<script type="text/javascript">
	sesJqueryObject('.sesrecipe_main_claim').parent().addClass('active');
</script>