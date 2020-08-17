<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursesalbum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $widgetParams = $this->allParams; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Coursesalbum/externals/styles/style_album.css'); ?>
<ul class="coursesalbum_photos_flex_view sesbasic_bxs">
      <?php foreach( $this->results as $item ): 
        if(isset($item->course_id))
        $courses = Engine_Api::_()->getItem('courses', $item->course_id);
        $album = Engine_Api::_()->getItem('coursesalbum_album', $item->album_id);  ?> 
        <li id="thumbs-photo-<?php echo $album->photo_id ?>" class="coursesalbum_album_list_grid_thumb coursesalbum_album_list_grid sespa-i-<?php echo (isset($widgetParams['insideOutside']) && $widgetParams['insideOutside'] == 'outside') ? 'outside' : 'inside'; ?> sespa-i-<?php echo (isset($widgetParams['fixHover']) && $widgetParams['fixHover'] == 'fix') ? 'fix' : 'over'; ?> sesbm" style="width:<?php echo is_numeric($widgetParams['width']) ? $widgetParams['width'].'px' : $widgetParams['width'] ?>;"> 
        	<article> 

          <a class="coursesalbum_album_list_grid_img" href="<?php echo Engine_Api::_()->eclassroom()->getHref($album->getIdentity(),$album->album_id); ?>" style="height:<?php echo is_numeric($widgetParams['height']) ? $widgetParams['height'].'px' : $widgetParams['height'] ?>;">
            <span class="main_image_container" style="background-image: url(<?php echo $album->getPhotoUrl('thumb.normalmain'); ?>);"></span>
          </a>
          <?php  if(in_array('socialSharing', $widgetParams['show_criteria']) || in_array('likeButton', $widgetParams['show_criteria']) || in_array('favouriteButton', $widgetParams['show_criteria'])){  ?>
          <span class="coursesalbum_album_list_grid_btns">
           <?php if(in_array('socialSharing', $widgetParams['show_criteria'])){ 
            //album viewpage link for sharing
              $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $album->getHref());
           ?>
            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $album, 'socialshare_enable_plusicon' => $widgetParams['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $widgetParams['socialshare_icon_limit'])); ?>
          <?php }
          $canComment =  $album->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');
          if(in_array('likeButton', $widgetParams['show_criteria']) && Engine_Api::_()->user()->getViewer()->getIdentity() !=0 && $canComment) {  ?>
                <!--Album Like Button-->
                <?php $albumLikeStatus = Engine_Api::_()->eclassroom()->getLikeStatus($album->getIdentity(), $album->getType()); ?>
                <a href="javascript:;" data-contenttype="album" data-resource-type="<?php echo $album->getType(); ?>" data-url='<?php echo $album->album_id; ?>' class="sesbasic_icon_btn_count sesbasic_icon_btn sesbasic_icon_like_btn coursesalbum_albumlike <?php echo ($albumLikeStatus) ? 'button_active' : '' ; ?>">
                  <i class="fa fa-thumbs-up"></i>
                  <span><?php echo $album->like_count; ?></span>
                </a>
            <?php }
            if(Engine_Api::_()->user()->getViewer()->getIdentity() !=0 && in_array('favouriteButton', $widgetParams['show_criteria'])){
                  $albumFavStatus = Engine_Api::_()->getDbTable('favourites', 'eclassroom')->isFavourite(array('resource_type'=>$album->getType(),'resource_id'=>$album->getIdentity())); ?>
              <a href="javascript:;" data-contenttype="album" data-resource-type="<?php echo $album->getType(); ?>" data-url='<?php echo $album->album_id; ?>' class="sesbasic_icon_btn_count sesbasic_icon_btn sesbasic_icon_fav_btn coursesalbum_albumFav <?php echo ($albumFavStatus)>0 ? 'button_active' : '' ; ?>">
                <i class="fa fa-heart"></i>
                <span><?php echo $album->favourite_count; ?></span>
              </a>
          <?php } ?>
          </span>
      <?php } ?>
      <?php if(isset($this->featured) || isset($this->sponsored)){ ?>
          	<span class="coursesalbum_labels">
              <?php if(isset($this->featured) && $item->featured == 1){ ?>
                <p class="coursesalbum_label_featured"><?php echo $this->translate("Featured"); ?></p>
              <?php } ?>
            <?php if(isset($this->sponsored)  && $item->sponsored == 1){ ?>
            	<p class="coursesalbum_label_sponsored"><?php echo $this->translate("Sponsored"); ?></p>
            <?php } ?>
          </span>
         <?php } ?>
      <?php if(in_array('like', $widgetParams['show_criteria']) || in_array('comment', $widgetParams['show_criteria']) || in_array('view', $widgetParams['show_criteria']) || in_array('title', $widgetParams['show_criteria']) || in_array('photoCount', $widgetParams['show_criteria']) || in_array('favouriteCount', $widgetParams['show_criteria'])  || in_array('by', $widgetParams['show_criteria']) || in_array('classroomName', $widgetParams['show_criteria'])){ ?>
        <p class="coursesalbum_album_list_grid_info sesbasic_clearfix<?php if(!in_array('photoCount', $widgetParams['show_criteria'])) { ?> nophotoscount<?php } ?>">
        <?php if(in_array('title', $widgetParams['show_criteria'])) { ?>
          <span class="coursesalbum_album_list_grid_title">
            <?php echo $this->htmlLink($album, $this->string()->truncate($album->getTitle(), $widgetParams['title_truncation']),array('title'=>$album->getTitle())) ; ?>
          </span>
        <?php } ?>
        <span class="coursesalbum_album_list_grid_stats">
          <?php if(!empty($courses) && in_array('classroomName', $widgetParams['show_criteria'])) { ?>
            <span class="coursesalbum_album_list_grid_owner">
              <?php echo $this->translate('in ');?>
             <?php echo $this->htmlLink($courses->getHref(), $courses->getTitle(), array('class' => 'thumbs_author')) ?>
            </span>
          <?php } ?>
          <?php if(COURSESSHOWUSERDETAIL == 1 && in_array('by', $widgetParams['show_criteria'])) { ?>
            <span class="coursesalbum_album_list_grid_owner">
              <?php echo $this->translate('by ');?>
             <?php echo $this->htmlLink($album->getOwner()->getHref(), $album->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?>
            </span>
          <?php }?>
        </span>
        <span class="coursesalbum_album_list_grid_stats sesbasic_text_light">
          <?php if(in_array('like', $widgetParams['show_criteria'])) { ?>
            <span class="coursesalbum_album_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $album->like_count), $this->locale()->toNumber($album->like_count))?>">
              <i class="fa fa-thumbs-up"></i>
              <?php echo $album->like_count;?>
            </span>
          <?php } ?>
          <?php if(in_array('comment', $widgetParams['show_criteria'])) { ?>
            <span class="coursesalbum_album_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $album->comment_count), $this->locale()->toNumber($album->comment_count))?>">
              <i class="fa fa-comment"></i>
              <?php echo $album->comment_count;?>
            </span>
         <?php } ?>
         <?php if(in_array('view', $widgetParams['show_criteria'])) { ?>
            <span class="coursesalbum_album_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $album->view_count), $this->locale()->toNumber($album->view_count))?>">
              <i class="fa fa-eye"></i>
              <?php echo $album->view_count;?>
            </span>
         <?php } ?>
         <?php if(in_array('favouriteCount', $widgetParams['show_criteria'])) { ?>
            <span class="coursesalbum_album_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $album->favourite_count), $this->locale()->toNumber($album->favourite_count))?>">
              <i class="fa fa-heart"></i> 
              <?php echo $album->favourite_count;?>            
            </span>
          <?php } ?>
           <?php if(in_array('photoCount', $widgetParams['show_criteria'])) { ?>
          <span class="coursesalbum_album_list_grid_count" title="<?php echo $this->translate(array('%s photo', '%s photos', $album->count()), $this->locale()->toNumber($album->count()))?>" >
            <i class="fa fa-photo"></i> 
            <?php echo $album->count();?>                
          </span>
          <?php } ?>
          </span>
        </p>
      <?php } ?>
        <?php if(in_array('photoCount', $widgetParams['show_criteria'])) { ?>
          <p class="coursesalbum_album_list_grid_count">
            <?php echo $this->translate(array('%s <span>photo</span>', '%s <span>photos</span>', $album->count()),$this->locale()->toNumber($album->count())); ?>
          </p>
          <?php } ?>
        </article>
      </li>
    <?php endforeach;?>
</ul>
