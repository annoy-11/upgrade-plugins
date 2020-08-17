<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-team.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Estoreteam/externals/scripts/core.js'); ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estoreteam/externals/styles/styles.css'); ?>

<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estoreteam/externals/styles/styles.css'); ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'estore', array(
	'store' => $this->store,
      ));	
?>
<div class="estore_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs estore_dashboard_team_content">
<?php } ?>
  <div class="estore_dashboard_content_header"> 
    <h3><?php echo $this->translate("Teams")?></h3>
    <p><?php echo $this->translate("You can add your store team by click on Add New Team link."); ?></p> 
  </div>
  <section class="estoreteam_dashboard_team_desination_section">
  	<h4><?php echo $this->translate("Designations")?></h4>
    <div class="estore_dashboard_content_btns">
      <a href="<?php echo $this->url(array('store_id' => $this->store->store_id, 'action'=>'add-designation'),'estoreteam_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add Designation");?></span></a>
    </div>
    <div class="estore_dashboard_team_desinations" id="estore_dashboard_team_desinations">
    	<?php include APPLICATION_PATH . '/application/modules/Estoreteam/views/scripts/_designations.tpl'; ?>
    </div>  
  </section>
  
  
  <section class="estoreteam_dashboard_team_section">
  	<h4><?php echo $this->translate("Team Members")?></h4>
    <div class="estore_dashboard_content_btns">
      <a href="<?php echo $this->url(array('store_id' => $this->store->store_id, 'action'=>'add', 'type' => 'sitemember'),'estoreteam_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add Site Team Members");?></span></a>
      <a href="<?php echo $this->url(array('store_id' => $this->store->store_id, 'action'=>'add', 'type' => 'nonsitemember'), 'estoreteam_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add Non-Site Team");?></span></a>
    </div>
    
    <div class="estoreteam_mamage_team" id="estoreteam_teams">
      <?php include APPLICATION_PATH . '/application/modules/Estoreteam/views/scripts/_teams.tpl'; ?>
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
  var storePhotoDeleteUrl = "<?php echo $this->url(Array('module' => 'estore', 'controller' => 'dashboard', 'action' => 'remove'), 'default') ?>";
</script>
