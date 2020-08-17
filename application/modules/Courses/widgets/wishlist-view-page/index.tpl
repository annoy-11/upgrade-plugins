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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<div class="courses_my_wishlist sesbasic_clearfix sesbasic_bxs">
  <div class="courses_wishlist_head">
    <div class="courses_wishlist_left">
      <?php if(isset($this->wishlist) && isset($this->wishlistPhoto)) { ?>
        <div class="courses_thumb">
          <img src="<?php echo $this->wishlist->getPhotoUrl(); ?>" class="lg_img"/>
        </div>
      <?php } ?>
    </div>
     <div class="courses_wishlist_right">
    <?php if(isset($this->wishlistTitle)) { ?>
          <a href="<?php echo $this->wishlist->getHref(); ?>"><h3><?php echo $this->wishlist->getTitle(); ?></h3></a>
    <?php } ?>
    <?php if(isset($this->wishlistDesc)) { ?>
         <span class="course_wishlist_des sesbasic_text_light"><?php echo $this->wishlist->description; ?></span>
    <?php } ?>
		<?php if(isset($this->wishlist) && $this->wishlist->owner_id == $this->viewer_id) {?>
        <a href="javascript:void(0);" class="sesbasic_pulldown_toggle">
          <span><i class="fa fa-ellipsis-h"></i></span>  
        </a>      
          <div class="sesbasic_pulldown_options">
            <ul>
             <?php if(isset($this->editButton)) { ?>
                <li>
                    <a class="menu_sespage_main" href="javascript:void(0);" onclick="Smoothbox.open('<?php echo $this->url(array('action'=>'edit','wishlist_id'=> $this->wishlist->wishlist_id),'courses_wishlist_view',true); ?>')"><?php echo $this->translate("Edit"); ?></a>
                </li>
            <?php } ?>
             <?php if(isset($this->deleteButton)) { ?>
                <li>
                    <a class="menu_sespage_main" href="javascript:void(0);" onclick="Smoothbox.open('<?php echo $this->url(array('action'=>'delete','wishlist_id'=> $this->wishlist->wishlist_id),'courses_wishlist_view',true); ?>')" ><?php echo $this->translate("Delete"); ?></a>
                </li>
              <?php } ?>
            </ul>
          </div>
		<?php } ?>
         <div class="course_wishlist_stats">
         <?php if(isset($this->wishlistOwner)) { ?>
            <div class="_stats sesbasic_text_light">
                <a href="<?php echo $this->wishlist->getOwner()->getHref(); ?>"><span class="admin-name"><?php echo $this->translate("By "); ?><?php echo $this->wishlist->getOwner()->getTitle(); ?></span></a>
            </div>
           <?php } ?>
           <?php if(isset($this->wishlistCreation)) {?>
            <div class="_stats sesbasic_text_light">
                <a href="javascript:void(0);"><span class="date"><i class="fa fa-calendar"></i> <?php echo date('dS D, Y',strtotime($this->wishlist->creation_date)); ?></span></a>
            </div>
           <?php } ?>
          <div class="_stats sesbasic_text_light">
            <?php if(isset($this->wishlist->like_count) && isset($this->likeCountWishlist)) { ?>
                <span class="list_like"><i class="sesbasic_icon_like_o"></i><?php echo $this->wishlist->like_count; ?></span>
            <?php } ?>
            <?php if(isset($this->wishlist->comment_count)) { ?>
                <span class="list_comm"><i class="sesbasic_icon_comment_o"></i><?php echo $this->wishlist->comment_count; ?></span>
            <?php } ?>
            <?php if(isset($this->wishlist->view_count)  && isset($this->viewCountPlaylist)) { ?>
                <span class="list_view"><i class="sesbasic_icon_view"></i><?php  echo $this->wishlist->view_count; ?></span>
            <?php } ?>
            <?php if(isset($this->wishlist->favourite_count)  && isset($this->favouriteCountWishlist)) { ?>
                <span class="list_fav"><i class="fa fa-star-o"></i><?php echo $this->wishlist->favourite_count; ?></span>
             <?php } ?>
             <?php if(isset($this->wishlist->courses_count) && isset($this->totalCourse)) { ?>
                <span class="list_follow"><i class="fa fa-list"></i><?php  echo $this->wishlist->courses_count; ?></span>
            <?php } ?>
          </div>
          </div>
        </div>  
</div>
      </div>
