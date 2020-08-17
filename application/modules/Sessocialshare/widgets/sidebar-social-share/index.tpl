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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sessocialshare/externals/styles/styles.css'); ?>
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

    $pinteresturl = 'http://pinterest.com/pin/create/button/?url='.$urlencode.'&media='.urlencode((strpos($image,'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'].$image ) : $image)).'&description='.strip_tags($nonmetaTitle);
  }
  $socialicons = Engine_Api::_()->getDbTable('socialicons', 'sessocialshare')->getSocialInfo(array('enabled' => 1, 'limit' => $this->socialshare_icon_limit)); 
?>
<?php if($this->margintype == 'per'){$type = '%';}else{$type = 'px';} ?>
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
<div id="sessocialshare_floating_btns" style="top:<?php echo $this->margin.$type; ?>" class="sidebar_social_share_widget <?php if($this->position == 1): ?> sidebar_social_share_right <?php endif; ?> sesbasic_bxs ">

   <a title="<?php echo $this->translate('Hide'); ?>" href="javascript:void(0);" class="sidebar_social_share_toggle" id="sidebar_social_share_toggle"><i class="_left fa fa-angle-double-left"></i><i class="_right fa fa-angle-double-right"></i></a>
  <?php foreach($socialicons as $socialicon):  ?>
    <?php 
    $socialShareCounter = Engine_Api::_()->getDbtable('linksaves', 'sessocialshare')->socialShareCounter(array('title' => $socialicon->type, 'pageurl' => $URL)); 
    if(empty($socialShareCounter)) {
      $socialShareCounter = 0; 
    }
    ?>
    <?php if($socialicon->type == 'facebook') { ?>
      <a href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode.'&t='; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>', '<?php echo $this->showCount; ?>')" class="sessocial_icon_btn sessocial_icon_facebook_btn">
      <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/facebook.png'); "></i> 
      <span class="sidebar_social_content sessocialshare_count_facebook"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
      <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
    <?php } elseif($socialicon->type == 'twitter') { ?>
      <a href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '&text=%0a'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title)?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>', '<?php echo $this->showCount; ?>')" class="sessocial_icon_btn sessocial_icon_twitter_btn">
      <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/twitter.png')"></i> 
      <span class="sidebar_social_content sessocialshare_count_twitter"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
      <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
      </a>
    <?php } elseif($socialicon->type == 'pinterest') { ?>
      <a href="<?php echo $pinteresturl; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>', '<?php echo $this->showCount; ?>')" class="sessocial_icon_btn sessocial_icon_pintrest_btn">
      <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/pinterest.png')"></i> 
      <span class="sidebar_social_content sessocialshare_count_pinterest"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
      <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
      </a>
    <?php } elseif($socialicon->type == 'googleplus') { ?>
      <a href="<?php echo 'https://plus.google.com/share?url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>', '<?php echo $this->showCount; ?>')" class="sessocial_icon_btn sessocial_icon_googleplus_btn">
      <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/google-plus.png')"></i>
      <span class="sidebar_social_content sessocialshare_count_googleplus"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
      <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
      </a>
    <?php } elseif($socialicon->type == 'linkedin') { ?>
      <a href="<?php echo 'https://www.linkedin.com/shareArticle?mini=true&url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>', '<?php echo $this->showCount; ?>')" class="sessocial_icon_btn sessocial_icon_linkedin_btn">
      <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/linkedin.png')"></i> 
      <span class="sidebar_social_content sessocialshare_count_linkedin"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
      <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
      </a>
    <?php } elseif($socialicon->type == 'gmail') { ?>
      <a href="<?php echo 'https://mail.google.com/mail/u/0/?view=cm&fs=1&to&body='.$urlencode.'&ui=2&tf=1'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>', '<?php echo $this->showCount; ?>')" class="sessocial_icon_btn sessocial_icon_gmail_btn">
      <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/gmail.png')"></i> 
      <span class="sidebar_social_content sessocialshare_count_gmail"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
      <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
    <?php } elseif($socialicon->type == 'tumblr') { ?>
      <a href="<?php echo 'http://www.tumblr.com/share/link?url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>', '<?php echo $this->showCount; ?>')" class="sessocial_icon_btn sessocial_icon_tumblr_btn">
      <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/tumblr.png')"></i> 
      <span class="sidebar_social_content sessocialshare_count_tumblr"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
      <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
      </a>
    <?php } elseif($socialicon->type == 'digg') { ?>
      <a href="<?php echo 'http://digg.com/submit?phase=2&amp;url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>', '<?php echo $this->showCount; ?>')" class="sessocial_icon_btn sessocial_icon_digg_btn">
      <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/digg.png')"></i>
      <span class="sidebar_social_content sessocialshare_count_digg"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
       <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
      </a>
    <?php } elseif($socialicon->type == 'stumbleupon') { ?>
      <a href="<?php echo 'http://www.stumbleupon.com/submit?url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>', '<?php echo $this->showCount; ?>')" class="sessocial_icon_btn sessocial_icon_stumbleupon_btn">
      <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/stumbleupon.png')"></i>
      <span class="sidebar_social_content sessocialshare_count_stumleupon"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
       <span class="sidebar_social_title"><?php echo $this->translate("Stumbleupon"); ?></span>
      </a>
    <?php } elseif($socialicon->type == 'myspace') { ?>
      <a href="<?php echo 'http://www.myspace.com/Modules/PostTo/Pages/?u='.$urlencode.'&l=3'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>', '<?php echo $this->showCount; ?>')" class="sessocial_icon_btn sessocial_icon_myspace_btn">
      <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/myspace.png')"></i>
      <span class="sidebar_social_content sessocialshare_count_myspace"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
       <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
      </a>
    <?php } elseif($socialicon->type == 'facebookmessager' && $facebokClientId) { ?>
      <a href="<?php echo 'https://www.facebook.com/dialog/send?link='.$urlencode.'&redirect_uri='.$urlencode.'&app_id='.$facebokClientId; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>', '<?php echo $this->showCount; ?>')" class="sessocial_icon_btn sessocial_icon_facebookmessager_btn">
      <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/facebook_messenger.png')"></i>
      <span class="sidebar_social_content sessocialshare_count_facebookmessager"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
       <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
      </a>
    <?php } elseif($socialicon->type == 'rediff') { ?>
      <a href="<?php echo 'http://share.rediff.com/bookmark/addbookmark?bookmarkurl='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>', '<?php echo $this->showCount; ?>')" class="sessocial_icon_btn sessocial_icon_rediff_btn">
      <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/rediff.png')"></i>
      <span class="sidebar_social_content sessocialshare_count_rediff"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
       <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
      </a>
    <?php } elseif($socialicon->type == 'googlebookmark') { ?>
      <a href="<?php echo 'https://www.google.com/bookmarks/mark?op=edit&output=popup&bkmk='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>', '<?php echo $this->showCount; ?>')" class="sessocial_icon_btn sessocial_icon_bookmark_btn">
      <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/bookmark.png')"></i>
      <span class="sidebar_social_content sessocialshare_count_googlebookmark"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
       <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
      </a>
    <?php } elseif($socialicon->type == 'flipboard') { ?>
      <a href="<?php echo 'https://share.flipboard.com/bookmarklet/popout?v=2&url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>', '<?php echo $this->showCount; ?>')" class="sessocial_icon_btn sessocial_icon_flipboard_btn">
        <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/flipboard.png');"></i>
        <span class="sidebar_social_content sessocialshare_count_flipboard"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
        <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
      </a>
    <?php } elseif($socialicon->type == 'skype') { ?>
        <a href="<?php echo 'https://web.skype.com/share?url='.$urlencode.'&lang=en' ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>', '<?php echo $this->showCount; ?>')" class="sessocial_icon_btn sessocial_icon_skype_btn">
          <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/skype.png');"></i>
          <span class="sidebar_social_content sessocialshare_count_skype"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
          <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
      </a>
      <?php } elseif($socialicon->type == 'yahoo') { ?>
        <a href="<?php echo 'http://compose.mail.yahoo.com/?body='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>', '<?php echo $this->showCount; ?>')" class="sessocial_icon_btn sessocial_icon_yahoo_btn">
          <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/yahoo.png');"></i>
          <span class="sidebar_social_content sessocialshare_count_yahoo"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
          <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
        </a>
      <?php } elseif($socialicon->type == 'vk') { ?>
        <a href="<?php echo 'https://vk.com/share.php?url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>', '<?php echo $this->showCount; ?>')" class="sessocial_icon_btn sessocial_icon_vk_btn">
          <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/vk.png');"></i>
          <span class="sidebar_social_content sessocialshare_count_vk"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
          <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
        </a>
      <?php } elseif($socialicon->type == 'whatsapp') { ?>
        <a href="javascript:;" class="ss_whatsapp sessocial_icon_btn sessocial_icon_whatsapp_btn">
          <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/whatsapp.png');"></i>
          <span class="sidebar_social_content sessocialshare_count_whatsapp"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
          <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
      </a>
    <?php } elseif($socialicon->type == 'print') { ?>
      <a href="javascript:;" class="sessocial_icon_btn sessocial_icon_print_btn" onclick="socialshareprint();">
        <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/print.png');"></i>
        <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
      </a>
    <?php } else if($socialicon->type == 'email') { ?>

      <?php if($this->subject) { ?>
        <a onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" target="_blank" href="sessocialshare/index/email/resource_id/<?php echo $this->subject->getType() ?>/resource_id/<?php echo $this->subject->getIdentity() ?>" class="sessocial_icon_btn sessocial_icon_email_btn">
          <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/email.png');"></i>
          <span class="sidebar_social_content sessocialshare_count_email"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
          <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
        </a>
      <?php } else { ?>
        <a onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" target="_blank" href="sessocialshare/index/email" class="sessocial_icon_btn sessocial_icon_email_btn">
          <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/email.png');"></i>
          <span class="sidebar_social_content sessocialshare_count_email"> <?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
          <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate($socialicon->title); ?></span><?php endif; ?>
        </a>
      <?php } ?>
    <?php } ?>
  <?php endforeach; ?>
  <?php if(count($socialicons) > 0 && $this->socialshare_enable_plusicon) { ?>
    <a href="javascript:;" data-url="<?php echo $this->layout()->staticBaseUrl.'sessocialshare/index/index?url='.$urlencode; ?>" class="sessocial_icon_btn sessocial_icon_more_btn sessmoothbox sessocial_icon_add_btn">
    <i style="background-image:url('application/modules/Sessocialshare/externals/images/social/more.png');"></i>
    
    <span class="sidebar_social_content sessocialshare_count_add"> <?php if($this->showtotalshare && $this->showCountnumber < $this->totalCount): ?><?php echo $this->sessocialshareApi->number_format_short($this->totalCount); ?><?php endif; ?></span>
    
    <?php if($this->showTitleTip): ?><span class="sidebar_social_title"><?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialshare.more.title', 'More')); ?></span><?php endif; ?>
    </a>
  <?php } ?>
</div>
<script>
function socialshareprint() {
  window.print();
}

<?php if($this->showsharedefault) { ?>
window.addEvent('domready', function() {
  $('sessocialshare_floating_btns').addClass('_ishidden');
  sesJqueryObject('#sidebar_social_share_toggle').attr('title', "Show");
});
<?php } ?>

$('sidebar_social_share_toggle').addEvent('click', function(event){
	event.stop();
	if($('sessocialshare_floating_btns').hasClass('_ishidden')) {
		$('sessocialshare_floating_btns').removeClass('_ishidden');
		sesJqueryObject('#sidebar_social_share_toggle').attr('title', "Hide");
  } else {
		$('sessocialshare_floating_btns').addClass('_ishidden');
		sesJqueryObject('#sidebar_social_share_toggle').attr('title', "Show");
  }
	return false;
});
</script>
<style type="text/css">
@media (min-width: 768px){
	<?php if($this->position == 1): ?>
		.sidebar_social_share_widget a.sessocial_icon_btn:nth-child(1),
		.sidebar_social_share_widget a.sessocial_icon_btn:nth-child(2){
			border-radius:<?php echo $this->radius.'px'; ?> 0 0 0;
		}
		.sidebar_social_share_widget:hover a.sessocial_icon_btn:nth-child(2){
			border-radius:0;
		}
		.sidebar_social_share_widget a.sessocial_icon_btn:nth-last-child(1){
			border-radius:0 0 0 <?php echo $this->radius.'px'; ?>;
		}
		.sidebar_social_share_widget:hover a.sessocial_icon_btn:hover{
			border-radius:<?php echo $this->radius.'px'; ?> 0 0 <?php echo $this->radius.'px'; ?>;
		}
		.sidebar_social_share_widget:hover a.sidebar_social_share_toggle{
			border-radius:<?php echo $this->radius.'px'; ?> 0 0 0;
		}
		.sidebar_social_share_widget._ishidden .sidebar_social_share_toggle{
			border-radius:<?php echo $this->radius.'px'; ?> 0 0 <?php echo $this->radius.'px'; ?> !important;
		}
	<?php else: ?>
		.sidebar_social_share_widget a.sessocial_icon_btn:nth-child(1),
		.sidebar_social_share_widget a.sessocial_icon_btn:nth-child(2){
			border-radius:0 <?php echo $this->radius.'px'; ?> 0 0;
		}
		.sidebar_social_share_widget:hover a.sessocial_icon_btn:nth-child(2){
			border-radius:0;
		}
		.sidebar_social_share_widget a.sessocial_icon_btn:nth-last-child(1){
			border-radius:0 0 <?php echo $this->radius.'px'; ?> 0;
		}
		.sidebar_social_share_widget:hover a.sessocial_icon_btn:hover{
			border-radius:0 <?php echo $this->radius.'px'; ?> <?php echo $this->radius.'px'; ?> 0;
		}
		.sidebar_social_share_widget:hover a.sidebar_social_share_toggle{
			border-radius:0 <?php echo $this->radius.'px'; ?> 0 0;
		}
		.sidebar_social_share_widget._ishidden .sidebar_social_share_toggle{
			border-radius:0 <?php echo $this->radius.'px'; ?> <?php echo $this->radius.'px'; ?> 0 !important;
		}
	<?php endif; ?>
}
</style>
