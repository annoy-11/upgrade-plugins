<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _gridViewContents.tpl  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php foreach( $this->paginator as $result ): ?>
  <?php $resource = Engine_Api::_()->getItem($result->resource_type, $result->resource_id); ?>
  <?php if($resource) { ?>
    <?php $like_count = Engine_Api::_()->seslike()->likeCount($result->resource_type, $result->resource_id); ?>
    <li class="seslike_item sesbasic_bg">
      <a href="<?php echo $resource->getHref(); ?>">
        <div class="_img">
          <?php echo $this->itemPhoto($resource, 'thumb.profile', true); ?>
        </div>
        <div class="_title"><span><?php echo $resource->getTitle(); ?></span></div>
      </a>
      <div class="_mid"><?php echo $this->translate("by "); ?><a href="<?php echo $resource->getOwner()->getHref(); ?>" class="_posted_by"><?php echo $resource->getOwner()->getTitle(); ?></a></div>
      <div class="_bottom sesbasic_clearfix">
        <div class="_left" id="<?php echo $result->resource_type ?>_likecount_<?php echo $result->resource_id; ?>">
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
<?php endforeach; ?>
