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
$sessocialshareApi = Engine_Api::_()->sessocialshare();
$facebokClientId = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.facebook.appid', '');
$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sessocialshare/externals/styles/styles.css'); ?>
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
if($this->subject) {
  $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

  
  $pinteresturl = 'http://pinterest.com/pin/create/button/?url='.$urlencode.'&media='.urlencode((strpos($this->subject->getPhotoUrl(),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'].$this->subject->getPhotoUrl() ) : $this->subject->getPhotoUrl())).'&description='.$this->subject->getTitle(); 
  
} else {
  $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
  
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

$URL = ((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


?>
<script>
function socialshareprint() {
  window.print();
}

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
<?php if($this->viewType == 1) { ?>
<div class="ses_sociallinks_1">
  <ul class="sesbasic_sidebar_block ses_sociallinks sesbasic_bxs sesbasic_clearfix">
    <?php foreach($this->socialicons as $socialicon): ?>
      <?php $socialShareCounter = Engine_Api::_()->getDbtable('linksaves', 'sessocialshare')->socialShareCounter(array('title' => $socialicon->type, 'pageurl' => $URL)); 
      if(empty($socialShareCounter)) {
        $socialShareCounter = 0; 
      } ?>
      <li class="ses_sociallinks_<?php echo $socialicon->type ?>" style="width:<?php echo $this->width;?>px;">
        <?php if($socialicon->type == 'facebook'):?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?> href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/facebook_active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_facebook"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'twitter'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '%0a'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title)?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/twitter-active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_twitter"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Tweet"); } else { echo $this->translate("Tweets"); }; ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'pinterest'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo $pinteresturl; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/pinterest_active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_pinterest"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
              <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Pin"); } else { echo $this->translate("Pins"); }; ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'googleplus'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://plus.google.com/share?url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
            <img src="application/modules/Sessocialshare/externals/images/social/google-plus_active.png" />
            <span class="ses_sociallinks_count sessocialshare_count_googleplus"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
            <?php if($this->showShareText) { ?>
            <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
            <?php } ?>
          </div>
        </a>
        <?php elseif($socialicon->type == 'linkedin'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://www.linkedin.com/shareArticle?mini=true&url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/linkedin_active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_linkedin"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
              <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'gmail'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://mail.google.com/mail/u/0/?view=cm&fs=1&to&body='.$urlencode.'&ui=2&tf=1'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/gmail_active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_gmail"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
              <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Email"); } else { echo $this->translate("Emails"); }; ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'tumblr'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'http://www.tumblr.com/share/link?url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/tumblr-active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_tumblr"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
              <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'digg'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'http://digg.com/submit?phase=2&amp;url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/digg_active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_digg"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
              <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'stumbleupon'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'http://www.stumbleupon.com/submit?url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" >
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/stumbleupon_active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_stumbleupon"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
              <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'myspace'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'http://www.myspace.com/Modules/PostTo/Pages/?u='.$urlencode.'&l=3'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" >
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/myspace_active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_myspace"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
              <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'facebookmessager'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://www.facebook.com/dialog/send?link='.$urlencode.'&redirect_uri='.$urlencode.'&app_id='.$facebokClientId; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/facebook_messenger_active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_facebookmessager"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
              <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'rediff'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'http://share.rediff.com/bookmark/addbookmark?bookmarkurl='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" >
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/rediff_active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_rediff"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'googlebookmark'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://www.google.com/bookmarks/mark?op=edit&output=popup&bkmk='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" >
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/bookmark_active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_googlebookmark"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
              <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'flipboard'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://share.flipboard.com/bookmarklet/popout?v=2&url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" >
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/flipboard_active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_flipboard"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
              <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'skype'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://web.skype.com/share?url='.$urlencode.'&lang=en' ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" >
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/skype-active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_skype"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
              <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'yahoo'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'http://compose.mail.yahoo.com/?body='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" >
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/yahoo_active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_yahoo"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
              <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'vk'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://vk.com/share.php?url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" >
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/vk-active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_vk"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
              <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'whatsapp'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="javascript:;" class="ss_whatsapp">
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/whatsapp-active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_whatsapp"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
              <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'print'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="javascript:;" onclick="socialshareprint();">
            <div>
              <img src="application/modules/Sessocialshare/externals/images/social/print-active.png" />
              <span class="ses_sociallinks_count sessocialshare_count_print"></span>
              <?php if($this->showShareText) { ?>
              <span class="ses_sociallinks_text"><?php echo $this->translate("Print"); ?></span>
              <?php } ?>
            </div>
          </a>
        <?php elseif($socialicon->type == 'email'): ?>
          <?php if($this->subject) { ?>
            <a  onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  target="_blank" href="sessocialshare/index/email/resource_id/<?php echo $this->subject->getType() ?>/resource_id/<?php echo $this->subject->getIdentity() ?>">
              <div>
                <img src="application/modules/Sessocialshare/externals/images/social/email_active.png" />
                <span class="ses_sociallinks_count sessocialshare_count_email"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                <?php } ?>
              </div>
            </a>
          <?php } else { ?>
            <a  onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  target="_blank" href="sessocialshare/index/email/">
              <div>
                <img src="application/modules/Sessocialshare/externals/images/social/email_active.png" />
                <span class="ses_sociallinks_count sessocialshare_count_email"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php echo $this->translate("Email"); ?></span>
                <?php } ?>
              </div>
            </a>
          <?php } ?>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
    <?php if(count($socialicon) > 0 && $this->socialshare_enable_plusicon) { ?>
      <li class="ses_sociallinks_more" style="width:<?php echo $this->width;?>px;">
        <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialshare.more.title', 'More')); ?>" <?php } ?>  href="javascript:;" data-url="<?php echo $this->layout()->staticBaseUrl.'sessocialshare/index/index?url='.$urlencode; ?>" class="sessocial_icon_add_btn sessmoothbox">
          <div>
            <img src="application/modules/Sessocialshare/externals/images/social/more_active.png" />
            <span class="ses_sociallinks_count"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $sessocialshareApi->number_format_short(Engine_Api::_()->getDbTable('linksaves', 'sessocialshare')->socialShareTotalCounter(array('pageurl' => $URL))); ?><?php endif; ?></span>
            <?php if($this->showShareText) { ?>
              <span class="ses_sociallinks_text"><?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialshare.more.title', 'More')); ?></span>
            <?php } ?>
          </div>
        </a>
      </li>
    <?php } ?>
  </ul>
</div>
<?php } elseif($this->viewType == 2) { ?>
<div class="ses_sociallinks_2">
  <ul class="sesbasic_sidebar_block ses_sociallinks sesbasic_bxs sesbasic_clearfix">
    <?php foreach($this->socialicons as $socialicon): //print_r($socialicon->type);die; ?>
      <?php $socialShareCounter = Engine_Api::_()->getDbtable('linksaves', 'sessocialshare')->socialShareCounter(array('title' => $socialicon->type, 'pageurl' => $URL)); if(empty($socialShareCounter)) { $socialShareCounter = 0; } ?>
      <li class="ses_sociallinks_<?php echo $socialicon->type ?>" style="width:<?php echo $this->width;?>px;">
        <?php if($socialicon->type == 'facebook'):?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
              <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/facebook_active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count sessocialshare_count_facebook"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                  <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'twitter'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '%0a'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title)?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
              <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/twitter-active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count sessocialshare_count_twitter"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'pinterest'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo $pinteresturl; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
              <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/pinterest_active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count sessocialshare_count_pinterest"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'googleplus'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://plus.google.com/share?url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
            <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/google-plus_active.png" /></span>
            <div class="social_desc">
              <span class="ses_sociallinks_count sessocialshare_count_googleplus"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
              <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
              <?php } ?>
            </div>
          </div>
        </a>
        <?php elseif($socialicon->type == 'linkedin'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://www.linkedin.com/shareArticle?mini=true&url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
              <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/linkedin_active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count sessocialshare_count_linkedin"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'gmail'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://mail.google.com/mail/u/0/?view=cm&fs=1&to&body='.$urlencode.'&ui=2&tf=1'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
              <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/gmail_active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count sessocialshare_count_gmail"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'tumblr'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'http://www.tumblr.com/share/link?url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
              <span class="ses_sociallinks_img sessocialshare_count_tumblr"><img src="application/modules/Sessocialshare/externals/images/social/tumblr-active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                  <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                  <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'digg'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'http://www.tumblr.com/share/link?url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
              <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/digg_active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count sessocialshare_count_digg"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'stumbleupon'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'http://www.stumbleupon.com/submit?url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" >
            <div>
              <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/stumbleupon_active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count sessocialshare_count_stumbleupon"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                  <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                  <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'myspace'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'http://www.myspace.com/Modules/PostTo/Pages/?u='.$urlencode.'&l=3'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" >
            <div>
              <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/myspace_active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count sessocialshare_count_myspace"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'facebookmessager'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://www.facebook.com/dialog/send?link='.$urlencode.'&redirect_uri='.$urlencode.'&app_id='.$facebokClientId; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')">
            <div>
              <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/facebook_messenger_active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count sessocialshare_count_facebookmessager"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'rediff'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'http://share.rediff.com/bookmark/addbookmark?bookmarkurl='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" >
            <div>
              <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/rediff_active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count sessocialshare_count_rediff"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                  <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                  <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'googlebookmark'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://www.google.com/bookmarks/mark?op=edit&output=popup&bkmk='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" >
            <div>
              <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/bookmark_active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count sessocialshare_count_googlebookmark"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'flipboard'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://share.flipboard.com/bookmarklet/popout?v=2&url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" >
            <div>
              <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/flipboard_active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count sessocialshare_count_flipboard"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'skype'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://web.skype.com/share?url='.$urlencode.'&lang=en' ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" >
            <div>
              <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/skype-active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count sessocialshare_count_skype"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'yahoo'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'http://compose.mail.yahoo.com/?body='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" >
            <div>
              <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/yahoo_active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count sessocialshare_count_yahoo"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'vk'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="<?php echo 'https://vk.com/share.php?url='.$urlencode.'&lang=en' ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" >
            <div>
              <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/vk-active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count sessocialshare_count_vk"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'whatsapp'): ?>
          <a href="<?php echo 'https://web.whatsapp.com/share?url='.$urlencode.'&lang=en' ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" >
            <div>
              <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/whatsapp-active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count sessocialshare_count_whatsapp"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php if($socialShareCounter == 1) { echo $this->translate("Share"); } else { echo $this->translate("Shares"); }; ?></span>
                <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'print'): ?>
          <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  href="javascript:void(0);" onclick="socialshareprint();" >
            <div>
              <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/print-active.png" /></span>
              <div class="social_desc">
                <span class="ses_sociallinks_count sessocialshare_count_print"></span>
                <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php echo $this->translate("Print"); ?></span>
                <?php } ?>
              </div>
            </div>
          </a>
        <?php elseif($socialicon->type == 'email'): ?>
          <?php if($this->subject) { ?>
            <a  onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  target="_blank" href="sessocialshare/index/email/resource_id/<?php echo $this->subject->getType() ?>/resource_id/<?php echo $this->subject->getIdentity() ?>">
              <div>
                <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/email_active.png" /></span>
                <div class="social_desc">
                  <span class="ses_sociallinks_count sessocialshare_count_email"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                  <?php if($this->showShareText) { ?>
                  <span class="ses_sociallinks_text"><?php echo $this->translate("Email"); ?></span>
                  <?php } ?>
                </div>
              </div>
            </a>
          <?php } else { ?>
            <a  onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate($socialicon->title); ?>" <?php } ?>  target="_blank" href="sessocialshare/index/email/">
              <div>
                <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/email_active.png" /></span>
                <div class="social_desc">
                  <span class="ses_sociallinks_count sessocialshare_count_email"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $this->sessocialshareApi->number_format_short($socialShareCounter); ?><?php endif; ?></span>
                  <?php if($this->showShareText) { ?>
                  <span class="ses_sociallinks_text"><?php echo $this->translate("Email"); ?></span>
                  <?php } ?>
                </div>
              </div>
            </a>
          <?php } ?>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
    <?php if(count($socialicon) > 0 && $this->socialshare_enable_plusicon) { ?>
      <li class="ses_sociallinks_more" style="width:<?php echo $this->width;?>px;">
        <a <?php if($this->showTitleTip) { ?> title="<?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialshare.more.title', 'More')); ?>" <?php } ?>  href="javascript:;" data-url="<?php echo $this->layout()->staticBaseUrl.'sessocialshare/index/index?url='.$urlencode; ?>" class="sessocial_icon_add_btn sessmoothbox">
          <div>
            <span class="ses_sociallinks_img"><img src="application/modules/Sessocialshare/externals/images/social/more_active.png" /></span>
            <div class="social_desc">
              <span class="ses_sociallinks_count sessocialshare_count_add"><?php if($this->showCount && $this->showCountnumber < $socialShareCounter): ?><?php echo $sessocialshareApi->number_format_short(Engine_Api::_()->getDbTable('linksaves', 'sessocialshare')->socialShareTotalCounter(array('pageurl' => $URL))); ?><?php endif; ?></span>
              <?php if($this->showShareText) { ?>
                <span class="ses_sociallinks_text"><?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialshare.more.title', 'More')); ?></span>
              <?php } ?>
            </div>
          </div>
        </a>
      </li>
    <?php } ?>
  </ul>
</div>
<?php } ?>