<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eclassroom/externals/styles/styles.css'); ?>
<?php ?>
<?php $checkClaimRequest = Engine_Api::_()->getDbTable('claims', 'eclassroom')->claimCount();?>
<div class="eclassroom_profile_tabs sesbasic_clearfix">
<div class="eclassroom_profile_tabs_top claim_request  sesbasic_clearfix">
	<a href="<?php echo $this->url(array('action' => 'claim'), 'eclassroom_general', true);?>"><i class=" fa fa-plus"></i><?php echo $this->translate('Claim New Classroom');?></a>
</div>
<?php if($checkClaimRequest):?>
	<div class="eclassroom_profile_tabs_top claim_new_classroom active sesbasic_clearfix">
		<a href="<?php echo $this->url(array('action' => 'claim-requests'), 'eclassroom_general', true);?>"><i class="fa fa-files-o"></i><?php echo $this->translate('Your Claim Requests');?></a>
	</div>
<?php endif;?>

</div>

<div class="eclassroom_claims_con_classroom sesbasic_clearfix sesbasic_bxs">
<?php foreach($this->paginator as $claim): ?>
<div class="eclassroom_claims_contant sesbasic_clearfix">
<div class="eclassroom_claims_cont_inner">
  <p class="claims-request_img"><?php $classroomItem = Engine_Api::_()->getItem('classroom', $claim->classroom_id);?>
  <?php echo $this->htmlLink($classroomItem->getHref(), $this->itemPhoto($classroomItem, 'thumb.profile', $classroomItem->getTitle())) ?></p>
  <p class="claims-request_title"><?php echo $this->htmlLink($classroomItem->getHref(), $classroomItem->getTitle()) ?></p>
  <p class="claims_tegs claims_by"><?php echo $this->htmlLink($classroomItem->getOwner()->getHref(), $classroomItem->getOwner()->getTitle()) ?></p>
  <?php  $locale = new Zend_Locale($localeLanguage);?>
  <?php Zend_Date::setOptions(array('format_type' => 'php'));?>
  <?php $date = new Zend_Date(strtotime($claim->creation_date), false, $locale);?>
  <p class="claims_tegs claims_date"><?php echo $this->translate('Claim Date: ');?><span class="_date sesbasic_text_light" title=""><i class="fa fa-calendar" ></i> <?php echo $date->toString('jS M');?>,&nbsp;<?php echo date('Y', strtotime($claim->creation_date)); ?></span></p>
  <?php $status = $claim->status ? 'approved' : 'pending'; ?>
  <p class="claims_tegs claims_status"><?php echo $this->translate('Claim Status: ');?><span class="<?php echo $status; ?>"><?php echo $status; ?></span></p>
  </div>
  </div>
<?php endforeach;?>
</div>
<script type="text/javascript">
	sesJqueryObject('.eclassroom_main_claim').parent().addClass('active');
</script>
