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
<div class="sesytube_populat_videos sesbasic_bxs">
  <div class="sesytube_populat_videos_content clearfix">
    <?php foreach($this->results as $result) { ?>
      <div class="sesytube_video_item">
        <article>
          <div class="_thumb">            
            <a href="<?php echo $result->getHref(); ?>"><?php echo $this->itemBackgroundPhoto($result, 'thumb.profile'); ?><i class="fa fa-play sesbasic_animation"></i></a>
          </div>
          <div class="_info">
            <div class="_title"><a href=""><?php echo $result->getTitle(); ?></a></div>
            <div class="_poster">
              <span><a href="<?php echo $result->getOwner()->getHref(); ?>"><?php echo $result->getOwner()->getTitle(); ?></a> - <?php echo $this->timestamp(strtotime($result->creation_date)) ?></span>
            </div>
          </div>
        </article>
      </div>
    <?php } ?>
  </div>
</div>
