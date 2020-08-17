<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesjob/externals/styles/styles.css'); ?>
<div class="sesjob_job_of_the_day">
  <ul class="sesjob_album_listing sesbasic_bxs">
    <?php $limit = 0;?>
    <?php $item = Engine_Api::_()->getItem('sesjob_job',$this->job_id);?>
    <?php if($item):?>
      <li class="sesjob_grid sesjob_list_grid_thumb sesbasic_bg sesjob_list_grid sesa-i-<?php echo (isset($this->insideOutside) && $this->insideOutside == 'outside') ? 'outside' : 'inside'; ?> sesa-i-<?php echo (isset($this->fixHover) && $this->fixHover == 'fix') ? 'fix' : 'over'; ?> sesbm" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
        <div class="sesjob_grid_inner sesjob_thumb">
          <div class="sesjob_grid_thumb sesjob_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;"> <a class="sesjob_thumb_img" href="<?php echo $item->getHref(); ?>"> <span class="main_image_container" style="background-image: url(<?php echo $item->getPhotoUrl('thumb.normal'); ?>);"></span> </a>
            <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)){ ?>
              <div class="sesjob_grid_labels">
                <?php if(isset($this->featuredLabelActive) && $item->featured == 1){ ?>
                  <p class="sesjob_label_featured" title="Featured"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
                <?php } ?>
                <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
                  <p class="sesjob_label_sponsored" title="Sponsored"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
                <?php endif;?>
                <?php if(isset($this->hotLabelActive) && $item->hot == 1):?>
                  <p class="sesjob_label_hot" title="Hot"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
                <?php endif;?>
              </div>
              <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
                <div class="sesjob_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
              <?php endif;?>
            <?php } ?>
          </div>
          <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->titleActive) || isset($this->favouriteActive) || isset($this->byActive)){ ?>
            <div class="sesjob_grid_info clear sesbasic_clearfix sesbm">
              <?php if(isset($this->titleActive)) { ?>
                <div class="sesjob_grid_info_title"> <?php echo $this->htmlLink($item, $this->string()->truncate($item->getTitle(), $this->title_truncation),array('title'=>$item->getTitle())) ; ?> </div>
              <?php } ?>
                <div class="sesjob_grid_Comp">
                  <span>
                    <?php include APPLICATION_PATH .  '/application/modules/Sesjob/views/scripts/_company_industry.tpl';?>
                    </span>
                </div>  
              <div class="sesjob_list_grid_info sesbasic_clearfix">
                <div class="sesjob_list_stats">
                  <?php if(isset($this->byActive)) { ?>
                    <span class="sesjob_list_grid_owner"> <a href="<?php echo $item->getOwner()->getHref();?>"><?php echo $this->itemPhoto($item->getOwner(), 'thumb.icon');?></a> <?php echo $this->translate('By');?> <?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?> </span>
                  <?php }?>
                </div>
                <div class="sesjob_list_stats sesjob_list_location sesbasic_text_light"> <span> <i class="fa fa-map-marker"></i><a href="<?php echo $this->url(array('resource_id' => $item->job_id,'resource_type'=>'sesjob_job','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl"><?php echo $item->location;?></a></span> </div>
              </div>
            </div>
          <?php } ?>
          <div class="sesjob_grid_hover_block">
            <div class="sesjob_grid_hover_block_footer">
              <div class="sesjob_list_stats sesbasic_text_light">
                <?php if(isset($this->likeActive)) { ?>
                  <span class="sesjob_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count))?>"> <i class="fa fa-thumbs-up"></i> <?php echo $item->like_count;?> </span>
                <?php } ?>
                <?php if(isset($this->commentActive)) { ?>
                  <span class="sesjob_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"> <i class="fa fa-comment"></i> <?php echo $item->comment_count;?> </span>
                <?php } ?>
                <?php if(isset($this->viewActive)) { ?>
                  <span class="sesjob_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"> <i class="fa fa-eye"></i> <?php echo $item->view_count;?> </span>
                <?php } ?>
                <?php if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.favourite', 1)) { ?>
                  <span class="sesjob_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"> <i class="fa fa-heart"></i> <?php echo $item->favourite_count;?> </span>
                <?php } ?>
              </div>
            </div>
          </div>
              <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
            <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
            <div class="sesjob_list_grid_thumb_btns"> 
              <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.sharing', 1)):?>
              
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
              <?php endif;?>
              <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
                <?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
                <?php if(isset($this->likeButtonActive) && $canComment):?>
                  <!--Like Button-->
                  <?php $LikeStatus = Engine_Api::_()->sesjob()->getLikeStatus($item->job_id,$item->getType()); ?>
                  <a href="javascript:;" data-url="<?php echo $item->job_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesjob_like_sesjob_job_<?php echo $item->job_id ?> sesjob_like_sesjob_job <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
                <?php endif;?>
                <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.favourite', 1)): ?>
                  <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesjob')->isFavourite(array('resource_type'=>'sesjob_job','resource_id'=>$item->job_id)); ?>
                  <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesjob_favourite_sesjob_job_<?php echo $item->job_id ?> sesjob_favourite_sesjob_job <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->job_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
                <?php endif;?>
              <?php endif;?>
            </div>
          <?php endif;?> 
          </div>
      </li>
    <?php endif;?>
    <?php $limit++;?>
  </ul>
</div>
