<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $viewer = Engine_Api::_()->user()->getViewer(); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslike/externals/styles/styles.css'); ?>
<div class="seslike_side_widget sesbasic_bxs sesbasic_clearfix">
  <div class="seslike_side_widget_inner">
    <ul class="seslike_side_widget_cont">
      <?php foreach($this->results as $result) { ?>
        <?php $resource = Engine_Api::_()->getItem($result->resource_type, $result->resource_id); ?>
        <?php if($resource) { ?>
          <?php $like_count = Engine_Api::_()->seslike()->likeCount($result->resource_type, $result->resource_id); ?>
          <li class="seslike_side_widget_item sesbasic_bg">
            <div class="top_cont">
              <div class="left_cont">
                <a href="<?php echo $resource->getHref(); ?>" title="<?php echo $resource->getTitle(); ?>">
                  <div class="_img">
                    <?php echo $this->itemPhoto($resource, 'thumb.profile', true); ?>
                  </div>
                </a>
              </div>
              <div class="right_cont">
                <div class="_title"><a href="<?php echo $resource->getHref(); ?>" title="<?php echo $resource->getTitle(); ?>"><?php echo $resource->getTitle(); ?></a></div>
                <div class="_user"><?php echo $this->translate("by "); ?><a href="<?php echo $resource->getOwner()->getHref(); ?>" class="_posted_by"><?php echo $resource->getOwner()->getTitle(); ?></a></div>
              </div>
            </div>
            <div class="_bottom sesbasic_clearfix">
              <div class="_left">
                  <span class="_likes sesbasic_text_light" title="<?php echo $this->translate(array('%s like', '%s likes', $like_count), $this->locale()->toNumber($like_count)) ?>"><i class="fa fa-thumbs-o-up"></i><?php echo $like_count; ?></span>
              </div>
              <?php $is_like = Engine_Api::_()->getDbTable('likes', 'core')->isLike($resource, $viewer); ?>
              <?php if (!empty($viewer->getIdentity())) { ?>
                <?php
                $likeUser = Engine_Api::_()->sesbasic()->getLikeStatus($resource->getIdentity(), $resource->getType());
                $likeClass = (!$likeUser) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;
                $likeText = ($likeUser) ?  $this->translate('Unlike') : $this->translate('Like');
                ?>
                <div class="_right">
                  <a href="javascript:;" data-id="<?php echo $resource->getIdentity() ; ?>" data-type="<?php echo $resource->getType() ; ?>" data-widget="1" data-url="<?php echo $resource->getIdentity() ; ?>" class="<?php if($likeUser) { ?> button_active <?php } ?> sesbasic_animation seslike_like_btn seslike_like_content_view  seslike_like_<?php echo $resource->getType() ?>_<?php echo $resource->getIdentity() ?>"><i class="fa <?php echo $likeClass;?>"></i><span><?php echo $likeText;?></span></a>
                </div>
              <?php } ?>
            </div>
          </li>
        <?php } ?>
      <?php } ?>
    </ul>
  </div>
</div>
