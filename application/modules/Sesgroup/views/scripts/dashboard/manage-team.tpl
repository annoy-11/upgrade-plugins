<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-team.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesgroupteam/externals/scripts/core.js'); ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroupteam/externals/styles/styles.css'); ?>

<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroupteam/externals/styles/styles.css'); ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sesgroup', array(
	'group' => $this->group,
      ));	
?>
<div class="sesgroup_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs sesgroup_dashboard_team_content">
<?php } ?>
  <div class="sesgroup_dashboard_content_header"> 
    <h3><?php echo $this->translate("Teams")?></h3>
    <p><?php echo $this->translate("You can add your group team by click on Add New Team link."); ?></p> 
  </div>
  <section class="sesgroupteam_dashboard_team_desination_section">
  	<h4><?php echo $this->translate("Designations")?></h4>
    <div class="sesgroup_dashboard_content_btns">
      <a href="<?php echo $this->url(array('group_id' => $this->group->group_id, 'action'=>'add-designation'),'sesgroupteam_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add Designation");?></span></a>
    </div>
    <div class="sesgroup_dashboard_team_desinations" id="sesgroup_dashboard_team_desinations">
    	<?php include APPLICATION_PATH . '/application/modules/Sesgroupteam/views/scripts/_designations.tpl'; ?>
    </div>  
  </section>
  
  
  <section class="sesgroupteam_dashboard_team_section">
  	<h4><?php echo $this->translate("Team Members")?></h4>
    <div class="sesgroup_dashboard_content_btns">
      <a href="<?php echo $this->url(array('group_id' => $this->group->group_id, 'action'=>'add', 'type' => 'sitemember'),'sesgroupteam_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add Site Team Members");?></span></a>
      <a href="<?php echo $this->url(array('group_id' => $this->group->group_id, 'action'=>'add', 'type' => 'nonsitemember'), 'sesgroupteam_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add Non-Site Team");?></span></a>
    </div>
    
    <div class="sesgroupteam_mamage_team" id="sesgroupteam_teams">
      <?php include APPLICATION_PATH . '/application/modules/Sesgroupteam/views/scripts/_teams.tpl'; ?>
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
  var groupPhotoDeleteUrl = "<?php echo $this->url(Array('module' => 'sesgroup', 'controller' => 'dashboard', 'action' => 'remove'), 'default') ?>";
</script>