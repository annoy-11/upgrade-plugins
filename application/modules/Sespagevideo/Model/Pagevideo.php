<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagevideo
 * @package    Sespagevideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Video.php 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagevideo_Model_Pagevideo extends Core_Model_Item_Abstract {

  protected $_parent_type = 'user';
  protected $_owner_type = 'user';
  protected $_parent_is_owner = true;
  protected $_type = 'pagevideo';

  //Change Primary key of table.
  public function getShortType() {
    return 'video';
  }

  public function getHref($params = array()) {

    $params = array_merge(array(
        'route' => 'sespagevideo_view',
        'reset' => true,
        'user_id' => $this->owner_id,
        'video_id' => $this->video_id,
        'slug' => $this->getSlug(),
            ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
                    ->assemble($params, $route, $reset);
  }

  public function getFilePath() {
    $file = Engine_Api::_()->getItem('storage_file', $this->file_id);
    if ($file)
      return $file->map();
  }

  public function getRichContent($view = false, $params = array(), $map = false,$autoplay = true) {
    $session = new Zend_Session_Namespace('mobile');
    $mobile = $session->mobile;
    if ($this->type == 'iframely') {
      $videoEmbedded = $this->code;
    }
    // if video type is youtube
    if ($this->type == 1) {
      $videoEmbedded = $this->compileYouTube($this->video_id, $this->code, $view, $mobile, $map,$autoplay);
    }
    // if video type is vimeo
    if ($this->type == 2) {
      $videoEmbedded = $this->compileVimeo($this->video_id, $this->code, $view, $mobile, $map,$autoplay);
    }
    // if video type is uploaded
    if ($this->type == 3) {
      $video_location = Engine_Api::_()->getItem('pagevideo', $this->video_id)->getHref();
      $videoEmbedded = $this->compileFlowPlayer($video_location, $view, $map,$autoplay);
    }
    // if video type is dailymotion
    if ($this->type == 4) {
      $videoEmbedded = $this->compileDailymotion($this->video_id, $this->code, $view, $mobile, $map,$autoplay);
    }
    // $view == false means that this rich content is requested from the activity feed
    if ($view == false) {
      // prepare the duration
      $video_duration = "";
      if ($this->duration) {
        if ($this->duration >= 3600) {
          $duration = gmdate("H:i:s", $this->duration);
        } else {
          $duration = gmdate("i:s", $this->duration);
        }
        $duration = ltrim($duration, '0:');

        $video_duration = "<span class='sespagevideo_length'>" . $duration . "</span>";
      }
			 $watchLater = '';
			$watchLaterId = Engine_Api::_()->sespagevideo()->getWatchLaterId($this->video_id);
			 if(Engine_Api::_()->user()->getViewer()->getIdentity() != '0' && Engine_Api::_()->getApi('settings', 'core')->getSetting('video.enable.watchlater', 1)){
					  $watchLaterActive = count($watchLaterId)  ? 'selectedWatchlater' : '';
						$watchLaterText = count($watchLaterId)  ? Zend_Registry::get('Zend_Translate')->_('Remove from Watch Later')  : Zend_Registry::get('Zend_Translate')->_('Add to Watch Later');
           $watchLater =   '<a href="javascript:;" class="sespagevideo_watch_later_btn sespagevideo_watch_later '.$watchLaterActive.'" title = "'.$watchLaterText.'" data-url="'.$this->video_id.'"></a>';
       }
			 $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
			 $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $this->getHref());
			  $buttons = '<div class="sespagevideo_thumb_btns">
                  <a href="http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $this->getTitle().'" onclick="return socialSharingPopUp(this.href,\''. Zend_Registry::get('Zend_Translate')->_('Facebook').'\')" class="sesbasic_icon_btn sesbasic_icon_facebook_btn"><i class="fa fa-facebook"></i></a>
                  <a href="http://twitthis.com/twit?url=' . $urlencode . '&title=' . $this->getTitle().'" onclick="return socialSharingPopUp(this.href,\''.Zend_Registry::get('Zend_Translate')->_('Twitter').'\')" class="sesbasic_icon_btn sesbasic_icon_twitter_btn"><i class="fa fa-twitter"></i></a>
                  <a href="http://pinterest.com/pin/create/button/?url='.$urlencode.'&media='.urlencode((strpos($this->getPhotoUrl(),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'].$this->getPhotoUrl() ) : $this->getPhotoUrl())).'&description='. $this->getTitle().'" onclick="return socialSharingPopUp(this.href,\''.Zend_Registry::get('Zend_Translate')->_('Pinterest').'\')" class="sesbasic_icon_btn sesbasic_icon_pintrest_btn"><i class="fa fa-pinterest"></i></a>';
                if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ){
											$thistype = 'pagevideo';
											$getId = 'video_id';
                      $canComment =  $this->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');
                      if($canComment){
                $LikeStatus = Engine_Api::_()->sespagevideo()->getLikeStatusVideo($this->$getId,$this->getType());
								$likeText = ($LikeStatus) ? 'button_active' : '';
                $buttons  .= ' <a href="javascript:;" data-url="'. $this->$getId .'" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sespagevideo_like_pagevideo '.$likeText.'"> <i class="fa fa-thumbs-up"></i><span>'. $this->like_count.'</span></a>';
                     } ;
                     if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagevideo.enable.favourite', 1) && isset($this->favourite_count)){
                   		$favStatus = Engine_Api::_()->getDbtable('favourites', 'sespagevideo')->isFavourite(array('resource_type'=>$thistype,'resource_id'=>$this->$getId));
											$favText = ($favStatus)  ? 'button_active' : '';
                   		$buttons .= '<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sespagevideo_favourite_pagevideo '.$favText .'"  data-url="'.$this->$getId.'"><i class="fa fa-heart"></i><span>'. $this->favourite_count.'</span></a>';
                  	}
                }
             $buttons .= ' </div>';
      // prepare the thumbnail
      $thumb = Zend_Registry::get('Zend_View')->itemPhoto($this, 'thumb.video.activity');
      $thumb = '<a class="sespagevideo_thumb_img sespagevideo_attachment_thumb_img" href="'.$this->getHref().'" data-url="video"><span style="background-image:url(' . $this->getPhotoUrl() . ');"></span></a><a class="sespagevideo_play_btn fa fa-play-circle sespagevideo_thumb_img" href="'.$this->getHref().'" data-url="video"><span style="background-image:url(' . $this->getPhotoUrl() . ');display:none"></span></a>'.$video_duration.$watchLater.$buttons;
      if (!$mobile) {
        $thumb = '<div class="sespagevideo_thumb sespagevideo_attachment_thumb sespagevideo_play_btn_wrap sespagevideo_activity_video sesbasic_bxs" id="video_thumb_' . $this->video_id . '" >' . $thumb  . '</div>';
      } else {
        $thumb = '<div class="sespagevideo_thumb sespagevideo_attachment_thumb sespagevideo_play_btn_wrap sespagevideo_activity_video sesbasic_bxs" id="video_thumb_' . $this->video_id . '" href="' . $this->getHref() . '">' . $thumb  . '</div>';
      }
      // prepare title and description
      $title = "<a href='" . $this->getHref($params) . "'>$this->title</a>";
      $tmpBody = strip_tags($this->description);
      $description = "<div class='sespagevideo_attachment_desc'>" . (Engine_String::strlen($tmpBody) > 255 ? Engine_String::substr($tmpBody, 0, 255) . '...' : $tmpBody) . "</div>";
      $videoEmbedded = $thumb . '<div id="video_object_' . $this->video_id . '" data-rel="'.$this->type.'" class="sespagevideo_object">' . $videoEmbedded . '</div><div class="sespagevideo_attachment_info">' . $title . $description . '</div>';
    }
    return $videoEmbedded;
  }

  /**
   * Gets a url to the current video representing this item. Return null if none
   * set
   *
   * @param string The video type;
   * @return string The video photo url
   * */
  public function getPhotoUrl($type = null) {
    $photo_id = $this->photo_id;
    if (!$photo_id && !$this->is_locked)
      return 'application/modules/Sespagevideo/externals/images/video.png';
    if ($this->is_locked)
      return 'application/modules/Sespagevideo/externals/images/locked-video.jpg';
    $file = Engine_Api::_()->getItemTable('storage_file')->getFile($photo_id, $type);
    if (!$file)
      return 'application/modules/Sespagevideo/externals/images/video.png';
    return $file->map();
  }

  public function getEmbedCode(array $options = null) {
    $options = array_merge(array(
        'height' => '525',
        'width' => '525',
            ), (array) $options);

    $view = Zend_Registry::get('Zend_View');
    $url = 'http://' . $_SERVER['HTTP_HOST']
            . Zend_Controller_Front::getInstance()->getRouter()->assemble(array(
                'module' => 'sespagevideo',
                'controller' => 'video',
                'action' => 'external',
                'video_id' => $this->getIdentity(),
                    ), 'default', true) . '?format=frame';
    return '<iframe '
            . 'src="' . $view->escape($url) . '" '
            . 'width="' . sprintf("%d", $options['width']) . '" '
            . 'height="' . sprintf("%d", $options['width']) . '" '
            . 'style="overflow:hidden;"'
            . '>'
            . '</iframe>';
  }
	public function compileFromUrl($video_id, $code, $view, $mobile = false, $map = false){
    $autoplay = !$mobile && $view;
    if ($map)
      return $code.'?wmode=opaque&' . ($autoplay ? "&autoplay=1" : "");
    $embedded = '
    <iframe
    title="Url video player"
    id="videoFrame' . $video_id . '"
    class="url_iframe' . ($view ? "_big" : "_small") . '"' .
            'src=" '.$code . '?wmode=opaque&' . ($autoplay ? "&autoplay=1" : "") . '"
    frameborder="0"
    allowfullscreen=""
    scrolling="no">
    </iframe>
    <script type="text/javascript">
        en4.core.runonce.add(function() {
        var doResize = function() {
            var aspect = 16 / 9;
            var el = document.id("videoFrame' . $video_id . '");
						if(typeof el == "undefined" || !el)
						return;
            var parent = el.getParent();
            var parentSize = parent.getSize();
            el.set("width", parentSize.x);
            el.set("height", parentSize.x / aspect);
        }
        window.addEvent("resize", doResize);
        doResize();
        });
    </script>
    ';
    return $embedded;

	}
  public function compileDailymotion($video_id, $code, $view, $mobile = false, $map = false,$autoPlayView) {
    $autoplay = !$mobile && $view;
		if(!$autoPlayView)
			$autoplay = $autoPlayView;
    if ($map)
      return '//www.dailymotion.com/embed/video/' . $code;
    $embedded = '
    <iframe
    title="Dailymotion video player"
    id="videoFrame' . $video_id . '"
    class="dailymotion_iframe' . ($view ? "_big" : "_small") . '"' .
            'src="//www.dailymotion.com/embed/video/' . $code . '"
    frameborder="0"
    allowfullscreen=""
		' . ($autoplay ? "autoplay=1" : "") . '
    >
    </iframe>
    <script type="text/javascript">
        en4.core.runonce.add(function() {
        var doResize = function() {
            var aspect = 16 / 9;
            var el = document.id("videoFrame' . $video_id . '");
						if(typeof el == "undefined" || !el)
						return;
            var parent = el.getParent();
            var parentSize = parent.getSize();
            el.set("width", parentSize.x);
            el.set("height", parentSize.x / aspect);
        }
        window.addEvent("resize", doResize);
        doResize();
        });
    </script>
    ';

    return $embedded;
  }

  public function compileYouTube($video_id, $code, $view, $mobile = false, $map = false,$autoPlayView) {
    $autoplay = !$mobile && $view;
		if(!$autoPlayView)
			$autoplay = $autoPlayView;
    if ($map)
      return '//www.youtube.com/embed/' . $code . '?wmode=opaque' . ($autoplay ? "&autoplay=1" : "");
    $embedded = '
    <iframe
    title="YouTube video player"
    id="videoFrame' . $video_id . '"
    class="youtube_iframe_ses youtube_iframe' . ($view ? "_big" : "_small") . '"' .
            'src="//www.youtube.com/embed/' . $code . '?enablejsapi=1&wmode=opaque' . ($autoplay ? "&autoplay=1" : "") . '"
    frameborder="0"
    allowfullscreen=""
    scrolling="no">
    </iframe>
    <script type="text/javascript">
        en4.core.runonce.add(function() {
        var doResize = function() {
            var aspect = 16 / 9;
            var el = document.id("videoFrame' . $video_id . '");
						if(typeof el == "undefined" || !el)
						return;
            var parent = el.getParent();
            var parentSize = parent.getSize();
            el.set("width", parentSize.x);
            el.set("height", parentSize.x / aspect);
        }
        window.addEvent("resize", doResize);
        doResize();
        });
    </script>
    ';
    return $embedded;
  }
  public function compileVimeo($video_id, $code, $view, $mobile = false, $map = false,$autoPlayView) {
    $autoplay = !$mobile && $view;
		if(!$autoPlayView)
			$autoplay = $autoPlayView;
    if ($map)
      return '//player.vimeo.com/video/' . $code . '?api=1&title=0&amp;byline=0&amp;portrait=0&amp;wmode=opaque' . ($autoplay ? "&amp;autoplay=1" : "");
    $embedded = '
        <iframe
        title="Vimeo video player"
        id="videoFrame' . $video_id . '"
        class="vimeo_iframe' . ($view ? "_big" : "_small") . '"' .
            ' src="//player.vimeo.com/video/' . $code . '?api=1&title=0&amp;byline=0&amp;portrait=0&amp;wmode=opaque' . ($autoplay ? "&amp;autoplay=1" : "") . '"
        frameborder="0"
        allowfullscreen=""
        scrolling="no">
        </iframe>
        <script type="text/javascript">
          en4.core.runonce.add(function() {
            var doResize = function() {
              var aspect = 16 / 9;
              var el = document.id("videoFrame' . $video_id . '");
							if(typeof el == "undefined" || !el)
						return;
              var parent = el.getParent();
              var parentSize = parent.getSize();
              el.set("width", parentSize.x);
              el.set("height", parentSize.x / aspect);
            }
            window.addEvent("resize", doResize);
            doResize();
          });
        </script>
        ';
    return $embedded;
  }
  public function compileFlowPlayer($location, $view, $map = false) {
    if ($map)
      return;
			$flowplayer = Engine_Api::_()->sesbasic()->checkPluginVersion('core', '4.8.10') ? 'externals/flowplayer/flowplayer-3.2.18.swf' : 'externals/flowplayer/flowplayer-3.1.5.swf';
    $embedded = "
    <div id='videoFrame" . $this->video_id . "'></div>
    <script type='text/javascript'>
    en4.core.runonce.add(function(){\$('video_thumb_" . $this->video_id . "').removeEvents('click').addEvent('click', function(){checkFunctionEmbed();flashembed('videoFrame$this->video_id',{src: '" . Zend_Registry::get('StaticBaseUrl') . $flowplayer."', width: " . ($view ? "480" : "420") . ", height: " . ($view ? "386" : "326") . ", wmode: 'opaque'},{config: {clip: {url: '$location',autoPlay: " . ($view ? "false" : "true") . ", duration: '$this->duration', autoBuffering: true},plugins: {controls: {background: '#000000',bufferColor: '#333333',progressColor: '#444444',buttonColor: '#444444',buttonOverColor: '#666666'}},canvas: {backgroundColor:'#000000'}}});})});
    </script>";

    return $embedded;
  }

  public function getKeywords($separator = ' ') {
    $keywords = array();
    foreach ($this->tags()->getTagMaps() as $tagmap) {
      $tag = $tagmap->getTag();
      $keywords[] = $tag->getTitle();
    }

    if (null === $separator) {
      return $keywords;
    }

    return join($separator, $keywords);
  }

  // Interfaces

  /**
   * Gets a proxy object for the comment handler
   *
   * @return Engine_ProxyObject
   * */
  public function comments() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('comments', 'core'));
  }

  /**
   * Gets a proxy object for the like handler
   *
   * @return Engine_ProxyObject
   * */
  public function likes() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('likes', 'core'));
  }

  /**
   * Gets a proxy object for the tags handler
   *
   * @return Engine_ProxyObject
   * */
  public function tags() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('tags', 'core'));
  }

}
