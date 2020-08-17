<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<script type="text/javascript">
  function showPopUp(url) {
    Smoothbox.open(url);
    parent.Smoothbox.close;
  }
</script>
<?php if(count($this->results) > 0) :?>
  <ul class="courses_playlist_grid_listing sesbasic_clearfix sesbasic_bxs">
    <?php foreach( $this->results as $item ):  ?>
      <li class="courses_playlist_grid sesbm" style="width:<?php echo $this->width ?>px;">
        <div class="courses_playlist_grid_top sesbasic_clearfix">
          <?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.icon')) ?>
          <div>
             <?php if(!empty($this->information) && in_array('title', $this->information)): ?>
                <div class="courses_playlist_grid_title">
                    <?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
                </div>
            <?php endif; ?>
            <?php if(!empty($this->information) && in_array('postedby', $this->information)): ?>
            <div class="courses_playlist_grid_stats  sesbasic_text_light">
              <?php echo $this->translate('by');?> <?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle()) ?>     
            </div>
            <?php endif; ?>
            <div class="courses_playlist_grid_stats courses_list_stats sesbasic_text_light">
              <?php if (!empty($this->information) && in_array('favouriteCount', $this->information)): ?>
                <span title="<?php echo $this->translate(array('%s favorite', '%s favorites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count)); ?>" class="courses_wishlist_favourite_count_<?php echo $item->wishlist_id; ?>"><i class="fa fa-heart-o"></i><?php echo $item->favourite_count; ?></span>
              <?php endif; ?>
              <?php if (!empty($this->information) && in_array('viewCount', $this->information)): ?>
                <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count)); ?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
              <?php endif; ?>
              <?php if (!empty($this->information) && in_array('likeCount', $this->information)): ?>
                <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>" class="courses_wishlist_like_count_<?php echo $item->wishlist_id; ?>"><i  class="sesbasic_icon_like_o"></i><?php echo $item->like_count; ?></span>
              <?php endif; ?>
              <?php $wishlistCount = Engine_Api::_()->getDbtable('playlistcourses', 'courses')->playlistCoursesCount(array('wishlist_id' => $item->wishlist_id));  ?>
              <?php if (!empty($this->information) && in_array('courseCount', $this->information)): ?>
                <span title="<?php echo $this->translate(array('%s courses', '%s courses', $item->courses_count), $this->locale()->toNumber($item->courses_count)); ?>"><i class="fa fa-shopping-bag fa-video-camera"></i><?php echo $item->courses_count; ?></span>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
