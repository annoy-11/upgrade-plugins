<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-team.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespageteam/externals/scripts/core.js'); ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespageteam/externals/styles/styles.css'); ?>

<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespageteam/externals/styles/styles.css'); ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sespage', array(
	'page' => $this->page,
      ));	
?>
<div class="sespage_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs sespage_dashboard_team_content">
<?php } ?>
  <div class="sespage_dashboard_content_header"> 
    <h3><?php echo $this->translate("Teams")?></h3>
    <p><?php echo $this->translate("You can add your page team by click on Add New Team link."); ?></p> 
  </div>
  <section class="sespageteam_dashboard_team_desination_section">
  	<h4><?php echo $this->translate("Designations")?></h4>
    <div class="sespage_dashboard_content_btns">
      <a href="<?php echo $this->url(array('page_id' => $this->page->page_id, 'action'=>'add-designation'),'sespageteam_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add Designation");?></span></a>
    </div>
    <div class="sespage_dashboard_team_desinations" id="sespage_dashboard_team_desinations">
    	<?php include APPLICATION_PATH . '/application/modules/Sespageteam/views/scripts/_designations.tpl'; ?>
    </div>  
  </section>
  
  
  <section class="sespageteam_dashboard_team_section">
  	<h4><?php echo $this->translate("Team Members")?></h4>
    <div class="sespage_dashboard_content_btns">
      <a href="<?php echo $this->url(array('page_id' => $this->page->page_id, 'action'=>'add', 'type' => 'sitemember'),'sespageteam_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add Site Team Members");?></span></a>
      <a href="<?php echo $this->url(array('page_id' => $this->page->page_id, 'action'=>'add', 'type' => 'nonsitemember'), 'sespageteam_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add Non-Site Team");?></span></a>
    </div>
    
    <div class="sespageteam_mamage_team" id="sespageteam_teams">
      <?php include APPLICATION_PATH . '/application/modules/Sespageteam/views/scripts/_teams.tpl'; ?>
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
  var pagePhotoDeleteUrl = "<?php echo $this->url(Array('module' => 'sespage', 'controller' => 'dashboard', 'action' => 'remove'), 'default') ?>";
</script>