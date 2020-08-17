<?php

?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();  ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seseventmusic/externals/scripts/favourites.js'); ?> 

<?php 
  if(isset($this->identityForWidget) && !empty($this->identityForWidget)):
    $randonNumber = $this->identityForWidget;
  else:
    $randonNumber = $this->identity; 
  endif;
?>
<?php if(!$this->is_ajax): ?>
<script type="application/javascript">
var tabId_pMusic = <?php echo $this->identity; ?>;
window.addEvent('domready', function() {
	tabContainerHrefSesbasic(tabId_pMusic);	
});
</script>
	<?php if($this->allowMusic && $this->canCreateMusic): ?>
		<div class="sesevent_event_profile_widgets_top sesbasic_clearfix">
			<a class="sesbasic_button fa fa-plus" href='<?php echo $this->url(array('action' => 'create','event_id' => $this->event_id ),'seseventmusic_general', true) ?>'><?php echo $this->translate("Add Music"); ?></a>
		</div>
	<?php endif; ?>
  <div class="clear sesbasic_clearfix" id="scrollHeightDivSes_<?php echo $randonNumber; ?>">
          <ul class="clear sesbasic_clearfix" id="tabbed-widget_<?php echo $randonNumber; ?>">
          <?php endif; ?>
          <?php $limit = $this->limit; ?>
          <?php if($this->paginator->getTotalItemCount() > 0): ?>
    			<?php foreach( $this->paginator as $photo ): ?>
          <?php if($this->albumPhotoOption == 'album') { ?>
            <li id="thumbs-photo-<?php echo $photo->album_id ?>" class="seseventmusic_item_grid" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
              <div class="seseventmusic_item_artwork" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
                <?php echo $this->htmlLink($photo, $this->itemPhoto($photo, 'thumb.main') ) ?>
                <a href="<?php echo $photo->getHref(); ?>" class="transparentbg"></a>
                <div class="seseventmusic_item_info">
                  <div class="seseventmusic_item_info_title">
                    <?php echo $this->htmlLink($photo->getHref(), $photo->getTitle()) ?>
                  </div>
                  <?php if(!empty($this->informationAlbum) && in_array('postedBy', $this->informationAlbum)): ?>
                    <div class="seseventmusic_item_info_owner">
                      <?php echo $this->translate('by %s', $this->htmlLink($photo->getOwner(), $photo->getOwner()->getTitle())) ?>
                    </div>
                  <?php endif; ?>
                  <div class="seseventmusic_item_info_stats">
                    <?php if(!empty($this->informationAlbum) && in_array('commentCount', $this->informationAlbum)): ?>
                      <span>
                        <?php echo $this->translate(array($photo->comment_count), $this->locale()->toNumber($photo->comment_count)) ?>
                        <i class="fa fa-comment"></i>
                      </span>
                    <?php endif; ?>
                    <?php if(!empty($this->informationAlbum) && in_array('likeCount', $this->informationAlbum)): ?>
                      <span>
                        <?php echo $this->translate(array($photo->like_count), $this->locale()->toNumber($photo->like_count)) ?>
                        <i class="fa fa-thumbs-up"></i>
                      </span>
                    <?php endif; ?>
                    <?php if(!empty($this->informationAlbum) && in_array('viewCount', $this->informationAlbum)): ?>
                      <span>
                        <?php echo $this->translate(array($photo->view_count), $this->locale()->toNumber($photo->view_count)) ?>
                        <i class="fa fa-eye"></i>
                      </span>
                    <?php endif; ?>
                    <?php if(!empty($this->informationAlbum) && in_array('songCount', $this->informationAlbum)): ?>
                      <span>
                        <?php echo $this->translate(array($photo->song_count), $this->locale()->toNumber($photo->song_count)) ?>
                        <i class="fa fa-music"></i>
                      </span>
                    <?php endif; ?>
                  </div>
                  <?php if ($this->showRating && !empty($this->informationAlbum) && in_array('ratingStars', $this->informationAlbum)) : ?>
                    <div class="seseventmusic_item_info_rating">
                      <?php if( $photo->rating > 0 ): ?>
                      <?php for( $x=1; $x<= $photo->rating; $x++ ): ?>
                      <span class="sesbasic_rating_star_small fa fa-star"></span>
                      <?php endfor; ?>
                      <?php if( (round($photo->rating) - $photo->rating) > 0): ?>
                      <span class="sesbasic_rating_star_small fa fa-star-half"></span>
                      <?php endif; ?>
                      <?php endif; ?>
                    </div>
                  <?php endif; ?>
                  <div class="seseventmusic_item_info_label">
                    <?php if($photo->hot && !empty($this->informationAlbum) && in_array('hot', $this->informationAlbum)): ?>
                      <span class="seseventmusic_label_hot"><?php echo $this->translate("HOT"); ?></span>
                    <?php endif; ?>
                    <?php if($photo->featured && !empty($this->informationAlbum) && in_array('featured', $this->informationAlbum)): ?>
                    <span class="seseventmusic_label_featured"><?php echo $this->translate("FEATURED"); ?></span>
                    <?php endif; ?>
                    <?php if($photo->sponsored && !empty($this->informationAlbum) && in_array('sponsored', $this->informationAlbum)): ?>
                    <span class="seseventmusic_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="hover_box">
                  <a title="<?php echo $photo->getTitle(); ?>" class="seseventmusic_grid_link" href="<?php echo $photo->getHref(); ?>"></a>
                  <div class="hover_box_options">
                  <?php 
                  if($viewer_id): ?>
                      <?php $isFavourite = Engine_Api::_()->getDbTable('favourites', 'seseventmusic')->isFavourite(array('resource_type' => "seseventmusic_album", 'resource_id' => $photo->album_id)); ?>

                      <?php if($this->addfavouriteAlbumSong && !empty($this->informationAlbum) && in_array('favourite', $this->informationAlbum)): ?>
	                      <a title='<?php echo $this->translate("Remove from Favorite") ?>' class="favorite-white favorite" id="seseventmusic_album_unfavourite_<?php echo $photo->album_id; ?>" style ='display:<?php echo $isFavourite ? "inline-block" : "none" ?>' href = "javascript:void(0);" onclick = "seseventmusicFavourite('<?php echo $photo->album_id; ?>', 'seseventmusic_album');"><i class="fa fa-heart seseventmusic_favourite"></i></a>
	                      <a title='<?php echo $this->translate("Add to Favorite") ?>' class="favorite-white favorite" id="seseventmusic_album_favourite_<?php echo $photo->album_id; ?>" style ='display:<?php echo $isFavourite ? "none" : "inline-block" ?>' href = "javascript:void(0);" onclick = "seseventmusicFavourite('<?php echo $photo->album_id; ?>', 'seseventmusic_album');"><i class="fa fa-heart"></i></a>
	                      <input type="hidden" id="seseventmusic_album_favouritehidden_<?php echo $photo->album_id; ?>" value='<?php echo $isFavourite ? $isFavourite : 0; ?>' />
                      <?php endif; ?>
	                    <?php if(in_array('share', $this->albumlink) && !empty($this->informationAlbum) && in_array('share', $this->informationAlbum)): ?>
		                    <a class="share-white" title='<?php echo $this->translate("Share") ?>' href="javascript:void(0);" onclick="showPopUp('<?php echo $this->escape($this->url(array('module'=>'activity', 'controller'=>'index', 'action'=>'share', 'route'=>'default', 'type'=>'seseventmusic_album', 'id' => $photo->album_id, 'format' => 'smoothbox'), 'default' , true)); ?>'); return false;" ><i class="fa fa-share"></i></a>
	                    <?php endif; ?>
                    <?php endif; ?>
                    <?php  ?>
                  </div>
                </div>
              </div>
            </li>
          <?php  } ?>
          <?php $limit++; ?>
      <?php endforeach;?>
      <?php endif; ?>
      <?php if($this->paginator->getTotalItemCount() == 0): ?>
        <div class="tip">
          <span>
              <?php echo $this->translate("There are currently no albums");?>
          </span>
        </div>    
      <?php endif; ?>
    <?php if(!$this->is_ajax) { ?>
  </ul>
  <div class="sesbasic_view_more" id="view_more_<?php echo $randonNumber; ?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore')); ?> </div>
  <div class="sesbasic_view_more_loading" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' style='margin-right: 5px;' /> <?php echo $this->translate("Loading ...") ?> </div>
</div>
<script type="text/javascript">
var valueTabData ;

  //Globally define available tab array

	var requestTab_<?php echo $randonNumber; ?>;

<?php if($this->loadOptionData == 'auto_load'){ ?>
		window.addEvent('domready', function() {
		 sesBasicAutoScroll(window).scroll( function() {
			  var heightOfContentDiv_<?php echo $randonNumber; ?> = sesBasicAutoScroll('#scrollHeightDivSes_<?php echo $randonNumber; ?>').offset().top;
        var fromtop_<?php echo $randonNumber; ?> = sesBasicAutoScroll(this).scrollTop();
        if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesBasicAutoScroll('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
						document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
				}
     });
	});
<?php } ?>
</script>
<?php } ?>

<script type="text/javascript">
	viewMoreHide_<?php echo $randonNumber; ?>();
  function viewMoreHide_<?php echo $randonNumber; ?>() {
    if ($('view_more_<?php echo $randonNumber; ?>'))
      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
  }
  function viewMore_<?php echo $randonNumber; ?> (){
    var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
    document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
    document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';    
    en4.core.request.send(new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'widget/index/mod/seseventmusic/name/profile-musicalbums/openTab/' + openTab_<?php echo $randonNumber; ?>,
      'data': {
        format: 'html',
        page: <?php echo $this->page + 1; ?>,    
				params :'<?php echo json_encode($this->params); ?>', 
				is_ajax : 1,
				identity : '<?php echo $randonNumber; ?>',
				//identityObject : '<?php echo $this->identityObject; ?>',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
				document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
      }
    }));
    return false;
  }
</script>
