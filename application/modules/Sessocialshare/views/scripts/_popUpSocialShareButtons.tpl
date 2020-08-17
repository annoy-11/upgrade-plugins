<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _popUpSocialShareButtons.tpl 2017-07-29 00:00:00 SocialEngineSolutions $
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
$type = $this->type;
$id = $this->id;
$resource = Engine_Api::_()->getItem($type, $id);
if($resource) {
  $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $resource->getHref());
  
  $pinteresturl = 'http://pinterest.com/pin/create/button/?url='.$urlencode.'&media='.urlencode((strpos($resource->getPhotoUrl(),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'].$resource->getPhotoUrl() ) : $resource->getPhotoUrl())).'&description='.$resource->getTitle(); 
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
        $nonmetaTitle = $getPageTitle->title . ' '. $this->translate($this->layout()->siteinfo['title']);
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
  
  $pinteresturl = 'http://pinterest.com/pin/create/button/?url='.$urlencode.'&media='.urlencode((strpos($image,'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'].$image ) : $image)).'&description='.strip_tags($nonmetaTitle); 
}
?>
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

function socialshareprint() {
  window.print();
}
</script>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sessocialshare/externals/styles/styles.css'); ?>
<div class="socialshare_popup_buttons sesbasic_bxs">
<?php 
  $facebokClientId = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.facebook.appid', '');
  
  $socialicons = Engine_Api::_()->getDbTable('socialicons', 'sessocialshare')->getSocialInfo(array('enabled' => 1, 'limit' => 20)); ?>

<?php foreach($socialicons as $socialicon):  ?>
  <?php if($socialicon->type == 'facebook') { ?>
    <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_facebook_btn">
    	<i><img src="application/modules/Sessocialshare/externals/images/social/facebook.png" /></i>
      <span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'twitter') { ?>
    <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '&text=%0a'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title)?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_twitter_btn">
    	<i><img src="application/modules/Sessocialshare/externals/images/social/twitter.png" /></i>
    	<span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'pinterest') { ?>
    <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo $pinteresturl; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_pintrest_btn">
   		<i><img src="application/modules/Sessocialshare/externals/images/social/pinterest.png" /></i>
  		<span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'googleplus') { ?>
    <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'https://plus.google.com/share?url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_googleplus_btn">
    	<i><img src="application/modules/Sessocialshare/externals/images/social/google-plus.png" /></i>
      <span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'linkedin') { ?>
    <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'https://www.linkedin.com/shareArticle?mini=true&url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_linkedin_btn">
    	<i><img src="application/modules/Sessocialshare/externals/images/social/linkedin.png" /></i>
    	<span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'gmail') { ?>
    <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'https://mail.google.com/mail/u/0/?view=cm&fs=1&to&body='.$urlencode.'&ui=2&tf=1'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_gmail_btn">
    	<i><img src="application/modules/Sessocialshare/externals/images/social/gmail.png" /></i>
    	<span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'tumblr') { ?>
    <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'http://www.tumblr.com/share/link?url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_tumblr_btn">
      <i><img src="application/modules/Sessocialshare/externals/images/social/tumblr.png" /></i>
      <span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'digg') { ?>
    <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'http://digg.com/submit?phase=2&amp;url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_digg_btn">
    	<i><img src="application/modules/Sessocialshare/externals/images/social/digg.png" /></i>
    	<span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'stumbleupon') { ?>
    <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'http://www.stumbleupon.com/submit?url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_stumbleupon_btn">
    	<i><img src="application/modules/Sessocialshare/externals/images/social/stumbleupon.png" /></i>
    	<span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'myspace') { ?>
    <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'http://www.myspace.com/Modules/PostTo/Pages/?u='.$urlencode.'&l=3'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_myspace_btn">
    	<i><img src="application/modules/Sessocialshare/externals/images/social/myspace.png" /></i>
      <span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'facebookmessager' && $facebokClientId) { ?>
    <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'https://www.facebook.com/dialog/send?link='.$urlencode.'&redirect_uri='.$urlencode.'&app_id='.$facebokClientId; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_facebookmessager_btn">
    	<i><img src="application/modules/Sessocialshare/externals/images/social/facebook_messenger.png" /></i>
      <span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'rediff') { ?>
    <a title="<?php echo $this->translate($socialicon->title); ?>"  href="<?php echo 'http://share.rediff.com/bookmark/addbookmark?bookmarkurl='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_rediff_btn">
    	<i><img src="application/modules/Sessocialshare/externals/images/social/rediff.png" /></i>
    	<span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'googlebookmark') { ?>
    <a title="<?php echo $this->translate($socialicon->title); ?>"  href="<?php echo 'https://www.google.com/bookmarks/mark?op=edit&output=popup&bkmk='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_bookmark_btn">
    	<i><img src="application/modules/Sessocialshare/externals/images/social/bookmark.png" /></i>
      <span><?php echo $this->translate($socialicon->title); ?></span>
  	</a>
  <?php } elseif($socialicon->type == 'flipboard') { ?>
    <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'https://share.flipboard.com/bookmarklet/popout?v=2&url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_rediff_btn">
    	<i><img src="application/modules/Sessocialshare/externals/images/social/flipboard.png" /></i>
    	<span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'skype') { ?>
    <a title="<?php echo $this->translate($socialicon->title); ?>"  href="<?php echo 'https://web.skype.com/share?url='.$urlencode.'&lang=en' ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_skype_btn">
    	<i><img src="application/modules/Sessocialshare/externals/images/social/skype.png" /></i>
      <span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'yahoo') { ?>
    <a title="<?php echo $this->translate($socialicon->title); ?>"  href="<?php echo 'http://compose.mail.yahoo.com/?body='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_yahoo_btn">
    	<i><img src="application/modules/Sessocialshare/externals/images/social/yahoo.png" /></i>
    	<span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'vk') { ?>
    <a title="<?php echo $this->translate($socialicon->title); ?>"  href="<?php echo 'https://vk.com/share.php?url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_vk_btn">
    	<i><img src="application/modules/Sessocialshare/externals/images/social/vk.png" /></i>
      <span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'whatsapp') { ?>
    <a onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" title="<?php echo $this->translate($socialicon->title); ?>"  href="javascript:;" class="ss_whatsapp sessocial_icon_btn sessocial_icon_whatsapp_btn">
    	<i><img src="application/modules/Sessocialshare/externals/images/social/whatsapp.png" /></i>
    	<span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'print') { ?>
    <a onclick="socialshareprint();" title="<?php echo $this->translate($socialicon->title); ?>"  href="javascript:;" class="sessocial_icon_btn sessocial_icon_print_btn">
    	<i><img src="application/modules/Sessocialshare/externals/images/social/print.png" /></i>
    	<span><?php echo $this->translate($socialicon->title); ?></span>
    </a>
  <?php } elseif($socialicon->type == 'email') { ?>
    <?php if($this->subject) { ?>
      <a onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" target="_blank" href="sessocialshare/index/email/resource_id/<?php echo $this->subject->getType() ?>/resource_id/<?php echo $this->subject->getIdentity() ?>" title="<?php echo $this->translate('Email'); ?>"  href="javascript:;" class="sessocial_icon_btn sessocial_icon_email_btn"> 
      	<i><img src="application/modules/Sessocialshare/externals/images/social/email.png" /></i>
      	<span><?php echo $this->translate($socialicon->title); ?></span>
      </a>
    <?php } else { ?>
      <a onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" onclick="openSmoothBoxInUrl('sessocialshare/index/email/');return false;" title="<?php echo $this->translate('Email'); ?>"  href="javascript:;" class="sessocial_icon_btn sessocial_icon_email_btn"> 
      	<i><img src="application/modules/Sessocialshare/externals/images/social/email.png" /></i>
      	<span><?php echo $this->translate($socialicon->title); ?></span>
      </a>
    <?php } ?>
  <?php } ?>
<?php endforeach; ?>
</div>