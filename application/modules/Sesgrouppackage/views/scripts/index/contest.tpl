<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppackage
 * @package    Sesgrouppackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: contest.tpl  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgrouppackage/externals/styles/styles.css'); ?>
<?php 
$information = array('description' => 'Package Description', 'featured' => 'Featured', 'sponsored' => 'Sponsored', 'verified' => 'Verified', 'hot' => 'Hot', 'custom_fields' => 'Custom Fields');
$showinfo = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppackage.package.info', array_keys($information)); ?>
<?php $currentCurrency =  Engine_Api::_()->sesgrouppackage()->getCurrentCurrency(); ?>
<?php if(count($this->existingleftpackages)){ ?>
	<div class="sesgroup_packages_main sesbasic_clearfix sesbasic_bxs">
  	<div class="sesgroup_packages_main_header">
      <h2><?php echo $this->translate("Existing Package(s)")?></h2>
    </div>
    <div class="sesgroup_packages_table_container">
      <ul class="sesgroup_packages_list">
        <?php $existing = 1;?>
      <?php foreach($this->existingleftpackages as $packageleft)	{
            $package = Engine_Api::_()->getItem('sesgrouppackage_package',$packageleft->package_id);
            $enableModules = json_decode($package->params,true);
       ?>
        <?php include APPLICATION_PATH .  '/application/modules/Sesgrouppackage/views/scripts/_packagesHorizontal.tpl';?>
      <?php } ?>
      </ul>
    </div>
  </div>
<?php } ?>
<?php if(count($this->package)){ ?>
	<div class="sesgroup_packages_main sesbasic_clearfix sesbasic_bxs">
  	<div class="sesgroup_packages_main_header">
      <h2><?php echo $this->translate("Choose A Package")?></h2>
      <p><?php echo $this->translate('Select a package that suits you most to start creating groups on this website.');?></p>
    </div>
    <div class="sesgroup_packages_table_container">
      <ul class="sesgroup_packages_table">
        <?php $existing = 0;?>
      	<?php foreach($this->package as $package)	{
              $enableModules = json_decode($package->params,true);
       	?>
         <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppackage.package.style', 1)):?>
           <?php include APPLICATION_PATH .  '/application/modules/Sesgrouppackage/views/scripts/_packages.tpl';?>
         <?php else:?>
           <?php include APPLICATION_PATH .  '/application/modules/Sesgrouppackage/views/scripts/_packagesHorizontal.tpl';?>
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