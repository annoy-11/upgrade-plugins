<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seseventmusic/externals/scripts/favourites.js'); ?>
<script type="text/javascript">
  function showPopUp(url) {
    Smoothbox.open(url);
    parent.Smoothbox.close;
  }
</script>
<?php if($this->contentType == 'album'): ?>
<ul class="seseventmusic_side_block seseventmusic_browse_listing">
  <li class="seseventmusic_item_grid">
    <div class="seseventmusic_item_artwork">
      <?php echo $this->itemPhoto($this->album, 'thumb.main') ?>
      <a href="<?php echo $this->album->getHref(); ?>" class="transparentbg"></a>
      <div class="seseventmusic_item_info">
        <?php if(!empty($this->information) && in_array('title', $this->information)): ?>
        <div class="seseventmusic_item_info_title">
          <?php echo $this->htmlLink($this->album->getHref(), $this->album->getTitle()) ?>
        </div>
        <?php endif; ?>

        <?php if(!empty($this->information) && in_array('postedby', $this->information)): ?>
        <div class="seseventmusic_item_info_owner">
          <?php echo $this->translate('by');?> <?php echo $this->htmlLink($this->album->getOwner()->getHref(), $this->album->getOwner()->getTitle()) ?>
        </div>
        <?php endif; ?>

        <div class="seseventmusic_item_info_stats">
           <?php if (!empty($this->information) && in_array('favouriteCount', $this->information)) : ?>
            <span>
              <?php echo $this->album->favourite_count; ?>
              <i class="fa fa-heart"></i>
            </span>
          <?php endif; ?>
          <?php if (!empty($this->information) && in_array('commentCount', $this->information)) : ?>
          <span>
            <?php echo $this->album->comment_count; ?>
            <i class="fa fa-comment"></i>
          </span>
          <?php endif; ?>
          <?php if (!empty($this->information) && in_array('likeCount', $this->information)) : ?>
          <span>
            <?php echo $this->album->like_count; ?>
            <i class="fa fa-thumbs-up"></i>
          </span>
          <?php endif; ?>
          <?php if (!empty($this->information) && in_array('viewCount', $this->information)) : ?>
          <span>
            <?php echo $this->album->view_count; ?>
            <i class="fa fa-eye"></i>
          </span>
          <?php endif; ?>
          <?php if (!empty($this->information) && in_array('songsCount', $this->information)) : ?>
          <span>
            <?php echo $this->album->song_count; ?>
            <i class="fa fa-music"></i>
          </span>
          <?php endif; ?>
        </div>
        
        <?php if ($this->showRating && !empty($this->information) && in_array('ratingCount', $this->information)) : ?>
        <div class="seseventmusic_item_info_rating">
          <?php if( $this->album->rating > 0 ): ?>
          <?php for( $x=1; $x<= $this->album->rating; $x++ ): ?>
          <span class="sesbasic_rating_star_small fa fa-star"></span>
          <?php endfor; ?>
          <?php if( (round($this->album->rating) - $this->album->rating) > 0): ?>
          <span class="sesbasic_rating_star_small fa fa-star-half"></span>
          <?php endif; ?>
          <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php // Featured and Sponsored and Hot Label Icon ?>
        <div class="seseventmusic_item_info_label">
          <?php if(!empty($this->album->hot) && !empty($this->information) && in_array('hot', $this->information)): ?>
          <span class="seseventmusic_label_hot"><?php echo $this->translate("HOT"); ?></span>
          <?php endif; ?>
          <?php if(!empty($this->album->featured) && !empty($this->information) && in_array('featured', $this->information)): ?>
          <span class="seseventmusic_label_featured"><?php echo $this->translate("FEATURED"); ?></span>
          <?php endif; ?>
          <?php if(!empty($this->album->sponsored) && !empty($this->information) && in_array('sponsored', $this->information)): ?>
          <span class="seseventmusic_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>
          <?php endif; ?>
        </div>
      </div>

      <div class="hover_box">
        <a title="<?php echo $this->album->getTitle(); ?>" class="seseventmusic_grid_link" href="<?php echo $this->album->getHref(); ?>"></a>
        <div class="hover_box_options">
          <?php if($this->viewer_id): ?>
          <?php if($this->canAddFavourite): ?>
          <a title='<?php echo $this->translate("Remove from Favorite") ?>' class="favorite-white favorite" id="seseventmusic_album_unfavourite_<?php echo $this->album->getIdentity(); ?>" style ='display:<?php echo $this->isFavourite ? "inline-block" : "none" ?>' href = "javascript:void(0);" onclick = "seseventmusicFavourite('<?php echo $this->album->getIdentity(); ?>', 'seseventmusic_album');"><i class="fa fa-heart seseventmusic_favourite"></i></a>
          <a title='<?php echo $this->translate("Add to Favorite") ?>' class="favorite-white favorite" id="seseventmusic_album_favourite_<?php echo $this->album->getIdentity(); ?>" style ='display:<?php echo $this->isFavourite ? "none" : "inline-block" ?>' href = "javascript:void(0);" onclick = "seseventmusicFavourite('<?php echo $this->album->getIdentity(); ?>', 'seseventmusic_album');"><i class="fa fa-heart"></i></a>
          <input type ="hidden" id = "seseventmusic_album_favouritehidden_<?php echo $this->album->getIdentity(); ?>" value = '<?php echo $this->isFavourite ? $this->isFavourite : 0; ?>' />
          <?php endif; ?>

          <?php if($this->albumlink && in_array('share', $this->albumlink)): ?>
          <a class="share-white" title='<?php echo $this->translate("Share") ?>' href="javascript:void(0);" onclick="showPopUp('<?php echo $this->escape($this->url(array('module'=>'activity', 'controller'=>'index', 'action'=>'share', 'route'=>'default', 'type'=>'seseventmusic_album', 'id' => $this->album->getIdentity(), 'format' => 'smoothbox'), 'default' , true)); ?>'); return false;" ><i class="fa fa-share"></i></a>
          <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </li>
</ul>
<?php elseif($this->contentType == 'albumsong'): ?>
<ul class="seseventmusic_side_block seseventmusic_browse_listing">
  <li class="seseventmusic_item_grid">
    <div class="seseventmusic_item_artwork">
      <?php if($this->song->photo_id): ?>
        <?php echo $this->itemPhoto($this->song, 'thumb.profile') ?>
      <?php else: ?>
        <?php echo $this->itemPhoto($this->song, 'thumb.main') ?>
      <?php endif; ?>
      <a href="<?php echo $this->song->getHref(); ?>" class="transparentbg"></a>

      <div class="seseventmusic_item_info">
        <?php if(!empty($this->information) && in_array('title', $this->information)): ?>
        <div class="seseventmusic_item_info_title">
          <?php echo $this->htmlLink($this->song->getHref(), $this->song->getTitle()) ?>
        </div>
        <?php endif; ?>

        <?php if(!empty($this->information) && in_array('postedby', $this->information)): ?>
        <div class="seseventmusic_item_info_owner">
          <?php echo $this->translate('by');?> <?php echo $this->htmlLink($this->song->getOwner()->getHref(), $this->song->getOwner()->getTitle()) ?>
        </div>
        <?php endif; ?>

        <div class="seseventmusic_item_info_stats">
          <?php if (!empty($this->information) && in_array('favouriteCount', $this->information)) : ?>
            <span>
              <?php echo $this->song->favourite_count; ?>
              <i class="fa fa-heart"></i>              
            </span>
          <?php endif; ?>
          <?php if (!empty($this->information) && in_array('commentCount', $this->information)) : ?>
          <span>
            <?php echo $this->song->comment_count; ?>
            <i class="fa fa-comment"></i>
          </span>
          <?php endif; ?>
          <?php if (!empty($this->information) && in_array('likeCount', $this->information)) : ?>
          <span>
            <?php echo $this->song->like_count; ?>
            <i class="fa fa-thumbs-up"></i>
          </span>
          <?php endif; ?>
          <?php if (!empty($this->information) && in_array('viewCount', $this->information)) : ?>
          <span>
            <?php echo $this->song->view_count; ?>
            <i class="fa fa-eye"></i>
          </span>
          <?php endif; ?>
          <?php if (!empty($this->information) && in_array('downloadCount', $this->information)) : ?>
            <span>
              <?php echo $this->song->download_count; ?>
              <i class="fa fa-download"></i>
            </span>
          <?php endif; ?>
        </div>
        
        <?php if ($this->showAlbumSongRating && !empty($this->information) && in_array('ratingCount', $this->information)) : ?>
          <div class="seseventmusic_item_info_rating">
            <?php if( $this->song->rating > 0 ): ?>
            <?php for( $x=1; $x<= $this->song->rating; $x++ ): ?>
            <span class="sesbasic_rating_star_small fa fa-star"></span>
            <?php endfor; ?>
            <?php if( (round($this->song->rating) - $this->song->rating) > 0): ?>
            <span class="sesbasic_rating_star_small fa fa-star-half"></span>
            <?php endif; ?>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <?php // Featured and Sponsored and Hot Label Icon ?>
        <div class="seseventmusic_item_info_label">
          <?php if(!empty($this->song->hot) && !empty($this->information) && in_array('hot', $this->information)): ?>
          <span class="seseventmusic_label_hot"><?php echo $this->translate("HOT"); ?></span>
          <?php endif; ?>
          <?php if(!empty($this->song->featured) && !empty($this->information) && in_array('featured', $this->information)): ?>
          <span class="seseventmusic_label_featured"><?php echo $this->translate("FEATURED"); ?></span>
          <?php endif; ?>
          <?php if(!empty($this->song->sponsored) && !empty($this->information) && in_array('sponsored', $this->information)): ?>
          <span class="seseventmusic_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>
          <?php endif; ?>
        </div>
      </div>

      <div class="hover_box">
        <a title="<?php echo $this->song->getTitle(); ?>" class="seseventmusic_grid_link" href="<?php echo $this->song->getHref(); ?>"></a>
			  <?php if($this->song->track_id): ?>
	        <?php $uploadoption = Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.uploadoption', 'myComputer');
	        $consumer_key =  Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.scclientid'); ?>          
	        <?php if(($uploadoption == 'both' || $uploadoption == 'soundCloud') && $consumer_key): ?>
	        <?php $track_id = $this->song->track_id;
          $URL = "http://api.soundcloud.com/tracks/$track_id/stream?consumer_key=$consumer_key"; ?>
	          <a class="seseventmusic_play_button" href="javascript:void(0);" onclick="play_music('<?php echo $this->song->albumsong_id ?>', '<?php echo $URL; ?>', '<?php echo preg_replace("/[^A-Za-z0-9\-]/", "", $this->song->getTitle()); ?>');"><i class="fa fa-play-circle"></i></a>
	        <?php else: ?>
	          <a class="seseventmusic_play_button" href="javascript:void(0);"><i class="fa fa-play-circle"></i></a>
	        <?php endif; ?>
	      <?php else: ?>
	        <a class="seseventmusic_play_button" href="javascript:void(0);" onclick="play_music('<?php echo $this->song->albumsong_id ?>', '<?php echo $this->song->getFilePath(); ?>', '<?php echo $this->song->getTitle(); ?>');"><i class="fa fa-play-circle"></i></a>
	      <?php endif; ?>
        <div class="hover_box_options">
          <?php if($this->viewer_id): ?>
            <?php if($this->addfavouriteAlbumSong): ?>
              <a title='<?php echo $this->translate("Remove from Favorite") ?>' class="favorite-white favorite" id="seseventmusic_albumsong_unfavourite_<?php echo $this->song->getIdentity(); ?>" style ='display:<?php echo $this->isFavourite ? "inline-block" : "none" ?>' href = "javascript:void(0);" onclick = "seseventmusicFavourite('<?php echo $this->song->getIdentity(); ?>', 'seseventmusic_albumsong');"><i class="fa fa-heart seseventmusic_favourite"></i></a>
              <a title='<?php echo $this->translate("Add to Favorite") ?>' class="favorite-white favorite" id="seseventmusic_albumsong_favourite_<?php echo $this->song->getIdentity(); ?>" style ='display:<?php echo $this->isFavourite ? "none" : "inline-block" ?>' href = "javascript:void(0);" onclick = "seseventmusicFavourite('<?php echo $this->song->getIdentity(); ?>', 'seseventmusic_albumsong');"><i class="fa fa-heart"></i></a>
              <input type ="hidden" id = "seseventmusic_albumsong_favouritehidden_<?php echo $this->song->getIdentity(); ?>" value = '<?php echo $this->isFavourite ? $this->isFavourite : 0; ?>' />
            <?php endif; ?>
            <?php if($this->songlink && in_array('share', $this->songlink)): ?>
              <a class="share-white" title='<?php echo $this->translate("Share") ?>' href="javascript:void(0);" onclick="showPopUp('<?php echo $this->escape($this->url(array('module'=>'activity', 'controller'=>'index', 'action'=>'share', 'route'=>'default', 'type'=>'seseventmusic_albumsong', 'id' => $this->song->getIdentity(), 'format' => 'smoothbox'), 'default' , true)); ?>'); return false;" ><i class="fa fa-share"></i></a>
            <?php endif ;?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </li>
</ul>
<?php endif; ?>