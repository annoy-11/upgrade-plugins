<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbrowserpush/externals/styles/styles.css'); ?>
<?php if($this->type == 2) { ?>

<div id="sesbrowserpush_tip" class="sesbrowserpush_tip sesbasic_bxs sesbasic_bg hide_push_popup">
  <div class="sesbrowserpush_tip_inner">
    <div class="sesbrowserpush_tip_icon">
      <?php if(empty($this->logo)) { ?>
      <img src="application/modules/Sesbrowserpush/externals/images/bell-icon.png" alt="" />
      <?php } else { ?>
      <img src="<?php echo Engine_Api::_()->sesbrowserpush()->getFileUrl($this->logo); ?>" alt="" />
      <?php } ?>
    </div>
    <div class="sesbrowserpush_tip_content">
      <div class="sesbrowserpush_tip_title"><?php echo $this->translate($this->title); ?></div>
      <div class="sesbrowserpush_tip_des"><?php echo $this->translate($this->descr); ?></div>
    </div>
    <div class="sesbrowserpush_tip_buttons"> <a href="javascript:void(0);" class="sesbrowserpush_button sesbrowserpush_button_alt sesbrowserpush_hide hide_pushnotnow"><?php echo $this->translate("I'll do this later");?></a> <a href="javascript:void(0);" class="sesbrowserpush_button sesbrowserpush_button_main sesbrowserpush_hide hide_pushallow"><?php echo $this->translate("Allow");?></a> </div>
  </div>
</div>
<?php } else if($this->type == 1  && !empty($this->showbell)){ ?>
<?php //Bell option  ?>
<div id="sesbrowserpush_tip" class="sesbrowserpush_notification_button sesbasic_bxs">
	<a data-active="1" href="javascript:;" id="browserpush_bell" class="sesbasic_pulldown_toggle_browser"><i id="sesbrowsepush_bell_icon"></i></a>
  <p id="subscribe_browertip" class="_tip"><?php echo $this->translate('Click to subscribe.'); ?></p>
  <div id="sesbrowserpush_notification_bubble" class="sesbrowserpush_notification_bubble hide_push_popup">
    <div class="sesbrowserpush_notification_bubble_content">
      <div class="_icon">
        <?php if(empty($this->logo)) { ?>
        <img src="application/modules/Sesbrowserpush/externals/images/notification.png" alt="" />
        <?php } else { ?>
        <img src="<?php echo Engine_Api::_()->sesbrowserpush()->getFileUrl($this->logo); ?>" alt="" />
        <?php } ?>
      </div>
      <div class="_cont">
        <div class="_title"><?php echo $this->translate($this->title); ?></div>
        <div class="_des"><?php echo $this->translate($this->descr); ?></div>
      </div>
    </div>
    <div class="sesbrowserpush_notification_bubble_buttons">
      <div><a href="javascript:void(0);" class="hide_pushnotnow"><?php echo $this->translate("I'll do this later");?></a></div>
      <div><a href="javascript:void(0);" class="hide_pushallow"><?php echo $this->translate("Allow");?></a></div>
    </div>
  </div>
  
  <div id="sesbrowserpush_notification_bubble_unsubscribe" class="sesbrowserpush_notification_bubble _unsubscribe" style="display:none;">
    <div class="sesbrowserpush_notification_bubble_content">
      <div class="_icon">
        <?php if(empty($this->logo)) { ?>
        <img src="application/modules/Sesbrowserpush/externals/images/notification-off.png" alt="" />
        <?php } else { ?>
        <img src="<?php echo Engine_Api::_()->sesbrowserpush()->getFileUrl($this->logo); ?>" alt="" />
        <?php } ?>
      </div>
      <div class="_cont">
        <div class="_title"><?php echo $this->translate("Are you sure you want to unsubscribe?"); ?></div>
        <div class="_des"><?php echo $this->translate("Go to your browser’s Notification setting and configure it according to your choice."); ?></div>
      </div>
    </div>
    <div class="sesbrowserpush_notification_bubble_buttons">
      <div><a href="javascript:void(0);" id="unsubscribe_popup_close" onclick="unsubscribeNotification();"><?php echo $this->translate("Okay");?></a></div>
    </div>
  </div>
  
</div>
<?php } else if($this->type == 3) { ?>
<div id="sesbrowserpush_tip" class="sesbrowserpush_notification_popup_wrapper sesbasic_bxs  hide_push_popup">
<div class="sesbrowserpush_notification_popup_overlay sesbrowserpush_hide_popup"></div>
<?php if(empty($this->logo)) { ?>
<div class="sesbrowserpush_notification_popup sesbasic_bg" style="background-image:url(application/modules/Sesbrowserpush/externals/images/popup-bg.jpg);height:<?php echo $this->height; ?>px;width:<?php echo $this->width; ?>px;">
  <?php } else { ?>
  <div class="sesbrowserpush_notification_popup sesbasic_bg" style="background-image:url(<?php echo Engine_Api::_()->sesbrowserpush()->getFileUrl($this->logo); ?>);height:<?php echo $this->height; ?>px;width:<?php echo $this->width; ?>px;">
    <?php } ?>
    <section> <a href="javascript:void(0);" class="sesbrowserpush_notification_popup_close sesbrowserpush_hide_popup hide_pushnotnow"></a>
      <div class="sesbrowserpush_notification_popup_content">
        <div class="_title"><?php echo $this->translate($this->title); ?></div>
        <div class="_des"><?php echo $this->translate($this->descr); ?></div>
      </div>
      <div class="sesbrowserpush_notification_popup_button"> <a href="javascript:void(0);" class="sesbrowserpush_hide_popup  hide_pushnotnow"><?php echo $this->translate("I'll do this later");?></a> <a href="javascript:void(0);" class="sesbrowserpush_hide_popup hide_pushallow"><?php echo $this->translate("Allow");?></a> </div>
    </section>
  </div>
</div>
<?php } ?>
<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbrowserpush.percontainer',1)) { ?>
<div id="sesbrowsepush_browser_permission_container" class="sesbrowsepush_browser_permission_container">
  <div id="sesbrowsepush_browser_permission_box" class="sesbrowsepush_browser_permission_box" style="display:none;"> <i></i>
    <?php  $web_title = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.site.title', 'My Community');
    $des = $this->translate('Always receive notifications to stay updated on new posts & activities on your content and account on ').$web_title.'.'; ?>
    <span><?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbrowserpush.textpercontai', $des)); ?></span> </div>
</div>
<?php } ?>

<script type="text/javascript">
// cookie get and set function
function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var browserpushnoti = "browserpushnoti="+d.toGMTString();
	document.cookie = cname + "=" + cvalue + "; " + browserpushnoti;
} 

function getCookieBrowserPush(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1);
    if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
	}
	return "";
}

function unsubscribeNotification() {
  //Notification.close();
  sesJqueryObject('#sesbrowserpush_notification_bubble_unsubscribe').hide();
  if(sesJqueryObject ('#sesbrowserpush_tip').hasClass('showpulldown')) {
    sesJqueryObject('#sesbrowserpush_tip').removeClass('showpulldown');
  }
}

var browserDays = '<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbrowserpush.days', 5); ?>';
sesJqueryObject (document).ready(function(){
  sesJqueryObject ('.hide_pushnotnow').click(function(){
    if(browserDays > 0) {
      setCookie("browser_ispopup",'browserpopo', browserDays);
    }
    sesJqueryObject ('.hide_push_popup').hide();
    if(sesJqueryObject ('#sesbrowserpush_tip').hasClass('showpulldown')) {
        sesJqueryObject('#sesbrowserpush_tip').removeClass('showpulldown');
    }
  });
});

sesJqueryObject (document).ready(function(){
  sesJqueryObject ('.hide_pushallow').click(function(){
    requestPermission();
    sesJqueryObject ('.hide_push_popup').hide();
  });
});

sesJqueryObject (document).ready(function(){
  
  var permission = Notification.permission;
  var dataActive = sesJqueryObject('#browserpush_bell').attr('data-active');
  sesJqueryObject ('.sesbasic_pulldown_toggle_browser').click(function() {
    if(permission != 'granted' && sesJqueryObject('#browserpush_bell').attr('data-active') == 1) { 
      if(sesJqueryObject ('#sesbrowserpush_tip').hasClass('showpulldown')) {
        sesJqueryObject('#sesbrowserpush_tip').removeClass('showpulldown');
        sesJqueryObject ('.hide_push_popup').hide();
        //sesJqueryObject('#subscribe_browertip').show();
      } else {
        sesJqueryObject('#sesbrowserpush_tip').addClass('showpulldown');
        sesJqueryObject ('.hide_push_popup').show();
        //sesJqueryObject('#subscribe_browertip').hide();
      }
    } else {
      if(sesJqueryObject ('#sesbrowserpush_tip').hasClass('showpulldown')) {
        sesJqueryObject('#sesbrowserpush_tip').removeClass('showpulldown');
        sesJqueryObject ('#sesbrowserpush_notification_bubble').hide();
        sesJqueryObject('#sesbrowserpush_notification_bubble_unsubscribe').hide();
      } else {
        sesJqueryObject('#sesbrowserpush_tip').addClass('showpulldown');
        sesJqueryObject ('#sesbrowserpush_notification_bubble').hide();
        sesJqueryObject('#sesbrowserpush_notification_bubble_unsubscribe').show();
      }
    }
  });
  
  sesJqueryObject ('#sesbrowsepush_browser_permission_container').click(function() {
    sesJqueryObject('#sesbrowsepush_browser_permission_container').hide();
  });
});

window.addEvent('domready', function() {
  $(document.body).addEvent('click', function(event){
    if(event.target.id != 'sesbrowserpush_notification_bubble' && event.target.id != 'browserpush_bell' && event.target.id != 'sesbrowsepush_bell_icon' && event.target.id != 'unsubscribe_popup_close') {
      sesJqueryObject('#sesbrowserpush_notification_bubble').hide();
      sesJqueryObject('#sesbrowserpush_tip').removeClass('showpulldown');
      if(sesJqueryObject('#sesbrowserpush_notification_bubble_unsubscribe'))
        sesJqueryObject('#sesbrowserpush_notification_bubble_unsubscribe').hide();
    }
  });
});
</script>
