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
  
  function closeFly() {
    if($('socialshare_bottom_popupfly')) {
      sesJqueryObject('#socialshare_bottom_popupfly').addClass('_ishidden');
    }
  }

	window.addEventListener("scroll", function(event) {
	
    var wintop = sesJqueryObject(window).scrollTop(), docheight = sesJqueryObject(document).height(), winheight = sesJqueryObject(window).height();

    var top = (wintop/(docheight-winheight))*100; //this.scrollY;

		if (top > 30) {
			sesJqueryObject('#socialshare_bottom_popupfly').addClass('_isvisible');
		} /*else {
			sesJqueryObject('#socialshare_bottom_popupfly').removeClass('_isvisible');
    }*/
	}, false);
	var stepTime = 20;
	var docBody = document.body;
	var focElem = document.documentElement;
	
	var scrollAnimationStep = function (initPos, stepAmount) {
			var newPos = initPos - stepAmount > 0 ? initPos - stepAmount : 0;
	
			docBody.scrollTop = focElem.scrollTop = newPos;
	
			newPos && setTimeout(function () {
					scrollAnimationStep(newPos, stepAmount);
			}, stepTime);
	}
	var SESscrollTopAnimated = function (speed) {
			var topOffset = docBody.scrollTop || focElem.scrollTop;
			var stepAmount = topOffset;
	
			speed && (stepAmount = (topOffset * stepTime)/speed);
	
			scrollAnimationStep(topOffset, stepAmount);
	};
</script>

<div id="socialshare_bottom_popupfly" class="socialshare_bottom_popup sesbasic_bxs <?php if($this->position == 1) { ?> _posright <?php } else { ?> _posleft <?php  } ?>">
	<a title="<?php echo $this->translate('Close'); ?>" onclick="closeFly();" href="javascript:void(0);" class="_closebtn fa fa-close"></a>
	<div class="socialshare_bottom_popup_title"><?php echo $this->translate($this->heading); ?></div>
  <p class="socialshare_bottom_popup_desc sesbasic_text_light"><?php echo $this->translate($this->description); ?></p>
  <?php if($this->showtotalshare && $this->showminimumnumber < $this->totalCount) { ?>
    <p class="socialshare_bottom_popup_count sesbasic_text_light"><?php echo $this->translate("<b>%s</b> shares", $sessocialshareApi->number_format_short($this->totalCount)); ?></p>
  <?php } ?>
  <div class="socialshare_popup_buttons sesbasic_bxs">
  <?php 
    $facebokClientId = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.facebook.appid', '');
    $socialicons = Engine_Api::_()->getDbTable('socialicons', 'sessocialshare')->getSocialInfo(array('enabled' => 1, 'limit' => $this->socialshare_icon_limit)); ?>
  <?php foreach($socialicons as $socialicon):  ?>
    <?php if($socialicon->type == 'facebook') { ?>
    	<div>
        <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_facebook_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/facebook.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->facebook): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->facebook); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'twitter') { ?>
    	<div>
        <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '&text=%0a'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title)?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_twitter_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/twitter.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->twitter): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->twitter); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'pinterest') { ?>
    	<div>
        <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo $pinteresturl; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_pintrest_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/pinterest.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->pinterest): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->pinterest); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'googleplus') { ?>
    	<div>
        <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'https://plus.google.com/share?url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_googleplus_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/google-plus.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->googleplus): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->googleplus); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'linkedin') { ?>
    	<div>
        <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'https://www.linkedin.com/shareArticle?mini=true&url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_linkedin_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/linkedin.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->linkedin): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->linkedin); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'gmail') { ?>
    	<div>
        <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'https://mail.google.com/mail/u/0/?view=cm&fs=1&to&body='.$urlencode.'&ui=2&tf=1'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_gmail_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/gmail.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->gmail): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->gmail); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'tumblr') { ?>
    	<div>
        <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'http://www.tumblr.com/share/link?url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_tumblr_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/tumblr.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->tumblr): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->tumblr); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'digg') { ?>
    	<div>
        <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'http://digg.com/submit?phase=2&amp;url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_digg_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/digg.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->digg): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->digg); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'stumbleupon') { ?>
    	<div>
        <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'http://www.stumbleupon.com/submit?url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_stumbleupon_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/stumbleupon.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->stumbleupon): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->stumbleupon); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'myspace') { ?>
    	<div>
        <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'http://www.myspace.com/Modules/PostTo/Pages/?u='.$urlencode.'&l=3'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_myspace_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/myspace.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->myspace): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->myspace); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'facebookmessager' && $facebokClientId) { ?>
    	<div>
        <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'https://www.facebook.com/dialog/send?link='.$urlencode.'&redirect_uri='.$urlencode.'&app_id='.$facebokClientId; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_facebookmessager_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/facebook_messenger.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->facebookmessager): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->facebookmessager); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'rediff') { ?>
    	<div>
        <a title="<?php echo $this->translate($socialicon->title); ?>"  href="<?php echo 'http://share.rediff.com/bookmark/addbookmark?bookmarkurl='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_rediff_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/rediff.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->rediff): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->rediff); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'googlebookmark') { ?>
    	<div>
        <a title="<?php echo $this->translate($socialicon->title); ?>"  href="<?php echo 'https://www.google.com/bookmarks/mark?op=edit&output=popup&bkmk='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_bookmark_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/bookmark.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->googlebookmark): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->googlebookmark); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'flipboard') { ?>
    	<div>
        <a title="<?php echo $this->translate($socialicon->title); ?>" href="<?php echo 'https://share.flipboard.com/bookmarklet/popout?v=2&url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_flipboard_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/flipboard.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->flipboard): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->flipboard); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'skype') { ?>
    	<div>
        <a title="<?php echo $this->translate($socialicon->title); ?>"  href="<?php echo 'https://web.skype.com/share?url='.$urlencode.'&lang=en' ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_skype_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/skype.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->skype): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->skype); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'yahoo') { ?>
    	<div>
        <a title="<?php echo $this->translate($socialicon->title); ?>"  href="<?php echo 'http://compose.mail.yahoo.com/?body='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_yahoo_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/yahoo.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->yahoo): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->yahoo); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'vk') { ?>
    	<div>
        <a title="<?php echo $this->translate($socialicon->title); ?>"  href="<?php echo 'https://vk.com/share.php?url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_vk_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/vk.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->vk): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->vk); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'whatsapp') { ?>
    	<div class="_whatsappW">
        <a title="<?php echo $this->translate($socialicon->title); ?>"  href="javascript:;" class="ss_whatsapp sessocial_icon_btn sessocial_icon_whatsapp_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/whatsapp.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->whatsapp): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->whatsapp); ?>)</b><?php endif; ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'print') { ?>
    	<div>
        <a onclick="socialshareprint();" title="<?php echo $this->translate($socialicon->title); ?>"  href="javascript:;" class="sessocial_icon_btn sessocial_icon_print_btn">
          <i><img src="application/modules/Sessocialshare/externals/images/social/print.png" /></i>
          <span><?php echo $this->translate($socialicon->title); ?></span>
        </a>
      </div>
    <?php } elseif($socialicon->type == 'email') { ?>
      <?php if($this->subject) { ?>
      	<div>
          <a onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" target="_blank" href="sessocialshare/index/email/resource_id/<?php echo $this->subject->getType() ?>/resource_id/<?php echo $this->subject->getIdentity() ?>" title="<?php echo $this->translate($socialicon->title); ?>"  href="javascript:;" class="sessocial_icon_btn sessocial_icon_email_btn"> 
            <i><img src="application/modules/Sessocialshare/externals/images/social/email.png" /></i>
            <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->email): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->email); ?>)</b><?php endif; ?></span>
          </a>
        </div>
      <?php } else { ?>
      	<div>
          <a onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" onclick="openSmoothBoxInUrl('sessocialshare/index/email/');return false;" title="<?php echo $this->translate($socialicon->title); ?>"  href="javascript:;" class="sessocial_icon_btn sessocial_icon_email_btn"> 
            <i><img src="application/modules/Sessocialshare/externals/images/social/email.png" /></i>
            <span><?php echo $this->translate($socialicon->title); ?><?php if($this->showCount && $this->showminimumnumber < $this->email): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->email); ?>)</b><?php endif; ?></span>
          </a>
        </div>
      <?php } ?>
    <?php } ?>
  <?php endforeach; ?>
    <?php if($this->socialshare_enable_plusicon): ?>
    	<div>	
        <a href="javascript:;" data-url="<?php echo $this->layout()->staticBaseUrl.'sessocialshare/index/index?url='.$urlencode; ?>" title="<?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialshare.more.title', 'More')); ?>"  href="javascript:;" class="sessocial_icon_btn sessocial_icon_more_btn sessmoothbox sessocial_icon_add_btn"> 
        <i><img src="application/modules/Sessocialshare/externals/images/social/more.png" /></i>
        <span><?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialshare.more.title', 'More')); ?><?php if($this->showCount && $this->showminimumnumber < $this->totalCount): ?> <b>(<?php echo $sessocialshareApi->number_format_short($this->totalCount); ?>)</b><?php endif; ?></span>
      </a>
  	</div>
  <?php endif; ?>
  </div>
</div>
