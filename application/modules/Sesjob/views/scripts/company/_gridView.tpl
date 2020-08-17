<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _gridView.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<li class="sesjob_grid sesbasic_bxs <?php if((isset($this->my_jobs) && $this->my_jobs)){ ?>isoptions<?php } ?>" style="width:<?php echo is_numeric($this->width_grid) ? $this->width_grid.'px' : $this->width_grid ?>;">
  <div class="sesjob_grid_inner sesjob_thumb">
    <div class="sesjob_grid_thumb" style="height:<?php echo is_numeric($this->height_grid) ? $this->height_grid.'px' : $this->height_grid ?>;width:<?php echo is_numeric($this->width_grid_photo) ? $this->width_grid_photo.'px' : $this->width_grid_photo ?>">
      <?php $href = $item->getHref();$imageURL = $photoPath;?>
      <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="sesjob_thumb_img"> <span style="background-image:url(<?php echo $imageURL; ?>);"></span> </a>
      <?php if(isset($this->categoryActive)){ ?>
        <?php if($item->industry_id != '' && intval($item->industry_id) && !is_null($item->industry_id)):?>
          <?php $industryItem = Engine_Api::_()->getItem('sesjob_industry', $item->industry_id);?>
          <?php if($industryItem):?>
            <div class="sesjob_grid_memta_title">
              <?php if($industryItem):?>
                <span><?php echo $industryItem->industry_name; ?></span>
              <?php endif;?>
            </div>
          <?php endif;?>
        <?php endif;?>
      <?php } ?>
      <?php if(isset($this->descriptiongridActive)){ ?>
        <p class="sesjob_list_des">
          <?php echo nl2br( Engine_String::strlen($item->company_description) > $this->description_truncation_grid ? Engine_String::substr($item->company_description, 0, $this->description_truncation_grid) . '...' : $item->company_description); ?>
        </p>
      <?php } ?>
    </div>
    <div class="sesjob_grid_info clear clearfix sesbm">
      <?php if(isset($this->titleActive) ){ ?>
      <div class="sesjob_grid_info_title">
        <?php if(strlen($item->company_name) > $this->title_truncation_grid):?>
        <?php $title = mb_substr($item->company_name,0,$this->title_truncation_grid).'...';?>
        <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->company_name) ) ?>
        <?php else: ?>
        <?php echo $this->htmlLink($item->getHref(),$item->company_name,array('title'=>$item->company_name)  ) ?>
        <?php endif; ?>
      </div>
      <?php } ?>
      <div class="sesjob_grid_hover_block_footer">
        <?php if(isset($this->subscribecountActive) && isset($item->subscribe_count)) { ?>
          <span title="<?php echo $this->translate(array('%s subscriber', '%s subscribers', $item->subscribe_count), $this->locale()->toNumber($item->subscribe_count)); ?>"><i class="fa fa-check-square-o"></i><?php echo $item->subscribe_count; ?></span>
        <?php } ?>
        <?php if(isset($this->jobcountActive) && isset($item->job_count)) { ?>
          <span title="<?php echo $this->translate(array('%s job', '%s jobs', $item->job_count), $this->locale()->toNumber($item->job_count)); ?>"><i class="fa fa-briefcase"></i><?php echo $item->job_count; ?></span>
        <?php } ?>
      </div>
       <?php if(isset($this->descriptionlistActive)){ ?>
        <p class="sesjob_list_des  sesbasic_text_light">
          <?php echo nl2br( Engine_String::strlen($item->company_description) > $this->description_truncation_list ? Engine_String::substr($item->company_description, 0, $this->description_truncation_list) . '...' : $item->company_description); ?>
        </p>
      <?php } ?>      
    </div>
    <div class="sesjob_grid_owner sesbasic_clearfix">
     <div class="sesjob_list_stats sesbasic_text_light"> 
     <?php if(isset($this->byActive)){ ?>
       <span>
          <?php $owner = $item->getOwner(); ?>
          <?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?> <?php echo $this->translate("Posted by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?></span> 
        <?php } ?>
        <?php if(isset($this->creationDateActive)): ?>
       <span>on <?php echo date('M d, Y',strtotime($item->creation_date));?></span> 
        <?php endif;?>
        </div>
    </div>
    <div class="sesjob_grid_hover_block">
       <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.sharing', 1))):?>
    <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
    <div class="sesjob_list_thumb_over"> <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
      <div class="sesjob_list_grid_thumb_btns">
        <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.sharing', 1)):?>
          <?php if($this->socialshare_icon_limit): ?>
            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
          <?php else: ?>
            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_gridview1plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_gridview1limit)); ?>
          <?php endif; ?>
        <?php endif;?>
      </div>
    </div>
    <?php endif;?>
    </div>
  </div>
</li>
