<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: slideshow.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 s
 ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sesproduct', array('product' => $this->product));	
?>
<div class="estore_dashboard_content sesbm sesbasic_clearfix">
  <?php } ?>
  <div class="estore_dashboard_form">
    <div class="sesbasic_profile_tabs_top sesbasic_clearfix">
       <a href="<?php echo $this->url(array('product_id' => $this->product->custom_url,'action'=>'create-slide'), 'sesproduct_dashboard', true); ?>" class="sesbasic_button"><i class="fa fa-plus"></i><?php echo $this->translate(" Add New Slide"); ?></a>        
    </div>
    <?php if(count($this->paginator)){ ?>
    <div class="sesproduct_search_result sesbasic_clearfix sesbm" id="paginator_count_sesproduct">
      <span id="total_item_count_sesproduct"> 
        <?php echo $this->translate(array('%s slide found', '%s slides found', count($this->paginator)),$this->locale()->toNumber(count($this->paginator))) ?>
      </span>
    </div>
    <form action="<?php echo $this->escape($this->form->getAction()) ?>" name="editPhotos" method="<?php echo $this->escape($this->form->getMethod()) ?>">
      <ul class='sesproduct_manage_photos'>
        <?php foreach( $this->paginator as $photo ): ?>
        <li class="sesproduct_manage_photos_list" id="thumbs-photo-<?php echo $photo->getIdentity() ?>">
          <div class="sesbasic_clearfix sesbm">
              <div class="sesproduct_manage_photos_list_photo">
                <?php $url = $photo->getPhotoUrl('thumb.normalmain'); ?>
                <span style="background-image:url(<?php echo $url ?>);"></span> 
              </div>
              <div class="sesproduct_manage_photos_list_info">
                <?php $key = $photo->getGuid();
                  echo $this->form->getSubForm($key)->render($this);
                ?>
              </div>
          </div>
        </li>
        <?php endforeach; ?>
      </ul>
      <?php if(count($this->paginator)){ ?>
      <?php echo $this->form->submit->render(); ?>
      <?php } ?>
    </form>
    <?php }else{ ?>
    <div class="tip">
      <span><?php echo $this->translate("No slides created by you yet."); ?></span>
    </div>
    <?php } ?>
    <?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
