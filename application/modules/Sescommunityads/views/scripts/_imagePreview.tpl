<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescommunityads
 * @package    Sescommunityads
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _imagePreview.tpl  2018-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<div class="sescmads_create_preview sescmads_create_preview_image" style="display:none;">
  <div class="preview_header sesbasic_clearfix">
    <div class="_img sescommunity_preview_sub_image _image_image" style="display:none;"> 
      <a href="javascript:;">
        <?php if(!empty($this->ad) && $this->ad->type == "promote_website_cnt"){
          $image = Engine_Api::_()->getItem('storage_file',$this->ad->website_image);
          $imageSrc = "";
          if($image)
            $imageSrc = $image->map();  
          
        } ?>
        <img src="<?php echo !empty($this->ad) && $this->ad->resources_type ? $this->ad->description : ($imageSrc ? $imageSrc : "application/modules/Sescommunityads/externals/images/transprant-bg.png"); ?>" class="thumb_icon _preview_content_img">
      </a> 
    </div>
    <div class="_cont">
      <div class="preview_title"><a href="javascript:;"><?php echo !empty($this->ad) && ($this->ad->resources_type || $this->ad->type == "promote_website_cnt") ? $this->ad->title : ""; ?></a></div>
      <?php if($this->package->sponsored || $this->package->featured){ ?>
      <div class="_txt sesbasic_text_light sescommunity_sponsored" style="display:none;">
        <?php echo $this->package->sponsored ? $this->translate('Sponsored') : ($this->package->featured ? $this->translate('Featured') : ""); ?>
      </div>
      <?php } ?>
    </div>
    <div class="_optionbtn"><i class="sesbasic_text_light fa fa-angle-down"></i></div>
  </div>
  <?php if(empty($this->ad) || !count($this->attachment)){ ?>
  <div class="sescmads_create_preview_item">
    <div class="_img sescomm_img"> 
      <a href="javascript:;">
        <img src="application/modules/Sescommunityads/externals/images/transprant-bg.png" data-original="application/modules/Sescommunityads/externals/images/transprant-bg.png" />
      </a> 
      <span class="_badge sescommunity_badge" style="display:none;"></span> 
    </div>
    <div class="_cont">
      <div class="_details">
        <div class="_url sesbasic_text_light _preview_url"></div>
        <div class="_headline _preview_title"></div>
        <div class="_des _preview_des"></div>
      </div>
      <div class="_button sescomm_call_to_action" style="display:none;">
        <a href="javascript:;" class="sesbasic_button"></a>
      </div>
      <a href="javascript:;" class="_link"></a> 
    </div>
  </div>
  <?php }else{ ?>
  <div class="sescmads_create_preview_item">
    <?php 
      $counter = 1;
      foreach($this->attachment as $attachment){ 
      $image = Engine_Api::_()->getItem('storage_file',$attachment->file_id);
            $imageSrc = "application/modules/Sescommunityads/externals/images/transprant-bg.png";
            if($image)
              $imageSrc = $image->map();
      ?>
    <div class="_img sescomm_img"> 
      <a href="javascript:;">
        <img src="<?php echo $imageSrc; ?>" data-original="" />
      </a> 
      <span class="_badge sescommunity_badge" style="display:none;"></span> 
    </div>
    <div class="_cont">
      <div class="_details">
        <div class="_url sesbasic_text_light _preview_url">
        <?php  
          if($this->ad->type == "promote_website_cnt"){
             $description = $this->ad->description;
             $description = str_replace('http://','',$description);
             $description = str_replace('https://','',$description);
             $description = explode('/',$description);
             echo $description[0];
          } 
        ?>
        </div>
        <div class="_headline _preview_title"><?php echo $attachment->title; ?></div>
        <div class="_des _preview_des"><?php echo $attachment->description; ?></div>
      </div>
      <div class="_button sescomm_call_to_action" style="display:<?php echo $this->ad->calltoaction ? 'block' : 'none;' ?>;">
          <a href="javascript:;" class="sesbasic_button"><?php echo $this->translate(ucwords(str_replace('_',' ',$this->ad->calltoaction ? $this->ad->calltoaction : ""))); ?></a>
        </div>
      <a href="javascript:;" class="_link"></a> 
    </div>
    <?php } ?>
  </div>
  <?php } ?>
</div>
