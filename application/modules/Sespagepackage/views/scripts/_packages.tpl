 <li class="sespage_packages_table_item <?php echo ($package->highlight) ? 'active' : '' ?>">
  <section>
      <div class="_title sesbasic_clearfix">
      <h5><?php echo $this->translate($package->title); ?></h5>
      <?php if(!$package->isFree()){ ?>
        <span><?php echo Engine_Api::_()->sespagepackage()->getCurrencyPrice($package->price,'','',true); ?></span>
      <?php }else{ ?>
        <span><?php echo $this->translate("FREE"); ?></span>
      <?php } ?>
    </div>
    <div class="_cont">
      <ul class="package_capabilities">
        <li class="sesbasic_clearfix">
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
        </li>
        <li class="sesbasic_clearfix">
          <span class="_label"><?php echo $this->translate('Billing Cycle');?></span>
          <span class="_value">
            <?php if($package->recurrence_type == 'day'):?>
              <?php echo $this->translate('Daily');?>
            <?php elseif($package->price && $package->recurrence_type != 'forever'):?>
              <?php echo $this->translate(ucfirst($package->recurrence_type).'ly');?>
            <?php elseif($package->recurrence_type == 'forever'): ?>
              <?php echo sprintf($this->translate('One-time fee of %1$s'), Engine_Api::_()->sespagepackage()->getCurrencyPrice($package->price,'','',true)); ?>
            <?php else:?>
              <?php echo $this->translate('Free');?>
            <?php endif;?>
          </span>
        </li>
        <li class="sesbasic_clearfix">
          <span class="_label"><?php echo $this->translate('Pages Count');?></span>
          <?php if($existing):?>
            <span class="_value"><?php echo (!$package->item_count) ? $this->translate("Unlimited") : $package->item_count.' ( '.$packageleft->item_count.' Left )' ?></span>
          <?php else:?>
            <span class="_value"><?php echo $package->item_count ; ?></span>
          <?php endif;?>
        </li>
        <li class="sesbasic_clearfix">
          <span class="_label"><?php echo $this->translate('Auto Approved Pages');?></span>
          <span class="_value"><i class="_icon _<?php echo ($enableModules['page_approve']) ? 'yes' : 'no';?>"></i></span>
        </li>
        <?php if(in_array('featured',$showinfo)){ ?>	
          <li class="sesbasic_clearfix <?php echo ($enableModules['page_featured']) ? 'yes' : 'no'; ?>">
              <span class="_label">Featured</span>
            <span class="_value"><i class="_icon <?php echo ($enableModules['page_featured']) ? '_yes' : '_no'; ?>"></i></span>
          </li>
        <?php } ?>
        <?php if(in_array('sponsored',$showinfo)){ ?>  
          <li class="sesbasic_clearfix <?php echo ($enableModules['page_sponsored']) ? 'yes' : 'no'; ?>">
              <span class="_label">Sponsored</span>
               <span class="_value"><i class="_icon <?php echo ($enableModules['page_sponsored']) ? '_yes' : '_no'; ?>"></i></span>
          </li>
        <?php } ?>
        <?php if(in_array('verified',$showinfo)){ ?>  
          <li class="sesbasic_clearfix <?php echo ($enableModules['page_verified']) ? 'yes' : 'no'; ?>">
              <span class="_label">Verified</span>
              <span class="_value"><i class="_icon <?php echo ($enableModules['page_verified']) ? '_yes' : '_no'; ?>"></i></span>
          </li>
        <?php } ?>
        <?php if(in_array('hot',$showinfo)){ ?>  
          <li class="sesbasic_clearfix <?php echo ($enableModules['page_hot']) ? 'yes' : 'no'; ?>">
              <span class="_label">Hot</span>
              <span class="_value"><i class="_icon <?php echo ($enableModules['page_hot']) ? '_yes' : '_no'; ?>"></i></span>
          </li>
        <?php } ?>
        <li class="sesbasic_clearfix">
          <span class="_label"><?php echo $this->translate('Background Photo');?></span>
          <span class="_value"><i class="_icon <?php echo ($enableModules['page_bgphoto']) ? '_yes' : '_no'; ?>"></i></span>
        </li>
        <li class="sesbasic_clearfix">
          <span class="_label"><?php echo $this->translate('Main Photo');?></span>
          <span class="_value"><i class="_icon <?php echo ($enableModules['upload_mainphoto']) ? '_yes' : '_no'; ?>"></i></span>
        </li>
        <li class="sesbasic_clearfix">
          <span class="_label"><?php echo $this->translate('Cover Photo');?></span>
          <span class="_value"><i class="_icon <?php echo ($enableModules['upload_cover']) ? '_yes' : '_no'; ?>"></i></span>
        </li>
        <li class="sesbasic_clearfix">
          <span class="_label"><?php echo $this->translate('Select Design Layout');?></span>
          <span class="_value"><i class="_icon <?php echo ($enableModules['page_choose_style']) ? '_yes' : '_no'; ?>"></i></span>
        </li>
      </ul>
      <?php if(in_array('description',$showinfo)){ ?> 
        <p class="package_des"><?php echo $this->translate($package->description); ?> </p>
      <?php } ?>
    </div>
    <div class="_btn">
      <?php if($existing):?>
        <a class="sespage_packages_create_btn sesbasic_animation" href="<?php echo $this->url(array('action' => 'create', 'existing_package_id' => $packageleft->getIdentity()),'sespage_general',true); ?>"><?php echo $this->translate('Create Page');?></a>
      <?php else:?>
        <a class="sespage_packages_create_btn sesbasic_animation" href="<?php echo $this->url(array('action' => 'create', 'package_id' => $package->package_id),'sespage_general',true); ?>"><?php echo $this->translate('Create Page');?></a>
      <?php endif;?>
    </div>
  </section>
 </li>   