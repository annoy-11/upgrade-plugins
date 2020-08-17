<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursespackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: classroom.tpl 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Coursespackage/externals/styles/styles.css'); ?>
<?php 
$information = array('description' => 'Package Description', 'featured' => 'Featured', 'sponsored' => 'Sponsored', 'verified' => 'Verified', 'hot' => 'Hot', 'custom_fields' => 'Custom Fields');
$showinfo = Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.package.info', array_keys($information)); ?>
<?php $currentCurrency =  Engine_Api::_()->courses()->getCurrentCurrency(); ?>
<?php if(count($this->existingleftpackages)){ ?>
	<div class="courses_packages_main sesbasic_clearfix sesbasic_bxs">
  	<div class="courses_packages_main_header">
      <h2><?php echo $this->translate("Existing Package(s)")?></h2>
    </div>
    <div class="courses_packages_table_container">
      <ul class="courses_packages_list">
        <?php $existing = 1;?>
      <?php foreach($this->existingleftpackages as $packageleft)	{
            $package = Engine_Api::_()->getItem('coursespackage_package',$packageleft->package_id);
            $enableModules = json_decode($package->params,true);
       ?>
        <?php include APPLICATION_PATH .  '/application/modules/Coursespackage/views/scripts/_packagesHorizontal.tpl';?>      
      <?php } ?>
      </ul>
    </div>
  </div>
<?php } ?>
<?php if(count($this->package)){ ?>
	<div class="courses_packages_main sesbasic_clearfix sesbasic_bxs">
  	<div class="courses_packages_main_header">
      <h2><?php echo $this->translate("Choose A Package")?></h2>
      <p><?php echo $this->translate('Select a package that suits you most to start creating pages on this website.');?></p>
    </div>
    <div class="courses_packages_table_container">
      <ul class="courses_packages_table">
        <?php $existing = 0;?>
      	<?php foreach($this->package as $package)	{
              $enableModules = json_decode($package->params,true);
       	?>
         <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.package.style', 1)):?>
           <?php include APPLICATION_PATH .  '/application/modules/Coursespackage/views/scripts/_packages.tpl';?> 
         <?php else:?>
           <?php include APPLICATION_PATH .  '/application/modules/Coursespackage/views/scripts/_packagesHorizontal.tpl';?>
         <?php endif;?>
      	<?php } ?>
      </ul>
		</div>
  </div>  
<?php } ?>
  
<script type="application/javascript">
var elem = sesJqueryObject('.package_catogery_listing');
for(i=0;i<elem.length;i++){
	var widthTotal = sesJqueryObject(elem[i]).children().length * 265;
	sesJqueryObject(elem[i]).css('width',widthTotal+'px');
}
</script>
