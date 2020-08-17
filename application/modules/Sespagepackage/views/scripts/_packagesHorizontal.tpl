 <li class="sespage_packages_list_item <?php echo ($package->highlight) ? 'active' : '' ?>">
  <section>
   <div class="_top sesbasic_clearfix">
   		<div class="_title"><h5><?php echo $this->translate($package->title); ?></h5></div>
      <div class="_price">
        <?php if(!$package->isFree()){ ?>
          <span><?php echo Engine_Api::_()->sespagepackage()->getCurrencyPrice($package->price,'','',true); ?></span>
          <small>
            <?php if($package->recurrence_type == 'day'):?>
              <?php echo $this->translate('Daily');?>
            <?php elseif($package->price && $package->recurrence_type != 'forever'):?>
              <?php echo $this->translate(ucfirst($package->recurrence_type).'ly');?>
            <?php elseif($package->recurrence_type == 'forever'): ?>
              <?php echo sprintf($this->translate('One-time fee of %1$s'), Engine_Api::_()->sespagepackage()->getCurrencyPrice($package->price,'','',true)); ?>
            <?php else:?>
              <?php echo $this->translate('Free');?>
            <?php endif;?>
          </small>
        <?php }else{ ?>
          <span><?php echo $this->translate("FREE"); ?></span>
        <?php } ?>
      </div>
    </div>
    <div class="_cont sesbasic_clearfix">
    	<div class="package_capabilities _features">
        <div class="sesbasic_clearfix">
        	<div>
            <span class="_label"><?php echo $this->translate('Billing Duration');?></span>
            <span class="_value">
              <?php if($package->duration_type == 'forever'):?>
                <?php echo $this->translate('Forever');?>
              <?php else:?>
                <?php if($package->duration > 1):?>
                  <?php echo $package->duration . ' ' . ucfirst($package->duration_type).'s';?>
                <?php else:?>
                  <?php echo $package->duration . ' ' . ucfirst($package->duration_type);?>
                <?php endif;?>
              <?php endif;?>
            </span>
          </div>
        </div>
        <div class="sesbasic_clearfix">
        	<div>
          <span class="_label"><?php echo $this->translate('Pages Count');?></span>
            <?php if($existing):?>
              <span class="_value"><?php echo (!$package->item_count) ? $this->translate("Unlimited") : $package->item_count.' ( '.$packageleft->item_count.' Left )' ?></span>
            <?php else:?>
              <span class="_value"><?php echo $package->item_count ; ?></span>
            <?php endif;?>
          </div>
        </div>
        <div class="sesbasic_clearfix">
        	<div>
            <span class="_label"><?php echo $this->translate('Auto Approved Pages');?></span>
            <span class="_value"><i class="_icon _<?php echo ($enableModules['page_approve']) ? 'yes' : 'no';?>"></i></span>
        	</div>
        </div>
        <?php if(in_array('featured',$showinfo)){ ?>	
          <div class="sesbasic_clearfix <?php echo ($enableModules['page_featured']) ? 'yes' : 'no'; ?>">
          	<div>
              <span class="_label">Featured</span>
              <span class="_value"><i class="_icon <?php echo ($enableModules['page_featured']) ? '_yes' : '_no'; ?>"></i></span>
          	</div>
          </div>
        <?php } ?>
        <?php if(in_array('sponsored',$showinfo)){ ?>  
          <div class="sesbasic_clearfix <?php echo ($enableModules['page_sponsored']) ? 'yes' : 'no'; ?>">
          	<div>
              <span class="_label">Sponsored</span>
              <span class="_value"><i class="_icon <?php echo ($enableModules['page_sponsored']) ? '_yes' : '_no'; ?>"></i></span>
          	</div>
          </div>
        <?php } ?>
        <?php if(in_array('verified',$showinfo)){ ?>  
          <div class="sesbasic_clearfix <?php echo ($enableModules['page_verified']) ? 'yes' : 'no'; ?>">
          	<div>
              <span class="_label">Verified</span>
              <span class="_value"><i class="_icon <?php echo ($enableModules['page_verified']) ? '_yes' : '_no'; ?>"></i></span>
          	</div>
          </div>
        <?php } ?>
        <?php if(in_array('hot',$showinfo)){ ?>  
          <div class="sesbasic_clearfix <?php echo ($enableModules['page_hot']) ? 'yes' : 'no'; ?>">
            <div>
              <span class="_label">Hot</span>
              <span class="_value"><i class="_icon <?php echo ($enableModules['page_hot']) ? '_yes' : '_no'; ?>"></i></span>
          	</div>
          </div>
        <?php } ?>
        <div class="sesbasic_clearfix">
        	<div>
            <span class="_label"><?php echo $this->translate('Background Photo');?></span>
            <span class="_value"><i class="_icon <?php echo ($enableModules['page_bgphoto']) ? '_yes' : '_no'; ?>"></i></span>
        	</div>
        </div>
        <div class="sesbasic_clearfix">
        	<div>
            <span class="_label"><?php echo $this->translate('Main Photo');?></span>
            <span class="_value"><i class="_icon <?php echo ($enableModules['upload_mainphoto']) ? '_yes' : '_no'; ?>"></i></span>
        	</div>
        </div>
        <div class="sesbasic_clearfix">
        	<div>
            <span class="_label"><?php echo $this->translate('Cover Photo');?></span>
            <span class="_value"><i class="_icon <?php echo ($enableModules['upload_cover']) ? '_yes' : '_no'; ?>"></i></span>
        	</div>
        </div>
        <div class="sesbasic_clearfix">
        	<div>
            <span class="_label"><?php echo $this->translate('Select Design Layout');?></span>
            <span class="_value"><i class="_icon <?php echo ($enableModules['page_choose_style']) ? '_yes' : '_no'; ?>"></i></span>
        	</div>
        </div>
      </div>
      <?php if(in_array('description',$showinfo)){ ?> 
      	<div class="_des _colm">
        	<p class="package_des"><?php echo $this->translate($package->description); ?> </p>
        </div>  
      <?php } ?>
    </div>
    <div class="_btns sesbasic_clearfix">
      <?php if($existing && !$package->isOneTime()):?>
        <div class="_left">
          <a href="<?php echo $this->url(array('action' => 'cancel','package_id' => $package->package_id),'sespagepackage_general',true);?>" class="sespage_packages_cancel_btn smoothbox"><?php echo $this->translate("Cancel");?></a>
          <span><b><?php echo $this->translate("Subscribed on: ");?></b><?php echo date('d F Y', strtotime($packageleft->creation_date));?></span><span>&nbsp;|</span>
          <span><b><?php echo $this->translate("Next Payment Date: ");?></b><?php echo date('d F Y', strtotime($packageleft->expiration_date));?></span>
        </div>
      <?php endif;?>
      <div class="_right">
        <?php if($existing):?>
          <a class="sespage_packages_create_btn sesbasic_animation" href="<?php echo $this->url(array('action' => 'create', 'existing_package_id' => $packageleft->getIdentity()),'sespage_general',true); ?>"><?php echo $this->translate('Create Page');?></a>
        <?php else:?>
          <a class="sespage_packages_create_btn sesbasic_animation" href="<?php echo $this->url(array('action' => 'create', 'package_id' => $package->package_id),'sespage_general',true); ?>"><?php echo $this->translate('Create Page');?></a>
        <?php endif;?>
      </div>
    </div>
  </section>
 </li>   