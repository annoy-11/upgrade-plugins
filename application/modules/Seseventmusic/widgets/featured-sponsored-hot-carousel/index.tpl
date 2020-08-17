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

<?php $randonNumber = $this->identity; ?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<script type="text/javascript" src="<?php echo $baseUrl; ?>application/modules/Sesbasic/externals/scripts/PeriodicalExecuter.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl; ?>application/modules/Sesbasic/externals/scripts/Carousel.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl; ?>application/modules/Sesbasic/externals/scripts/Carousel.Extra.js"></script>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seseventmusic/externals/styles/carousel.css'); ?>

<style>
  #slide_<?php echo $randonNumber; ?> {
    position: relative;
    height:<?php echo $this->height ?>px;
    overflow: hidden;
  }
</style>

<div class="slide seseventmusic_carousel_wrapper clearfix <?php if($this->viewType == 'horizontal'): ?> seseventmusic_carousel_h_wrapper <?php else: ?> seseventmusic_carousel_v_wrapper <?php endif; ?>">
  <div id="slide_<?php echo $randonNumber; ?>">
    <?php foreach( $this->results as $item ):  ?>
    <div class="seseventmusic_item_grid" style="width:<?php echo $this->width ?>px;">
      <div class="seseventmusic_item_artwork" style="height:<?php echo $this->height ?>px;">
        <?php if($this->contentType == 'songs'): ?>
          <?php $album = Engine_Api::_()->getItem('seseventmusic_albums', $item->album_id); ?>
          <?php if($item->photo_id): ?>
            <?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.profile')); ?>
          <?php else: ?>
            <?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.main')); ?>
          <?php endif; ?>
        <?php else: ?>
          <?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.main')); ?>
        <?php endif; ?>
        <a href="<?php echo $item->getHref(); ?>" class="transparentbg"></a>

        <div class="seseventmusic_item_info">
          <div class="seseventmusic_item_info_title">
            <?php if(!empty($this->information) && in_array('title', $this->information)): ?>
              <?php echo $this->htmlLink($item->getHref(), $item->getTitle(), array('title' => $item->description)) ?>
            <?php endif; ?>
          </div>
          <?php //if($this->contentType == 'albums'): ?>
            <?php if(!empty($this->information) && in_array('postedby', $this->information)): ?>
              <div class="seseventmusic_item_info_owner">
                <?php echo $this->translate('by');?> <?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle()) ?>
              </div>
            <?php endif; ?>
            <div class="seseventmusic_item_info_stats">
              <?php if (!empty($this->information) && in_array('commentCount', $this->information)) :?>
                <span>
                  <?php echo $item->comment_count; ?>
                  <i class="fa fa-comment"></i>
                </span>
              <?php endif; ?>
              <?php if (!empty($this->information) && in_array('likeCount', $this->information)) : ?>
                <span>
                  <?php echo $item->like_count; ?>
                  <i class="fa fa-thumbs-up"></i>
                </span>
              <?php endif; ?>
              <?php if (!empty($this->information) && in_array('viewCount', $this->information)) : ?>
                <span>
                  <?php echo $item->view_count; ?>
                  <i class="fa fa-eye"></i>
                </span>
              <?php endif; ?>
              <?php if ($this->contentType == 'albums' && !empty($this->information) && in_array('songCount', $this->information)) : ?>
                <span>
                  <?php echo $item->song_count; ?>
                  <i class="fa fa-music"></i>
                </span>
              <?php endif; ?>
              <?php if($this->contentType == 'songs'): ?>
                <?php if (!empty($this->information) && in_array('downloadCount', $this->information)) : ?>
                <span>
                  <?php echo $item->download_count; ?>
                  <i class="fa fa-download"></i>
                </span>
                <?php endif; ?>
                <?php if (!empty($this->information) && in_array('playCount', $this->information)) : ?>
                <span>
                  <?php echo $item->play_count; ?>
                  <i class="fa fa-play"></i>
                </span>
                <?php endif; ?>
              <?php endif; ?>
            </div>

            <?php if ($this->contentType == 'albums' && $this->showRating && !empty($this->information) && in_array('ratingCount', $this->information)) : ?>
              <div class="seseventmusic_item_info_rating">
                <?php if( $item->rating > 0 ): ?>
                <?php for( $x=1; $x<= $item->rating; $x++ ): ?>
                <span class="sesbasic_rating_star_small fa fa-star"></span>
                <?php endfor; ?>
                <?php if( (round($item->rating) - $item->rating) > 0): ?>
                <span class="sesbasic_rating_star_small fa fa-star-half"></span>
                <?php endif; ?>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            <?php if ($this->contentType == 'songs' && $this->showAlbumSongRating && !empty($this->information) && in_array('ratingCount', $this->information)) : ?>
              <div class="seseventmusic_item_info_rating">
                <?php if( $item->rating > 0 ): ?>
                <?php for( $x=1; $x<= $item->rating; $x++ ): ?>
                <span class="sesbasic_rating_star_small fa fa-star"></span>
                <?php endfor; ?>
                <?php if( (round($item->rating) - $item->rating) > 0): ?>
                <span class="sesbasic_rating_star_small fa fa-star-half"></span>
                <?php endif; ?>
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <?php // Featured and Sponsored and Hot Label Icon ?>
            <div class="seseventmusic_item_info_label">
              <?php if(!empty($item->hot) && !empty($this->information) && in_array('hot', $this->information)): ?>
              <span class="seseventmusic_label_hot"><?php echo $this->translate("HOT"); ?></span>
              <?php endif; ?>
              <?php if(!empty($item->featured) && !empty($this->information) && in_array('featured', $this->information)): ?>
              <span class="seseventmusic_label_featured"><?php echo $this->translate("FEATURED"); ?></span>
              <?php endif; ?>
              <?php if(!empty($item->sponsored) && !empty($this->information) && in_array('sponsored', $this->information)): ?>
              <span class="seseventmusic_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>
              <?php endif; ?>
            </div>
          <?php //endif; ?>
        </div>
        <?php if($this->contentType == 'albums'): ?>
        <div class="hover_box">
          <a title="<?php echo $item->getTitle(); ?>" href="<?php echo $item->getHref(); ?>" class="seseventmusic_grid_link"></a>
          <div class="hover_box_options">
            <?php if($this->viewer_id): ?>
              <?php if($this->canAddFavourite && !empty($this->information) && in_array('favourite', $this->information)): ?>
                <?php $isFavourite = Engine_Api::_()->getDbTable('favourites', 'seseventmusic')->isFavourite(array('resource_type' => "seseventmusic_album", 'resource_id' => $item->album_id)); ?>
                <a title='<?php echo $this->translate("Remove from Favorite") ?>' class="favorite-white favorite" id="seseventmusic_album_unfavourite_<?php echo $item->album_id; ?>" style ='display:<?php echo $isFavourite ? "inline-block" : "none" ?>' href = "javascript:void(0);" onclick = "seseventmusicFavourite('<?php echo $item->album_id; ?>', 'seseventmusic_album');"><i class="fa fa-heart seseventmusic_favourite"></i></a>
                <a title='<?php echo $this->translate("Add to Favorite") ?>' class="favorite-white favorite" id="seseventmusic_album_favourite_<?php echo $item->album_id; ?>" style ='display:<?php echo $isFavourite ? "none" : "inline-block" ?>' href = "javascript:void(0);" onclick = "seseventmusicFavourite('<?php echo $item->album_id; ?>', 'seseventmusic_album');"><i class="fa fa-heart"></i></a>
                <input type="hidden" id="seseventmusic_album_favouritehidden_<?php echo $item->album_id; ?>" value='<?php echo $isFavourite ? $isFavourite : 0; ?>' />
              <?php endif; ?>
              <?php if($this->albumlink && in_array('share', $this->albumlink) && !empty($this->information) && in_array('share', $this->information)): ?>
                <a class="share-white" title='<?php echo $this->translate("Share") ?>' href="javascript:void(0);" onclick="showPopUp('<?php echo $this->escape($this->url(array('module'=>'activity', 'controller'=>'index', 'action'=>'share', 'route'=>'default', 'type'=>'seseventmusic_album', 'id' => $item->album_id, 'format' => 'smoothbox'), 'default' , true)); ?>'); return false;" ><i class="fa fa-share"></i></a>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
        <?php else: ?>
        <div class="hover_box">
          <a title="<?php echo $item->getTitle(); ?>" href="<?php echo $item->getHref(); ?>" class="seseventmusic_grid_link"></a>
          <?php if($item->track_id): ?>
            <?php $uploadoption = Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.uploadoption', 'myComputer');
            $consumer_key =  Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.scclientid'); ?>          
            <?php if(($uploadoption == 'both' || $uploadoption == 'soundCloud') && $consumer_key): ?>
            <?php $URL = "http://api.soundcloud.com/tracks/$item->track_id/stream?consumer_key=$consumer_key"; ?>
              <a class="seseventmusic_play_button" href="javascript:void(0);" onclick="play_music('<?php echo $item->albumsong_id ?>', '<?php echo $URL; ?>', '<?php echo preg_replace("/[^A-Za-z0-9\-]/", "", $item->getTitle()); ?>');"><i class="fa fa-play-circle"></i></a>
            <?php else: ?>
              <a class="seseventmusic_play_button" href="javascript:void(0);"><i class="fa fa-play-circle"></i></a>
            <?php endif; ?>
          <?php else: ?>
            <a class="seseventmusic_play_button" href="javascript:void(0);" onclick="play_music('<?php echo $item->albumsong_id ?>', '<?php echo $item->getFilePath(); ?>', '<?php echo $item->getTitle(); ?>');"><i class="fa fa-play-circle"></i></a>
          <?php endif; ?>
          <div class="hover_box_options">
            <?php if($this->viewer_id): ?>
            <?php if($this->addfavouriteAlbumSong): ?>
            <?php $isFavourite = Engine_Api::_()->getDbTable('favourites', 'seseventmusic')->isFavourite(array('resource_type' => "seseventmusic_albumsong", 'resource_id' => $item->albumsong_id)); ?>                            <a title='<?php echo $this->translate("Remove from Favorite") ?>' class="favorite-white favorite" id="seseventmusic_albumsong_unfavourite_<?php echo $item->albumsong_id; ?>" style ='display:<?php echo $isFavourite ? "inline-block" : "none" ?>' href = "javascript:void(0);" onclick = "seseventmusicFavourite('<?php echo $item->albumsong_id; ?>', 'seseventmusic_albumsong');"><i class="fa fa-heart"></i></a>
            <a title='<?php echo $this->translate("Add to Favorite") ?>' class="favorite-white favorite" id="seseventmusic_albumsong_favourite_<?php echo $item->albumsong_id; ?>" style ='display:<?php echo $isFavourite ? "none" : "inline-block" ?>' href = "javascript:void(0);" onclick = "seseventmusicFavourite('<?php echo $item->albumsong_id; ?>', 'seseventmusic_albumsong');"><i class="fa fa-heart"></i></a>
            <input type ="hidden" id = "seseventmusic_albumsong_favouritehidden_<?php echo $item->albumsong_id; ?>" value = '<?php echo $isFavourite ? $isFavourite : 0; ?>' />
            <?php endif; ?>
            <?php if($this->songlink && in_array('share', $this->songlink)): ?>
            <a class="share-white" title='<?php echo $this->translate("Share") ?>' href="javascript:void(0);" onclick="showPopUp('<?php echo $this->escape($this->url(array('module'=>'activity', 'controller'=>'index', 'action'=>'share', 'route'=>'default', 'type'=>'seseventmusic_albumsong', 'id' => $item->albumsong_id, 'format' => 'smoothbox'), 'default' , true)); ?>'); return false;" ><i class="fa fa-share"></i></a>
            <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <div>
        <?php //echo $this->htmlLink($item->getHref(), $item->getTitle(), array('title' => $item->description)) ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php if($this->viewType == 'horizontal'): ?>
    <div class="tabs_<?php echo $randonNumber; ?> seseventmusic_carousel_nav">
      <a class="seseventmusic_carousel_nav_pre" href="#page-p"><i class="fa fa-caret-left"></i></a>
      <a class="seseventmusic_carousel_nav_nxt" href="#page-p"><i class="fa fa-caret-right"></i></a>
    </div>  
  <?php else: ?>
    <div class="tabs_<?php echo $randonNumber; ?> seseventmusic_carousel_nav">
      <a class="seseventmusic_carousel_nav_pre" href="#page-p"><i class="fa fa-caret-up"></i></a>
      <a class="seseventmusic_carousel_nav_nxt" href="#page-p"><i class="fa fa-caret-down"></i></a>
    </div>  
  <?php endif; ?>

</div>
<script type="text/javascript">
window.addEvent('domready', function() {
  var duration = 150,
  div = document.getElement('div.tabs_<?php echo $randonNumber; ?>');
  links = div.getElements('a'),
  carousel = new Carousel.Extra({
    activeClass: 'selected',
    container: 'slide_<?php echo $randonNumber; ?>',
    circular: true,
    current: 1,
    previous: links.shift(),
    next: links.pop(),
    tabs: links,
    mode: '<?php echo $this->viewType; ?>',
    fx: {
      duration: duration
    }
  })
});
</script>
