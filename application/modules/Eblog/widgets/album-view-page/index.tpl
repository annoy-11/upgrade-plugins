<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
  $baseUrl = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/SesLightbox/photoswipe.min.js');
  $this->headScript()->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/SesLightbox/photoswipe-ui-default.min.js');
  $this->headScript()->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/flexcroll.js');
  $this->headScript()->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/SesLightbox/lightbox.js');
  $this->headLink()->appendStylesheet($baseUrl . 'application/modules/Sesbasic/externals/styles/photoswipe.css');
  $this->headLink()->appendStylesheet($baseUrl . 'application/modules/Eblog/externals/styles/style_album.css'); 

  if(!$this->is_ajax && isset($this->docActive)) {
    $imageURL = $this->album->getPhotoUrl();
    if(strpos($this->album->getPhotoUrl(),'http') === false)
              $imageURL = (!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://". $_SERVER['HTTP_HOST'].$this->album->getPhotoUrl();
    $this->doctype('XHTML1_RDFA');
    $this->headMeta()->setProperty('og:title', strip_tags($this->album->getTitle()));
    $this->headMeta()->setProperty('og:description', strip_tags($this->album->getDescription()));
    $this->headMeta()->setProperty('og:image',$imageURL);
    $this->headMeta()->setProperty('twitter:title', strip_tags($this->album->getTitle()));
    $this->headMeta()->setProperty('twitter:description', strip_tags($this->album->getDescription()));
  }
  
  if(isset($this->identityForWidget) && !empty($this->identityForWidget)){
      $randonNumber = $this->identityForWidget;
  }else{
      $randonNumber = $this->identity; 
  } 

  if(isset($this->canEdit)) {
    // First, include the Webcam.js JavaScript Library 
    $this->headScript()->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/webcam.js'); 
  }
 
  $editItem = true;
  if($this->canEditMemberLevelPermission == 1){
    if($this->viewer->getIdentity() == $this->album->owner_id){
      $editItem = true;
    }else{
      $editItem = false;
    }
  }else if($this->canEditMemberLevelPermission == 2){
      $editItem = true;
  }else{
      $editItem = false;
  } 
  $deleteItem = true;
  if($this->canDeleteMemberLevelPermission == 1){
    if($this->viewer->getIdentity() == $this->album->owner_id){
      $deleteItem = true;
    }else{
      $deleteItem = false;
    }
  }else if($this->canDeleteMemberLevelPermission == 2){
      $deleteItem = true;
  }else{
      $deleteItem = false;
  }
    $createItem = true;
  if($this->canCreateMemberLevelPermission == 1){
    if($this->viewer->getIdentity() == $this->album->owner_id){
      $createItem = true;
    }else{
      $createItem = false;
    }
  }else{
      $createItem = false;
  }

  if(!$this->is_ajax) {
    $this->headTranslate(array('Save', 'Cancel', 'delete'));
?>
<script type="text/javascript">
sesJqueryObject(document).click(function(blog){
	if(blog.target.id != 'eblog_dropdown_btn' && blog.target.id != 'a_btn' && blog.target.id != 'i_btn'){
		sesJqueryObject('#eblog_dropdown_btn').find('.eblog_album_option_box1').css('display','none');
		sesJqueryObject('#a_btn').removeClass('active');
	}
	if(blog.target.id == 'change_cover_txt' || blog.target.id == 'cover_change_btn_i' || blog.target.id == 'cover_change_btn'){
		if(sesJqueryObject('#eblog_album_change_cover_op').hasClass('active'))
			sesJqueryObject('#eblog_album_change_cover_op').removeClass('active')
		else
			sesJqueryObject('#eblog_album_change_cover_op').addClass('active')
	}else{
			sesJqueryObject('#eblog_album_change_cover_op').removeClass('active')
	}
	if(blog.target.id == 'a_btn'){
			if(sesJqueryObject('#a_btn').hasClass('active')){
				sesJqueryObject('#a_btn').removeClass('active');
				sesJqueryObject('.eblog_album_option_box1').css('display','none');
			}
			else{
				sesJqueryObject('#a_btn').addClass('active');
				sesJqueryObject('.eblog_album_option_box1').css('display','block');
			}
		}else if(blog.target.id == 'i_btn'){
			if(sesJqueryObject('#a_btn').hasClass('active')){
				sesJqueryObject('#a_btn').removeClass('active');
				sesJqueryObject('.eblog_album_option_box1').css('display','none');
			}
			else{
				sesJqueryObject('#a_btn').addClass('active');
				sesJqueryObject('.eblog_album_option_box1').css('display','block');
			}
	}	
});
</script>
<div class="eblog_album_cover_container sesbasic_bxs">
  <?php if(isset($this->album->art_cover) && $this->album->art_cover != 0 && $this->album->art_cover != '') {
    $albumArtCover =	Engine_Api::_()->storage()->get($this->album->art_cover, '')->getPhotoUrl(); 
  } else
    $albumArtCover ='';  
  ?>
  <div id="eblog_album_cover_default" class="eblog_album_cover_thumbs" style="display:<?php echo $albumArtCover == '' ? 'block' : 'none'; ?>;">
    <ul>
      <?php $albumImage = Engine_Api::_()->eblog()->getAlbumPhoto($this->album->getIdentity(),0,3); 
      $countTotal = count($albumImage);
      foreach( $albumImage as $photo ) {
        $imageURL = $photo->getPhotoUrl('thumb.normalmain');
        if(strpos($imageURL,'http') === false){
          $https = (!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://";
          $imageURL = $https.$_SERVER['HTTP_HOST'].$imageURL;
        }
        $widthPer = $countTotal == 3 ? "33.33" : ($countTotal == 2 ? "50" : '100') ; ?> 
        <li style="height:300px;width:<?php echo $widthPer; ?>%"><span style="background-image:url(<?php echo $imageURL; ?>);"></span></li>
      <?php } ?>
    </ul>
  </div>
	<span class="eblog_album_cover_image" id="cover_art_work_image" style="background-image:url(<?php echo $albumArtCover; ?>);"></span>
  <div style="display:none;" id="eblog-pos-btn" class="eblog_album_cover_positions_btns">
  	<a id="saveCoverPosition" href="javascript:;" class="sesbasic_button"><?php echo $this->translate("Save");?></a>
    <a href="javascript:;" id="cancelCoverPosition" class="sesbasic_button"><?php echo $this->translate("Cancel");?></a>
  </div>
  <span class="eblog_album_cover_fade"></span>
  <?php if( $this->mine || $this->canEdit || $editItem): ?>
    <div class="eblog_album_coverphoto_op" id="eblog_album_change_cover_op">
      <a href="javascript:;" id="cover_change_btn"><i class="fa fa-camera" id="cover_change_btn_i"></i><span id="change_cover_txt"><?php echo $this->translate("Upload Cover Photo"); ?></span></a>
      <div class="eblog_album_coverphoto_op_box eblog_album_option_box">
      	<i class="eblog_album_coverphoto_op_box_arrow"></i>
        <?php if($this->canEdit){ ?>
          <input type="file" id="uploadFileeblog" name="art_cover" onchange="uploadCoverArt(this);"  style="display:none" />
          <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
          <a id="coverChangeeblog" data-src="<?php echo $this->album->art_cover; ?>" href="javascript:;"><i class="fa fa-plus"></i><?php echo (isset($this->album->art_cover) && $this->album->art_cover != 0 && $this->album->art_cover != '') ? $this->translate('Change Cover Photo') : $this->translate('Add Cover Photo');; ?></a>
           <a id="coverRemoveeblog" style="display:<?php echo (isset($this->album->art_cover) && $this->album->art_cover != 0 && $this->album->art_cover != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $this->album->art_cover; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Cover Photo'); ?></a>
        <?php } ?>
      </div>
    </div>
  <?php endif;?>
	<div class="eblog_album_cover_inner">
  	<div class="eblog_album_cover_album_cont sesbasic_clearfix">
			<div class="eblog_album_cover_album_cont_inner">
      	<div class="eblog_album_cover_album_owner_photo">
          <?php $coverAlbumPhoto = $this->album->getPhotoUrl('thumb.icon','status'); 
          if($coverAlbumPhoto == '') {
            echo $this->itemPhoto($this->albumUser, 'thumb.profile');
          } else {
            $photoCover = Engine_Api::_()->getItem('eblog_photo',$this->album->photo_id);
            $imageURL = $photoCover->getHref(); ?>
            <a class="ses-image-viewer" onclick="openLightBoxForSesPlugins('<?php echo $imageURL	; ?>','<?php echo $photoCover->getPhotoUrl(); ?>')" href="<?php echo $imageURL ?>"><img src="<?php echo $coverAlbumPhoto; ?>" /></a>
          <?php } ?>
        </div>
        <div class="eblog_album_cover_album_info">
            <?php  if($this->title) { ?>
          <h2 class="eblog_album_cover_title">
          	<?php echo trim($this->album->getTitle()) ? $this->album->getTitle() : '<em>' . $this->translate('Untitled') . '</em>'; ?>
          </h2>
            <?php } ?>
          <div class="eblog_album_cover_date clear sesbasic_clearfix">
            <?php  $blog = Engine_Api::_()->getItem('eblog_blog',$this->album->blog_id); ?>
            <?php  if($this->title) { ?>
           <?php echo  $this->translate('in').' <a href="'.$blog->getHref().'"> '.$blog->getTitle().'</a>'; ?><br />
              <?php } ?>
          	<?php echo  $this->translate('by').' '.$this->albumUser->__toString(); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $this->translate('Added %1$s', $this->timestamp($this->album->creation_date)); ?>           
          </div>
          <div class="clear sesbasic_clearfix eblog_album_cover_album_info_btm">
            <div class="eblog_album_cover_stats">
            	<div title="<?php echo $this->translate(array('%s photo', '%s photos', $this->album->count()), $this->locale()->toNumber($this->album->count()))?>">
              	<span class="eblog_album_cover_stat_count"><?php echo $this->album->count(); ?></span>
              	<span class="eblog_album_cover_stat_txt"><?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Photo', '%s Photos', $this->album->count()), $this->locale()->toNumber($this->album->count())))); ?></span>
            	</div>
            	<div title="<?php echo $this->translate(array('%s view', '%s views', $this->album->view_count), $this->locale()->toNumber($this->album->view_count))?>">
              	<span class="eblog_album_cover_stat_count"><?php echo $this->album->view_count; ?></span>
              	<span class="eblog_album_cover_stat_txt"><?php echo str_replace(',','',preg_replace('/[0-9]+/','',$this->translate(array('%s View', '%s Views', $this->album->view_count), $this->locale()->toNumber($this->album->view_count)))); ?></span>
            	</div>
            	<div title="<?php echo $this->translate(array('%s like', '%s likes', $this->album->like_count), $this->locale()->toNumber($this->album->like_count))?>">
              	<span class="eblog_album_cover_stat_count"><?php echo $this->album->like_count; ?></span>
              	<span class="eblog_album_cover_stat_txt"><?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Like', '%s Likes', $this->album->like_count), $this->locale()->toNumber($this->album->like_count)))); ?></span>
            	</div>
              <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)) { ?>
            	<div title="<?php echo $this->translate(array('%s favourite', '%s favourites', $this->album->favourite_count), $this->locale()->toNumber($this->album->favourite_count))?>">
              	<span class="eblog_album_cover_stat_count"><?php echo $this->album->favourite_count; ?></span>
              	<span class="eblog_album_cover_stat_txt"><?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Favourites', '%s Favourites', $this->album->favourite_count), $this->locale()->toNumber($this->album->favourite_count)))); ?></span>
            	</div>
              <?php } ?>              
            	<div title="<?php echo $this->translate(array('%s comment', '%s comments',$this->album->comment_count), $this->locale()->toNumber($this->album->comment_count))?>">
              	<span class="eblog_album_cover_stat_count"><?php echo $this->album->comment_count; ?></span>
              	<span class="eblog_album_cover_stat_txt"><?php echo str_replace(',','',preg_replace('/[0-9]+/', '',  $this->translate(array('%s Comment', '%s Comments',$this->album->comment_count), $this->locale()->toNumber($this->album->comment_count)))); ?></span>
            	</div>
            </div>
          </div>
				</div>          
      </div>
    </div>
    <div class="eblog_album_cover_footer clear sesbasic_clearfix">
      <ul id="tab_links_cover" class="eblog_album_cover_tabs sesbasic_clearfix">
        <li data-src="album-info" class="tab_cover"><a href="javascript:;" ><?php echo $this->translate("Album Info") ; ?></a></li>
        <li class="<?php echo $this->paginator->getTotalItemCount() == 0  ? '' : "eblog_album_cover_tabactive" ; ?> tab_cover" data-src="album-photo" style="display:<?php echo $this->paginator->getTotalItemCount() == 0  ? '' : "" ; ?>"><a href="javascript:;"><?php echo $this->translate("Photos") ; ?></a></li>
        <li class="tab_cover" data-src="album-discussion" ><a href="javascript:;"><?php echo $this->translate("Discussion") ; ?></a></li>
      </ul>
      <?php
         $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $this->album->getHref()); ?>
      <div class="eblog_album_cover_user_options sesbasic_clearfix">
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1)){ ?>
          <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->album, 'param' => 'feed')); ?>
          <?php } ?>
          <?php if( $this->mine || $this->canEdit || $editItem || $deleteItem || $createItem): ?>
            <span class="eblog_album_cover_user_options_drop_btn" id="eblog_dropdown_btn">
              <a title="<?php echo $this->translate('Options'); ?>" href="javascript:;" id="a_btn">
                <i class="fa fa-ellipsis-v" id="i_btn"></i>
              </a>
              <div class="eblog_album_option_box eblog_album_option_box1">
                <?php if($createItem && $this->allow_create){ ?>
                  <a href="<?php echo $this->url(array('module' => 'eblog', 'action' => 'create', 'album_id' => $this->album_id), 'eblog_specific_album', true); ?>">
                  	<i class="fa fa-plus"></i>
                    <?php echo $this->translate('Add More Photos'); ?>
                  </a>
                <?php } ?>
                <?php if($editItem){ ?>
                  <a href="<?php echo $this->url(array('module' => 'eblog', 'action' => 'edit', 'album_id' => $this->album_id), 'eblog_specific_album', true); ?>"><i class="fa fa-pencil"></i><?php echo $this->translate('Edit Settings'); ?></a>
                <?php } ?>
                <?php if($deleteItem){ ?>
                  <a class="smoothbox" href="<?php echo $this->url(array('module' => 'eblog', 'action' => 'delete', 'album_id' => $this->album_id, 'format' => 'smoothbox'), 'eblog_specific_album', true); ?>"><i class="fa fa-trash"></i><?php echo $this->translate('Delete Album'); ?></a>
                <?php } ?>
                <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.report', 1)){ ?>
                 <?php echo $this->htmlLink(Array("module"=> "core", "controller" => "report", "action" => "create", "route" => "default", "subject" => $this->album->getGuid(),'format' => 'smoothbox'),'<i class="fa fa-flag"></i>'.$this->translate("Report"), array("class" => "smoothbox")); ?>               
                 <?php } ?>
              </div>
        		</span>
        	<?php endif; ?>
      </div>
    </div>
  </div>
</div>
<div class="clear sesbasic_clearfix sesbasic_bxs" id="scrollHeightDivSes_<?php echo $randonNumber; ?>">
  <ul id="ses-image-view" class="album-photo eblog_album_listings eblog_album_photos_listings eblog_album_photos_flex_view sesbasic_clearfix" style="<?php echo $this->paginator->getTotalItemCount() == 0  ? 'none' : "" ; ?>">
<?php } ?>
    <?php 
    			$limit = 0;
          foreach( $this->paginator as $photo ){
           if($this->view_type != 'masonry'){ ?>
            <li id="thumbs-photo-<?php echo $photo->photo_id ?>" class="ses_album_image_viewer eblog_album_list_photo_grid eblog_album_list_grid  sesea-i-<?php echo (isset($this->insideOutside) && $this->insideOutside == 'outside') ? 'outside' : 'inside'; ?> sesea-i-<?php echo (isset($this->fixHover) && $this->fixHover == 'fix') ? 'fix' : 'over'; ?> sesbm" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
              <?php $imageURL = $photo->getHref(); ?>
              <a class="eblog_album_list_grid_img ses-image-viewer" onclick="openLightBoxForSesPlugins('<?php echo $imageURL	; ?>','<?php echo $photo->getPhotoUrl(); ?>')" href="<?php echo $photo->getHref(); ?>" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;"> 
                <span style="background-image: url(<?php echo $photo->getPhotoUrl('thumb.normalmain'); ?>);"></span>
              </a>
              <?php 
              if((isset($this->socialSharing)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1)) || isset($this->likeButton) ){
              //album viewpage link for sharing
                $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $photo->getHref()); ?>
      					<span class="eblog_album_list_grid_btns">
                  <?php if(isset($this->socialSharing)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1)){ ?>
                    
                    <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $photo)); ?>
                    

        					<?php } 
                  $canComment =  $canComment =  $this->blog->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');
                  	if(isset($this->likeButton) && Engine_Api::_()->user()->getViewer()->getIdentity() !=0 && $canComment){  ?>
                    <?php $albumLikeStatus = Engine_Api::_()->eblog()->getLikeStatusBlog($photo->photo_id,'eblog_photo'); ?>
                    <a href="javascript:;" data-src='<?php echo $photo->photo_id; ?>' class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn eblog_photolike <?php echo ($albumLikeStatus) ? 'button_active' : '' ; ?>">
                      <i class="fa fa-thumbs-up"></i>
                      <span><?php echo $photo->like_count; ?></span>
                    </a>
                  <?php }   if(isset($this->favouriteButton) && Engine_Api::_()->user()->getViewer()->getIdentity() !=0 && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)){
                  ?>
                    <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'eblog')->isFavourite(array('resource_type'=>'eblog_photo','resource_id'=>'photo_id')); ?>
                    <a href="javascript:;" data-url='<?php echo $photo->photo_id; ?>' class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn eblog_favourite <?php echo ($favStatus) ? 'button_active' : '' ; ?>">
                      <i class="fa fa-heart"></i>
                      <span><?php echo $photo->favourite_count; ?></span>
                    </a>
                    <?php }
                    ?>
              	</span>
      				<?php } ?>
              
              <?php if(isset($this->like) || isset($this->comment) || isset($this->favouriteCount) || isset($this->view) || isset($this->title) || isset($this->by)){ ?>
                <p class="eblog_album_list_grid_info sesbasic_clearfix">
                  <?php if(isset($this->title)) { ?>
                    <span class="eblog_album_list_grid_title">
                      <?php echo $this->htmlLink($photo, $this->htmlLink($photo, $this->string()->truncate($photo->getTitle(), $this->title_truncation), array('title'=>$photo->getTitle()))) ?>
                    </span>
                  <?php } ?>
                  <span class="eblog_album_list_grid_stats">
                    <?php if(isset($this->by)) { ?>
                      <span class="eblog_album_list_grid_owner">
                        <?php echo $this->translate('By');?>
                        <?php echo $this->htmlLink($photo->getOwner()->getHref(), $photo->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?>
                      </span>
                    <?php }?>
                  </span>
                  <span class="eblog_album_list_grid_stats sesbasic_text_light">
                    <?php if(isset($this->like)) { ?>
                      <span class="eblog_album_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $photo->like_count), $this->locale()->toNumber($photo->like_count))?>">
                        <i class="fa fa-thumbs-up"></i>
                        <?php echo $photo->like_count;?>
                      </span>
                    <?php } ?>
                     <?php if(isset($this->favouriteCount) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)) { ?>
                      <span class="sesbasic_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $photo->favourite_count), $this->locale()->toNumber($photo->favourite_count))?>">
                        <i class="fa fa-heart"></i>
                        <?php echo $photo->favourite_count;?>
                      </span>
                    <?php } ?>
                  <?php if(isset($this->comment)) { ?>
                    <span class="eblog_album_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $photo->comment_count), $this->locale()->toNumber($photo->comment_count))?>">
                      <i class="fa fa-comment"></i>
                      <?php echo $photo->comment_count;?>
                    </span>
                 <?php } ?>
                 <?php if(isset($this->view)) { ?>
                  <span class="eblog_album_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $photo->view_count), $this->locale()->toNumber($photo->view_count))?>">
                    <i class="fa fa-eye"></i>
                    <?php echo $photo->view_count;?>
                  </span>
                 <?php } ?>
                    </span>
                </p>         
              <?php } ?>
            </li>
         <?php }else{
          $imageURL = $photo->getPhotoUrl('thumb.normalmain');
          if(strpos($imageURL,'http://') === FALSE && strpos($imageURL,'https://') === FALSE)
    					$imageGetSizeURL = $_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR . substr($imageURL, 0, strpos($imageURL, "?"));
          else
          	$imageGetSizeURL = $imageURL;
    			$imageHeightWidthData = getimagesize($imageGetSizeURL);
          $width = isset($imageHeightWidthData[0]) ? $imageHeightWidthData[0] : '300';
          $height = isset($imageHeightWidthData[1]) ? $imageHeightWidthData[1] : '200'; ?>
         		<li id="thumbs-photo-<?php echo $photo->photo_id ?>" data-w="<?php echo $width ?>" data-h="<?php echo $height; ?>" class="ses_album_image_viewer eblog_album_list_flex_thumb eblog_album_list_photo_grid eblog_album_list_grid sesbasic_list_photo_grid sesea-i-inside sesea-i-<?php echo (isset($this->fixHover) && $this->fixHover == 'fix') ? 'fix' : 'over'; ?>">
              <?php $imageViewerURL = $photo->getHref() ?>
              <a class="eblog_album_list_flex_img ses-image-viewer" onclick="openLightBoxForSesPlugins('<?php echo $imageViewerURL	; ?>','<?php echo $photo->getPhotoUrl(); ?>')" href="<?php echo $photo->getHref(); ?>"> 
                <img data-src="<?php echo $imageURL; ?>" src="<?php $baseUrl; ?>application/modules/Eblog/externals/images/blank-img.gif" /> 
              </a>
              <?php 
              if((isset($this->socialSharing)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1)) || isset($this->likeButton)){
              //album viewpage link for sharing
                $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $photo->getHref()); ?>
      					<span class="eblog_album_list_grid_btns">
                  <?php if(isset($this->socialSharing)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1)){ ?>
                    
                    <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $photo)); ?>

        					<?php }
                   		$canComment =  $this->blog->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');
                  	 if(isset($this->likeButton) && Engine_Api::_()->user()->getViewer()->getIdentity() !=0 && $canComment){  ?>	
                    <?php $albumLikeStatus = Engine_Api::_()->eblog()->getLikeStatusBlog($photo->photo_id,'eblog_photo'); ?>
                    <a href="javascript:;" data-url='<?php echo $photo->photo_id; ?>' class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn eblog_photolike <?php echo ($albumLikeStatus) ? 'button_active' : '' ; ?>">
                      <i class="fa fa-thumbs-up"></i>
                      <span><?php echo $photo->like_count; ?></span>
                    </a>
                  <?php } 
                  if(isset($this->favouriteButton) && Engine_Api::_()->user()->getViewer()->getIdentity() !=0 && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)){
                 ?>
                 <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'eblog')->isFavourite(array('resource_type'=>'eblog_photo','resource_id'=>'photo_id')); ?>
                    <a href="javascript:;" data-url='<?php echo $photo->photo_id; ?>' class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn eblog_favourite <?php echo ($favStatus) ? 'button_active' : '' ; ?>">
                      <i class="fa fa-heart"></i>
                      <span><?php echo $photo->favourite_count; ?></span>
                    </a>
                    <?php }
                    ?>
              	</span>
      				<?php } ?>
              
          
              
              <?php if(isset($this->like) || isset($this->comment) || isset($this->view) || isset($this->title) || isset($this->by)){ ?>
                <p class="eblog_album_list_grid_info sesbasic_clearfix">
                  <?php if(isset($this->title)) { ?>
                    <span class="eblog_album_list_grid_title">
                      <?php echo $this->htmlLink($photo, $this->htmlLink($photo, $this->string()->truncate($photo->getTitle(), $this->title_truncation), array('title'=>$photo->getTitle()))) ?>
                    </span>
                  <?php } ?>
                  <span class="eblog_album_list_grid_stats">
                    <?php if(isset($this->by) && $photo->user_id) { ?>
                      <span class="eblog_album_list_grid_owner">
                        <?php echo $this->translate('By');?>
                        <?php echo $this->htmlLink($photo->getOwner()->getHref(), $photo->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?>
                      </span>
                    <?php }?>
                  </span>
                  <span class="eblog_album_list_grid_stats sesbasic_text_light">
                    <?php if(isset($this->like)) { ?>
                      <span class="eblog_album_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $photo->like_count), $this->locale()->toNumber($photo->like_count))?>">
                        <i class="fa fa-thumbs-up"></i>
                        <?php echo $photo->like_count;?>
                      </span>
                    <?php } ?>
                      <?php if(isset($this->favouriteCount) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)) { ?>
                      <span class="sesbasic_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $photo->favourite_count), $this->locale()->toNumber($photo->favourite_count))?>">
                        <i class="fa fa-heart"></i>
                        <?php echo $photo->favourite_count;?>
                      </span>
                    <?php } ?>
                  <?php if(isset($this->comment)) { ?>
                    <span class="eblog_album_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $photo->comment_count), $this->locale()->toNumber($photo->comment_count))?>">
                      <i class="fa fa-comment"></i>
                      <?php echo $photo->comment_count;?>
                    </span>
                 <?php } ?>
                 <?php if(isset($this->view)) { ?>
                  <span class="eblog_album_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $photo->view_count), $this->locale()->toNumber($photo->view_count))?>">
                    <i class="fa fa-eye"></i>
                    <?php echo $photo->view_count;?>
                  </span>
                 <?php } ?>
                    </span>
                </p>         
              <?php } ?>   
            </li>
         <?php } 
         		 $limit++;
           }
         		 if($this->loadOptionData == 'pagging'){ ?>
             <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "eblog"),array('identityWidget'=>$randonNumber)); ?>
       		  <?php }
         
          ?>
<?php if(!$this->is_ajax) { ?>
  </ul>
  <!--Album Info Tab-->
	<div class="clear sesbasic_clearfix eblog_album_info">
    <div class="eblog_album_info_left album-info" style="display:none;">
      <?php if( '' != trim($this->album->getDescription())){ ?>
        <div class="eblog_album_info_desc clear"><?php echo nl2br($this->album->getDescription()); ?></div>  
      <?php }else{ ?>
      	<div class="tip">
        	<span>
        		<?php echo $this->translate("No description found.");?>
          </span>
        </div>
      <?php } ?>
		</div>
   	<div class="eblog_album_info_left album-discussion layout_core_comments" style="display:none">
  		<?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedcomment')){ ?>
                      <?php echo $this->action("list", "comment", "sesadvancedcomment", array("type" => "eblog_album", "id" => $this->album->getIdentity(),'is_ajax_load'=>true)); 
                        }else{
                         echo $this->action("list", "comment", "core", array("type" => "eblog_album", "id" => $this->album->getIdentity())); 
                         }
                         ?>
  	</div>
	 </div>
  <?php } ?>
  <?php if(!$this->is_ajax){ ?>
   <?php if($this->loadOptionData != 'pagging'){ ?>
    <div class="sesbasic_view_more" id="view_more_<?php echo $randonNumber; ?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore')); ?> </div>
    <div class="sesbasic_view_more_loading" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src='<?php echo $baseUrl ?>application/modules/Sesbasic/externals/images/loading.gif' /></div>
  <?php } ?>
</div>

<script type="text/javascript">
<?php if(!$this->is_ajax && $this->canEdit){ ?>
sesJqueryObject('<div class="eblog_album_photo_update_popup sesbasic_bxs" id="eblog_popup_cam_upload" style="display:none"><div class="eblog_album_photo_update_popup_overlay"></div><div class="eblog_album_photo_update_popup_container eblog_album_photo_update_webcam_container"><div class="eblog_album_photo_update_popup_header"><?php echo $this->translate("Click to Take Cover Photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="eblog_album_photo_update_popup_webcam_options"><div id="eblog_camera" style="background-color:#ccc;"></div><div class="centerT eblog_album_photo_update_popup_btns">   <button onclick="take_snapshot()" style="margin-right:3px;" ><?php echo $this->translate("Take Cover Photo") ?></button><button onclick="hideProfilePhotoUpload()" ><?php echo $this->translate("Cancel") ?></button></div></div></div></div><div class="eblog_album_photo_update_popup sesbasic_bxs" id="eblog_popup_existing_upload" style="display:none"><div class="eblog_album_photo_update_popup_overlay"></div><div class="eblog_album_photo_update_popup_container" id="eblog_popup_container_existing"><div class="eblog_album_photo_update_popup_header"><?php echo $this->translate("Select a cover photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="eblog_album_photo_update_popup_content"><div id="eblog_album_existing_data"></div><div id="eblog_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="<?php echo $this->translate("Loading"); ?>" style="margin-top:10px;"  /></div></div></div></div>').appendTo('body');
var canPaginatePageNumber = 1;
sesJqueryObject(document).on('click','#uploadWebCamPhoto',function(){
	sesJqueryObject('#eblog_popup_cam_upload').show();
	<!-- Configure a few settings and attach camera -->
	Webcam.set({
		width: 320,
		height: 240,
		image_format:'jpeg',
		jpeg_quality: 90
	});
	Webcam.attach('#eblog_camera');
});
<!-- Code to handle taking the snapshot and displaying it locally -->
function take_snapshot() {
	// take snapshot and get image data
	Webcam.snap(function(data_uri) {
		Webcam.reset();
		sesJqueryObject('#eblog_popup_cam_upload').hide();
		// upload results
		sesJqueryObject('.eblog_album_cover_container').append('<div id="eblog_album_cover_loading" class="sesbasic_loading_cont_overlay"></div>');
		 Webcam.upload( data_uri, en4.core.staticBaseUrl+'eblog/album/upload-cover/album_id/<?php echo $this->album_id ?>' , function(code, text) {
				response = sesJqueryObject.parseJSON(text);
				sesJqueryObject('#eblog_album_cover_loading').remove();
				sesJqueryObject('.eblog_album_cover_image').css('background-image', 'url(' + response.file + ')');
				sesJqueryObject('#eblog_album_cover_default').hide();
				sesJqueryObject('#coverChangeeblog').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Photo'));
				sesJqueryObject('#coverRemoveeblog').css('display','block');
			} );
	});
}
function hideProfilePhotoUpload(){
	if(typeof Webcam != 'undefined')
	 Webcam.reset();
	canPaginatePageNumber = 1;
	sesJqueryObject('#eblog_popup_cam_upload').hide();
	sesJqueryObject('#eblog_popup_existing_upload').hide();
	if(typeof Webcam != 'undefined'){
		sesJqueryObject('.slimScrollDiv').remove();
		sesJqueryObject('.eblog_album_photo_update_popup_content').html('<div id="eblog_album_existing_data"></div><div id="eblog_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="Loading" style="margin-top:10px;"  /></div>');
	}
}

sesJqueryObject(document).on('click','#coverChangeeblog',function(){
	document.getElementById('uploadFileeblog').click();	
});
function uploadCoverArt(input){
	 var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG' || ext == 'gif'  || ext == 'GIF')){
				uploadFileToServer(input.files[0]);
    }else{
				//Silence
		}
}
sesJqueryObject('#coverRemoveeblog').click(function(){
		sesJqueryObject(this).css('display','none');
		sesJqueryObject('.eblog_album_cover_image').css('background-image', 'url()');
		sesJqueryObject('#eblog_album_cover_default').show();
		var album_id = '<?php echo $this->album->album_id; ?>';
		uploadURL = en4.core.staticBaseUrl+'eblog/album/remove-cover/album_id/'+album_id;
		var jqXHR=sesJqueryObject.ajax({
			url: uploadURL,
			type: "POST",
			contentType:false,
			processData: false,
			cache: false,
			success: function(response){
				sesJqueryObject('#coverChangeeblog').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Add Cover Photo'));
				//silence
			 }
			}); 
});
sesJqueryObject('#changePositionOfCoverPhoto').click(function(){
		sesJqueryObject('.eblog_album_cover_fade').css('display','none');
		sesJqueryObject('.eblog_album_cover_inner').css('display','none');
		sesJqueryObject('#eblog-pos-btn').css('display','inline-block');
});
sesJqueryObject(document).on('click','#cancelCoverPosition',function(){
	sesJqueryObject('.eblog_album_cover_fade').css('display','block');
	sesJqueryObject('.eblog_album_cover_inner').css('display','block');
	sesJqueryObject('#eblog-pos-btn').css('display','none');
});
sesJqueryObject('#saveCoverPosition').click(function(){
	var album_id = '<?php echo $this->album->album_id; ?>';
	var bgPosition = sesJqueryObject('#cover_art_work_image').css('background-position');
	sesJqueryObject('.eblog_album_cover_fade').css('display','block');
	sesJqueryObject('.eblog_album_cover_inner').css('display','block');
	sesJqueryObject('#eblog-pos-btn').css('display','none');
	var URL = en4.core.staticBaseUrl+'albums/index/change-position/album_id/'+album_id;
	(new Request.HTML({
		method: 'post',
		'url':URL,
		'data': {
			format: 'html',
			position: bgPosition,    
			album_id:'<?php echo $this->album_id; ?>',
		},
		onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
			//silence
		}
	})).send();
});
function uploadFileToServer(files){
	sesJqueryObject('.eblog_album_cover_container').append('<div id="eblog_album_cover_loading" class="sesbasic_loading_cont_overlay"></div>');
	var formData = new FormData();
	formData.append('Filedata', files);
	uploadURL = en4.core.staticBaseUrl+'eblog/album/upload-cover/album_id/<?php echo $this->album_id ?>';
	var jqXHR=sesJqueryObject.ajax({
    url: uploadURL,
    type: "POST",
    contentType:false,
    processData: false,
		cache: false,
		data: formData,
		success: function(response){
			response = sesJqueryObject.parseJSON(response);
			sesJqueryObject('#eblog_album_cover_loading').remove();
			sesJqueryObject('.eblog_album_cover_image').css('background-image', 'url(' + response.file + ')');
				sesJqueryObject('#eblog_album_cover_default').hide();
			sesJqueryObject('#coverChangeeblog').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Photo'));
			sesJqueryObject('#coverRemoveeblog').css('display','block');
     }
    }); 
}
<?php } ?>

<?php if($this->loadOptionData == 'auto_load'){ ?>
sesJqueryObject("#feed_viewmore_link_<?php echo $randonNumber;?>").text("");
sesJqueryObject("#feed_viewmore_link_<?php echo $randonNumber;?>").removeClass('sesbasic_link_btn fa fa-repeat buttonlink icon_viewmore');
		window.addEvent('domready', function() {
		 sesJqueryObject(window).scroll( function() {
			 if(!$('loading_image_<?php echo $randonNumber; ?>'))
			 	return false;
			  var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#scrollHeightDivSes_<?php echo $randonNumber; ?>').offset().top;
        var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
        if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
						document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
				}
     });
	});
<?php } ?>
</script>
<?php } ?>
<script type="text/javascript">
<?php if(!$this->is_ajax){ ?>
		sesJqueryObject(document).on('click','#tab_links_cover > li',function(){
			var elemLength = sesJqueryObject('#tab_links_cover').children();	
			for(i=0;i<elemLength.length;i++){
					sesJqueryObject(elemLength[i].removeClass('eblog_album_cover_tabactive'));
					sesJqueryObject('.'+sesJqueryObject(elemLength[i]).attr('data-src')).css('display','none');
			}
				sesJqueryObject(this).addClass('eblog_album_cover_tabactive');
				sesJqueryObject('.'+sesJqueryObject(this).attr('data-src')).css('display','block');
				if("<?php echo $this->view_type ; ?>" == 'masonry'){
					sesJqueryObject("#ses-image-view").sesbasicFlexImage({rowHeight: <?php echo str_replace('px','',$this->height); ?>});
				}
				if(sesJqueryObject(this).attr('data-src') == 'album-photo'){
					sesJqueryObject('#eblog-container-right').css('display','none');
					if(sesJqueryObject('#view_more_<?php echo $randonNumber; ?>'))
						sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display','block');
					if(sesJqueryObject('#view_more_<?php echo $randonNumber; ?>'))
						sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').css('display','none');					
					if(sesJqueryObject('#view_more_related_<?php echo $randonNumber; ?>'))							
							sesJqueryObject('#view_more_related_<?php echo $randonNumber; ?>').css('display','none');						
						if(sesJqueryObject('#view_more_related<?php echo $randonNumber; ?>'))
							sesJqueryObject('#loading_image_related_<?php echo $randonNumber; ?>').css('display','none');
				}else{
					sesJqueryObject('#eblog-container-right').css('display','block');
						if(sesJqueryObject('#view_more_<?php echo $randonNumber; ?>'))							
							sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display','none');						
						if(sesJqueryObject('#view_more_<?php echo $randonNumber; ?>'))
							sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').css('display','none');
						if(sesJqueryObject('#view_more_related_<?php echo $randonNumber; ?>'))							
							sesJqueryObject('#view_more_related_<?php echo $randonNumber; ?>').css('display','none');						
						if(sesJqueryObject('#view_more_related<?php echo $randonNumber; ?>'))
							sesJqueryObject('#loading_image_related_<?php echo $randonNumber; ?>').css('display','none');
				}
		});
	 var divPosition = sesJqueryObject('.eblog_album_cover_inner').offset();
	 sesJqueryObject('html, body').animate({scrollTop: divPosition.top}, "slow");
	 if("<?php echo $this->view_type ; ?>" == 'masonry'){
		sesJqueryObject("#ses-image-view").sesbasicFlexImage({rowHeight: <?php echo str_replace('px','',$this->height); ?>});
	 }
<?php } ?>
viewMoreHide_<?php echo $randonNumber; ?>();
  function viewMoreHide_<?php echo $randonNumber; ?>() {
    if ($('view_more_<?php echo $randonNumber; ?>'))
      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
			if(sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'none'){
				sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').remove();
				sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').remove();
			}	
  }
	 function viewMore_<?php echo $randonNumber; ?> (){
    document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
    document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';    
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'widget/index/mod/eblog/name/album-view-page/',
      'data': {
        format: 'html',
        page: <?php echo $this->page ; ?>,    
				params :'<?php echo json_encode($this->params); ?>', 
				is_ajax : 1,
				album_id:'<?php echo $this->album_id; ?>',
				blog_id:'<?php echo $this->blog_id ?>',
				identity : '<?php echo $randonNumber; ?>',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('ses-image-view').innerHTML = document.getElementById('ses-image-view').innerHTML + responseHTML;
				if("<?php echo $this->view_type ; ?>" == 'masonry'){
							sesJqueryObject("#ses-image-view").sesbasicFlexImage({rowHeight: <?php echo str_replace('px','',$this->height); ?>});
				}
				if($('loading_image_<?php echo $randonNumber; ?>'))
					document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
      }
    })).send();
    return false;
  }

function paggingNumber<?php echo $randonNumber; ?>(pageNum){
		 sesJqueryObject ('.overlay_<?php echo $randonNumber ?>').css('display','block');
			(new Request.HTML({
				method: 'post',
				'url': en4.core.baseUrl + 'widget/index/mod/eblog/name/album-view-page/',
				'data': {
					format: 'html',
					page: pageNum,    
					params :'<?php echo json_encode($this->params); ?>', 
					is_ajax : 1,
					identity : '<?php echo $randonNumber; ?>',
					album_id:'<?php echo $this->album_id; ?>',
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					sesJqueryObject ('.overlay_<?php echo $randonNumber ?>').css('display','none');
					document.getElementById('ses-image-view').innerHTML =  responseHTML;
					if("<?php echo $this->view_type ; ?>" == 'masonry'){
						sesJqueryObject("#ses-image-view").sesbasicFlexImage({rowHeight: <?php echo str_replace('px','',$this->height); ?>});
					}
				}
			})).send();
			return false;
	}
</script>
