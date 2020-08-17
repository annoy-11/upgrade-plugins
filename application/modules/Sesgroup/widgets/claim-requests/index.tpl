<?php



/**

 * SocialEngineSolutions

 *

 * @category   Application_Sesgroup

 * @package    Sesgroup

 * @copyright  Copyright 2015-2016 SocialEngineSolutions

 * @license    http://www.socialenginesolutions.com/license/

 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $

 * @author     SocialEngineSolutions

 */



?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroup/externals/styles/styles.css'); ?>

<?php ?>

<?php $checkClaimRequest = Engine_Api::_()->getDbTable('claims', 'sesgroup')->claimCount();?>

<div class="sesgroup_profile_tabs sesbasic_clearfix">

<div class="sesgroup_profile_tabs_top claim_request  sesbasic_clearfix">

	<a href="<?php echo $this->url(array('action' => 'claim'), 'sesgroup_general', true);?>"><i class=" fa fa-plus"></i><?php echo $this->translate('Claim New Group');?></a>

</div>

<?php if($checkClaimRequest):?>

	<div class="sesgroup_profile_tabs_top claim_new_group active sesbasic_clearfix">

		<a href="<?php echo $this->url(array('action' => 'claim-requests'), 'sesgroup_general', true);?>"><i class="fa fa-files-o"></i><?php echo $this->translate('Your Claim Requests');?></a>

	</div>

<?php endif;?>



</div>



<div class="sesgroup_claims_con_group sesbasic_clearfix sesbasic_bxs">

<?php foreach($this->paginator as $claim):?>

  <?php $groupItem = Engine_Api::_()->getItem('sesgroup_group', $claim->group_id);?>

  <?php if(empty($groupItem)):?><?php continue;?><?php endif;?>

  <div class="sesgroup_claims_contant sesbasic_clearfix">

  <div class="sesgroup_claims_cont_inner">

    <p class="claims_request_img">

    <?php echo $this->htmlLink($groupItem->getHref(), $this->itemBackgroundPhoto($groupItem, 'thumb.profile', $groupItem->getTitle())) ?></p>

    <p class="claims-request_title"><?php echo $this->htmlLink($groupItem->getHref(), $groupItem->getTitle()) ?></p>

    <p class="claims_tegs claims_by"><?php echo $this->translate('Group Owner: ');?><a href="<?php echo $groupItem->getHref(); ?>"><?php echo $groupItem->getOwner()->getTitle(); ?></a></p>

    <!--<p class="claims_tegs claims_date"><?php //echo $this->translate('Claim Date: 14-06-2016');?></p>-->

    <p class="claims_tegs claims_status"><?php echo $this->translate('Claim Status: <span class="pending">Pending</span>');?></p>

    </div>

    </div>

  <?php endforeach;?>

</div>

<script type="text/javascript">

	sesJqueryObject('.sesgroup_main_claim').parent().addClass('active');

</script>
