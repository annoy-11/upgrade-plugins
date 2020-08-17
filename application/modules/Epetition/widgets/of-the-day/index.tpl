<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/styles/styles.css'); ?>

<div class="epetition_of_the_day">
  <ul class="epetition_album_listing sesbasic_bxs">
    <?php $limit = 0;   ?>
    <?php $itemPetition = Engine_Api::_()->getItem('epetition',$this->epetition_id);    ?>
    <?php if($itemPetition):?>
      <li class="epetition_sidebar_grid epetition_list_grid_thumb epetition_list_grid sesa-i-<?php echo (isset($this->insideOutside) && $this->insideOutside == 'outside') ? 'outside' : 'inside'; ?> sesa-i-<?php echo (isset($this->fixHover) && $this->fixHover == 'fix') ? 'fix' : 'over'; ?> sesbm" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
        <div class="epetition_grid_inner epetition_thumb">
          <div class="epetition_grid_thumb epetition_listing_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;"> <a class="epetition_thumb_img" href="<?php echo $itemPetition->getHref(); ?>"> <span class="main_image_container" style="background-image: url(<?php echo $itemPetition->getPhotoUrl('thumb.normal'); ?>);"></span> </a>
            <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)){ ?>
              <div class="epetition_listing_label">
                <?php if(isset($this->featuredLabelActive) && $itemPetition->featured == 1){ ?>
                  <p class="epetition_label_featured"><?php echo $this->translate("Featured"); ?></p>
                <?php } ?>
                <?php if(isset($this->sponsoredLabelActive)  && $itemPetition->sponsored == 1){ ?>
                  <p class="epetition_label_sponsored"><?php echo $this->translate("Sponsored"); ?></p>
                <?php } ?>
                <?php if(isset($this->verifiedLabelActive) && $itemPetition->verified == 1):?>
                <p class="epetition_label_verified"><?php echo $this->translate('Verified');?></p>
              <?php endif;?>
              </div>
              
            <?php } ?>
          </div>
          <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->titleActive) || isset($this->favouriteActive) || isset($this->byActive)){ ?>
            <div class="epetition_grid_info clear sesbasic_clearfix sesbm">
              <?php if(isset($this->titleActive)) { ?>
                <div class="epetition_grid_info_title"> <?php echo $this->htmlLink($itemPetition, $this->string()->truncate($itemPetition->getTitle(), $this->title_truncation),array('title'=>$itemPetition->getTitle())) ; ?> </div>
              <?php } ?>
              <div class="epetition_list_grid_info sesbasic_clearfix">
                <div class="epetition_admin">
                  <?php if(isset($this->byActive)) { ?>
                    <span class="epetition_list_grid_owner"> <a href="<?php echo $itemPetition->getOwner()->getHref();?>"><?php echo $this->itemPhoto($itemPetition->getOwner(), 'thumb.icon');?></a> <?php echo $this->translate('By');?> <?php echo $this->htmlLink($itemPetition->getOwner()->getHref(), $itemPetition->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?> </span>
                  <?php }?>
                </div>
              </div>
          <?php } ?>
            <div>
              <div class="epetition_list_stats sesbasic_text_light">
                <?php if(isset($this->likeActive)) { ?>
                  <span class="epetition_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $itemPetition->like_count), $this->locale()->toNumber($itemPetition->like_count))?>"> <i class="sesbasic_icon_like_o"></i> <?php echo $itemPetition->like_count;?> </span>
                <?php } ?>
                <?php if(isset($this->commentActive)) { ?>
                  <span class="epetition_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $itemPetition->comment_count), $this->locale()->toNumber($itemPetition->comment_count))?>"> <i class="sesbasic_icon_comment_o"></i> <?php echo $itemPetition->comment_count;?> </span>
                <?php } ?>
                <?php if(isset($this->viewActive)) { ?>
                  <span class="epetition_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $itemPetition->view_count), $this->locale()->toNumber($itemPetition->view_count))?>"> <i class="sesbasic_icon_view"></i> <?php echo $itemPetition->view_count;?> </span>
                <?php } ?>
                <?php if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.favourite', 1)) { ?>
                  <span class="epetition_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $itemPetition->favourite_count), $this->locale()->toNumber($itemPetition->favourite_count))?>"> <i class="sesbasic_icon_favourite_o"></i> <?php echo $itemPetition->favourite_count;?> </span>
                <?php } ?>
                <?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('epetition_signature', 'view') && isset($this->ratingActive) && isset($itemPetition->rating)): ?>
                  <span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($itemPetition->rating,1)), $this->locale()->toNumber(round($itemPetition->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($itemPetition->rating,1).'/5';?></span>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
            <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $itemPetition->getHref()); ?>
            <div class="epetition_list_grid_thumb_btns"> 
              <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.sharing', 1)):?>
              
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $itemPetition, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
              <?php endif;?>
              <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
                <?php $canComment =  $itemPetition->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
                <?php if(isset($this->likeButtonActive) && $canComment):?>
                  <!--Like Button-->
                  <?php $LikeStatus = Engine_Api::_()->epetition()->getLikeStatus($itemPetition->epetition_id,$itemPetition->getType()); ?>
                  <a href="javascript:;" data-url="<?php echo $itemPetition->epetition_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn epetition_like_epetition_<?php echo $itemPetition->epetition_id ?> epetition_like_epetition <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $itemPetition->like_count; ?></span></a>
                <?php endif;?>
                <?php if(isset($this->favouriteButtonActive) && isset($itemPetition->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.favourite', 1)): ?>
                  <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'epetition')->isFavourite(array('resource_type'=>'epetition','resource_id'=>$itemPetition->epetition_id)); ?>
                  <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn epetition_favourite_epetition_<?php echo $itemPetition->epetition_id ?> epetition_favourite_epetition <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $itemPetition->epetition_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $itemPetition->favourite_count; ?></span></a>
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
