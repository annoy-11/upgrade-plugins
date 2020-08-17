<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessiteiframe
 * @package    Sessiteiframe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: default.tpl  2017-10-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if(empty($_COOKIE['sessiteiframeCookieValue'])){ 
      setcookie('sessiteiframeCookieValue', 'sessiteiframe', time() + (86400 * 30), '/');
?>
  <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if(strpos($actual_link, 'sessiteiframeCookieValue') === false){
          if(strpos($actual_link, '?') === true) 
          $actual_link = $actual_link.'&sessiteiframeCookieValue=true';
          else 
          $actual_link = $actual_link.'?sessiteiframeCookieValue=true';
        } 
  ?>
  <?php echo $this->doctype()->__toString() ?>
  <?php $locale = $this->locale()->getLocale()->__toString(); $orientation = ($this->layout()->orientation == 'right-to-left' ? 'rtl' : 'ltr'); ?>
 <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $locale ?>" lang="<?php echo $locale ?>" dir="<?php echo $orientation ?>">
  <head>
    <base href="<?php echo rtrim($this->serverUrl($this->baseUrl()), '/'). '/' ?>" />
    <?php // ALLOW HOOKS INTO META?>
    <?php echo $this->hooks('onRenderLayoutDefault', $this) ?>
    <?php // TITLE/META?>
    <?php
    $counter = (int) $this->layout()->counter;
    $staticBaseUrl = $this->layout()->staticBaseUrl;
    $headIncludes = $this->layout()->headIncludes;

    $request = Zend_Controller_Front::getInstance()->getRequest();
    $this->headTitle()
        ->setSeparator(' - ');
    $pageTitleKey = 'pagetitle-' . $request->getModuleName() . '-' . $request->getActionName()
        . '-' . $request->getControllerName();
    $pageTitle = $this->translate($pageTitleKey);
    if ($pageTitle && $pageTitle != $pageTitleKey) {
        $this
            ->headTitle($pageTitle, Zend_View_Helper_Placeholder_Container_Abstract::PREPEND);
    }
    $this
        ->headTitle($this->translate($this->layout()->siteinfo['title']))
    ;
    $this->headMeta()
        ->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8')
        ->appendHttpEquiv('Content-Language', $this->locale()->getLocale()->__toString());
    // Make description and keywords
    $description = $this->layout()->siteinfo['description'];
    $keywords = $this->layout()->siteinfo['keywords'];
    if ($this->subject() && $this->subject()->getIdentity()) {
        $this->headTitle($this->subject()->getTitle(), Zend_View_Helper_Placeholder_Container_Abstract::PREPEND);

        $description = $this->subject()->getDescription() . ' ' . $description;
        // Remove the white space from left and right side
        $keywords = trim($keywords);
        if (!empty($keywords) && (strrpos($keywords, ',') !== (strlen($keywords) - 1))) {
            $keywords .= ',';
        }
        $keywords .= $this->subject()->getKeywords(',');
    }
    $keywords = trim($keywords, ',');
    $this->headMeta()->appendName('description', trim($description));
    $this->headMeta()->appendName('keywords', trim($keywords));
    $this->headMeta()->appendName('viewport', 'width=device-width, initial-scale=1.0');
    //Adding open graph meta tag for video thumbnail
    if ($this->subject() && $this->subject()->getPhotoUrl()) {
        $this->headMeta()->setProperty('og:image', $this->absoluteUrl($this->subject()->getPhotoUrl()));
    }
    // Get body identity
    if (isset($this->layout()->siteinfo['identity'])) {
        $identity = $this->layout()->siteinfo['identity'];
    } else {
        $identity = $request->getModuleName() . '-' .
            $request->getControllerName() . '-' .
            $request->getActionName();
    }
    ?>
    <?php echo $this->headTitle()->toString()."\n" ?>
    <?php echo $this->headMeta()->toString()."\n" ?>
    <?php // LINK/STYLES?>
    <?php
    $this->headLink(array(
        'rel' => 'shortcut icon',
        'href' => $staticBaseUrl . (isset($this->layout()->favicon) ? $this->layout()->favicon : 'favicon.ico'),
        'type' => 'image/x-icon'),
        'PREPEND');
    ?>    
    <?php
      $this->headScript()->exchangeArray(array());
      $this->headLink()->exchangeArray(array());
      $this->headScript()
          ->prependFile($staticBaseUrl . 'externals/ses-scripts/sesJquery.js')
          ->prependFile($staticBaseUrl . 'externals/scrollbars/scrollbars.min.js')
          ->prependFile($staticBaseUrl . 'externals/smoothbox/smoothbox4.js')
          ->prependFile($staticBaseUrl . 'application/modules/User/externals/scripts/core.js')
          ->prependFile($staticBaseUrl . 'application/modules/Core/externals/scripts/core.js')
          ->prependFile($staticBaseUrl . 'externals/chootools/chootools.js')
          ->prependFile($staticBaseUrl . 'externals/mootools/mootools-more-1.4.0.1-full-compat-' . (APPLICATION_ENV == 'development' ? 'nc' : 'yc') . '.js')
          ->prependFile($staticBaseUrl . 'externals/mootools/mootools-core-1.4.5-full-compat-' . (APPLICATION_ENV == 'development' ? 'nc' : 'yc') . '.js')
          ->appendFile($staticBaseUrl . 'externals/soundmanager/script/soundmanager2' . (APPLICATION_ENV == 'production' ? '-nodebug-jsmin' : '' ) . '.js')
          ->appendFile($staticBaseUrl . 'application/modules/Sesmusic/externals/scripts/player.js')
           ->appendFile($staticBaseUrl . 'application/modules/Sesmusic/externals/scripts/core.js');
           $this->headLink()->appendStylesheet($staticBaseUrl . 'externals/font-awesome/css/font-awesome.min.css');
         $this->headLink()->appendStylesheet($staticBaseUrl . 'application/modules/Sesmusic/externals/styles/player.css');
         
    ?>
    
    <?php echo $this->headScript()->toString()."\n" ?>
    <?php echo $this->headLink()->toString()."\n" ?>
    <style>
    #TB_overlay {
      position: absolute;
      z-index: 100;
      top: 0px;
      left: 0px;
      background-color: #000;
    }
    #TB_window {
      +rounded(8px);
      position: absolute;
      z-index: 102;
      text-align: left;
      background: #eee;
      color: #000;
      border: 8px solid #444;
    }
    #TB_caption {
      height: 25px;
      padding: 7px 30px 10px 25px;
      float: left;
    }
    #TB_closeAjaxWindow{
      display:none;  
    }
    #TB_closeWindow {
      display:none !important;
      height: 25px;
      padding: 11px 25px 10px 0;
      float: right;
    }
    .sessiteiframe_iframe{
      width:100%;
      border-width:0; 
      position:absolute; 
      height:100%;
    }
    </style>
    <script type="text/javascript">
      function setMusicCookie(cname, cvalue, exdays) {
          var d = new Date();
          d.setTime(d.getTime() + (exdays*24*60*60*1000));
          var expires = "expires="+d.toGMTString();
          document.cookie = cname + "=" + cvalue + "; " + expires+"; path=/"; 
        } 
        function getMusicCookie(cname){
          var name = cname + "=";
          var ca = document.cookie.split(';');
          for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
          }
          return "";
        }
      sesJqueryObject(window).bind('beforeunload',function(){
        setMusicCookie("sessiteiframeCookieValue", 'sessiteiframe', 0);
        return undefined;
      });
      var isHashChange = false;
      function changeHashState(){
          isHashChange = true;
      }
     window.addEventListener('popstate', function(event) {
        if(isHashChange == true){
            window.location.href = document.URL             
        }
      });
      function iframeFullPayerClass() {
        <?php if(!empty($_COOKIE["sesmusic_player_hide"])) { ?>
            var fullPlayer = sesJqueryObject('#sessiteiframeCookieValue').contents().find('body').removeClass('sesmusic_music_player_full');
        <?php } else if(!empty($_COOKIE["sesmusic_playlists"])) { ?> 
        var fullPlayer = sesJqueryObject('#sessiteiframeCookieValue').contents().find('body').addClass('sesmusic_music_player_full');
        <?php } ?>
      }      
    </script>
</head>
<body style="padding:0; margin:0;" id="global_page_<?php echo $identity ?>"<?php if (!$this->viewer()->getIdentity()): ?> class="guest-user"<?php endif; ?>>
      <iframe onload="iframeFullPayerClass();" src="<?php echo $actual_link; ?>" class="sessiteiframe_iframe" id="sessiteiframeCookieValue"></iframe>
 <?php echo $this->content()->renderWidget('sesmusic.player'); ?>
</body>
</html>
<?php }else{ ?>
<?php echo $this->doctype()->__toString() ?>
<?php $locale = $this->locale()->getLocale()->__toString(); $orientation = ($this->layout()->orientation == 'right-to-left' ? 'rtl' : 'ltr'); ?>
<?php $headerContent = $this->content('header'); ?>
<?php $footerContent = $this->content('footer'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $locale ?>" lang="<?php echo $locale ?>" dir="<?php echo $orientation ?>">
<head>
    <base href="<?php echo rtrim($this->serverUrl($this->baseUrl()), '/'). '/' ?>" />


    <?php // ALLOW HOOKS INTO META?>
    <?php echo $this->hooks('onRenderLayoutDefault', $this) ?>


    <?php // TITLE/META?>
    <?php
    $counter = (int) $this->layout()->counter;
    $staticBaseUrl = $this->layout()->staticBaseUrl;
    $headIncludes = $this->layout()->headIncludes;

    $request = Zend_Controller_Front::getInstance()->getRequest();
    $this->headTitle()
        ->setSeparator(' - ');
    $pageTitleKey = 'pagetitle-' . $request->getModuleName() . '-' . $request->getActionName()
        . '-' . $request->getControllerName();
    $pageTitle = $this->translate($pageTitleKey);
    if ($pageTitle && $pageTitle != $pageTitleKey) {
        $this
            ->headTitle($pageTitle, Zend_View_Helper_Placeholder_Container_Abstract::PREPEND);
    }
    $this
        ->headTitle($this->translate($this->layout()->siteinfo['title']))
    ;
    $this->headMeta()
        ->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8')
        ->appendHttpEquiv('Content-Language', $this->locale()->getLocale()->__toString());

    // Make description and keywords
    $description = $this->layout()->siteinfo['description'];
    $keywords = $this->layout()->siteinfo['keywords'];

    if ($this->subject() && $this->subject()->getIdentity()) {
        $this->headTitle($this->subject()->getTitle(), Zend_View_Helper_Placeholder_Container_Abstract::PREPEND);

        $description = $this->subject()->getDescription() . ' ' . $description;
        // Remove the white space from left and right side
        $keywords = trim($keywords);
        if (!empty($keywords) && (strrpos($keywords, ',') !== (strlen($keywords) - 1))) {
            $keywords .= ',';
        }
        $keywords .= $this->subject()->getKeywords(',');
    }

    $keywords = trim($keywords, ',');

    $this->headMeta()->appendName('description', trim($description));
    $this->headMeta()->appendName('keywords', trim($keywords));
    $this->headMeta()->appendName('viewport', 'width=device-width, initial-scale=1.0');

    //Adding open graph meta tag for video thumbnail
    if ($this->subject() && $this->subject()->getPhotoUrl()) {
        $this->headMeta()->setProperty('og:image', $this->absoluteUrl($this->subject()->getPhotoUrl()));
    }

    // Get body identity
    if (isset($this->layout()->siteinfo['identity'])) {
        $identity = $this->layout()->siteinfo['identity'];
    } else {
        $identity = $request->getModuleName() . '-' .
            $request->getControllerName() . '-' .
            $request->getActionName();
    }
    ?>
    <?php echo $this->headTitle()->toString()."\n" ?>
    <?php echo $this->headMeta()->toString()."\n" ?>


    <?php // LINK/STYLES?>
    <?php
    $this->headLink(array(
        'rel' => 'shortcut icon',
        'href' => $staticBaseUrl . (isset($this->layout()->favicon) ? $this->layout()->favicon : 'favicon.ico'),
        'type' => 'image/x-icon'),
        'PREPEND');
    $themes = array();
    if (!empty($this->layout()->themes)) {
        $themes = $this->layout()->themes;
    } else {
        $themes = array('default');
    }

    foreach ($themes as $theme) {
        if (APPLICATION_ENV != 'development') {
            $this->headLink()
                ->prependStylesheet($staticBaseUrl . 'application/css.php?request=application/themes/' . $theme . '/theme.css');
        } else {
            $this->headLink()
                ->prependStylesheet(rtrim($this->baseUrl(), '/') . '/application/css.php?request=application/themes/' . $theme . '/theme.css');
        }
    }
    // Process
    foreach ($this->headLink()->getContainer() as $dat) {
        if (!empty($dat->href)) {
            if (false === strpos($dat->href, '?')) {
                $dat->href .= '?c=' . $counter;
            } else {
                $dat->href .= '&c=' . $counter;
            }
        }
    }

    $currentTheme = APPLICATION_PATH . '/application/themes/' . $themes[0] . '/default.tpl';
    $currentThemeHeader = APPLICATION_PATH . '/application/themes/' . $themes[0] . '/head.tpl';
    ?>
    <?php echo $this->headLink()->toString()."\n" ?>
    <?php echo $this->headStyle()->toString()."\n" ?>

    <?php // TRANSLATE?>
    <?php $this->headScript()->prependScript($this->headTranslate()->toString()) ?>

    <?php // SCRIPTS?>
    <script type="text/javascript">if (window.location.hash == '#_=_')window.location.hash = '';</script>
    <script type="text/javascript">
        <?php echo $this->headScript()->captureStart(Zend_View_Helper_Placeholder_Container_Abstract::PREPEND) ?>

        Date.setServerOffset('<?php echo date('D, j M Y G:i:s O', time()) ?>');

        en4.orientation = '<?php echo $orientation ?>';
        en4.core.environment = '<?php echo APPLICATION_ENV ?>';
        en4.core.language.setLocale('<?php echo $this->locale()->getLocale()->__toString() ?>');
        en4.core.setBaseUrl('<?php echo $this->url(array(), 'default', true) ?>');
        en4.core.staticBaseUrl = '<?php echo $this->escape($staticBaseUrl) ?>';
        en4.core.loader = new Element('img', {src: en4.core.staticBaseUrl + 'application/modules/Core/externals/images/loading.gif'});

        <?php if ($this->subject()): ?>
        en4.core.subject = {
            type : '<?php echo $this->subject()->getType(); ?>',
            id : <?php echo $this->subject()->getIdentity(); ?>,
            guid : '<?php echo $this->subject()->getGuid(); ?>'
        };
        <?php endif; ?>
        <?php if ($this->viewer()->getIdentity()): ?>
        en4.user.viewer = {
            type : '<?php echo $this->viewer()->getType(); ?>',
            id : <?php echo $this->viewer()->getIdentity(); ?>,
            guid : '<?php echo $this->viewer()->getGuid(); ?>'
        };
        <?php endif; ?>
        if( <?php echo(Engine_Api::_()->getDbtable('settings', 'core')->core_dloader_enabled ? 'true' : 'false') ?> ) {
            en4.core.runonce.add(function() {
                en4.core.dloader.attach();
            });
        }

        <?php echo $this->headScript()->captureEnd(Zend_View_Helper_Placeholder_Container_Abstract::PREPEND) ?>
    </script>
    <?php
    $this->headScript()
        ->prependFile($staticBaseUrl . 'externals/scrollbars/scrollbars.min.js')
        ->prependFile($staticBaseUrl . 'externals/smoothbox/smoothbox4.js')
        ->prependFile($staticBaseUrl . 'application/modules/User/externals/scripts/core.js')
        ->prependFile($staticBaseUrl . 'application/modules/Core/externals/scripts/core.js')
        ->prependFile($staticBaseUrl . 'externals/chootools/chootools.js')
        ->prependFile($staticBaseUrl . 'externals/mootools/mootools-more-1.4.0.1-full-compat-' . (APPLICATION_ENV == 'development' ? 'nc' : 'yc') . '.js')
        ->prependFile($staticBaseUrl . 'externals/mootools/mootools-core-1.4.5-full-compat-' . (APPLICATION_ENV == 'development' ? 'nc' : 'yc') . '.js');
    // Process
    foreach ($this->headScript()->getContainer() as $dat) {
        if (!empty($dat->attributes['src'])) {
            if (false === strpos($dat->attributes['src'], '?')) {
                $dat->attributes['src'] .= '?c=' . $counter;
            } else {
                $dat->attributes['src'] .= '&c=' . $counter;
            }
        }
    }
    ?>
    <?php echo $this->headScript()->toString()."\n" ?>



    <?php echo $headIncludes ?>

    <?php
    if (file_exists($currentThemeHeader)) {
        require($currentThemeHeader);
    }
    ?>


<script type="application/javascript">
  //set page title
  window.parent.document.title = sesJqueryObject(document).prop('title');
  //update parent meta tags
  sesJqueryObject("head meta").each(function () {
    var name = sesJqueryObject(this).attr('name');
    var content = sesJqueryObject(this).attr('content');
    var property = sesJqueryObject(this).attr('content');
    if(typeof name != "undefined" && typeof content != "undefined"){
        parent.sesJqueryObject("meta[name='"+name+"']").attr('content',content);
    }else if(typeof name != "undefined" && property != "undefined"){
        parent.sesJqueryObject("meta[name='"+name+"']").attr('property',property);
    }
  })

  sesJqueryObject(document).click(function(){
    setMusicCookie("sessiteiframeCookieValue", 'sessiteiframe', 1);
  });
  sesJqueryObject(document).on("click", function(event) {
    if (event.ctrlKey || event.shiftKey || event.metaKey || event.which == 2) {
        setMusicCookie("sessiteiframeCookieValue", 'sessiteiframe', 0);
    }
    // ... load only necessary things for normal clicks
  });
  sesJqueryObject(document).ready(function(){
    <?php if(empty($_COOKIE["sesmusic_player_hide"]) && !empty($_COOKIE["sesmusic_playlists"])) { ?> 
        sesJqueryObject('#iframe12345').contents().find('body').addClass('sesmusic_music_player_full');
    <?php } else { ?>
        sesJqueryObject('#iframe12345').contents().find('body').removeClass('sesmusic_music_player_full');
    <?php } ?>
    window.parent.changeHashState();
    
    parent.history.pushState(null, null, '<?php echo str_replace(array('?sessiteiframeCookieValue=true', 'sessiteiframeCookieValue=true'), array('', ''), "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>');
    });
</script>
</head>
<body id="global_page_<?php echo $identity ?>"<?php if (!$this->viewer()->getIdentity()): ?> class="guest-user"<?php endif; ?>>
<script type="javascript/text">
    if(DetectIpad()){
      $$('a.album_main_upload').setStyle('display', 'none');
      $$('a.album_quick_upload').setStyle('display', 'none');
      $$('a.icon_photos_new').setStyle('display', 'none');
    }
  </script>
<?php if (file_exists($currentTheme)): ?>
    <?php $this->content()->renderThemeLayout($this, $currentTheme); ?>
<?php else: ?>
    <div id="global_header">
        <?php echo $headerContent ?>
    </div>
    <div id='global_wrapper'>
        <div id='global_content'>
            <?php echo $this->layout()->content ?>
        </div>
    </div>
    <div id="global_footer">
        <?php echo $footerContent ?>
    </div>
<?php endif; ?>
<script type="application/javascript">
function play_music(id, path, title, store_link, image_path, playallsongs) {
  parent.play_music(id, path, title, store_link, image_path, playallsongs);
}
</script>
<div id="janrainEngageShare" style="display:none">Share</div>
</body>
</html>
<?php } ?>