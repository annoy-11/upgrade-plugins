<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagepackage/externals/styles/styles.css'); ?>
<?php 
$information = array('description' => 'Package Description', 'featured' => 'Featured', 'sponsored' => 'Sponsored', 'verified' => 'Verified', 'hot' => 'Hot', 'custom_fields' => 'Custom Fields');
$showinfo = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagepackage.package.info', array_keys($information)); ?>
<?php $currentCurrency =  Engine_Api::_()->sespagepackage()->getCurrentCurrency(); ?>
<?php if(count($this->existingleftpackages)): ?>
	<div class="sespage_packages_main sesbasic_clearfix sesbasic_bxs">
  	<div class="sespage_packages_main_header">
      <h2><?php echo $this->translate("My Package(s)")?></h2>
    </div>
    <div class="sespage_packages_transactions_btn">
      <a href="<?php echo $this->url(array('action' => 'transactions'),'sespage_general',true);?>" class="sespage_packages_create_btn sesbasic_animation"><?php echo $this->translate("See All Transactions");?></a>
    </div>
    <div class="sespage_packages_table_container">
      <ul class="sespage_packages_list">
        <?php $existing = 1;?>
      <?php foreach($this->existingleftpackages as $packageleft)	{
            $package = Engine_Api::_()->getItem('sespagepackage_package',$packageleft->package_id);
            $enableModules = json_decode($package->params,true);
       ?>
        <?php include APPLICATION_PATH .  '/application/modules/Sespagepackage/views/scripts/_packagesHorizontal.tpl';?>
      <?php } ?>
      </ul>
    </div>
  </div>
<?php else: ?>
  <div class="sesbasic_tip clearfix">
    <img src="application/modules/Sespagepackage/externals/images/package-icon.png" alt="">
    <span class="sesbasic_text_light"><?php echo $this->translate("You have not subscribed to any package yet!")?></span>
  </div>
<?php endif;?>
<script type="application/javascript">
var elem = sesJqueryObject('.package_catogery_listing');
for(i=0;i<elem.length;i++){
	var widthTotal = sesJqueryObject(elem[i]).children().length * 265;
	sesJqueryObject(elem[i]).css('width',widthTotal+'px');
}
</script>