<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-team.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbusinessteam/externals/scripts/core.js'); ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusinessteam/externals/styles/styles.css'); ?>

<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusinessteam/externals/styles/styles.css'); ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sesbusiness', array(
	'business' => $this->business,
      ));	
?>
<div class="sesbusiness_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs sesbusiness_dashboard_team_content">
<?php } ?>
  <div class="sesbusiness_dashboard_content_header"> 
    <h3><?php echo $this->translate("Teams")?></h3>
    <p><?php echo $this->translate("You can add your business team by click on Add New Team link."); ?></p> 
  </div>
  <section class="sesbusinessteam_dashboard_team_desination_section">
  	<h4><?php echo $this->translate("Designations")?></h4>
    <div class="sesbusiness_dashboard_content_btns">
      <a href="<?php echo $this->url(array('business_id' => $this->business->business_id, 'action'=>'add-designation'),'sesbusinessteam_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add Designation");?></span></a>
    </div>
    <div class="sesbusiness_dashboard_team_desinations" id="sesbusiness_dashboard_team_desinations">
    	<?php include APPLICATION_PATH . '/application/modules/Sesbusinessteam/views/scripts/_designations.tpl'; ?>
    </div>  
  </section>
  
  
  <section class="sesbusinessteam_dashboard_team_section">
  	<h4><?php echo $this->translate("Team Members")?></h4>
    <div class="sesbusiness_dashboard_content_btns">
      <a href="<?php echo $this->url(array('business_id' => $this->business->business_id, 'action'=>'add', 'type' => 'sitemember'),'sesbusinessteam_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add Site Team Members");?></span></a>
      <a href="<?php echo $this->url(array('business_id' => $this->business->business_id, 'action'=>'add', 'type' => 'nonsitemember'), 'sesbusinessteam_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add Non-Site Team");?></span></a>
    </div>
    
    <div class="sesbusinessteam_mamage_team" id="sesbusinessteam_teams">
      <?php include APPLICATION_PATH . '/application/modules/Sesbusinessteam/views/scripts/_teams.tpl'; ?>
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
  var businessPhotoDeleteUrl = "<?php echo $this->url(Array('module' => 'sesbusiness', 'controller' => 'dashboard', 'action' => 'remove'), 'default') ?>";
</script>
