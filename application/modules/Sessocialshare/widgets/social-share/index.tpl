<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php 
if(Engine_Api::_()->sesbasic()->isModuleEnable(array('sesmetatag'))) {
  $request = Zend_Controller_Front::getInstance()->getRequest();
  $moduleName = $request->getModuleName();
  $controllerName = $request->getControllerName();
  $actionName = $request->getActionName();
  $metaTags = Engine_Api::_()->sesmetatag()->getWidgitizePagesPhoto(array('module'=>$moduleName, 'controller' => $controllerName, 'action' => $actionName)); 
}
?>
<?php 
  $sessocialshareApi = Engine_Api::_()->sessocialshare();
  $URL = ((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  
  $facebokClientId = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.facebook.appid', '');
  
  if($this->subject) {
  
    $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    
    $pinteresturl = 'http://pinterest.com/pin/create/button/?url='.$urlencode.'&media='.urlencode((strpos($this->subject->getPhotoUrl(),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'].$this->subject->getPhotoUrl() ) : $this->subject->getPhotoUrl())).'&description='.$this->subject->getTitle(); 
    
  } else { 
    $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

    if(Engine_Api::_()->sesbasic()->isModuleEnable(array('sesmetatag'))) {
      $nonmetaTitle = $metaTags['title'];
        if($metaTags['image']) {
          $image = $metaTags['image'];
        } else {
          $nonmetaPhoto = Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialshare.nonmeta.photo', '');
          if (!empty($nonmetaPhoto)) {
            $image = $this->baseUrl() . '/' . $nonmetaPhoto;
            $image = 'http://' . $_SERVER['HTTP_HOST'] . $image;
          }
        }
    } else {
      $request = Zend_Controller_Front::getInstance()->getRequest();
      $pagename = $request->getModuleName() . '_' . $request->getActionName() . '_' . $request->getControllerName();
      $getPageTitle = Engine_Api::_()->sessocialshare()->getPageTitle($pagename);
      if($getPageTitle) {
        $nonmetaTitle = $getPageTitle->title . ' ' . $this->translate($this->layout()->siteinfo['title']);
      } else {
        $nonmetaTitle = $this->translate($this->layout()->siteinfo['title']);
      }
      $nonmetaPhoto = Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialshare.nonmeta.photo', '');
      if (!empty($nonmetaPhoto)) {
        $image = $this->baseUrl() . '/' . $nonmetaPhoto;
        $image = 'http://' . $_SERVER['HTTP_HOST'] . $image;
      } else {
        $image = '';
      }
    }
    if($image) {
      $pinteresturl = 'http://pinterest.com/pin/create/button/?url='.$urlencode.'&media='.urlencode((strpos($image,'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'].$image ) : $image)).'&description='.strip_tags($nonmetaTitle);
    } else {
      $pinteresturl = 'http://pinterest.com/pin/create/button/?url='.$urlencode.'&description='.strip_tags($nonmetaTitle);
    }
  }

  $socialicons = Engine_Api::_()->getDbTable('socialicons', 'sessocialshare')->getSocialInfo(array('enabled' => 1, 'limit' => $this->socialshare_icon_limit)); ?>
<script>
  sesJqueryObject(document).on('click','.ss_whatsapp',function(){
    var text = '';
    var url = '<?php echo ((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>';
    
    //Counter increase
    var	urlsave = en4.core.baseUrl+'sessocialshare/index/savesocialsharecount/';
    var socialShareCountSave =	(new Request.HTML({
        method: 'post',
        'url': urlsave,
        'data': {
          title: '',
          pageurl: '<?php echo $urlencode; ?>',
          type: 'whatsapp',
          format: 'html',
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          //keep Silence
          //location.reload();
          if(showCount == 1) {
            var countType = sesJqueryObject('.sessocialshare_count_'+type).html();
            sesJqueryObject('.sessocialshare_count_'+type).html(++countType);
          }
        }
    }));
    socialShareCountSave.send();
    
    var message = encodeURIComponent(text) + " - " + encodeURIComponent(url);
    var whatsapp_url = "whatsapp://send?text=" + message;
    window.location.href = whatsapp_url;
  });
</script>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sessocialshare/externals/styles/styles.css'); ?>
<div class="sesbasic_sidebar_block social_share_widget_icons">


<?php foreach($socialicons as $socialicon):  ?>
    <?php 
    $socialShareCounter = Engine_Api::_()->getDbtable('linksaves', 'sessocialshare')->socialShareCounter(array('title' => $socialicon->type, 'pageurl' => $URL)); 
    if(empty($socialShareCounter)) {
      $socialShareCounter = 0; 
    }
    ?>
  <?php if($socialicon->type == 'facebook') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_facebook_btn sessocialshare_buttons_hw">	
     <div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/facebook.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_facebook"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span><?php endif; ?><?php } ?>
     </div>
    </a>
  <?php } elseif($socialicon->type == 'twitter') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '&text=%0a'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title)?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_twitter_btn sessocialshare_buttons_hw">
     <div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/twitter.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_twitter"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Tweet"); } else { echo $this->translate("Tweets"); }; ?></span><?php endif; } ?>
     </div>
    </a>
  <?php } elseif($socialicon->type == 'pinterest') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo $pinteresturl; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_pintrest_btn sessocialshare_buttons_hw">
    	<div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/pinterest.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_pinterest"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Pin"); } else { echo $this->translate("Pins"); }; ?></span><?php endif; } ?>
     	</div>
    </a>
  <?php } elseif($socialicon->type == 'googleplus') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo 'https://plus.google.com/share?url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_googleplus_btn sessocialshare_buttons_hw">
   		<div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/google-plus.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_googleplus"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span><?php endif; } ?>
    	</div>
    </a>
  <?php } elseif($socialicon->type == 'linkedin') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo 'https://www.linkedin.com/shareArticle?mini=true&url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_linkedin_btn sessocialshare_buttons_hw">
    	<div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/linkedin.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_linkedin"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span><?php endif; } ?>
     </div>
    </a>
  <?php } elseif($socialicon->type == 'gmail') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo 'https://mail.google.com/mail/u/0/?view=cm&fs=1&to&body='.$urlencode.'&ui=2&tf=1'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_gmail_btn sessocialshare_buttons_hw">
    	<div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/gmail.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_gmail"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Email"); } else { echo $this->translate("Emails"); }; ?></span><?php endif; } ?>
     </div>
    </a>
  <?php } elseif($socialicon->type == 'tumblr') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo 'http://www.tumblr.com/share/link?url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_tumblr_btn sessocialshare_buttons_hw">
    	<div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/tumblr.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_tumblr"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span><?php endif; } ?>
    	</div>
    </a>
  <?php } elseif($socialicon->type == 'digg') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo 'http://digg.com/submit?phase=2&amp;url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_digg_btn sessocialshare_buttons_hw">
   		<div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/digg.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_digg"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span><?php endif; } ?>
    	</div>
    </a>
  <?php } elseif($socialicon->type == 'stumbleupon') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo 'http://www.stumbleupon.com/submit?url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_stumbleupon_btn sessocialshare_buttons_hw">
    	<div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/stumbleupon.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_stumbleupon"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span><?php endif; } ?>
    	</div>
    </a>
  <?php } elseif($socialicon->type == 'myspace') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo 'http://www.myspace.com/Modules/PostTo/Pages/?u='.$urlencode.'&l=3'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_myspace_btn sessocialshare_buttons_hw">
      <div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/myspace.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_myspace"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span><?php endif; } ?>
      </div>
    </a>
  <?php } elseif($socialicon->type == 'facebookmessager' && $facebokClientId) { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo 'https://www.facebook.com/dialog/send?link='.$urlencode.'&redirect_uri='.$urlencode.'&app_id='.$facebokClientId; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_facebookmessager_btn sessocialshare_buttons_hw">
      <div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/facebook_messenger.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_facebookmessager"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Message"); } else { echo $this->translate("Messages"); }; ?></span><?php endif; } ?>
      </div>
    </a>
  <?php } elseif($socialicon->type == 'rediff') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo 'http://share.rediff.com/bookmark/addbookmark?bookmarkurl='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_rediff_btn sessocialshare_buttons_hw">
      <div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/rediff.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_rediff"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Email"); } else { echo $this->translate("Emails"); }; ?></span><?php endif; } ?>
      </div>
    </a>
  <?php } elseif($socialicon->type == 'googlebookmark') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo 'https://www.google.com/bookmarks/mark?op=edit&output=popup&bkmk='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_bookmark_btn sessocialshare_buttons_hw">
      <div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/bookmark.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_googlebookmark"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Bookmark"); } else { echo $this->translate("Bookmarks"); }; ?></span><?php endif; } ?>
      </div>
     </a>
  <?php } elseif($socialicon->type == 'flipboard') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo 'https://share.flipboard.com/bookmarklet/popout?v=2&url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_rediff_btn sessocialshare_buttons_hw">
      <div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/flipboard.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_flipboard"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Flip"); } else { echo $this->translate("Flips"); }; ?></span><?php endif; } ?>
      </div>
    </a>
  <?php } elseif($socialicon->type == 'skype') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo 'https://web.skype.com/share?url='.$urlencode.'&lang=en' ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_skype_btn sessocialshare_buttons_hw">
      <div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/skype.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_skype"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Message"); } else { echo $this->translate("Messages"); }; ?></span><?php endif; } ?>
      </div>
    </a>
  <?php } elseif($socialicon->type == 'yahoo') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo 'http://compose.mail.yahoo.com/?body='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_yahoo_btn sessocialshare_buttons_hw">
      <div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/yahoo.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_yahoo"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Email"); } else { echo $this->translate("Emails"); }; ?></span><?php endif; } ?>
      </div>
    </a>
  <?php } elseif($socialicon->type == 'vk') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo 'https://vk.com/share.php?url='.$urlencode.'&lang=en' ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_vk_btn sessocialshare_buttons_hw">
      <div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/vk.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_vk"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span><?php endif; } ?>
      </div>
    </a>
  <?php } elseif($socialicon->type == 'whatsapp') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="javascript:;" class="ss_whatsapp sessocial_icon_btn sessocial_icon_whatsapp_btn sessocialshare_buttons_hw">
      <div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/whatsapp.png" /></span>
        <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_whatsapp"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Message"); } else { echo $this->translate("Messages"); }; ?></span><?php endif; } ?>
      </div>
    </a>
  <?php } elseif($socialicon->type == 'print') { ?>
    <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="javascript:;" class="sessocial_icon_btn sessocial_icon_print_btn sessocialshare_buttons_hw" onclick="socialshareprint();">
      <div class="social_wedgit_icons">
        <span><img src="application/modules/Sessocialshare/externals/images/social/print.png" /></span>
        <?php //if($this->showCount): ?><!--<span class="social_share_count">--><?php //echo $socialShareCounter ?><!--</span>--><?php //endif; ?>
        <?php if($this->showTitle): ?><span class="social_share_name"><?php echo $this->translate("Print"); ?></span><?php endif; ?>
      </div>
    </a>
  <?php } else if($socialicon->type == 'email') { ?>

    <?php if($this->subject) { ?>
      <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')"  target="_blank" href="sessocialshare/index/email/resource_id/<?php echo $this->subject->getType() ?>/resource_id/<?php echo $this->subject->getIdentity() ?>" class="sessocial_icon_btn sessocial_icon_email_btn sessocialshare_buttons_hw">
        <div class="social_wedgit_icons">
          <span><img src="application/modules/Sessocialshare/externals/images/social/email.png" /></span>
          <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_email"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
          <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Email"); } else { echo $this->translate("Emails"); }; ?></span><?php endif; } ?>
        </div>
      </a>
    <?php } else { ?>
      <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')"  target="_blank" href="sessocialshare/index/email/" class="sessocial_icon_btn sessocial_icon_email_btn sessocialshare_buttons_hw">
        <div class="social_wedgit_icons">
          <span><img src="application/modules/Sessocialshare/externals/images/social/email.png" /></span>
          <?php if($this->showCount && $this->showCountnumber < $socialShareCounter) { ?><span class="social_share_count sessocialshare_count_email"><?php echo $sessocialshareApi->number_format_short($socialShareCounter); ?></span>
          <?php if($this->showTitle): ?><span class="social_share_name"><?php if($socialShareCounter == 1) { echo $this->translate("Email"); } else { echo $this->translate("Emails"); }; ?></span><?php endif; } ?>
        </div>
      </a>
    <?php } ?>
  <?php } ?>
<?php endforeach; ?>
<?php if($this->socialshare_enable_plusicon) { ?>
  <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialshare.more.title', 'More')); ?>" <?php } ?> href="javascript:;" data-url="<?php echo $this->layout()->staticBaseUrl.'sessocialshare/index/index?url='.$urlencode; ?>" class="sessocial_icon_btn sessocial_icon_add_btn sessmoothbox sessocial_icon_more_btn sessocialshare_buttons_hw">
    <div class="social_wedgit_icons">
      <span><img src="application/modules/Sessocialshare/externals/images/social/more.png" /></span>
      <?php $totalCount = $sessocialshareApi->number_format_short(Engine_Api::_()->getDbTable('linksaves', 'sessocialshare')->socialShareTotalCounter(array('pageurl' => $URL))); ?>
      <?php if($this->showCountnumber < $totalCount): ?><span class="social_share_count sessocialshare_count_email"><?php echo $sessocialshareApi->number_format_short($totalCount); ?></span><?php endif; ?>
      <?php if($this->showTitle): ?><span class="social_share_name"><?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialshare.more.title', 'More')); ?></span><?php endif; ?>
    </div>
  </a>
<?php } ?>
</div>
<style type="text/css">
.sessocialshare_buttons_hw {
  height:<?php echo $this->height ?>px !important;
  width:<?php echo $this->width ?>px !important;
}
</style>
<script>
function socialshareprint() {
  window.print();
}
</script>