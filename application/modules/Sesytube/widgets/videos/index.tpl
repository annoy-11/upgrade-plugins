<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesytube_videos_block_wrapper sesbasic_bxs">
	<div class="sesytube_videos_container">
  	<?php foreach($this->results as $result) { ?>
      <div class="sesytube_videos_row">
        <div class="sesytube_videos_header clearfix">
          <div class="_left">
            <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesvideo')) { ?>
              <a href="<?php echo $result->getHref(); ?>">
                <?php $icon = Engine_Api::_()->storage()->get($result->cat_icon);
                if($icon) {
                $icon = $icon->getPhotoUrl('thumb.icon'); ?>
                <i><img src="<?php echo $icon ; ?>" /></i>
                <?php } ?>
                <span><?php echo $result->getTitle(); ?></span>
              </a>
            <?php } else { ?>
              <a href=""><span><?php echo $result->getTitle(); ?></span></a>
            <?php } ?>
          </div>
          <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesvideo')) { ?>
            <div class="_right">
              <a href="<?php echo $result->getHref(); ?>"><?php echo $this->translate("See All");?></a>
            </div>
          <?php } ?>
        </div>
        <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesvideo')) { ?>
          <?php $getVideo = Engine_Api::_()->getDbTable('videos', 'sesvideo')->getVideo(array('limit_data' => 4, 'category_id' => $result->getIdentity())); ?>
        <?php } else { ?>
          <?php $getVideo = Engine_Api::_()->video()->getVideosPaginator(array('limit' => 4, 'category' => $result->getIdentity())); ?>
        <?php } ?>
        <?php if(count($getVideo) > 0) { ?>
          <?php $videocount = 0; ?>
          <div class="sesytube_videos_content clearfix">
            <?php foreach($getVideo as $video) { ?>
              <?php if($videocount < 4) { ?>
              <div class="sesytube_video_item">
                <article>
                  <div class="_thumb">
                    <a href="<?php echo $video->getHref(); ?>"><?php echo $this->itemBackgroundPhoto($video, 'thumb.profile'); ?><i class="fa fa-play sesbasic_animation"></i></a>
                  </div>
                  <div class="_info">
                    <div class="_title"><a href="<?php echo $video->getHref(); ?>"><?php echo $video->getTitle(); ?></a></div>
                    <div class="_poster">
                      <i class="_icon"><?php echo $this->itemPhoto($video->getOwner(), 'thumb.icon'); ?></i>
                      <span><a href="<?php echo $video->getOwner()->getHref(); ?>"><?php echo $video->getOwner()->getTitle(); ?></a> - <?php echo $this->timestamp(strtotime($video->creation_date)) ?></span>
                    </div>
                  </div>
                </article>
              </div>
              <?php } ?>
            <?php $videocount++; } ?>
          </div>
        <?php } ?>
      </div>
    <?php } ?>  
  </div>
</div>
