
var songs;
var counter = 0;

(function() { // START NAMESPACE
var $ = 'id' in document ? document.id : window.$;

if( !('en4' in window) ) {
  en4 = {};
}

if( !('music' in en4) ) {
  en4.music = {};
}

soundManager.setup({url: en4.core.baseUrl + 'externals/soundmanager/swf/', flashVersion: 9});

en4.core.runonce.add(function() {

  //Preload pause button element as defined in CSS class '.sesmusic_player_button_pause'
  new Element('div', {
    'id': 'pause_preloader',
    'class': 'sesmusic_player_button_pause',
    'style': 'position: absolute; top: -9999px; left: -9999px;'
  }).inject(document.body).destroy();
  
  //ADD TO PLAYLIST
  $$('a.music_add_to_playlist').addEvent('click', function(){
    $('song_id').value = this.id.substring(5);
    Smoothbox.open( $('music_add_to_playlist'), {mode: 'Inline'} );
    var pl = $$('#TB_ajaxContent > div')[0];
    pl.show();
  });

  //PLAY ON MY PROFILE
  $$('a.music_set_profile_playlist').addEvent('click', function() {
    var url_part    = this.href.split('/');
    var playlist_id = 0;
    $each(url_part, function(val, i) {
      if (val == 'playlist_id')
        playlist_id = url_part[i+1];
    });
    new Request.JSON({
      method: 'post',
      url: this.href,
      noCache: true,
      data: {
        'playlist_id': playlist_id,
        'format': 'json'
      },
      onSuccess: function(json){
        var link = $$('#music_playlist_item_' + json.playlist_id + ' a.music_set_profile_playlist')[0];
        if (json && json.success) {
          $$('a.music_set_profile_playlist')
            .set('text', en4.core.language.translate('Play on my Profile'))
            .addClass('icon_music_playonprofile')
            .removeClass('icon_music_disableonprofile')
            ;
          if( json.enabled && link ) {
            link
              .set('text', en4.core.language.translate('Disable Profile Playlist'))
              .addClass('icon_music_disableonprofile')
              .removeClass('icon_music_playonprofile')
              ;
          }
        }
      }
    }).send();
    return false;
  });

  en4.music.player.enablePlayers();
});

en4.music.player = {

  playlists : [],

  mute : ( Cookie.read('en4_music_mute') == 1 ? true : false ),

  volume : ( Cookie.read('en4_music_volume') ? Cookie.read('en4_music_volume') : 85 ),
  
  getSoundManager : function() {

    if( !('soundManager' in en4.music) && 'soundManager' in window ) {
      en4.music.soundManager = soundManager;
    }

    return en4.music.soundManager;
  },

  getPlaylists : function() {
    return this.playlists;
  },

  getVolume : function() {
    if( this.mute ) {
      return 0;
    } else {
      return this.volume;
    }
  },

  setVolume : function(volume) {
    if( 0 == volume ) {
      this.mute = true;
    } else {
      this.mute = false;
      this.volume = volume;
    }
    this._writeCookies();
    this._updatePlaylists();
  },

  toggleMute : function(flag) {
    if( $type(flag) ) {
      this.mute = ( true == flag );
    } else {
      this.mute = !this.mute;
    }
    this._writeCookies();
    this._updatePlaylists();
  },

  enablePlayers : function() {
    // enable players automatically?
    var players = $$('.sesmusic_player_wrapper');
    //if( players.length > 0 ) {
      // Initialize sound manager?
      en4.music.player.getSoundManager();
    //}
    players.each(function(el) {
      var matches = el.get('id').match(/music_player_([\w\d]+)/i);
      if( matches && matches.length >= 2 && !el.hasClass('sesmusic_player_active') ) {
        el.addClass('sesmusic_player_active');
        en4.music.player.createPlayer(matches[1]);
      }
    });
  },
  
  createPlayer : function(id) {

    var par = $('music_player_' + id);
    var el  = par.getElement('div.sesmusic_player');
    
    en4.music.player.getSoundManager().onready(function() {
      // show the entire player
      if( !par.getElement('div.sesplaylist_short_player') ) {
        if( !el.hasClass('sesplaylist_player_loaded') ) {
          var playlist = new en4.music.playlistAbstract(el);
          en4.music.player.playlists.push(playlist);
          el.addClass('sesplaylist_player_loaded');
        }

      // show the short player first
      } else {
        par.getElement('div.sesmusic_player:not(div.sesplaylist_short_player)').hide();
        par.getElement('div.sesplaylist_short_player').addEvent('click', function(){
          var par = $('music_player_' + id);
          var el = par.getElement('div.sesmusic_player');
          el.show();
          par.getElement('div.sesplaylist_short_player').hide();

          if( !el.hasClass('sesplaylist_player_loaded') ) {
            var playlist = new en4.music.playlistAbstract(el);
            en4.music.player.playlists.push(playlist);
            playlist.play();
            el.addClass('sesplaylist_player_loaded');
          }
        });
      }
    });

    return this;
  },

  _writeCookies : function() {
    var tmpUri = new URI($$('head base[href]')[0]);
    Cookie.write('en4_music_volume', this.volume, {
      duration: 7, // days
      path: tmpUri.get('directory'),
      domain: tmpUri.get('domain')
    });
    Cookie.write('en4_music_mute', ( this.mute ? 1 : 0 ), {
      duration: 7, // days
      path: tmpUri.get('directory'),
      domain: tmpUri.get('domain')
    });
  },

  _updatePlaylists : function() {
    this.playlists.each(function(playlist) {
      playlist._updateScrub();
      playlist._updateVolume();
    });
  }
  
};
})(); // END NAMESPACE

function showPopUp(url) {
  Smoothbox.open(url);
  parent.Smoothbox.close;
}

window.addEvent('domready', function(){
var smoothbox_url = document.URL;
if(smoothbox_url.indexOf('format=smoothbox') > -1) {
  if($('sesmusic_player_list'))
  $('sesmusic_player_list').style.display = "none";
}
});

//Like Function
function sesmusicLike(resource_id, resource_type) {

  if ($(resource_type + '_likehidden_' + resource_id))
    var like_id = $(resource_type + '_likehidden_' + resource_id).value

  en4.core.request.send(new Request.JSON({
    url: en4.core.baseUrl + 'sesmusic/like/index',
    data: {
      format: 'json',
      'resource_type': resource_type,
      'resource_id': resource_id,
      'like_id': like_id
    },
    onSuccess: function(responseJSON) {
      if (responseJSON.like_id) {
        if ($(resource_type + '_unlike_' + resource_id))
          $(resource_type + '_unlike_' + resource_id).style.display = 'inline-block';
        if ($(resource_type + '_likehidden_' + resource_id))
          $(resource_type + '_likehidden_' + resource_id).value = responseJSON.like_id;
        if ($(resource_type + '_like_' + resource_id))
          $(resource_type + '_like_' + resource_id).style.display = 'none';
      } else {
        if ($(resource_type + '_likehidden_' + resource_id))
          $(resource_type + '_likehidden_' + resource_id).value = 0;
        if ($(resource_type + '_unlike_' + resource_id))
          $(resource_type + '_unlike_' + resource_id).style.display = 'none';
        if ($(resource_type + '_like_' + resource_id))
          $(resource_type + '_like_' + resource_id).style.display = 'inline-block';

      }
    }
  }));
}


sesJqueryObject(document).on('click','.sesmusic_like_sesmusic_album',function(){
	like_favourite_data_music(this,'like','sesmusic_album','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Music Album Liked successfully"))+'</span>','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Music Album Unliked successfully"))+'</span>','sesbasic_liked_notification');
});

sesJqueryObject(document).on('click','.sesmusic_favourite_sesmusic_album',function() {
	like_favourite_data_music(this,'favourite','sesmusic_album','<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("Music Album added as Favourite successfully"))+'</span>','<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("Music Album Unfavourited successfully"))+'</span>','sesbasic_favourites_notification');
});

sesJqueryObject(document).on('click','.sesmusic_like_sesmusic_albumsong',function(){
	like_favourite_data_music(this,'like','sesmusic_albumsong','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Song Liked successfully"))+'</span>','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Song Unliked successfully"))+'</span>','sesbasic_liked_notification');
});
sesJqueryObject(document).on('click','.sesmusic_favourite_sesmusic_albumsong',function() {
	like_favourite_data_music(this,'favourite','sesmusic_albumsong','<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("Song added as Favourite successfully"))+'</span>','<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("Song Unfavourited successfully"))+'</span>','sesbasic_favourites_notification');
});


//common function for like and favourite
function like_favourite_data_music(element,functionName,itemType,likeNoti,unLikeNoti,className) {
  
  if(!sesJqueryObject(element).attr('data-url'))
    return;
  
  if(sesJqueryObject(element).hasClass('button_active')){
      sesJqueryObject(element).removeClass('button_active');
  } else
      sesJqueryObject(element).addClass('button_active');
  
  (new Request.HTML({
    method: 'post',
    'url':  en4.core.baseUrl + 'sesmusic/like/'+functionName,
    'data': {
      format: 'html',
      id: sesJqueryObject(element).attr('data-url'),
      type:itemType,
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      
      var response =jQuery.parseJSON(responseHTML);
      
      if(response.error)
        alert(en4.core.language.translate('Something went wrong,please try again later'));
      else {
        sesJqueryObject(element).find('span').html(response.count);
        
        if(response.condition == 'reduced') {
          sesJqueryObject(element).removeClass('button_active');
          //showTooltip(10,10,unLikeNoti)
          return true;
        } else { 
          sesJqueryObject(element).addClass('button_active');
          //showTooltip(10,10,likeNoti,className)
          return false;
        }
      }
    }
  })).send();
}
sesJqueryObject(document).on('click','.sesmusic_player_tracks_photo',function(e){
  var id = sesJqueryObject('#sesmusic_player_tracks').find('.song_playing').attr('id');
  id = id.replace('sesmusic_playlist_','');
  window.location.href = 'music/song/'+id;
})