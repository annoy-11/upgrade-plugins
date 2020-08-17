<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: view.tpl 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seseventmusic/externals/scripts/favourites.js'); ?> 
<?php
//This is done to make these links more uniform with other viewscripts
$album = $this->album;
$songs = $album->getSongs();
?>
<div class="seseventmusic_item_view_wrapper clear">
  <ul class="clear seseventmusic_songslist_container playlist_<?php echo $album->getIdentity() ?>">
  <?php foreach( $songs as $song ): ?>
    <?php if( !empty($song) ): ?>
      <li class="seseventmusic_songslist sesbasic_clearfix">
        <div class="seseventmusic_songslist_photo">
            <?php if($song->photo_id): ?>
              <?php echo $this->htmlLink($song->getHref(), $this->itemPhoto($song, 'thumb.profile'), array()); ?>
            <?php else: ?>
             <?php $albumItem = Engine_Api::_()->getItem('seseventmusic_albums', $song->album_id); ?>
             <?php echo $this->htmlLink($song->getHref(), $this->itemPhoto($song, 'thumb.normal'), array()); ?>
            <?php endif; ?>
           <?php if($song->hot || $song->featured || $song->sponsored): ?>
              <div class="seseventmusic_item_info_label">
                <?php if($song->hot): ?>
                  <span class="seseventmusic_label_hot"><?php echo $this->translate("HOT"); ?></span>
                <?php endif; ?>
                <?php if($song->featured): ?>
                <span class="seseventmusic_label_featured"><?php echo $this->translate("FEATURED"); ?></span>
                <?php endif; ?>
                <?php if($song->sponsored): ?>
                <span class="seseventmusic_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>
                <?php endif; ?>
              </div>
           <?php endif; ?>
         </div>
        <div class="seseventmusic_songslist_info">
          <div class="seseventmusic_songslist_info_top sesbasic_clearfix">
            <div class="seseventmusic_songslist_playbutton">
              <?php $songTitle = preg_replace('/[^a-zA-Z0-9\']/', ' ', $song->getTitle()); ?>
                <?php $songTitle = str_replace("'", '', $songTitle); ?>
              <?php if($song->track_id): ?>                
                <?php $uploadoption = Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.uploadoption', 'myComputer');
                $consumer_key =  Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.scclientid'); ?>          
                <?php if(($uploadoption == 'both' || $uploadoption == 'soundCloud') && $consumer_key): ?>
                <?php $URL = "http://api.soundcloud.com/tracks/$song->track_id/stream?consumer_key=$consumer_key"; ?>
                  <a href="javascript:void(0);" onclick="play_music('<?php echo $song->albumsong_id ?>', '<?php echo $URL; ?>', '<?php echo $songTitle; ?>');"><i class="fa fa-play"></i></a>
                <?php elseif($consumer_key): ?>                
                  <?php $URL = "http://api.soundcloud.com/tracks/$song->track_id/stream?consumer_key=$consumer_key"; ?>
                  <a href="javascript:void(0);" onclick="play_music('<?php echo $song->albumsong_id ?>', '<?php echo $URL; ?>', '<?php echo $songTitle; ?>');"><i class="fa fa-play"></i></a>
                <?php endif; ?>
              <?php else: ?>
                <a href="javascript:void(0);" onclick="play_music('<?php echo $song->albumsong_id ?>', '<?php echo $song->getFilePath(); ?>', '<?php echo $songTitle; ?>');"><i class="fa fa-play"></i></a>
              <?php endif; ?>  
            </div> 
            <div class="seseventmusic_songslist_songdetail">
              <div class="seseventmusic_songslist_songname">
                <?php echo $this->htmlLink($song->getHref(), $song->getTitle(), array('class' => 'music_player_tracks_url', 'type' => 'audio', 'rel' => $song->song_id)); ?>
              </div>
              <div class="seseventmusic_songslist_author sesbasic_text_light">
                <?php $album = Engine_Api::_()->getItem('seseventmusic_albums', $song->album_id); ?>
                <?php echo $this->translate('by %s', $this->htmlLink($album->getOwner(), $album->getOwner()->getTitle())) ?><?php echo $this->translate(' on %s', $this->timestamp($song->creation_date)); ?><?php echo $this->translate(' in %s', $this->htmlLink($album->getHref(), $album->getTitle())); ?>
              </div>
              <?php if($this->showAlbumSongRating): ?>
                <div class="seseventmusic_songslist_rating" title="<?php echo $this->translate(array('%s rating', '%s ratings', $song->rating), $this->locale()->toNumber($song->rating)); ?>">
                  <?php if( $song->rating > 0 ): ?>
                    <?php for( $x=1; $x<= $song->rating; $x++ ): ?>
                      <span class="sesbasic_rating_star_small fa fa-star"></span>
                    <?php endfor; ?>
                    <?php if( (round($song->rating) - $song->rating) > 0): ?>
                      <span class="sesbasic_rating_star_small fa fa-star-half"></span>
                    <?php endif; ?>
                  <?php endif; ?>      
                </div>
              <?php endif; ?>
            </div>
          </div>

          <div class="seseventmusic_songslist_info_bottom">
            <div class="seseventmusic_songslist_options seseventmusic_options_buttons">
              <?php if( $this->viewer()->getIdentity()): ?>
                <?php if (($this->album->owner_id == $this->viewer_id  || $this->viewer->level_id == 1) && $this->canEdit): ?>
                  <?php echo $this->htmlLink($album->getHref(array('route' => 'seseventmusic_albumsong_specific', 'action' => 'edit', 'albumsong_id' => $song->albumsong_id)), $this->translate('Edit Song'), array('class'=>'fa fa-pencil', 'title' => $this->translate('Edit Song'))); ?> 
                <?php endif; ?> 
                <?php if ($this->canDelete): ?>
                  <?php echo $this->htmlLink(array('route' => 'seseventmusic_albumsong_specific', 'module' => 'seseventmusic', 'controller' => 'song', 'action' => 'delete', 'albumsong_id' => $song->albumsong_id, 'format' => 'smoothbox'), $this->translate('Delete Song'), array('class' => 'smoothbox fa fa-trash')); ?>
                <?php endif; ?>
                
                <?php if($song->download && !$song->track_id && !$song->song_url && $this->downloadAlbumSong): ?>
                  <?php echo $this->htmlLink(array('route' => 'seseventmusic_albumsong_specific', 'action' => 'download-song', 'albumsong_id' => $song->albumsong_id), $this->translate("Download"), array('class' => ' fa fa-download')); ?>
                <?php elseif($song->download && $this->downloadAlbumSong): ?>
                  <?php $file = Engine_Api::_()->getItem('storage_file', $song->file_id); ?>
                  <?php if($file->mime_minor && $this->downloadAlbumSong): ?>
                  <?php $consumer_key =  Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.scclientid');
                  $downloadURL = 'http://api.soundcloud.com/tracks/' . $song->track_id . '/download?client_id=' . $consumer_key;  ?>
                  <a class='fa fa-download' href='<?php echo $downloadURL; ?>' target="_blank"><?php $this->translate("Download");  ?><?php echo $this->translate("Download");  ?></a>
                  <?php endif; ?>
                <?php endif; ?>

                <?php if(!empty($this->songlink) && in_array('share', $this->songlink)): ?>
                <?php echo $this->htmlLink(array('module'=>'activity', 'controller'=>'index', 'action'=>'share', 'route'=>'default', 'type'=>'seseventmusic_albumsong', 'id' => $song->getIdentity(), 'format' => 'smoothbox'), $this->translate("Share"), array('class' => 'smoothbox fa fa-share')); ?>
                <?php endif; ?>

                <?php if(!empty($this->songlink) && in_array('report', $this->songlink)): ?>
                <?php echo $this->htmlLink(array('module'=>'core', 'controller'=>'report', 'action'=>'create', 'route'=>'default', 'subject'=> $song->getGuid(), 'format' => 'smoothbox'), $this->translate("Report"), array('class' => 'smoothbox fa fa-flag')); ?>
                <?php endif; ?>
              <?php if($this->canAddFavouriteAlbumSong): ?>
                <?php $isFavourite = Engine_Api::_()->getDbTable('favourites', 'seseventmusic')->isFavourite(array('resource_type' => "seseventmusic_albumsong", 'resource_id' => $song->albumsong_id)); ?>
                <a class="fa fa-heart seseventmusic_favourite" id="seseventmusic_albumsong_unfavourite_<?php echo $song->getIdentity(); ?>" style ='display:<?php echo $isFavourite ? "inline-block" : "none" ?>' href = "javascript:void(0);" onclick = "seseventmusicFavourite('<?php echo $song->getIdentity(); ?>', 'seseventmusic_albumsong');"><?php echo $this->translate("Remove from Favorites") ?></a>
                <a class="fa fa-heart" id="seseventmusic_albumsong_favourite_<?php echo $song->getIdentity(); ?>" style ='display:<?php echo $isFavourite ? "none" : "inline-block" ?>' href = "javascript:void(0);" onclick = "seseventmusicFavourite('<?php echo $song->getIdentity(); ?>', 'seseventmusic_albumsong');"><?php echo $this->translate("Add to Favorite") ?></a>
                <input type="hidden" id="seseventmusic_albumsong_favouritehidden_<?php echo $song->getIdentity(); ?>" value='<?php echo $isFavourite ? $isFavourite : 0; ?>' />
              <?php endif; ?>        

              <?php endif; ?>    
            </div>
            <div class="seseventmusic_songslist_songstats sesbasic_text_light">
              <?php 
               $information = '';   
              // if(!empty($this->information) && in_array('playCount', $this->information))
               $information .= '<span title="Plays"><i class="fa fa-play"></i>' .$song->play_count. '</span>';

               //if(!empty($this->information) && in_array('downloadCount', $this->information))
                 $information .= '<span title="Downloads"><i class="fa fa-download"></i>' .$song->download_count. '</span>';
              // if(!empty($this->information) && in_array('favouriteCount', $this->information))
                 $information .= '<span title="Favorites"><i class="fa fa-heart"></i>' .$song->favourite_count. '</span>';
              //if(!empty($this->information) && in_array('likeCount', $this->information))
                 $information .= '<span title="Likes"><i class="fa fa-thumbs-up"></i>' .$song->like_count. '</span>'; 
              // if(!empty($this->information) && in_array('commentCount', $this->information))
                 $information .= '<span title="Comments"><i class="fa fa-comment"></i>' .$song->comment_count. '</span>';
             //  if(!empty($this->information) && in_array('viewCount', $this->information))
                 $information .= '<span title="Views"><i class="fa fa-eye"></i>' .$song->view_count. '</span>';
               ?>
                <?php echo $information ?>
              </div>
          </div>
        </div>
      </li>
    <?php endif; ?>
  <?php endforeach; ?>
</ul>
<script type="text/javascript">
  $$('.core_main_seseventmusic').getParent().addClass('active');
</script>
</div>