<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-team.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescrowdfundingteam/externals/scripts/core.js'); ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescrowdfundingteam/externals/styles/styles.css'); ?>

<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescrowdfundingteam/externals/styles/styles.css'); ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sescrowdfunding', array(
	'crowdfunding' => $this->crowdfunding,
      ));	
?>
<div class="sescrowdfunding_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs sescrowdfunding_dashboard_team_content">
<?php } ?>
  <div class="sescrowdfunding_dashboard_content_header"> 
    <h3><?php echo $this->translate("Teams")?></h3>
    <p><?php echo $this->translate("You can add your crowdfunding team by click on Add New Team link."); ?></p> 
  </div>
  <section class="sescrowdfundingteam_dashboard_team_desination_section">
  	<h4><?php echo $this->translate("Designations")?></h4>
    <div class="sescrowdfunding_dashboard_content_btns">
      <a href="<?php echo $this->url(array('crowdfunding_id' => $this->crowdfunding->crowdfunding_id, 'action'=>'add-designation'),'sescrowdfundingteam_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add Designation");?></span></a>
    </div>
    <div class="sescrowdfunding_dashboard_team_desinations" id="sescrowdfunding_dashboard_team_desinations">
    	<?php include APPLICATION_PATH . '/application/modules/Sescrowdfundingteam/views/scripts/_designations.tpl'; ?>
    </div>  
  </section>
  
  
  <section class="sescrowdfundingteam_dashboard_team_section">
  	<h4><?php echo $this->translate("Team Members")?></h4>
    <div class="sescrowdfunding_dashboard_content_btns">
      <a href="<?php echo $this->url(array('crowdfunding_id' => $this->crowdfunding->crowdfunding_id, 'action'=>'add', 'type' => 'sitemember'),'sescrowdfundingteam_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add Site Team Members");?></span></a>
      <a href="<?php echo $this->url(array('crowdfunding_id' => $this->crowdfunding->crowdfunding_id, 'action'=>'add', 'type' => 'nonsitemember'), 'sescrowdfundingteam_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add Non-Site Team");?></span></a>
    </div>
    
    <div class="sescrowdfundingteam_mamage_team" id="sescrowdfundingteam_teams">
      <?php include APPLICATION_PATH . '/application/modules/Sescrowdfundingteam/views/scripts/_teams.tpl'; ?>
    </div>
  </section>  
  <?php if(!$this->is_ajax){ ?>
    </div>
  </section>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>

<script type="text/javascript">
  var crowdfundingPhotoDeleteUrl = "<?php echo $this->url(Array('module' => 'sescrowdfunding', 'controller' => 'dashboard', 'action' => 'remove'), 'default') ?>";
</script>
