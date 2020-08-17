<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>

<?php 
$information = array('description'=>'Package Description','featured'=>'Featured','sponsored'=>'Sponsored','verified'=>'Verified','location'=>'Location','modules'=>'Modules','editor'=>'Rich Editor','custom_fields'=>'Custom Fields','blogcount'=>'Blog Count');
$showinfo = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesblogpackage.package.information', array_keys($information)); ?>
<?php $currentCurrency =  Engine_Api::_()->sesblog()->getCurrentCurrency(); ?>
<?php if(count($this->existingleftpackages)){ ?>
<div class="sesblogpackage_blog_list sesbasic_clearfix sesbasic_bxs">
	<div class="sesblogpackage_slect_plan_blog">
  <div class="heading_blog">
  	<p class="headding"><?php echo $this->translate("Existing Package(s)"); ?></p>
    </div>
    <div class="select">
    	<ul>
      <?php if(in_array('blogcount',$showinfo)){ ?>
        <li><?php echo $this->translate("Blog Count"); ?></li>
     	<?php }else{ ?>
      	<li><?php echo $this->translate("Blog Left"); ?></li>
      <?php } ?>
      <?php if(in_array('featured',$showinfo)){ ?>
      	<li><?php echo $this->translate("Featured"); ?></li>
      <?php } ?>
      <?php if(in_array('sponsored',$showinfo)){ ?>
        <li><?php echo $this->translate("Sponsored"); ?></li>
       <?php } ?>  
      <?php if(in_array('verified',$showinfo)){ ?>
        <li><?php echo $this->translate("Verified"); ?></li>
        <?php } ?> 
      <?php if(in_array('location',$showinfo)){ ?>
        <li><?php echo $this->translate("Location"); ?></li>
       <?php } ?>  
      <?php if(in_array('editor',$showinfo)){ ?>
        <li><?php echo $this->translate("Rich Editor"); ?></li>
       <?php } ?>  
      <?php if(in_array('custom_fields',$showinfo)){ ?>
        <li><?php echo $this->translate("Custom Fields"); ?></li>
        <?php } ?> 
      <?php if(in_array('modules',$showinfo)){ ?>
        <li><?php echo $this->translate("Modules"); ?></li>
     <?php } ?>
      </ul>
    </div>
  </div>
  <div class="package_catogery_list sesbasic_custom_scroll">
  	<ul class="package_catogery_listing">
    <?php foreach($this->existingleftpackages as $packageleft)	{
            $package = Engine_Api::_()->getItem('sesblogpackage_package',$packageleft->package_id);
            $enableModules = json_decode($package->params,true);
            $curruncySymbol = str_replace('.','',preg_replace('/\d+/u', '', Engine_Api::_()->sesblog()->getCurrencyPrice($package->price)));
     ?>
    	<li class="<?php ($package->highlight) ? 'active' : '' ?>">
      	<div class="package-ditals_blog">
        	<div class="headding_blog">
          	<div class="tittle">
            	<p><?php echo $this->translate($package->title); ?></p>
              <small></small>
            </div>
            <div class="amount">
            	<?php if($package->price > 0){ ?>
            		<span><?php echo $curruncySymbol; ?></span><?php echo Engine_Api::_()->sesblog()->getCurrencyPrice($package->price,'','',true)); ?><br />
                <small><?php echo $package->getPackageDescription(); ?></small>
              <?php }else{ ?>
              	<span><?php echo $this->translate("FREE"); ?></span><br />
              <?php } ?>
            </div>
          </div>
          <div class="select">
          	<ul>
            <?php if(in_array('blogcount',$showinfo)){ ?>	
            	<li><span><?php echo (!$package->item_count) ? $this->translate("Unlimited") : $package->item_count.' ( '.$packageleft->item_count.' Left )' ?></span></li>
            <?php }else{ ?>
            	<li><span><?php echo $packageleft->item_count ; ?></span></li>
            <?php } ?>
            <?php if(in_array('featured',$showinfo)){ ?>	
            	<li class="<?php echo ($enableModules['is_featured']) ? 'yes' : 'no'; ?>"><i class="fa fa-<?php echo ($enableModules['is_featured']) ? 'check' : 'close'; ?>"></i></li>
            <?php } ?>
            <?php if(in_array('sponsored',$showinfo)){ ?>  
              <li class="<?php echo ($enableModules['is_sponsored']) ? 'yes' : 'no'; ?>"><i class="fa fa-<?php echo ($enableModules['is_sponsored']) ? 'check' : 'close'; ?>"></i></li>
            <?php } ?>
            <?php if(in_array('verified',$showinfo)){ ?>  
              <li class="<?php echo ($enableModules['is_verified']) ? 'yes' : 'no'; ?>"><i class="fa fa-<?php echo ($enableModules['is_verified']) ? 'check' : 'close'; ?>"></i></li>
            <?php } ?>
            <?php if(in_array('location',$showinfo)){ ?>  
              <li class="<?php echo ($enableModules['enable_location']) ? 'yes' : 'no'; ?>"><i class="fa fa-<?php echo ($enableModules['enable_location']) ? 'check' : 'close'; ?>"></i></li>
            <?php } ?>
            <?php if(in_array('editor',$showinfo)){ ?>
             <li class="<?php echo ($enableModules['enable_tinymce']) ? 'yes' : 'no'; ?>"><i class="fa fa-<?php echo ($enableModules['enable_tinymce']) ? 'check' : 'close'; ?>"></i></li>
           <?php } ?>
           <?php if(in_array('custom_fields',$showinfo)){ ?>
              <li class="<?php echo ($enableModules['custom_fields']) ? 'yes' : 'no'; ?>"><i class="fa fa-<?php echo ($enableModules['custom_fields']) ? 'check' : 'close'; ?>"></i></li>
          <?php } ?>
           <?php if(in_array('modules',$showinfo)){ ?>
              <li class="<?php echo (count($enableModules['modules'])) ? 'yes' : 'no'; ?>"><i class="fa fa-<?php echo (count($enableModules['modules'])) ? 'check' : 'close'; ?>"></i>
              	<?php if(count($enableModules['modules'])){ 
                		echo "<br>";
                    $counter = 1;
                		foreach($enableModules['modules'] as $module){
                    	$countmodulelimit = $enableModules[$module.'_count'] ? $enableModules[$module.'_count'] : $this->translate('Unlimited');
                    	echo ucfirst($module).'('.$countmodulelimit.')';
                      if(count($enableModules['modules']) != $counter)
                      	echo ' ,';
                       $counter++;
                    }
                 } ?>
              </li>
           <?php } ?>
            </ul>
          <?php if(in_array('description',$showinfo)){ ?> 
            <p class="footer_discprition"><?php echo $this->translate($package->description); ?> </p>
          <?php } ?>
          <a class="create_blog_btn" href="<?php echo $this->url(array('action' => 'create', 'existing_package_id' => $packageleft->getIdentity()),'sesblog_general',true); ?>">Create Blog</a>
          </div>
        </div>
      </li>      
    <?php } ?>
    </ul>
  </div>
</div>
<?php } ?>

<?php if(count($this->package)){ ?>
<div class="sesblogpackage_blog_list sesbasic_clearfix sesbasic_bxs">
	<div class="sesblogpackage_slect_plan_blog">
  <div class="heading_blog">
  	<p class="headding"><?php echo $this->translate("New Package(s)"); ?></p>
    </div>
    <div class="select">
    	<ul>
      <?php if(in_array('blogcount',$showinfo)){ ?>
        <li><?php echo $this->translate("Blog Count"); ?></li>
     	<?php }else{ ?>
      	<li><?php echo $this->translate("Blog Left"); ?></li>
      <?php } ?>
      <?php if(in_array('featured',$showinfo)){ ?>
      	<li><?php echo $this->translate("Featured"); ?></li>
      <?php } ?>
      <?php if(in_array('sponsored',$showinfo)){ ?>
        <li><?php echo $this->translate("Sponsored"); ?></li>
       <?php } ?>  
      <?php if(in_array('verified',$showinfo)){ ?>
        <li><?php echo $this->translate("Verified"); ?></li>
        <?php } ?> 
      <?php if(in_array('location',$showinfo)){ ?>
        <li><?php echo $this->translate("Location"); ?></li>
       <?php } ?>  
      <?php if(in_array('editor',$showinfo)){ ?>
        <li><?php echo $this->translate("Rich Editor"); ?></li>
       <?php } ?>  
      <?php if(in_array('custom_fields',$showinfo)){ ?>
        <li><?php echo $this->translate("Custom Fields"); ?></li>
        <?php } ?> 
      <?php if(in_array('modules',$showinfo)){ ?>
        <li><b><?php echo $this->translate("Modules"); ?></b></li>
     <?php } ?>
      </ul>
    </div>
  </div>
  <div class="package_catogery_list sesbasic_custom_scroll">
  	<ul class="package_catogery_listing">
    <?php foreach($this->package as $package)	{
            $enableModules = json_decode($package->params,true);
            $curruncySymbol = str_replace('.','',preg_replace('/\d+/u', '', Engine_Api::_()->sesblog()->getCurrencyPrice($package->price)));
     ?>
    	<li class="<?php echo ($package->highlight) ? 'active' : '' ?>">
      	<div class="package-ditals_blog">
        	<div class="headding_blog">
          	<div class="tittle">
            	<p><?php echo $this->translate($package->title); ?></p>
              <small></small>
            </div>
            <div class="amount">
            	<?php if(!$package->isFree()){ ?>
            		<span><?php echo $curruncySymbol; ?></span><?php echo  Engine_Api::_()->sesblog()->getCurrencyPrice($package->price,'','',true); ?><br />
                <small><?php echo $package->getPackageDescription(); ?></small>
              <?php }else{ ?>
              	<span><?php echo $this->translate("FREE"); ?></span><br />
              <?php } ?>
            </div>
          </div>
          <div class="select">
          	<ul class="check_list">
            <?php if(in_array('blogcount',$showinfo)){ ?>	
            	<li><span><?php echo (!$package->item_count) ? $this->translate("Unlimited") : $package->item_count; ?></span></li>
            <?php }else{ ?>
            	<li><span><?php echo $packageleft->item_count ; ?></span></li>
            <?php } ?>
            <?php if(in_array('featured',$showinfo)){ ?>	
            	<li class="<?php echo ($enableModules['is_featured']) ? 'yes' : 'no'; ?>"><i class="fa fa-<?php echo ($enableModules['is_featured']) ? 'check' : 'close'; ?>"></i></li>
            <?php } ?>
            <?php if(in_array('sponsored',$showinfo)){ ?>  
              <li class="<?php echo ($enableModules['is_sponsored']) ? 'yes' : 'no'; ?>"><i class="fa fa-<?php echo ($enableModules['is_sponsored']) ? 'check' : 'close'; ?>"></i></li>
            <?php } ?>
            <?php if(in_array('verified',$showinfo)){ ?>  
              <li class="<?php echo ($enableModules['is_verified']) ? 'yes' : 'no'; ?>"><i class="fa fa-<?php echo ($enableModules['is_verified']) ? 'check' : 'close'; ?>"></i></li>
            <?php } ?>
            <?php if(in_array('location',$showinfo)){ ?>  
              <li class="<?php echo ($enableModules['enable_location']) ? 'yes' : 'no'; ?>"><i class="fa fa-<?php echo ($enableModules['enable_location']) ? 'check' : 'close'; ?>"></i></li>
            <?php } ?>
            <?php if(in_array('editor',$showinfo)){ ?>
             <li class="<?php echo ($enableModules['enable_tinymce']) ? 'yes' : 'no'; ?>"><i class="fa fa-<?php echo ($enableModules['enable_tinymce']) ? 'check' : 'close'; ?>"></i></li>
           <?php } ?>
           <?php if(in_array('custom_fields',$showinfo)){ ?>
              <li class="<?php echo ($enableModules['custom_fields']) ? 'yes' : 'no'; ?>"><i class="fa fa-<?php echo ($enableModules['custom_fields']) ? 'check' : 'close'; ?>"></i></li>
          <?php } ?>
           <?php if(in_array('modules',$showinfo)){ ?>
             
           <?php } ?>
            </ul>
            <div class="modual_teb_list sesbasic_custom_scroll">
            <ul class="view_tags ">
            
            <?php if(count($enableModules['modules'])) { 
                    $counter = 1;
                		foreach($enableModules['modules'] as $module){
                    	$countmodulelimit = $enableModules[$module.'_count'] ? $enableModules[$module.'_count'] : $this->translate('Unlimited');
                    	echo '<li>'.ucfirst($module).' ('.$countmodulelimit.')';
                      if(count($enableModules['modules']) != $counter)
                      	echo ' </li>';
                      else 
                       echo '</li>';
                       $counter++;
                    }
                 } ?>
                 
                 </ul>
                 </div>
          <?php if(in_array('description',$showinfo)){ ?> 
            <p class="footer_discprition"><?php echo $this->translate($package->description); ?> </p>
          <?php } ?>
          <a class="create_blog_btn" href="<?php echo $this->url(array('action' => 'create', 'package_id' => $package->package_id),'sesblog_general',true); ?>">Create Blog</a>
          </div>
        </div>
      </li>      
    <?php } ?>
    </ul>
  </div>
</div>
<?php } ?>


  <div class="sesblogpackage_blog_two_list sesbasic_clearfix sesbasic_bxs">

    <div class="sesblogpackage_slect_plan_blog">
        <div class="select sesbasic_custom_scroll">
            <ul class="check_list tittle_list">  
            <li><p><span>Price</span></p></li>
            <?php if(in_array('blogcount',$showinfo)){ ?>	
            	<li> <div class="sesblogpackage_blog_plan_list"> <p><span><?php if(in_array('blogcount',$showinfo)){ ?><?php echo $this->translate("Blog Count"); ?><?php } ?></span> </p></div></li>
            <?php }else{ ?>
            	<li><div class="sesblogpackage_blog_plan_list"><p><span><?php echo $this->translate("Blog Left"); ?></span><?php echo $packageleft->item_count ; ?></p></div></li>
            <?php } ?>
            <?php if(in_array('featured',$showinfo)){ ?>	
            	<li class="<?php echo ($enableModules['is_featured']) ? 'yes' : 'no'; ?>"> <div class="sesblogpackage_blog_plan_list"><p><span><?php if(in_array('featured',$showinfo)){ ?><?php echo $this->translate("Featured"); ?><?php } ?></span> </p></div></li>
            <?php } ?>
            <?php if(in_array('sponsored',$showinfo)){ ?>  
             <li class="<?php echo ($enableModules['is_sponsored']) ? 'yes' : 'no'; ?>"><div class="sesblogpackage_blog_plan_list"><p><span><?php if(in_array('sponsored',$showinfo)){ ?><?php echo $this->translate("Sponsored"); ?><?php } ?></span> </p></div></li>
            <?php } ?>
            <?php if(in_array('verified',$showinfo)){ ?>  
              <li class="<?php echo ($enableModules['is_verified']) ? 'yes' : 'no'; ?>"><div class="sesblogpackage_blog_plan_list"><p><span><?php if(in_array('verified',$showinfo)){ ?><?php echo $this->translate("Verified"); ?><?php } ?> </span></p></div></li>
            <?php } ?>
            <?php if(in_array('location',$showinfo)){ ?>  
              <li class="<?php echo ($enableModules['enable_location']) ? 'yes' : 'no'; ?>"><div class="sesblogpackage_blog_plan_list"><p><span><?php if(in_array('location',$showinfo)){ ?><?php echo $this->translate("Location"); ?><?php } ?>  </span></p></div></li>
            <?php } ?>
            <?php if(in_array('editor',$showinfo)){ ?>
             <li class="<?php echo ($enableModules['enable_tinymce']) ? 'yes' : 'no'; ?>"><div class="sesblogpackage_blog_plan_list"><p><span><?php if(in_array('editor',$showinfo)){ ?><?php echo $this->translate("Rich Editor"); ?><?php } ?>  </span></p></div>
           <?php } ?>
           <?php if(in_array('custom_fields',$showinfo)){ ?>
              <li class="<?php echo ($enableModules['custom_fields']) ? 'yes' : 'no'; ?>"><div class="sesblogpackage_blog_plan_list"><p><span><?php if(in_array('custom_fields',$showinfo)){ ?><?php echo $this->translate("Custom Fields"); ?><?php } ?> </span></p></div></li>
          <?php } ?>
           <?php if(in_array('modules',$showinfo)){ ?>
             <li class="moduls"><div class="sesblogpackage_blog_plan_list">
             	      <?php if(in_array('modules',$showinfo)){ ?>
       <b><?php echo $this->translate("Modules"); ?></b>
     <?php } ?>     
                 </div>
             </li>
           <?php } ?>
            </ul>
              <div class="headding_tiitle"><p class="tittle_name"><?php echo $this->translate($package->title); ?></p></div>
         <div class="package_diescription">
         <ul class="check_list list_cont">  
         <li><?php if(!$package->isFree()){ ?>
            		<span><?php echo $curruncySymbol; ?></span><?php echo  Engine_Api::_()->sesblog()->getCurrencyPrice($package->price,'','',true); ?><br />
                <small><?php echo $package->getPackageDescription(); ?></small>
              <?php }else{ ?>
              	<span><b><?php echo $this->translate("FREE"); ?></b></span>
              <?php } ?></li>
            <?php if(in_array('blogcount',$showinfo)){ ?>	
            	<li> <div class="sesblogpackage_blog_plan_list"> <p><b><?php echo (!$package->item_count) ? $this->translate("Unlimited") : $package->item_count; ?></p></b></div></li>
            <?php }else{ ?>
            	<li><div class="sesblogpackage_blog_plan_list"><p><span><?php echo $this->translate("Blog Left"); ?></span><?php echo $packageleft->item_count ; ?></p></div></li>
            <?php } ?>
            <?php if(in_array('featured',$showinfo)){ ?>	
            	<li class="<?php echo ($enableModules['is_featured']) ? 'yes' : 'no'; ?>"> <div class="sesblogpackage_blog_plan_list"><p><i class="fa fa-<?php echo ($enableModules['is_featured']) ? 'check' : 'close'; ?>"></i></p></div></li>
            <?php } ?>
            <?php if(in_array('sponsored',$showinfo)){ ?>  
             <li class="<?php echo ($enableModules['is_sponsored']) ? 'yes' : 'no'; ?>"><div class="sesblogpackage_blog_plan_list"><p><i class="fa fa-<?php echo ($enableModules['is_sponsored']) ? 'check' : 'close'; ?>"></i></p></div></li>
            <?php } ?>
            <?php if(in_array('verified',$showinfo)){ ?>  
              <li class="<?php echo ($enableModules['is_verified']) ? 'yes' : 'no'; ?>"><div class="sesblogpackage_blog_plan_list"><p><i class="fa fa-<?php echo ($enableModules['is_verified']) ? 'check' : 'close'; ?>"></i></p></div></li>
            <?php } ?>
            <?php if(in_array('location',$showinfo)){ ?>  
              <li class="<?php echo ($enableModules['enable_location']) ? 'yes' : 'no'; ?>"><div class="sesblogpackage_blog_plan_list"><p><i class="fa fa-<?php echo ($enableModules['enable_location']) ? 'check' : 'close'; ?>"></i></p></div></li>
            <?php } ?>
            <?php if(in_array('editor',$showinfo)){ ?>
             <li class="<?php echo ($enableModules['enable_tinymce']) ? 'yes' : 'no'; ?>"><div class="sesblogpackage_blog_plan_list"><p><i class="fa fa-<?php echo ($enableModules['enable_tinymce']) ? 'check' : 'close'; ?>"></i></p></div>
           <?php } ?>
           <?php if(in_array('custom_fields',$showinfo)){ ?>
              <li class="<?php echo ($enableModules['custom_fields']) ? 'yes' : 'no'; ?>"><div class="sesblogpackage_blog_plan_list"><p><i class="fa fa-<?php echo ($enableModules['custom_fields']) ? 'check' : 'close'; ?>"></i></p></div></li>
          <?php } ?>
           <?php if(in_array('modules',$showinfo)){ ?>
             <li class="moduls"><div class="sesblogpackage_blog_plan_list">
             	      <?php if(in_array('modules',$showinfo)){ ?>
     <?php } ?>
     <b>
            <?php if(count($enableModules['modules'])) { 
                    $counter = 1;
                		foreach($enableModules['modules'] as $module){
                    	$countmodulelimit = $enableModules[$module.'_count'] ? $enableModules[$module.'_count'] : $this->translate('Unlimited');
                    	echo '<span>'.ucfirst($module).' ('.$countmodulelimit.')';
                      if(count($enableModules['modules']) != $counter)
                      	echo ' </span>';
                      else 
                       echo '';
                       $counter++;
                    }
                 } ?></b>
                 </div>
             </li>
             <li class="create_blog_btn"><a class="" href="<?php echo $this->url(array('action' => 'create', 'package_id' => $package->package_id),'sesblog_general',true); ?>">Create Blog</a></li>
           <?php } ?>
            </ul>
          <?php if(in_array('description',$showinfo)){ ?> 
            <p class="footer_discprition"><?php echo $this->translate($package->description); ?> </p>
          <?php } ?>
          
         </div>
          </div>    
    </div>
   
  </div>
<script type="application/javascript">
var elem = sesJqueryObject('.package_catogery_listing');
for(i=0;i<elem.length;i++){
	var widthTotal = sesJqueryObject(elem[i]).children().length * 265;
	sesJqueryObject(elem[i]).css('width',widthTotal+'px');
}
</script>