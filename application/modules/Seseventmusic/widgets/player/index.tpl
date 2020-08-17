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
<?php
$viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
//This forces every playlist to have a unique ID, so that a playlist can be displayed twice on the same page.
$random   = '';
for ($i=0; $i<6; $i++) { $d=rand(1,30)%2; $random .= ($d?chr(rand(65,90)):chr(rand(48,57))); }
?>
<div class="seseventmusic_player_wrapper <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.showplayer', 0)): ?>seseventmusic_player_mini<?php endif; ?>" id="music_player_100">
    <?php // style="display:none;" ?>
    <div class="seseventmusic_player" id="seseventmusic_player_list">
      <div class="seseventmusic_player_toggel">
        <i class="fa fa-angle-left"></i>
      </div>
      <div class="seseventmusic_player_top">
        <div class="seseventmusic_player_art">
          <?php //echo $this->itemPhoto($playlist, null, $playlist->getTitle()) ?>
        </div>
        <div class="seseventmusic_player_info">
          <div class="seseventmusic_player_controls_wrapper">
            <div class="seseventmusic_player_controls_right" style="display:none;">
              <span class="seseventmusic_player_button_launch_wrapper">
                <div class="seseventmusic_player_button_launch_tooltip"><?php //echo $this->translate('Pop-out Player') ?></div>
                <a class="seseventmusic_player_button_launch"></a>
                  <?php //echo $this->htmlLink($playlist->getHref(array('popout' => true)), '', array('class' => 'seseventmusic_player_button_launch')) ?>
              </span>
            </div>
            
            <div class="seseventmusic_player_song_control">
              <span class="seseventmusic_player_button_prev fa"></span>
              <span id="seseventmusic_player_button_play" class="seseventmusic_player_button_play fa"></span>
              <span class="seseventmusic_player_button_next fa"></span>
              <span class="seseventmusic_player_button_autoPlay" id="seseventmusic_player_button_autoPlay" style="display:none"></span>
            </div>            
            <div class="seseventmusic_player_right">
              <div class="seseventmusic_player_controls_volume">
                <span class="seseventmusic_player_controls_volume_toggle fa"></span>
                <span class="seseventmusic_player_controls_volume_bar"><span class="volume_bar_1"></span></span>
                <span class="seseventmusic_player_controls_volume_bar"><span class="volume_bar_2"></span></span>
                <span class="seseventmusic_player_controls_volume_bar"><span class="volume_bar_3"></span></span>
                <span class="seseventmusic_player_controls_volume_bar"><span class="volume_bar_4"></span></span>
                <span class="seseventmusic_player_controls_volume_bar"><span class="volume_bar_5"></span></span>
              </div>
              <div onclick="playlist_show('seseventmusic_player_tracks_contaner');" id="seseventmusic_player_tracks_toggle" class="seseventmusic_player_tracks_toggle fa fa-align-justify">
                <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.showplayer', 0)): ?>
                  <?php echo $this->translate("Songs");?>
                <?php endif; ?>
              </div>
            </div>
            <div class="seseventmusic_player_control">
              <div class="seseventmusic_player_trackname"></div>
              <div class="seseventmusic_player_time">
                <div class="seseventmusic_player_time_elapsed"></div>
                <div id="seseventmusic_showseprator">&nbsp;/&nbsp;</div>
                <div class="seseventmusic_player_time_total"></div>
              </div>
              <?php if(!empty($viewer_id)): ?>
                <div class="seseventmusic_player_control_options">
                  <?php if($this->canAddPlaylistAlbumSong): ?>
                  <a id="seseventmusic_player_addplaylist" href="javascript:void(0);"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add to Playlist"); ?></span></a>
                  <?php endif; ?>
                  <?php if($this->downloadAlbumSong): ?>
                  <a id="seseventmusic_player_download" href="#"><i class="fa fa-download"></i><span><?php echo $this->translate("Download"); ?></span></a>
                  <?php endif; ?>
                  <?php if(!empty($this->songlink) && in_array('share', $this->songlink)): ?>
                  <a id="seseventmusic_player_share" href="javascript:void(0);"><i class="fa fa-share"></i><span><?php echo $this->translate("Share"); ?></span></a>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
              <div class="seseventmusic_player_scrub">
                <div class="seseventmusic_player_scrub_cursor"></div>
                <div class="seseventmusic_player_scrub_downloaded"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div style='display: none;' id="seseventmusic_player_tracks_contaner" class="seseventmusic_player_tracks_container">
        <div class="seseventmusic_player_tracks_header">
          <?php echo $this->translate("Header Title"); ?>   
          <?php //if(count($_COOKIE['seseventmusic_playlists']) > 0): ?>
          <span style="display:none;" id="seseventmusic_player_tracks_header">
            <a id="clear_playlist_hide" href="javascript:void(0);" onclick="clear_playlists('seseventmusic_playlists');"><?php echo $this->translate("Clear Queue"); ?></a>
          </span>
        </div>

        <?php //endif; ?>
        <ul class="seseventmusic_player_tracks playlist_<?php echo $random ?>" id = "seseventmusic_player_tracks"></ul>
      </div>
    </div>
</div>
<script type="text/javascript">

function clear_playlists(name) {
document.cookie = name +'=; Path=/;';
$('seseventmusic_player_tracks_header').style.display = 'none';
$('seseventmusic_player_tracks').innerHTML = '';
setCookie("seseventmusic_playSongId", 0, 1);
//$$('.seseventmusic_player_button_pause').fireEvent('click');
}

function playlist_show(id) {
	var totalSongSelected = document.getElementById('seseventmusic_player_tracks').getElementsByTagName('li');
		if(totalSongSelected.length == 0){
			$(id).style.display = 'none';
			return false;
		}
  if($(id).style.display == 'block')
    $(id).style.display = 'none';
  else
    $(id).style.display = 'block';
}

function play_music(id, path, title) {
  
	var totalSongSelected = document.getElementById('seseventmusic_player_tracks').getElementsByTagName('li');
	for(var i = 0; i < totalSongSelected.length ; i++) {
		if(totalSongSelected[i].id.replace("seseventmusic_playlist_", "") == id) {
			if($(totalSongSelected[i].id).hasClass('song_playing')){
				$$('.seseventmusic_player_button_play').fireEvent('click');
			}else {
				songPlayWithId = id;
				$('seseventmusic_player_button_autoPlay').fireEvent('click');	
			}
			return false;
		}
	}
  
  if($('seseventmusic_player_list'))
    $('seseventmusic_player_list').style.display = 'block';
  
  var check_empty = document.getElementById('seseventmusic_player_tracks').innerHTML;
  var delete_URL = en4.core.baseUrl + 'music/playlist/delete-cookies/song_id/' + id;
  
  var final_append = '<li id="seseventmusic_playlist_'+id+'" class="seseventmusicplaylistmore seseventmusic_playlist_clearplaylists"><div class="seseventmusic_player_tracks_name"><a title="'+title+'" rel="' + id +'" type="audio" class="music_player_tracks_url" href="' +path +'">'+title+'</a></div><a class="clear_track_link fa fa-close" onclick="deleteSong('+id+', this)" rel="' + id +'" id="delete_coockies_playlist_'+id+'" href="javascript:void(0)"></a></li>';

  var final_append_innerhtml = check_empty + final_append;

  document.getElementById('seseventmusic_player_tracks').innerHTML = final_append_innerhtml;

  var par = $("music_player_100");
  var el  = par.getElement('div.seseventmusic_player');
  this.container = $(el);
  this.container.getElement('div.seseventmusic_player_scrub_downloaded').hide();
  
  counter = 1;
  songs = this.container.getElements('a.music_player_tracks_url'); 
  setCookie("seseventmusic_playlists", final_append_innerhtml, 1);
  
  $('seseventmusic_player_tracks_header').style.display = "block";

   if(!check_empty)
	  //fire event when click on any songs. Auto play
	  $$('.seseventmusic_player_button_play').fireEvent('click');
	else
		$$('.seseventmusic_player_button_next').fireEvent('click');
  
}
  <?php if(empty($_COOKIE['seseventmusic_playlists'])): ?>
  if($('seseventmusic_player_list'))
  $('seseventmusic_player_list').style.display = 'none';
  <?php endif; ?>
window.addEvent('domready', function() {

  var playlists_show = '';
  
  <?php if(isset($_COOKIE["seseventmusic_playlists"])): ?>
  
   <?php $playlists_show = json_encode(urldecode($_COOKIE['seseventmusic_playlists'])); 
   $playlists_show = str_replace(array("'\"",'"\''), array('', ''), $playlists_show); ?>
  playlists_show = "<?php echo trim($playlists_show, '\"'); ?>";
  $('seseventmusic_player_tracks').innerHTML = playlists_show;
  <?php endif; ?>
  if(playlists_show)
  $('seseventmusic_player_tracks_header').style.display = "block";

});

function thisindex(obj){
//get parent of obj 
parentObj=obj.parentNode.parentNode;
//get all li elements of parentObj 
litems=parentObj.getElementsByTagName('li');
//cycle through litems to find obj 
for (i=0;i<litems.length;i++){
if (litems.item(i)==obj.parentNode){ 
return i; 
break;
} 

}
return 0;
}


function deleteSong(id, sesthis) {
		
    var delete_URL = en4.core.baseUrl + 'music/playlist/delete-cookies/song_id/' + id;
    var request = new Request.HTML({
      method: 'post',
      'url': delete_URL,
      'data': {
        format: 'html',
    
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
	var getAutoPlayId = getCookie("seseventmusic_playSongId");
 	if(getAutoPlayId == id){
		setCookie("seseventmusic_playSongId", 0, 1);
	}
  if($('seseventmusic_playlist_' + id).className.indexOf('song_playing') > 0) {
		var totalSongSelected = document.getElementById('seseventmusic_player_tracks').getElementsByTagName('li');
    if(totalSongSelected.length == 1){
    	//$$('.seseventmusic_player_button_play').fireEvent('click');
		}else{
      $$('.seseventmusic_player_button_next').fireEvent('click');
		}
    removeSongs(sesthis);
  } else {
  		removeSongs(sesthis);
  }
  $('seseventmusic_playlist_' + id).remove();	
		var totalSongSelected = document.getElementById('seseventmusic_player_tracks').getElementsByTagName('li');
		if(totalSongSelected.length == 0)
			$('clear_playlist_hide').style.display = 'none';
		return false;
  }			
    });
    request.send();
}

function removeSongs(sesthis) {
  var sesindex = thisindex(sesthis);
  if(sesindex != 0)
   songs.splice(sesindex, 1);
}

$(document.body).addEvent('click', function(event) {
  if(event.target.id != 'seseventmusic_player_tracks_toggle')
	$('seseventmusic_player_tracks_contaner').style.display = 'none';
});

<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.showplayer', 0)): ?>
addClassToBody = 1;
window.addEvent('domready', function() {
if($('seseventmusic_player_list').style.display != 'none'){
  var htmlElement = document.getElementsByTagName("body")[0];
  htmlElement.addClass('seseventmusic_music_player_full');
  }
});
<?php endif; ?>
var playSongId = getCookie('seseventmusic_playSongId');
if(playSongId && typeof(playSongId) !== 'undefined' && playSongId >0){
	window.addEvent('load',function(){
		if($('seseventmusic_playlist_'+playSongId)){
			$('seseventmusic_player_button_autoPlay').fireEvent('click');
		}
	});
}
function getSongId(){
	var totalSongSelected = document.getElementById('seseventmusic_player_tracks').getElementsByTagName('li');
	for(var i = 0; i < totalSongSelected.length ; i++) {
			if($(totalSongSelected[i]).hasClass('song_playing')){
				return totalSongSelected[i].id.replace("seseventmusic_playlist_", "");
			}
	}	
	return false;
}
<?php if(!empty($viewer_id)): ?>
<?php if($this->canAddPlaylistAlbumSong): ?>
var addplaylist = document.getElementById("seseventmusic_player_addplaylist");
addplaylist.addEvent('click', function(e) {
	e.preventDefault();
	var song_id = getSongId();
	if(!song_id)
		return false;
	showPopUp(en4.core.baseUrl + 'music/song/' +song_id+'/append');
});
<?php endif; ?>
<?php if($this->downloadAlbumSong): ?>
var download = document.getElementById("seseventmusic_player_download");
download.addEvent('click', function(e) {
	var song_id = getSongId();
	if(!song_id)
		return false;
	download.setAttribute('href', 'music/song/' +song_id+'/download-song');
});
<?php endif; ?>
<?php if(!empty($this->songlink) && in_array('share', $this->songlink)): ?>
var share = document.getElementById("seseventmusic_player_share");
share.addEvent('click', function(e) {
	e.preventDefault();
	var song_id = getSongId();
	if(!song_id)
		return false;
	showPopUp(en4.core.baseUrl + 'activity/index/share/type/seseventmusic_albumsong/id/' +song_id+'/format/smoothbox');        
});
<?php endif; ?>
<?php endif; ?>
$('seseventmusic_showseprator').style.display = 'none';
</script>