<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Edocument/externals/styles/styles.css'); ?>
<div class="edocument_of_the_day">
  <ul class="edocument_album_listing sesbasic_bxs">
    <?php $itemDocument = Engine_Api::_()->getItem('edocument',$this->edocument_id);?>
    <?php if($itemDocument):?>
      <li class="edocument_grid edocument_list_grid_thumb edocument_list_grid sesa-i-<?php echo (isset($this->insideOutside) && $this->insideOutside == 'outside') ? 'outside' : 'inside'; ?> sesa-i-<?php echo (isset($this->fixHover) && $this->fixHover == 'fix') ? 'fix' : 'over'; ?> sesbm" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
        <div class="edocument_grid_inner edocument_thumb">
          <div class="edocument_grid_thumb edocument_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;"> <a class="edocument_thumb_img" href="<?php echo $itemDocument->getHref(); ?>"> <span class="main_image_container" style="background-image: url(<?php echo $itemDocument->getPhotoUrl('thumb.normal'); ?>);"></span> </a>
            <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)){ ?>
              <div class="edocument_grid_labels">
                <?php if(isset($this->featuredLabelActive) && $itemDocument->featured == 1){ ?>
                  <p class="edocument_label_featured"><?php echo $this->translate("Featured"); ?></p>
                <?php } ?>
                <?php if(isset($this->sponsoredLabelActive)  && $itemDocument->sponsored == 1){ ?>
                  <p class="edocument_label_sponsored"><?php echo $this->translate("Sponsored"); ?></p>
                <?php } ?>
              </div>
              <?php if(isset($this->verifiedLabelActive) && $itemDocument->verified == 1):?>
                <div class="edocument_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
              <?php endif;?>
            <?php } ?>
          </div>
          <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->titleActive) || isset($this->favouriteActive) || isset($this->byActive)){ ?>
            <div class="edocument_grid_info clear sesbasic_clearfix sesbm">
              <?php if(isset($this->titleActive)) { ?>
                <div class="edocument_grid_info_title"> <?php echo $this->htmlLink($itemDocument, $this->string()->truncate($itemDocument->getTitle(), $this->title_truncation),array('title'=>$itemDocument->getTitle())) ; ?> </div>
              <?php } ?>
              <div class="edocument_list_grid_info sesbasic_clearfix">
                <div class="edocument_list_stats">
                  <?php if(isset($this->byActive)) { ?>
                    <span class="edocument_list_grid_owner"> <a href="<?php echo $itemDocument->getOwner()->getHref();?>"><?php echo $this->itemPhoto($itemDocument->getOwner(), 'thumb.icon');?></a> <?php echo $this->translate('By');?> <?php echo $this->htmlLink($itemDocument->getOwner()->getHref(), $itemDocument->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?> </span>
                  <?php }?>
                </div>
                <div class="edocument_list_stats edocument_list_location sesbasic_text_light"> <span> <i class="fa fa-map-marker"></i><a href="<?php echo $this->url(array('resource_id' => $itemDocument->edocument_id,'resource_type'=>'edocument','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl"><?php echo $itemDocument->location;?></a></span> </div>
              </div>
            </div>
          <?php } ?>
          <div class="edocument_grid_hover_block">
            <div class="edocument_grid_info_hover_title"> 
              <?php echo $this->htmlLink($itemDocument, $this->string()->truncate($itemDocument->getTitle(), $this->title_truncation),array('title'=>$itemDocument->getTitle())) ; ?> <span></span> 
            </div>
            <div class="edocument_grid_des clear"><?php echo $itemDocument->getDescription($this->description_truncation);?></div>
            <div class="edocument_grid_hover_block_footer">
              <div class="edocument_list_stats sesbasic_text_light">
                <?php if(isset($this->likeActive)) { ?>
                  <span class="edocument_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $itemDocument->like_count), $this->locale()->toNumber($itemDocument->like_count))?>"> <i class="fa fa-thumbs-up"></i> <?php echo $itemDocument->like_count;?> </span>
                <?php } ?>
                <?php if(isset($this->commentActive)) { ?>
                  <span class="edocument_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $itemDocument->comment_count), $this->locale()->toNumber($itemDocument->comment_count))?>"> <i class="fa fa-comment"></i> <?php echo $itemDocument->comment_count;?> </span>
                <?php } ?>
                <?php if(isset($this->viewActive)) { ?>
                  <span class="edocument_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $itemDocument->view_count), $this->locale()->toNumber($itemDocument->view_count))?>"> <i class="fa fa-eye"></i> <?php echo $itemDocument->view_count;?> </span>
                <?php } ?>
                <?php if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.favourite', 1)) { ?>
                  <span class="edocument_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $itemDocument->favourite_count), $this->locale()->toNumber($itemDocument->favourite_count))?>"> <i class="fa fa-heart"></i> <?php echo $itemDocument->favourite_count;?> </span>
                <?php } ?>
                <?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('edocument_review', 'view') && isset($this->ratingActive) && isset($itemDocument->rating)): ?>
                  <span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($itemDocument->rating,1)), $this->locale()->toNumber(round($itemDocument->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($itemDocument->rating,1).'/5';?></span>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
            <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $itemDocument->getHref()); ?>
            <div class="edocument_list_grid_thumb_btns"> 
              <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.sharing', 1)):?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $itemDocument, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
              <?php endif;?>
              <?php if($this->viewer->getIdentity() != 0 ):?>
                <?php $canComment =  $itemDocument->authorization()->isAllowed($this->viewer, 'comment');?>
                <?php if(isset($this->likeButtonActive) && $canComment):?>
                  <!--Like Button-->
                  <?php $LikeStatus = Engine_Api::_()->edocument()->getLikeStatus($itemDocument->edocument_id,$itemDocument->getType()); ?>
                  <a href="javascript:;" data-url="<?php echo $itemDocument->edocument_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn edocument_like_edocument_<?php echo $itemDocument->edocument_id ?> edocument_like_edocument <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $itemDocument->like_count; ?></span></a>
                <?php endif;?>
                <?php if(isset($this->favouriteButtonActive) && isset($itemDocument->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.favourite', 1)): ?>
                  <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'edocument')->isFavourite(array('resource_type'=>'edocument','resource_id'=>$itemDocument->edocument_id)); ?>
                  <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn edocument_favourite_edocument_<?php echo $itemDocument->edocument_id ?> edocument_favourite_edocument <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $itemDocument->edocument_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $itemDocument->favourite_count; ?></span></a>
                <?php endif;?>
              <?php endif;?>
            </div>
          <?php endif;?> 
          </div>
      </li>
    <?php endif;?>
  </ul>
</div>
