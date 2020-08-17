<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesprayer/externals/styles/styles.css'); ?>
<ul class="sesprayers_other_listing prelative sesprayers_listing sesbasic_bxs">
  <?php foreach( $this->prayers as $item ): ?>
    <li class="sesbasic_clearfix sesprayers_list_item">
      <section>
        <header class="sesbasic_clearfix">
          <div class="_owner_thumb">
            <?php echo $this->htmlLink($item->getOwner()->getHref(), $this->itemPhoto($item->getOwner(), 'thumb.icon', $item->getOwner()->getTitle())) ?>
          </div>
          <div class="_owner_info">
            <?php if(in_array('postedby', $this->allParams['information'])) { ?>
              <div class="_owner_name"><?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle()) ?></div>
            <?php } ?>
            <?php if(in_array('posteddate', $this->allParams['information'])) { ?>
              <div class="sesbasic_text_light _date"><?php echo $this->timestamp(strtotime($item->creation_date)) ?></div>
            <?php } ?>
          </div>
        </header>
        <div class="_content">
          <?php if($item->mediatype == 1 && !empty($item->photo_id)) { ?>
            <div class="sesprayer_img"><?php echo $this->itemPhoto($item, 'thumb.main') ?></div>
          <?php } else if($item->mediatype == 2 && $item->code) { ?>
            <div class="sesprayer_video"><?php echo $item->code; ?></div>
          <?php } ?>
          <?php if(in_array('title', $this->allParams['information']) && !empty($item->prayertitle)) { ?>
            <div class="sesprayer_title">  
              <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.show', 0)) { ?>
                <a href="<?php echo $item->getHref(); ?>"><?php echo $item->prayertitle; ?></a>
              <?php } else { ?>
                <a data-url='sesprayer/index/prayer-popup/prayer_id/<?php echo $item->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $item->prayertitle; ?></a>
              <?php } ?>
            </div>
          <?php } ?>
          <div class="sesprayer_prayer">
            <?php echo $this->string()->truncate($this->string()->stripTags($item->getTitle()), $this->allParams['description_truncation']) ?>
          </div>
          <div class="_stats sesbasic_text_light">
            <?php if(in_array('likeCount', $this->allParams['information'])) { ?>
              <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $item->like_count), $this->locale()->toNumber($item->like_count)) ?>">
                <i class="fa fa-thumbs-up"></i>
                <span><?php echo $this->locale()->toNumber($item->like_count) ?></span>
              </span>
            <?php } ?>
            <?php if(in_array('commentCount', $this->allParams['information'])) { ?>
              <span title="<?php echo $this->translate(array('%s Comment', '%s Comments', $item->comment_count), $this->locale()->toNumber($item->comment_count)) ?>">
                <i class="fa fa-comment"></i>
                <span><?php echo $this->locale()->toNumber($item->comment_count) ?></span>
              </span>
            <?php } ?>
            <?php if(in_array('viewCount', $this->allParams['information'])) { ?>
              <span title="<?php echo $this->translate(array('%s View', '%s Views', $item->view_count), $this->locale()->toNumber($item->view_count)) ?>">
                <i class="fa fa-eye"></i>
                <span><?php echo $this->locale()->toNumber($item->view_count) ?></span>
              </span>
            <?php } ?>
            <?php if(in_array('permalink', $this->allParams['information'])) { ?>
              <span>- 
                <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.show', 0)) { ?>
                  <a href="<?php echo $item->getHref(); ?>"><?php echo $this->translate('Read More'); ?></a>
                <?php } else { ?>
                  <a data-url='sesprayer/index/prayer-popup/prayer_id/<?php echo $item->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $this->translate('Read More'); ?></a>
                <?php } ?>
              </span>
            <?php } ?>
          </div>
        </div>
        <div class="_footer sesbasic_clearfix sesprayer_social_btns">
          <?php if(in_array('socialSharing', $this->allParams['information']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.allowshare', 1)):?>
            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->allParams['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $this->allParams['socialshare_icon_limit'])); ?>
          <?php endif;?>
          <?php $canComment = Engine_Api::_()->authorization()->isAllowed('sesprayer_prayer', $viewer, 'create');?>
          <?php if(in_array('likebutton', $this->allParams['information']) && $canComment):?>
            <?php $likeStatus = Engine_Api::_()->sesprayer()->getLikeStatus($item->prayer_id,$item->getType()); ?>
            <a href="javascript:;" data-type="like_view" data-url="<?php echo $item->prayer_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesprayer_like_<?php echo $item->prayer_id ?> sesprayer_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count;?></span></a>
          <?php endif;?>
        </div>
      </section>
    </li>
  <?php endforeach; ?>
</ul>