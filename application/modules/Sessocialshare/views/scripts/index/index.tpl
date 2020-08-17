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
  
  $facebokClientId = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.facebook.appid', '');
  $title = '';
  $item = $this->resource; 
  if($item) {
    $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref());
    $title = $item->getTitle();
    $URL = ((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref();
    
    $pinteresturl = 'http://pinterest.com/pin/create/button/?url='.$urlencode.'&media='.urlencode((strpos($item->getPhotoUrl(),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'].$item->getPhotoUrl() ) : $item->getPhotoUrl())).'&description='.$item->getTitle(); 
  } else {
    $urlencode = urlencode($this->url);
    $URL = $this->url;
    
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
  $socialicons = Engine_Api::_()->getDbTable('socialicons', 'sessocialshare')->getSocialInfo(array('enabled' => 1, 'limit' => 20)); 

?>


<script type="application/javascript">

//static search function
function socialSharePlSearch() {

  // Declare variables
  var socialtitlesearch, socialtitlesearchfilter, allsocialshare_lists, allsocialshare_lists_li, allsocialshare_lists_p, i;
  
  socialtitlesearch = document.getElementById('socialtitlesearch');
  socialtitlesearchfilter = socialtitlesearch.value.toUpperCase();
  allsocialshare_lists = document.getElementById("allsocialshare_lists");
  allsocialshare_lists_li = allsocialshare_lists.getElementsByTagName('a');
  
  // Loop through all list items, and hide those who don't match the search query
  for (i = 0; i < allsocialshare_lists_li.length; i++) {
  
    allsocialshare_lists_p = sesJqueryObject(allsocialshare_lists_li[i]).find('.smoothbox_social_name')[0].innerHTML;
    if (allsocialshare_lists_p.toUpperCase().indexOf(socialtitlesearchfilter) > -1) {
        allsocialshare_lists_li[i].style.display = "";
    } else {
        allsocialshare_lists_li[i].style.display = "none";
    }
  }
}

sesJqueryObject(document).on('click','.ss_whatsapp',function(){
  <?php if($item): ?>
    var text = '<?php echo json_encode($item->getTitle()); ?>';
    var url = '<?php echo ((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == "on") ? "https://" : "http://") . $_SERVER["HTTP_HOST"] . $item->getHref(); ?>';
	<?php else: ?>
    var text = '';
    var url = '<?php echo $this->url ?>';
	<?php endif; ?>
	
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

<span class="sessocialshare_smoothbox_overlay" onclick="javascript:sessmoothboxclose();"></span>
<div class="sessocialshare_smoothbox_cont sesbasic_bxs">
	<div class="sessocialshare_smoothbox_header">
    <h3><?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialshare.popsharetitle', 'Share you Content'); ?></h3>
    <p class="sessocialshare_smoothbox_info"><?php if($item) { ?> <b><?php echo $item->getTitle(); ?></b><span><?php echo ((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref(); ?></span><?php } else { ?> <b>sessocialtitleofconent</b><span><?php echo $this->url; ?></span><?php } ?></p>
    <div class="sessocialshare_smoothbox_search">
      <input class="search_bar" type="text" value="" name="" placeholder="Search" id="socialtitlesearch" onkeyup="socialSharePlSearch()" />
      <span class="search_icon"><i class="fa fa-search"></i></span>
    </div>
  </div>
  <div class="sessocialshare_smoothbox_icons_list" id="allsocialshare_lists" onclick="javascript:sessmoothboxclose();">
  <?php foreach($socialicons as $socialicon):  ?>
    <?php if($socialicon->type == 'facebook') { ?>
      <a href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $title; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_facebook_btn">
      	<div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
		      <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/facebook.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
      	</div>
      </a>
    <?php } elseif($socialicon->type == 'twitter') { ?>
      <?php if($item) { ?>
        <a href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '&text=' . htmlspecialchars(urlencode(html_entity_decode($item->getTitle('encode'), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8').'%0a'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title)?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_twitter_btn">
      <?php } else { ?>
        <a href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '&text=%0a'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title)?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_twitter_btn">
      <?php } ?>
      	<div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
          <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/twitter.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
      	</div>
      </a>
    <?php } elseif($socialicon->type == 'pinterest') { ?>
      <?php if($item) { ?>
        <a href="<?php echo $pinteresturl?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_pintrest_btn">
      <?php } else { ?>
        <a href="<?php echo $pinteresturl ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_pintrest_btn">
      <?php } ?>
      	<div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
          <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/pinterest.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
      	</div>
      </a>
    <?php } elseif($socialicon->type == 'googleplus') { ?>
      <a href="<?php echo 'https://plus.google.com/share?url='.$urlencode . '&t=' . $title; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_googleplus_btn">
      	<div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
         	<span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/google-plus.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
      	</div>
      </a>
    <?php } elseif($socialicon->type == 'linkedin') { ?>
      <a href="<?php echo 'https://www.linkedin.com/shareArticle?mini=true&url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_linkedin_btn">      
      	<div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
        	<span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/linkedin.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
      	</div>
      </a>
    <?php } elseif($socialicon->type == 'gmail') { ?>
      <a href="<?php echo 'https://mail.google.com/mail/u/0/?view=cm&fs=1&to&su='.$title.'&body='.$urlencode.'&ui=2&tf=1'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_gmail_btn">
      	<div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
          <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/gmail.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
      	</div>
      </a>
    <?php } elseif($socialicon->type == 'tumblr') { ?>
      <a href="<?php echo 'http://www.tumblr.com/share/link?url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_tumblr_btn">        
        <div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
          <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/tumblr.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
      	</div>
      </a>
    <?php } elseif($socialicon->type == 'digg') { ?>
      <a href="<?php echo 'http://digg.com/submit?phase=2&amp;url='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_digg_btn">
      	<div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
          <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/digg.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
      	</div>
      </a>
    <?php } elseif($socialicon->type == 'stumbleupon') { ?>
      <a href="<?php echo 'http://www.stumbleupon.com/submit?url='.$urlencode.'&title='.$title; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_stumbleupon_btn">
      	<div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
         	<span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/stumbleupon.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
      	</div>
      </a>
    <?php } elseif($socialicon->type == 'myspace') { ?>
      <a href="<?php echo 'http://www.myspace.com/Modules/PostTo/Pages/?t='.$title .'&u='.$urlencode.'&l=3'; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_myspace_btn">    	 
      	<div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
          <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/myspace.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
      	</div>
      </a>
    <?php } elseif($socialicon->type == 'facebookmessager' && $facebokClientId) { ?>
      <a href="<?php echo 'https://www.facebook.com/dialog/send?link='.$urlencode.'&redirect_uri='.$urlencode.'&app_id='.$facebokClientId; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_facebookmessager_btn">
      	<div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
          <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/facebook_messenger.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
      	</div>
      </a>
    <?php } elseif($socialicon->type == 'rediff') { ?>
      <a href="<?php echo 'http://share.rediff.com/bookmark/addbookmark?title='.$title.'&bookmarkurl='.$urlencode; ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_rediff_btn">
      	<div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
          <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/rediff.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
      	</div>
      </a>
    <?php } elseif($socialicon->type == 'googlebookmark') { ?>
      <a href="<?php echo 'https://www.google.com/bookmarks/mark?op=edit&output=popup&bkmk='.$urlencode.'&title='.$title ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_bookmark_btn">
      	<div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
          <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/bookmark.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
      	</div>
      </a>
    <?php } elseif($socialicon->type == 'flipboard') { ?>
      <a href="<?php echo 'https://share.flipboard.com/bookmarklet/popout?v=2&title='.$title.'&url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_flipboard_btn">
      	<div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
          <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/flipboard.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
      	</div>
      </a>
    <?php } elseif($socialicon->type == 'skype') { ?>
      <a href="<?php echo 'https://web.skype.com/share?url='.$urlencode.'&lang=en' ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_skype_btn">
        <div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
          <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/skype.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
        </div>
      </a>
    <?php } elseif($socialicon->type == 'yahoo') { ?>
      <a href="<?php echo 'http://compose.mail.yahoo.com/?body='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_yahoo_btn">
      	<div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
          <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/yahoo.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
      	</div>
      </a>
    <?php } elseif($socialicon->type == 'vk') { ?>
      <a href="<?php echo 'https://vk.com/share.php?url='.$urlencode ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_vk_btn">
      	<div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
          <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/vk.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
      	</div>
      </a>
    <?php } elseif($socialicon->type == 'whatsapp') { ?>
      <a href="javascript:;" class="ss_whatsapp sessocial_icon_btn sessocial_icon_whatsapp_btn">
        <div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
          <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/whatsapp.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
        </div>
      </a>
    <?php } elseif($socialicon->type == 'email') { ?>
      <?php if($item) { ?>
        <a onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')"  class="sessocial_icon_btn sessocial_icon_email_btn" target="_blank" href="sessocialshare/index/email/resource_id/<?php echo $item->getType() ?>/resource_id/<?php echo $item->getIdentity() ?>">
          <div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
            <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/email.png" /></span>
            <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
          </div>
        </a>
      <?php } else { ?>
        <a onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" class="sessocial_icon_btn sessocial_icon_email_btn" target="_blank" href="sessocialshare/index/email/">
          <div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
            <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/email.png" /></span>
            <span class="smoothbox_social_name"><?php echo $this->translate($socialicon->title); ?></span>
          </div>
        </a>
      <?php } ?>
    <?php } elseif($socialicon->type == 'print') { ?>
      <a onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate($socialicon->title); ?>', '<?php echo $urlencode ?>','<?php echo $this->translate($socialicon->type); ?>')" href="javascript:;" class="sessocial_icon_btn sessocial_icon_print_btn" onclick="socialshareprint();">
        <div class="smoothbox_social_icon" title="<?php echo $this->translate($socialicon->title); ?>">
          <span class="smoothbox_social_img"><img src="application/modules/Sessocialshare/externals/images/social/print.png" /></span>
          <span class="smoothbox_social_name"><?php echo $this->translate("Print"); ?></span>
        </div>
      </a>
    <?php } ?>
  <?php endforeach; ?>
  </div>
</div>