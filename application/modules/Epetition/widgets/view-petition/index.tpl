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
<?php $allParam = $this->allParams;   ?>
<?php  $allParamCriteria= isset($allParam['show_criteria']) ?  $allParam['show_criteria'] : array(); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/scripts/core.js');?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/styles/styles_profile.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/styles/styles.css'); ?>
<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $this->epetition->getHref()); ?>
<?php $canComment = $this->epetition->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment'); ?>
<?php $LikeStatus = Engine_Api::_()->epetition()->getLikeStatus($this->epetition->epetition_id, $this->epetition->getType()); ?>
<?php $likeClass = (!$LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down'; ?>
<?php $likeText = ($LikeStatus) ? $this->translate('Unlike') : $this->translate('Like'); ?>
<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'epetition')->isFavourite(array('resource_type' => 'epetition', 'resource_id' => $this->epetition->epetition_id)); ?>
<?php $isAllowSignature = Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.allow.signature', 1); ?>
<?php $enableSharng = Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.sharing', 1); ?>

<div class="epetition_profile_main_container sesbasic_bxs">
  <?php // if ($this->epetition->photo_id):    ?>
      <div class="epetition_profile_main_photo">
          <img src="<?php echo $this->epetition->getPhotoUrl('thumb.normal'); ?>"
               alt="">
      </div>
  <?php //endif; ?>
    <div class="epetition_profile_main_content">
      <?php if (in_array("title",$allParamCriteria)): ?>
          <h1 class="sesbasic_text_hl"><?php echo $this->translate($this->epetition->getTitle()); ?></h1>
      <?php endif; ?>
      <?php if (isset($this->epetition->body) && in_array("shortDescription", $allParamCriteria)): ?>
          <p class="epetition_profile_main_des"><?php echo $this->translate($this->epetition->body); ?></p>
      <?php endif; ?>
    </div>
  <?php $user = Engine_Api::_()->getItem('user', $this->epetition->owner_id); ?>
    <div class="epetition_profile_main_info">
        <div class="epetition_profile_main_owner">
            <div class="_thumb">
              <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon', $user->getTitle())); ?>
            </div>
            <div class="_info">
                <div class="_name"><?php echo $this->htmlLink($user->getHref(), $user->getTitle()); ?></div>
                <div class="_stats">
                    <p class="sesbasic_text_light">
                      <?php if (in_array("view",$allParamCriteria)): ?>
                          <span title="0 likes"><i
                                      class="sesbasic_icon_like_o"></i><span><?php echo $this->translate(array('%s View', '%s Views', $this->epetition->view_count), $this->locale()->toNumber($this->epetition->view_count)); ?></span></span>
                      <?php endif; ?>
                      <?php if (in_array("comment",$allParamCriteria)): ?>
                          <span title="0 comments"><i
                                      class="sesbasic_icon_comment_o"></i><span><?php echo $this->translate(array('%s Comment', '%s Comments', $this->epetition->comment_count), $this->locale()->toNumber($this->epetition->comment_count)); ?></span></span>
                      <?php endif; ?>
                      <?php if (in_array("like",$allParamCriteria)): ?>
                          <span title="0 favourites"><i
                                      class="sesbasic_icon_favourite_o"></i><span><?php echo $this->translate(array('%s Like', '%s Likes', $this->epetition->like_count), $this->locale()->toNumber($this->epetition->like_count)); ?></span></span>
                      <?php endif; ?>
                        <!-- <span title="0 views"><i class="sesbasic_icon_view"></i><span>0</span></span>  -->
                    </p>
                </div>
            </div>
        </div>
        <div class="epetition_profile_main_buttons">
          <?php if ($this->viewer_id): ?>
            <?php if (in_array("likeButton", $allParamCriteria) && $canComment): ?>
                 <!-- <div><a href="javascript:" data-url="<?php /*echo $this->epetition->epetition_id; */?>" id="likehideshow"  class="sesbasic_icon_btn sesbasic_icon_like_btn  epetition_like_epetition_<?php /*echo $this->epetition->epetition_id */?> epetition_like_epetition_view <?php /*echo ($LikeStatus) ? 'button_active' : ''; */?>"><i class="fa <?php /*echo $likeClass; */?>"></i><span><?php /*echo $this->translate($likeText); */?></span></a></div>-->
                  <div><a href="javascript:" data-url="<?php echo $this->epetition->epetition_id; ?>" id="likehideshow" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn epetition_like_epetition_<?php echo $this->epetition->epetition_id; ?> epetition_like_epetition" ><i class="fa <?php echo $likeClass; ?>"></i><span><?php echo $this->epetition->like_count; ?></span></a></div>
            <?php endif; ?>
            <?php if (in_array("favouriteButton",$allParamCriteria) && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.favourite', 1)): ?>
                  <div><a href="javascript:" data-url="<?php echo $this->epetition->epetition_id; ?>" id="favhideshow"
                          class="sesbasic_icon_btn sesbasic_icon_fav_btn  epetition_favourite_epetition_<?php echo $this->epetition->epetition_id ?> epetition_favourite_epetition_view <?php echo ($favStatus) ? 'button_active' : ''; ?>"><i
                                  class="fa fa-heart"></i><span><?php if ($favStatus): ?><?php echo $this->translate('Un-Favourite'); ?><?php else: ?><?php echo $this->translate('Favourite'); ?><?php endif; ?></span></a>
                  </div>
            <?php endif; ?>
          <?php endif; ?>
          <?php if ($this->viewer_id && $enableSharng && in_array("socialShare", $allParamCriteria) && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.share.pet',1)) { ?>
            <div class="epetition_list_share_wrap">
                <a href="javascript:" class="sesbasic_icon_btn epetition_button_toggle"><i
                            class="sesbasic_icon_share"></i></a>
                <div class="epetition_listing_share_box sesbasic_bg">
                    <div class="_head centerT">Share This Petition</div>
                    <div class="_btns centerT">
                          <a href="<?php echo $this->url(array("module" => "activity", "controller" => "index", "action" => "share", "type" => $this->epetition->getType(), "id" => $this->epetition->getIdentity(), "format" => "smoothbox"), 'default', true); ?>"
                             class="share_icon sesbasic_icon_btn smoothbox"><i
                                      class="sesbasic_icon_share"></i><span><?php echo $this->translate('Share'); ?></span></a>
                        <?php echo $this->partial('_socialShareIcons.tpl', 'sesbasic', array('resource' => $this->epetition, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
                    </div>
                </div>
            </div>
            <?php  } ?>
            <div class="epetion_profile_gutter">
              <a href="javascript:" class="sesbasic_icon_btn sesbasic_pulldown_toggle"><i
                            class="fa fa-cog"></i></a>
               <div class="sesbasic_pulldown_options">
                  <?php echo $this->content()->renderWidget("epetition.gutter-menu"); ?>
               </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    sesJqueryObject(function(){
        sesJqueryObject('#likehideshow').hover(function(){
            sesJqueryObject(this).text(<?php echo $this->epetition->like_count; ?>);
        }, function(){
            sesJqueryObject(this).html('<i class="fa <?php echo $likeClass; ?>"></i><span><?php echo $this->translate($likeText); ?></span>');

        });
    });

    sesJqueryObject(function(){
        sesJqueryObject('#favhideshow').hover(function(){
            sesJqueryObject(this).text(<?php echo $this->epetition->favourite_count; ?>);
        }, function(){
            sesJqueryObject(this).html('<i class="fa fa-heart"></i><span><?php if ($favStatus): ?><?php echo $this->translate("Un-Favourite"); ?><?php else: ?><?php echo $this->translate("Favourite"); ?><?php endif; ?></span>');

        });
    });
</script>