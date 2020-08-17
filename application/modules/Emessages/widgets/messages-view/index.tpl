<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

?>
<?php
$settings = Engine_Api::_()->getApi('settings', 'core');
$user_level = Engine_Api::_()->user()->getViewer()->level_id;
$gify_key = $settings->getSetting('emes.gifkey', '');
$gify_limit=10;
$gify_lan='en';
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');

$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Emessages/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>


<link href="<?php echo $base_url; ?>application/modules/Emessages/externals/styles/magnific-popup.css" rel="stylesheet" />
<script src="<?php echo $base_url; ?>application/modules/Emessages/externals/scripts/jquery.magnific-popup.js"></script>
<?php
$this->headScript()
	->appendFile($this->layout()->staticBaseUrl . 'externals/mdetect/mdetect' . ( APPLICATION_ENV != 'development' ? '.min' : '' ) . '.js')
	->appendFile($this->layout()->staticBaseUrl . 'application/modules/Emessages/externals/scripts/composer.js');
?>
<div class="emessages-container">
  <div class="msg-users-panel">
  	<header class="sesbasic_clearfix">
    	<span class="title">Messages</span>
      <span class="new-btn"><a href="javascript:void(0);" title="<?php echo $this->translate('New Message');  ?>" onclick="addnewuser();" class="p-relative" data-toggle="tooltip" data-placement="top" data-original-title="Create New Message"><i><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
  viewBox="0 0 42 42" style="enable-background:new 0 0 42 42;" xml:space="preserve"><polygon points="42,19 23,19 23,0 19,0 19,19 0,19 0,23 19,23 19,42 23,42 23,23 42,23 "/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></i></a></span>
    </header>
    <?php if (isset($this->allusers) && count($this->allusers) > 0) { ?>
    	<div class="msg-search">
      	<div class="msg-search-input">
        	<span class="input-text"><input type="text" id="emessages_search_username" class="form-control" placeholder="Search Name Or Message"></span>
          <span class="input-icon"><i class="fas fa-search"></i></span>
        </div>
      </div>
			<?php } ?>
      <div class="msg-users-list sesbasic_custom_scroll">
        <ul id="appenduserlist">
          <?php if (isset($this->allusers) && count($this->allusers) > 0) {
            foreach ($this->allusers as $allusers) {
              if (isset($allusers['user_id2']) && !empty($allusers['user_id2']) && isset($allusers['type']) && trim($allusers['type']) == 1) {
                $user = Engine_Api::_()->getItem('user', $allusers['user_id2']);
                if (isset($user) && !empty($user)) { ?>
                  <?php  $lastlogin=Engine_Api::_()->emessages()->userlastlogin($allusers['user_id2']);
                         $is_online_class=Engine_Api::_()->emessages()->onlineclass($allusers['user_id2']);
                  ?>
                  <li class="listofusers clearfix" username="<?php echo $user->getTitle().''.$lastlogin; ?>" type="<?php echo $allusers['type']; ?>" id="chatuser_id_<?php echo $allusers['userlist_id']; ?>" onclick="changeusername('<?php echo $user->getTitle()." <b>".$lastlogin; ?></b>');displayusermessages(<?php echo $allusers['userlist_id']; ?>,1,1);">
                    <div class="item-photo">
                       <?php echo $this->itemPhoto($user, 'thumb.icon', $user->getTitle()); ?>
                       <?php echo $is_online_class; ?>
                    </div>
                    <div class="item-content">
                      <div class="item-title clearfix">
                        <span class="time sesbasic_text_light fsmall"
                              id="userdate_<?php echo $allusers['userlist_id']; ?>"><?php if (isset($allusers['modified_date']) && !empty($allusers['modified_date'])) {
                            echo Engine_Api::_()->emessages()->TimeAgo($allusers['modified_date'], false);
                          } ?></span>
                        <h6><?php if (!empty($user->getTitle())) {
                            echo $user->getTitle();
                          } ?>
                        </h6>
                      </div>
                      <p class="messages-body fsmall" id="userdescription_<?php echo $allusers['userlist_id']; ?>">
                        <?php if (isset($allusers['description']) && !empty($allusers['description'])) {
                          echo strlen($allusers['description']) > 30 ? substr($allusers['description'], 0, 30) . " ..." : $allusers['description'];
                        } ?>
                      </p>
                    </div>
                  </li>
                <?php }
              }
              else if (isset($allusers['type']) && trim($allusers['type']) == 2)
              {
              	echo Engine_Api::_()->emessages()->groupHtmlCode($allusers['userlist_id'],$allusers['group_id']);
              }
            }
          } ?>
        </ul>
      </div>
    </div>
    <div class="msg-chat-container">
      <header id="messagesheader">
        <div class="option-btn option-btn-left"><a onclick="displayonlyusers();" href="javascript:void(0);"><i class=""><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><g><polygon points="512,236.011 76.526,236.011 248.43,64.106 220.162,35.838 0,256 220.162,476.162 248.43,447.894 76.526,275.989 512,275.989"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></i></a></div>
        <div class="name centerT"><span id="displayhereselectuser"></span></div>
        <div class="option-btn-right">
        	<div class="option-btn option-btn-search"><a class="showhide-message-search-toggle" href="javascript:void(0);"><i class="fas fa-search sesbasic_text_light"></i></a></div>
          <div class="option-btn option-btn-info"><a class="showhide-info-panel-toggle" href="javascript:void(0);"><i class="sesbasic_text_hl fa fa-info-circle"></i></a></div>
        </div>
        <div class="msg-conv-search sesbasic_bg">
        	<input type="text" onkeyup="searchcall();" id="search_single_message" placeholder='<?php echo $this->translate("Search messages in current conversation")?>'>
        </div>
      </header>
      <header id="addheader" style="display: none;">
				<div class="option-btn option-btn-left"><a onclick="displayonlyusers();" href="javascript:void(0);">
        	<i><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><g><polygon points="512,236.011 76.526,236.011 248.43,64.106 220.162,35.838 0,256 220.162,476.162 248.43,447.894 76.526,275.989 512,275.989"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></i></a>
        </div>
        <div class="addusers">
          <div id="toValues-wrapper1" class="form-wrapper">
            <div id="toValues-label" class="form-label">
              <label for="toValues" class="required">To</label>
            </div>
            <div id="toValues-element" class="form-element">
              <input type="hidden" name="toValues" value="" id="toValues">
            </div>
          </div>
          <div class="field" id="addusertypefield_username">
            <input name="adduser" id="adduser" type="text" placeholder='<?php echo $this->translate("Type the name of a person...")?>'/>
          </div>
        </div>
      </header>
      <div class="msg-list-chat-empty" id="welcomeimgdisplay">
      	<img src="application/modules/Emessages/externals/images/chat-img.svg"><span><?php echo $this->translate("Choose one of your friends And Say Hello !");?></span>
      </div>
      <div class="msg-list-container sesbasic_custom_scroll_1" id="msg_scrolleradd">
        <ul id="messageslist"></ul>
      </div>
      <form enctype="multipart/form-data" action="javascript:void(0);" id="chatmessages_form">
        <div id="toValues-wrapper" class="msg-composer">
          <div class="msg-composer-inner">
            <div class="field">
              <textarea name="chatmessages" id="activity_body" placeholder='<?php echo $this->translate("Type a messages..."); ?>'></textarea>
            </div>
            <div class="composer-box-option">
              <div class="composer-box-option-item composer-box-option-emoji">
                <a href="javascript:void(0);" onclick="sesJqueryObject('#emessages_gif').hide();sesJqueryObject('#emessages_emoji').toggle();" class="composer-box-option-item-btn" title="<?php echo $this->translate('Insert an emoji');  ?>">
                  <i><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><path id="path-1" d="m1.80474.390524c.390524.390524.390524 1.02369 0 1.41421-.390524.390524-1.02369.390524-1.41421 0-.390524-.390524-.390524-1.02369 0-1.41421.390524-.390524 1.02369-.390524 1.41421 0"/></defs><use transform="translate(3.902 4.902)" xlink:href="#path-1"/><use transform="translate(9.902 4.902)" xlink:href="#path-1"/><path d="m8 0c-4.41113 0-8 3.58887-8 8s3.58887 8 8 8 8-3.58887 8-8-3.58887-8-8-8zm0 15c-3.85986 0-7-3.14014-7-7s3.14014-7 7-7 7 3.14014 7 7-3.14014 7-7 7z"/><path d="m3.5 3c1.93298 0 3.5-1.34314 3.5-3h-7c0 1.65686 1.56702 3 3.5 3z" transform="translate(4.5 9)"/></svg></i>
                </a>
                <div class="emessages_emoji_container" id="emessages_emoji">
                  <div class="emessages_emoji_content">
                    <ul class="emessages_emojilist">
                      <?php $emoticonsTag = Engine_Api::_()->activity()->getEmoticons();
                      foreach ($emoticonsTag as $key => $icon) { ?>
                          <li>
                            <a href="javascript:void(0);" onclick="addEmoticonIcon('<?php echo $key; ?>')">
                          <?php echo "<img src=\"" . $this->layout()->staticBaseUrl . "application/modules/Activity/externals/emoticons/images/$icon\" border=\"0\"/>"; ?>
                              </a>
                          </li>
                      <?php } ?>
                    </ul>
                  </div>
                <span class="arrowd"></span>
              </div>
            </div>
            	<div class="composer-box-option-item composer-box-option-item-gif" id="composer-box-option">
			    <?php if(isset($gify_key) && !empty($gify_key) && Engine_Api::_()->authorization()->getPermission($user_level, 'emessages', 'gifyview')==1) { ?>
                <a href="javascript:void(0);" id="displaygif" class="composer-box-option-item-btn" title="<?php echo $this->translate('Post a GIF');  ?>">
                <i><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><g><g><path d="M146.286,146.286H36.571C14.629,146.286,0,164.571,0,182.857v146.286c0,18.286,14.629,36.571,36.571,36.571h109.714 c21.943,0,36.571-18.286,36.571-36.571V256H128v54.857H54.857V201.143h128v-18.286 C182.857,164.571,168.229,146.286,146.286,146.286z"/><polygon points="512,201.143 512,146.286 347.429,146.286 347.429,365.714 402.286,365.714 402.286,292.571 475.429,292.571 475.429,237.714 402.286,237.714 402.286,201.143 "/><rect x="237.714" y="146.286" width="54.857" height="219.429"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></i>
              	</a>
				 <?php  } ?>
                <div class="emessages_emoji_container" id="emessages_gif">
                  <div class="emessages_emoji_container_search">
                    <div class="emessages_emoji_container_search_field">
                      <input type="text" id="emessages_gif_search" onkeyup="displaygiflist(this.value);" placeholder='<?php echo $this->translate("Search")?>' />
                      <i class="fas fa-search"></i>
                    </div>
                  </div>
                  <div class="emessages_emoji_content">
                    <ul class="emessages_giflist" id="gify_append"></ul>
                  </div>
                  <span class="arrowd"></span>
                </div>
            	</div>
          </div>
            <div class="send-btn">
            	<button type="submit" title="<?php echo $this->translate('Send'); ?>" id="submit"><i class="fa fa-paper-plane"></i></button>
            </div>
          </div>
          <div class="composer-box-attachment" id="emessages-compose-tray"></div>
        </div>
      </form>
			<script type="text/javascript">
          //<![CDATA[
          var composeInstance;
          en4.core.runonce.add(function() {
              var tel = new Element('div', {
                  'id' : 'compose-tray',
                  'styles' : {
                      'display' : 'none'
                  }
              }).inject($('emessages-compose-tray'), 'after');

              var mel = new Element('div', {
                  'id' : 'compose-menu'
              }).inject($('composer-box-option'), 'after');
              // @todo integrate this into the composer
              if( !Browser.Engine.presto && !Browser.Engine.trident && !DetectMobileQuick() && !DetectIpad() ) {
                  composeInstance = new Composer('activity_body', {
                      overText : false,
                      menuElement : mel,
                      trayElement: tel,
                      baseHref : '<?php echo $this->baseUrl(); ?>',
                      hideSubmitOnBlur : false,
                      allowEmptyWithAttachment : false,
                      submitElement: 'submit',
                      type: 'message'
                  });
              }
          });
      </script>
	</div>
	<div class="msg-userinfo-panel">
    <header>
    	<div class="msg-userinfo-panel-header-option">
      	<a href="javascript:void(0);" class="showhide-info-panel-toggle"><i class=""><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><g><polygon points="512,236.011 76.526,236.011 248.43,64.106 220.162,35.838 0,256 220.162,476.162 248.43,447.894 76.526,275.989 512,275.989"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></i></a>
    </div>
    </header>
    <div class="msg-userinfo-panel-inner sesbasic_custom_scroll_2" id="userpanelinfo">
      <input type="hidden" id="getpagenoforsocialmedia">
      <div class="member-info centerT">
      	<div class="member-photo centerT" id="sharemedia_profile_image">
        </div>
        <div class="member-name centerT"><span id="sharemedia_profile_username"></span></div>
      </div>
      <div class="msg-userinfo-links">
      	<ul id="sharemedia_profile_button"></ul>
      </div>
      <div class="msg-userinfo-members" style="display: none;" id="alluserlistdisplayhere">
      	<p class="_head"><?php echo $this->translate("Members"); ?></p>
        <ul id="group_member_list"></ul>
      </div>
      <div class="msg-userinfo-media">
        <p class="_head" id="sharemedia_profile_text_display"><?php echo $this->translate("Shared Media"); ?></p>
        <div id="sharemedia_profile_images_share"></div>
    	</div>
    </div>
	</div>
  <div class="emessages-container-overlay showhide-info-panel-toggle"></div>
</div>
<!-- All code for gif  start -->
<script type="application/javascript">

    var selecteduserid = 0;
    var old_page_id = 0;
    var total_pages = 0;
    var type = 1;

    function searchcall()
    {
        displayusermessages(selecteduserid, 1, type);
    }
    sesJqueryObject("#emessages_search_username").keyup(function () {
        var text = sesJqueryObject("#emessages_search_username").val();
        if (text.length > 0) {
            text = text.toLowerCase();
            sesJqueryObject(".listofusers").each(function () {
                var li_text = sesJqueryObject(this).attr('username');
                li_text = li_text.toLowerCase();
                if (parseInt(li_text.search(text)) >= 0) {
                    sesJqueryObject(this).show();
                } else {
                    sesJqueryObject(this).hide();
                }
            });

            sesJqueryObject.ajax({
                'url': en4.core.baseUrl + 'emessages/messages/getidforsearch',
                method: "POST",
                data: {text: sesJqueryObject("#emessages_search_username").val()},
                success: function (html)
                {
                    var arrays = jQuery.parseJSON(html);
                    if(parseInt(arrays['length'])>0)
                    {
                        for(var i=0; i<arrays['length']; i++)
                        {
                            sesJqueryObject("#chatuser_id_"+arrays[i]).show();
                        }
                    }
                }
            });


        } else {
            sesJqueryObject(".listofusers").show();
        }
    });

    function addEmoticonIcon(iconCode) {
        var content = htmlunescape(composeInstance.getContent());
        content = content.replace(/&nbsp;/g, ' ');
        if( !('useContentEditable' in composeInstance.options && composeInstance.options.useContentEditable )) {
            composeInstance.setContent(content + ' ' + iconCode);
            return;
        }
        var textBeforeCaret = content.substr(0, composeInstance.lastCaretPos);
        var textAfterCaret = content.substr(composeInstance.lastCaretPos);
        iconCode = ' ' + iconCode + ' ';
        composeInstance.setContent(textBeforeCaret + iconCode + textAfterCaret);
        composeInstance.setCaretPos(textBeforeCaret.length + iconCode.length);
        if ( composeInstance.getContent() !== '' ) {
            (function() {
                composeInstance.getMenu().setStyle('display', '');
            }).delay(300);
        }
    }

    function htmlunescape(content) {
        var doc = new DOMParser().parseFromString(content, "text/html");
        return doc.documentElement.textContent;
    }


    function displaygifseach() {
        sesJqueryObject("#gify_append").empty();
        sesJqueryObject("#emessages_gif_search").val('');
        sesJqueryObject.ajax({
            url: 'https://api.giphy.com/v1/gifs/trending?api_key=<?php echo $gify_key; ?>&limit=<?php echo $gify_limit; ?>&rating=G',
            method: "GET",
            enctype: 'multipart/form-data',
            data: {},
            success: function (html) {
                if (html['data'].length > 1) {
                    sesJqueryObject("#gify_append").empty();
                    for (var i = 0; i < html['data'].length; i++) {
                        if (typeof (html['data'][i]['images']['downsized']['url']) != "undefined" && (html['data'][i]['images']['downsized']['url']) != null)
                            sesJqueryObject("#gify_append").append('<li><a onclick="submitgif(\'' + html['data'][i]['images']['downsized']['url'] + '\')" href="javascript:void(0);"><span class="_img"><img src="' +html['data'][i]['images']['downsized']['url'] + '" alt=""></span></a></li>');
                    }

                }
            }
        });
    }
    function displaygiflist(text) {
        if(text.length<=0){ displaygifseach(); return false;  }
        sesJqueryObject.ajax({
            url: 'https://api.giphy.com/v1/gifs/search?api_key=<?php echo $gify_key; ?>&q='+text+'&limit=<?php echo $gify_limit; ?>&offset=0&rating=G&lang=en',
            method: "GET",
            enctype: 'multipart/form-data',
            data: {},
            success: function (html) {
                if (html['data'].length > 1) {
                    sesJqueryObject("#gify_append").empty();
                    for (var i = 0; i < html['data'].length; i++) {
                        if (typeof (html['data'][i]['images']['downsized']['url']) != "undefined" && (html['data'][i]['images']['downsized']['url']) != null)
                            sesJqueryObject("#gify_append").append('<li><a onclick="submitgif(\'' + html['data'][i]['images']['downsized']['url'] + '\')" href="javascript:void(0);"><span class="_img"><img src="' +html['data'][i]['images']['downsized']['url'] + '" alt=""></span></a></li>');
                    }

                }
            }
        });
    }


    sesJqueryObject("#displaygif").click(function () {
        sesJqueryObject('#emessages_emoji').hide();
        sesJqueryObject("#emessages_gif").toggle();
        if (sesJqueryObject("#emessages_gif").is(":hidden")) {
            displaygifseach();
        }
    });

    function submitgif(img_url) {
        sesJqueryObject("#activity_body").val(img_url);
        sesJqueryObject("#chatmessages_form").submit();
    }

</script>

<!-- All code for gif  end -->
<script type="application/javascript">

    // chat form submit
    sesJqueryObject("#chatmessages_form").submit(function () {
        var messages = sesJqueryObject("textarea:input[name=chatmessages]").val();
        var newuserid = sesJqueryObject("#toValues").val();
        sesJqueryObject("#emessages_gif").hide();
        sesJqueryObject("#activity_body").val('');
        var newuserid = sesJqueryObject("#toValues").val();
        if(parseInt(newuserid.length)>0){
            sesJqueryObject("#chatmessages_form").hide();
        }
        sesJqueryObject.ajax({
            url: en4.core.baseUrl + 'emessages/messages/setmessages?formdata='+sesJqueryObject("#chatmessages_form").serialize(),
            method: "POST",
            enctype: 'multipart/form-data',
            data: {chatuser_id: selecteduserid, messages: messages, type: type, newuserid: newuserid,},
            success: function (html) {
            var arrays = jQuery.parseJSON(html);
            if(parseInt(arrays['newuser_status'])==1)
            {
              window.history.pushState('messages', 'view', "messages/view/id/"+arrays['newuser_id'])+"?type=1";
              location.reload();
              return  false;
            }
            sesJqueryObject('#emessages_emoji').hide();
            sesJqueryObject(".compose-content").text('');
          sesJqueryObject("#finalcomposerclose").trigger("change");
          sesJqueryObject("#compose-video-body").empty();
          sesJqueryObject("#compose-music-body").empty();
          sesJqueryObject("#compose-photo-body").empty();
            sesJqueryObject("#submit").show();
            sesJqueryObject("input[type=hidden]").each(function () {
                var names=sesJqueryObject(this).attr('name');
                if (typeof names != "undefined") {
                    names = names.toLowerCase();
                    li_text = 'attachment';
                    if (parseInt(names.search(li_text)) >= 0) {
                        sesJqueryObject(this).remove();
                    }
                }
            });
            sesJqueryObject(".compose-activator").each(function () {
              sesJqueryObject(this).show();
            });
            if (arrays['status'] == 1 && arrays['user_id']!=0 && parseInt(selecteduserid) ==parseInt(arrays['user_id']))
            {
                selecteduserid = arrays['user_id'];
                sesJqueryObject("#emessages_gif").hide();
                sesJqueryObject("textarea:input[name=chatmessages]").val('');
                sesJqueryObject("#emessages-compose-tray").empty();
                sesJqueryObject("#messageslist").append(arrays['content']);
                jqueryObjectOfSes(".sesbasic_custom_scroll_1").mCustomScrollbar('scrollTo', 'last');
                sesJqueryObject("#userdescription_" + arrays['user_id']).html(arrays['user_des']);
                sesJqueryObject("#userdate_" + arrays['user_id']).text(arrays['user_date']);
                var htmltext = sesJqueryObject('#chatuser_id_' + arrays['user_id'] + '[type*=' + type + ']').html();
                var usernames = sesJqueryObject('#chatuser_id_' + arrays['user_id'] + '[type*=' + type + ']').attr('username');
                sesJqueryObject('#chatuser_id_' + arrays['user_id'] + '[type*=' + type + ']').remove();
                sesJqueryObject("#appenduserlist").prepend('<li class="listofusers clearfix selected" type="' + type + '"  username="' + usernames + '" id="chatuser_id_' + selecteduserid + '" onclick="changeusername(\'' + usernames + '\');displayusermessages(' + arrays['user_id'] + ',1,type)">' + htmltext + '</li>');
                return false;
            }
        }
    });
    });

</script>



<!-- All code for right side bar start-->
<script type="application/javascript">
    // Here we display messages

    function displayusermessages(chatuser_id, page_id, types)
    {
        type = types;
        if(parseInt(sesJqueryObject(window).width())<768)
        {
            sesJqueryObject(".msg-users-panel").addClass('_hide');
            sesJqueryObject(".msg-chat-container").removeClass('_hide');
        }
        sesJqueryObject("#addheader").hide();
        sesJqueryObject("#welcomeimgdisplay").hide();
        sesJqueryObject("#addusertypefield_username").hide();
        sesJqueryObject("#chatmessages_form").show();
        sesJqueryObject("#messagesheader").show();
        sesJqueryObject("#messageslist").show();
        sesJqueryObject('#userpanelinfo').show();
        sesJqueryObject(".listofusers").removeClass('selected');
        sesJqueryObject("#chatuser_id_" + chatuser_id + '[type*=' + type + ']').addClass('selected');
        sesJqueryObject("#chatuser_id_" + chatuser_id + '[type*=' + type + ']').removeClass('unread_message');
        selecteduserid = chatuser_id;
        old_page_id = page_id;
        if (page_id == 1) {
            if(type==1)
            {
                window.history.pushState('messages', 'view', "messages/view/id/"+chatuser_id+"?type=view");
            }
            else
            {
                window.history.pushState('messages', 'view', "messages/view/id/g."+chatuser_id+"?type=view");
            }

            sesJqueryObject("#messageslist").empty();
        }
        sesJqueryObject.ajax({
            'url': en4.core.baseUrl + 'emessages/messages/getmessages',
            method: "POST",
            data: {chatuser_id: chatuser_id, page_id: page_id, type: type, searchtext: sesJqueryObject("#search_single_message").val(),},
            success: function (html) {
                if(parseInt(page_id)==1) {  sesJqueryObject("#messageslist").empty();   }
                var arrays = jQuery.parseJSON(html);
                total_pages = parseInt(arrays['total_pages']);
                if(parseInt(arrays['chat_id']) == parseInt(chatuser_id))
                {
                    sesJqueryObject("#messageslist").prepend(arrays['content']);
                    if (arrays['userstatus'] != 1) {
                        sesJqueryObject(".msg-composer").hide();
                    } else {
                        sesJqueryObject(".msg-composer").show();
                    }
                    if (page_id == 1) {
                        jqueryObjectOfSes("#msg_scrolleradd").mCustomScrollbar('scrollTo', 'last');
                        allsharedmedia(chatuser_id, type);
                    }
                }
            }

        });
    }



    function allsharedmedia(chatuser_id, type) {
        sesJqueryObject("#group_member_list").empty();
        sesJqueryObject("#alluserlistdisplayhere").hide();
        sesJqueryObject("#getpagenoforsocialmedia").val(1);
        sesJqueryObject("#sharemedia_profile_images_share").empty();
        sesJqueryObject("#sharemedia_profile_button").empty();
        sesJqueryObject("#sharemedia_profile_image").empty();
        sesJqueryObject("#sharemedia_profile_username").empty();
        sesJqueryObject.ajax({
            url: en4.core.baseUrl + 'emessages/messages/allsharemedia',
            method: "POST",
            enctype: 'multipart/form-data',
            data: {chatuser_id: chatuser_id, type: type,},
            success: function (html) {
                var arrays = jQuery.parseJSON(html);
                if (arrays['status'] == 1) {
                    sesJqueryObject("#sharemedia_profile_text_display").hide();
                    if(parseInt(arrays['content'].length)>0)
                    {
                        sesJqueryObject("#sharemedia_profile_text_display").show();
                    }
                    sesJqueryObject("#sharemedia_profile_images_share").empty();
                    sesJqueryObject("#sharemedia_profile_button").empty();
                    sesJqueryObject("#sharemedia_profile_image").empty();
                    sesJqueryObject("#sharemedia_profile_username").empty();

                    sesJqueryObject("#sharemedia_profile_images_share").append(arrays['content']);
                    sesJqueryObject("#sharemedia_profile_button").append(arrays['buttontext']);
                    sesJqueryObject("#sharemedia_profile_image").append(arrays['profileimage']);
                    sesJqueryObject("#sharemedia_profile_username").append(arrays['username']);
                    if (parseInt(type) == 1) {
                        sesJqueryObject("#alluserlistdisplayhere").hide();
                    } else {
                        sesJqueryObject("#alluserlistdisplayhere").show();
                        sesJqueryObject("#group_member_list").empty();
                        sesJqueryObject("#group_member_list").append(arrays['allmemberlist']);
                        sesJqueryObject(".changegroupname").children('a').addClass('sessmoothbox');
                        sesJqueryObject(".addmemberforgroup").children('a').addClass('opensmoothboxurl');
                    }
                }
            }
        });
    }

    function removeUserFromGroup(conversation_id, user_id) {
        if (confirm('Are you sure? Do you want to remove this user from group')) {
            sesJqueryObject.ajax({
                url: en4.core.baseUrl + 'emessages/messages/deleteuserfromgroup',
                method: "POST",
                enctype: 'multipart/form-data',
                data: {conversation_id: conversation_id, user_id: user_id,},
                success: function (html) {
                    var arrays = jQuery.parseJSON(html);
                    if (arrays['status'] == 1) {
                        sesJqueryObject("#userlist_forsocialmedia_" + user_id).remove();
                    }
                }
            });
        }
    }


    function updateShareMediaImage(selecteduser_id, type) {
        var page_id = sesJqueryObject("#getpagenoforsocialmedia").val();
        sesJqueryObject("#getpagenoforsocialmedia").val((parseInt(page_id) + 1));
        sesJqueryObject.ajax({
            url: en4.core.baseUrl + 'emessages/messages/sharemediaupdate',
            method: "POST",
            enctype: 'multipart/form-data',
            data: {chatuser_id: selecteduser_id, type: type, page_id: (page_id+1)},
            success: function (html) {
                var arrays = jQuery.parseJSON(html);
                if (arrays['status'] == 1) {
                    sesJqueryObject("#sharemedia_profile_images_share").append(arrays['content']);
                }
            }
        });
    }

</script>
<!-- All code for right side bar end-->

<!-- All code for chat user start-->
<script type="application/javascript">
    window.addEvent("load",function(){ 
      sesJqueryObject("#chatuser_id_<?php echo str_replace("g.","",$this->id); ?>").trigger("click");
    });
    // For adding new user
    function addnewuser() {
        selecteduserid = 0;
        if(parseInt(sesJqueryObject(window).width())<768)
        {
            sesJqueryObject('.msg-chat-container').removeClass('_hide');
            sesJqueryObject(".msg-users-panel").addClass('_hide');
        }
        window.history.pushState('messages', 'view', "messages/compose");
        sesJqueryObject("#addheader").show();
        sesJqueryObject("#welcomeimgdisplay").show();
        sesJqueryObject("#addusertypefield_username").show();
        sesJqueryObject("#messagesheader").hide();
        sesJqueryObject("#messageslist").hide();
        sesJqueryObject('#userpanelinfo').hide();
        sesJqueryObject(".listofusers").removeClass('selected');
        sesJqueryObject("#chatmessages_form").hide();
    }


    sesJqueryObject(document).ready(function (){
			// Info Panel Show/Hide
			sesJqueryObject(".showhide-info-panel-toggle").click(function(){
				sesJqueryObject(".msg-userinfo-panel").toggleClass("show-info-panel");
				sesJqueryObject(".emessages-container-overlay").toggleClass("show-overlay");
			});

			// Messages Search Box
			sesJqueryObject(".showhide-message-search-toggle").click(function(){
				sesJqueryObject(".msg-conv-search").toggleClass("show-message-search");
				sesJqueryObject("#search_single_message").val('');
                searchcall();
			});
	    sesJqueryObject("#addusertypefield_username").children(".overTxtLabel").remove();

	    var forremoveduplicate=[];
	    sesJqueryObject("#compose-menu").children('.compose-activator').each(function () {
            var id=sesJqueryObject(this).attr('id');
            if(forremoveduplicate.indexOf(id) == -1)
            {
                forremoveduplicate.push(id);
            }
            else
            {
                sesJqueryObject(this).remove();
            }

        });
        var stringss=window.location.href;
        var string_length=stringss.lastIndexOf('/');
        var finalvalue=stringss.slice(string_length+1,stringss.length);
        if(parseInt(sesJqueryObject(window).width())<768 && finalvalue!='compose')
        {
            displayonlyusers();
            return false;
        }

        addnewuser();
        displaygifseach();
        if(Number.isInteger(parseInt(finalvalue)))
        {
             sesJqueryObject("#chatuser_id_"+parseInt(finalvalue)+ '[type*=1]').click();
        }
        else
        {
            var group_length=finalvalue.lastIndexOf('.');
            var group_finalvalue=finalvalue.slice(group_length+1,finalvalue.length);
            if(Number.isInteger(parseInt(group_finalvalue)))
            {
                sesJqueryObject("#chatuser_id_"+parseInt(group_finalvalue)+ '[type*=2]').click();
            }
        }
    });
    jqueryObjectOfSes(window).load(function () {
        jqueryObjectOfSes(".sesbasic_custom_scroll_1").mCustomScrollbar({
            theme: "minimal-dark",
            onTotalScrollBackOffset: 1000,
            scrollInertia: 100,
            callbacks: {
                onTotalScrollBack: function () {
                  if((old_page_id + 1) <= total_pages ) {
                    displayusermessages(selecteduserid, (old_page_id + 1), type);
                  }
                },
            }
        });
        jqueryObjectOfSes(".sesbasic_custom_scroll_2").mCustomScrollbar({
            theme: "minimal-dark",
            onTotalScrollBackOffset: 1000,
            scrollInertia: 100,
            callbacks: {
                onTotalScroll: function () {
                    updateShareMediaImage(selecteduserid, type);
                },
            }
        });
    });


    // Here we upload image by ajax
    function uploadmessagesimage() {
        var totalimages=sesJqueryObject('#messages_imageuplode').prop('files').length;
        for(var i=0;i<parseInt(totalimages);i++) {
            var form_data = new FormData();
            form_data.append('file', sesJqueryObject('#messages_imageuplode').prop('files')[i]);
            sesJqueryObject.ajax({
                url: en4.core.baseUrl + 'emessages/messages/setimages',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (html) {
                    var arrays = jQuery.parseJSON(html);
                    if (arrays['status'] == 1) {
                        sesJqueryObject("#emessages-compose-tray").append('<div id="append_img_' + arrays["id"] + '" class="_img"><span onclick="deleteappendimg(' + arrays["id"] + ')"><i class="fa fa-times"></i></span><input type="hidden" name="messagesimageid[]" value="' + arrays["id"] + '"><img src="' + arrays["image_path"] + '" alt=""></div>');
                    }
                }
            });
        }
    }

    //upload media by ajax
    function uploadmessagesmedia(id,size,type) {
        var uploadField = document.getElementById(id);
           if(parseInt(uploadField.files[0].size) > parseInt(size)){
                alert("File is too big! Its must be below to "+size+" kb");
                document.getElementById(id).value = "";
                return false;
            }
            var form_data = new FormData();
            form_data.append('file', sesJqueryObject('#'+id).prop('files')[0]);
            sesJqueryObject.ajax({
                url: en4.core.baseUrl + 'emessages/messages/setmedia',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (html) {
                    var arrays = jQuery.parseJSON(html);
                    if (arrays['status'] == 1) {
                        sesJqueryObject("#emessages-compose-tray").append('<div id="append_img_' + arrays["id"] + '" class="_img"><span onclick="deleteappendimg(' + arrays["id"] + ')"><i class="fa fa-times"></i></span><input type="hidden" name="messagesimageid[]" value="' + arrays["id"] + '"><img src="' + arrays["image_path"] + '" alt=""></div>');
                    }
                }
            });
    }

    // for delete ajax image
    function deleteappendimg(removeid) {
        sesJqueryObject("#append_img_" + removeid).remove();
    }


    // for autoview chatoption

    function autoupdate() {
        if (parseInt(selecteduserid) != 0) {
            var last=sesJqueryObject(".msg-list-item").last().attr('id');
            var last_id=0;
            if (typeof last != "undefined" && last!='')
            {
                last_id=last.split("_").pop(-1);
            }
            sesJqueryObject.ajax({
                url: en4.core.baseUrl + 'emessages/messages/autoupdate',
                method: "POST",
                data: {selecteduserid: selecteduserid, type: type, last_message_id: last_id},
                success: function (html) {
                    var arrays = jQuery.parseJSON(html);
                    if (arrays['status'] == 1 && arrays['selecteduserid'] == selecteduserid) {
                        sesJqueryObject("#messageslist").append(arrays['content']);
                        sesJqueryObject("#userdescription_" + selecteduserid).text(arrays['user_des']);
                        sesJqueryObject("#userdate_" + selecteduserid).text(arrays['user_date']);
                        jqueryObjectOfSes(".sesbasic_custom_scroll_1").mCustomScrollbar('scrollTo', 'last');
                        var htmltext = sesJqueryObject('#chatuser_id_' + arrays['selecteduserid'] + '[type*=' + type + ']').html();
                        sesJqueryObject('#chatuser_id_' + arrays['selecteduserid'] + '[type*=' + type + ']').remove();
                        sesJqueryObject("#appenduserlist").prepend('<li class="listofusers clearfix selected" type="' + type + '" username="' + arrays['username'] + '" id="chatuser_id_' + arrays['selecteduserid'] + '" onclick="changeusername(\'' + arrays['username'] + '\');displayusermessages(' + arrays['selecteduserid'] + ',1,' + type + ')">' + htmltext + '</li>');
                    }
                }
            });
        }
    }

    // autoupdate function call every sec
    setInterval(function ()
    {
      autoupdate();
    }, <?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.notificationupdate');  ?>);


    // for update all user
/*
    setInterval(function ()
    {
       //autoupdateAlluser();
      //deleteMessageupdate();
    }, 10000);
*/

    function autoupdateAlluser()
    {
        sesJqueryObject.ajax({
            url: en4.core.baseUrl + 'emessages/messages/autoupdatealluser',
            method: "POST",
            data: {},
            success: function (html) {
                var arrays = jQuery.parseJSON(html);
                if (parseInt(arrays['status']) == 1) {
                    for (var i = 0; i < arrays['totallength']; i++) {
                        var old_not_update=sesJqueryObject("#chatuser_id_" + arrays[i]['selecteduserid']).attr('msg_id');
                        sesJqueryObject("#userdate_" + arrays[i]['selecteduserid']).text(arrays[i]['time']);
                        if (arrays[i]['selecteduserid'] != selecteduserid && parseInt(arrays[i]['type']) == 1 && old_not_update!=arrays[i]['message_id']) {
                            sesJqueryObject("#userdescription_" + arrays[i]['selecteduserid']).text(arrays[i]['user_des']);
                            var htmltext = sesJqueryObject('#chatuser_id_' + arrays[i]['selecteduserid'] + '[type*=' + arrays[i]['type'] + ']').html();
                            sesJqueryObject('#chatuser_id_' + arrays[i]['selecteduserid'] + '[type*=' + arrays[i]['type'] + ']').remove();
                            sesJqueryObject("#appenduserlist").prepend('<li class="listofusers unread_message clearfix" msg_id="'+arrays[i]['message_id']+'" type="' + arrays[i]['type'] + '" id="chatuser_id_' + arrays[i]['selecteduserid'] + '" onclick="changeusername(\'' + arrays[i]['username'] + '\');displayusermessages(' + arrays[i]['selecteduserid'] + ',1,type)">' + htmltext + '</li>');
                        } else if (parseInt(arrays[i]['type']) == 2  && old_not_update!=arrays[i]['message_id']) {
                            sesJqueryObject("#userdescription_" + arrays[i]['selecteduserid']).text(arrays[i]['user_des']);
                            var htmltext = sesJqueryObject('#chatuser_id_' + arrays[i]['selecteduserid'] + '[type*=' + arrays[i]['type'] + ']').html();
                            sesJqueryObject('#chatuser_id_' + arrays[i]['selecteduserid'] + '[type*=' + arrays[i]['type'] + ']').remove();
                            sesJqueryObject("#appenduserlist").prepend('<li class="listofusers unread_message clearfix" msg_id="'+arrays[i]['message_id']+'" type="' + arrays[i]['type'] + '" id="chatuser_id_' + arrays[i]['selecteduserid'] + '" onclick="changeusername(\'' + arrays[i]['username'] + '\');displayusermessages(' + arrays[i]['selecteduserid'] + ',1,type)">' + htmltext + '</li>');
                        }
                    }
                    sesJqueryObject("#chatuser_id_" + selecteduserid + '[type*=' + type + ']').addClass('selected');
                }
            }
        });
    }

    // for deletemessages
    function deleteMessage(messages_id) {
        if (confirm('Are you sure? Do you want to delete')) {
            sesJqueryObject.ajax({
                url: en4.core.baseUrl + 'emessages/messages/deletemessages',
                method: "POST",
                data: {message_id: messages_id, type: type},
                success: function (html) {
                    var arrays = jQuery.parseJSON(html);
                    if (parseInt(arrays['status']) == 1) {
                        sesJqueryObject("#messages_li_" + messages_id).remove();
                    }
                }
            });
        }
    }

    // delete messages update
    function deleteMessageupdate() {
        sesJqueryObject.ajax({
            url: en4.core.baseUrl + 'emessages/messages/deletemessageslist',
            method: "POST",
            data: {selecteduserid: selecteduserid, type: type},
            success: function (html) {
                var arrays = jQuery.parseJSON(html);
                if (parseInt(arrays['status']) == 1) {
                    for (var i = 0; i < arrays['totallength']; i++)
                    {
                        sesJqueryObject("#messagesdisplay_" + arrays[i]['messages_id']).html(arrays[i]['messages']);
                        sesJqueryObject("#transh_delete_" + arrays[i]['messages_id']).remove();
                    }
                }
            }
        });

    }


    //auto suggetion for createuser

    en4.core.runonce.add(function () {
        new Autocompleter.Request.JSON('adduser', '<?php echo $this->url(array('module' => 'emessages', 'controller' => 'messages', 'action' => 'addusesuggest', 'message' => true), 'default', true) ?>', {
            'minLength': 1,
            'delay': 250,
            'selectMode': 'pick',
            'autocompleteType': 'message',
            'multiple': false,
            'className': 'sesbasic-autosuggest emessages-autosuggest',
            'filterSubset': true,
            'tokenFormat': 'object',
            'tokenValueKey': 'label',
            'injectChoice': function (token) {
                if (token.type == 'user') {
                    var choice = new Element('li', {
                        'class': 'autocompleter-choices',
                        'html': token.photo,
                        'id': token.label
                    });
                    new Element('div', {
                        'html': this.markQueryValue(token.label),
                        'class': 'autocompleter-choice'
                    }).inject(choice);
                    this.addChoiceEvents(choice).inject(this.choices);
                    choice.store('autocompleteChoice', token);
                } else {
                    var choice = new Element('li', {
                        'class': 'autocompleter-choices friendlist',
                        'id': token.label
                    });
                    new Element('div', {
                        'html': this.markQueryValue(token.label),
                        'class': 'autocompleter-choice'
                    }).inject(choice);
                    this.addChoiceEvents(choice).inject(this.choices);
                    choice.store('autocompleteChoice', token);
                }

            },
            onPush: function () {
                sesJqueryObject("#chatmessages_form").show();
                sesJqueryObject("#welcomeimgdisplay").hide();

                if($('toValues').value.split(',').length == 1)
                {
                    sesJqueryObject.ajax({
                        url: en4.core.baseUrl + 'emessages/messages/getuserlistid',
                        method: "POST",
                        data: {user_id: $('toValues').value},
                        success: function (html) {
                            var arrays = jQuery.parseJSON(html);
                            if (parseInt(arrays['status']) == 1) {
                                    sesJqueryObject("#msg_scrolleradd").append(arrays['content']);
                            }
                        }
                    });
                }
                else
                {
                    sesJqueryObject(".msg-list-item").remove();
                }
                if ($('toValues').value.split(',').length >= 20) {
                    $('adduser').disabled = true;
                }
            }
        });

        new Composer.OverText($('adduser'), {
            'textOverride': '<?php echo $this->translate('Start typing...') ?>',
            'element': 'label',
            'isPlainText': true,
            'positionOptions': {
                position: (en4.orientation == 'rtl' ? 'upperRight' : 'upperLeft'),
                edge: (en4.orientation == 'rtl' ? 'upperRight' : 'upperLeft'),
                offset: {
                    x: (en4.orientation == 'rtl' ? -4 : 4),
                    y: 2
                }
            }
        });
    });

    function removeFromToValue(id) {
        sesJqueryObject("#addusertypefield_username").show();
        sesJqueryObject("#chatmessages_form").hide();
        sesJqueryObject(".msg-list-item").remove();
        // code to change the values in the hidden field to have updated values
        // when recipients are removed.
        var toValues = $('toValues').value;
        var toValueArray = toValues.split(",");
        var toValueIndex = "";

        var checkMulti = id.search(/,/);

        // check if we are removing multiple recipients
        if (checkMulti != -1) {
            var recipientsArray = id.split(",");
            for (var i = 0; i < recipientsArray.length; i++) {
                removeToValue(recipientsArray[i], toValueArray);
            }
        } else {
            removeToValue(id, toValueArray);
        }

        // hide the wrapper for usernames if it is empty
        if ($('toValues').value == "") {
            $('toValues-wrapper').setStyle('height', '0');
        }

        $('adduser').disabled = false;
    }

    function removeToValue(id, toValueArray) {
        for (var i = 0; i < toValueArray.length; i++) {
            if (toValueArray[i] == id) toValueIndex = i;
        }

        toValueArray.splice(toValueIndex, 1);
        $('toValues').value = toValueArray.join();
    }

    function deleteAllChatForUser(chatuser_id) {
        if (confirm('Are you sure? Do you want to delete all conversation?')) {
            sesJqueryObject.ajax({
                url: en4.core.baseUrl + 'emessages/messages/deleteallchatforuser',
                method: "POST",
                data: {chatuser_id: chatuser_id},
                success: function (html) {
                    var arrays = jQuery.parseJSON(html);
                    if (parseInt(arrays['status']) == 1) {
                        displayusermessages(chatuser_id, 1, 1);
                    }
                }
            });
        }
    }

    function deleteAllChatWithUser(chatuser_id) {
        if (confirm('Are you sure? Do you want to delete all chat?')) {
            sesJqueryObject.ajax({
                url: en4.core.baseUrl + 'emessages/messages/deleteallahatwithuser',
                method: "POST",
                data: {chatuser_id: chatuser_id},
                success: function (html) {
                    var arrays = jQuery.parseJSON(html);
                    if (parseInt(arrays['status']) == 1) {
                        location.reload();
                    }
                }
            });
        }
    }


    function finalydeletegroup(group_id) {
        if (confirm('Are you sure? Do you want to delete this group?')) {
            sesJqueryObject.ajax({
                url: en4.core.baseUrl + 'emessages/messages/deletethisgroup',
                method: "POST",
                data: {group_id: group_id},
                success: function (html) {
                    var arrays = jQuery.parseJSON(html);
                    if (parseInt(arrays['status']) == 1) {
                        location.reload();
                    }
                }
            });
        }
    }
</script>
<!-- All code for chat user end-->


<!-- All code for mobile view  start-->

<script type="application/javascript">
    function  displayonlyusers()
    {
        sesJqueryObject('.msg-chat-container').addClass('_hide');
        sesJqueryObject(".msg-users-panel").removeClass('_hide');
        sesJqueryObject(".listofusers").removeClass('selected');
        window.history.pushState('messages/*', 'view', "messages");
    }

    // for update center user name
    function changeusername(username)
    {
        sesJqueryObject('#displayhereselectuser').html(username);
    }
</script>

<!-- All code for mobile view  end-->
<!-- Images display start -->

<script>
    function displayimages(id,openat)
    {
     if(id.length>0)
     {
         sesJqueryObject.ajax({
             url: en4.core.baseUrl + 'emessages/messages/getimagesurl',
             method: "POST",
             data: {images_id: id},
             success: function (html) {
                 var arrays = jQuery.parseJSON(html);
                 var galleryenable=false;
                 if(arrays.length>1){ galleryenable=true; }
                 if (arrays.length>0) {
                     var imagesrc=[];
                     for(var i=0; i<arrays.length; i++)
                     {

                         imagesrc.push({'src':arrays[i]});
                     }
                     jqueryObjectOfSes.magnificPopup.open({
                         items: imagesrc,
                         gallery: {
                             enabled: galleryenable
                         },
                         type: 'image', // this is a default type
                     },parseInt(openat));
                 }
             }
         });
     }
    }

  function  sharemediapopup(selectedimagepath)
  {
      var openat=0;
      var counts=0;
      var imagesrc=[];
      sesJqueryObject(".totalimagesupload").each(function () {
         var allsrc=sesJqueryObject(this).attr('src');
         if(selectedimagepath==allsrc)
         {
             openat=counts;
         }
          counts++;
          imagesrc.push({'src':allsrc});
      });
      var galleryenable=false;
      if(counts>1){ galleryenable=true; }
      jqueryObjectOfSes.magnificPopup.open({
          items: imagesrc,
          gallery: {
              enabled: galleryenable
          },
          type: 'image', // this is a default type
      },parseInt(openat));

  }

  function  addremoveadmin(group_id, user_id, type)
  {
      if (confirm('Are you sure? Do you want to change in group')) {
          sesJqueryObject.ajax({
              url: en4.core.baseUrl + 'emessages/messages/addremoveadmin',
              method: "POST",
              enctype: 'multipart/form-data',
              data: {group_id: group_id, user_id: user_id, type: type,},
              success: function (html) {
                  var arrays = jQuery.parseJSON(html);
                  if (arrays['status'] == 1)
                  {
                      location.reload();
                  }
              }
          });
      }
  }
</script>
<!-- Images display end -->
<?php foreach( $this->composePartials as $partial ): ?>
	<?php 
    try{
       echo $this->partial($partial[0], $partial[1]); 
    }catch(Exception $e){}
  ?>
<?php endforeach; ?>
