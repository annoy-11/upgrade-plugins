<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox	
 * @package    Sesshoutbox
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $allParams = $this->allParams; 
$shoutbox = $this->shoutbox;
//print_r();die; ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesshoutbox/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<div class="sessbx_bxs sessbx_main">
	<div class="sessbx_header sessbx_clearfix">
    <?php if($shoutbox->sesshoutbox_rules) { ?>
      <div class="_left"><?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesshoutbox', 'controller' => 'index', 'action' => 'shoutbox-rule', 'shoutbox_id' => $shoutbox->shoutbox_id), $this->translate('Check Shoutbox Rules'), array('class' => 'sessmoothbox')) ?></div>
    <?php } ?>
  	<!--<div class="_right"><a href="">Filter</a></div>-->
  </div>
  <div class="sessbx_main_container">
  <?php //sesbasic_custom_scroll ?>
  	<div class="sessbx_msgbox_wrapper">
      <div class="sesbasic_loading_cont_overlay" id="sessbx_msgbox_overlay" style="display:block;"></div>
      <div class="sessbx_msgbox" id="sessbx_msgbox">
        <?php for($i=count($this->contents);$i>=1;$i--) {
        $content = $this->contents[$i-1];
        ?>
          <?php $poster = Engine_Api::_()->getItem('user', $content->poster_id); ?>
          <?php if($this->viewer_id != $content->poster_id) { ?>
          
            <div id="sessbx_msg_item_send_<?php echo $content->getIdentity(); ?>" class="sessbx_msg_item sessbx_msg_item_receive <?php if($poster->getIdentity() && in_array($poster->level_id, array('1','2'))) { ?> _isadmin <?php } ?>" data-id="<?php echo $content->getIdentity(); ?>">
              <article class="sessbx_clearfix">
                <div class="sessbx_msg_item_photo">
                  <?php echo $this->htmlLink($poster->getHref(), $this->itemPhoto($poster, 'thumb.icon', $poster->getTitle())) ?>
                </div>
                <div class="sessbx_msg_item_body sessbx_clearfix">
                  <div class="sessbx_msg_item_body_inner">
                    <div class="_cont">
                      <div class="_name"><a href="<?php echo $poster->getHref(); ?>"><?php echo $poster->getTitle(); ?></a></div>
                      <?php $contents = Engine_Api::_()->sesshoutbox()->smileyToEmoticons($content->body); ?>   
                      <div class="_body" id="sesshoutbox_message_boy_<?php echo $content->getIdentity(); ?>"><?php echo $contents; ?></div>
                    </div>
                    <div class="_time"><?php echo $this->timestamp($content->creation_date); ?></div>
                  </div>
                </div>
                <?php if($this->viewer_id && $this->viewer_id != $content->poster_id) { ?>
                  <div class="_option">
                    <div class="_optioninner">
                      <div class="_options_pulldown">
                        <a class="smoothbox" href="<?php echo $this->url(array('module'=>'sesshoutbox','controller'=>'index','action'=>'report', 'resource_id' => $content->getIdentity(), 'resource_type' => 'sesshoutbox_content'), 'default' , true); ?>"><?php echo $this->translate("Report")?></a>
                      </div>	
                      <i class="fa fa-ellipsis-h"></i>
                    </div>  
                  </div>
                <?php } ?>
              </article>	
            </div>
          <?php } else if($this->viewer_id == $content->poster_id) { ?>
            <div id="sessbx_msg_item_send_<?php echo $content->getIdentity(); ?>" class="sessbx_msg_item sessbx_msg_item_send" data-id="<?php echo $content->getIdentity(); ?>">
              <article class="sessbx_clearfix">
                <div class="_option">
                  <div class="_optioninner">
                    <div class="_options_pulldown">
                      <a class="sessmoothbox" href="sesshoutbox/index/edit-message/content_id/<?php echo $content->getIdentity(); ?>"><?php echo $this->translate("Edit")?></a>
                      <a href="javascript:void(0);" onclick="deleteMessage('<?php echo $content->getIdentity(); ?>', '<?php echo $content->shoutbox_id; ?>')"><?php echo $this->translate("Delete")?></a>
                    </div>	
                    <i class="fa fa-ellipsis-h"></i>
                  </div>  
                </div>
                <div class="sessbx_msg_item_body sessbx_clearfix">
                  <div class="sessbx_msg_item_body_inner">
                    <div class="_cont">
                      <?php $contents = Engine_Api::_()->sesshoutbox()->smileyToEmoticons($content->body); ?>  
                      <div class="_body" id="sesshoutbox_message_boy_<?php echo $content->getIdentity(); ?>"><?php echo $contents; ?></div>
                    </div>
                    <div class="_time"><?php echo $this->timestamp($content->creation_date); ?></div>
                  </div>
                </div>
              </article>	
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
    <?php if(!empty($this->viewer_id)) { ?>
      <div class="sessbx_postbox">
        <div class="_field">
          <textarea id="shoutbox_content" maxlength="<?php echo $shoutbox->text_limit; ?>"></textarea>
          <span id="sesshoutbox_emoticons"  class="sessbx_emoticons_activator"  onmousedown="shoutboxSetEmoticonsBoard()">
            <i></i>  

          </span>
        </div>
        <?php if(in_array($shoutbox->postcontentbutton, array('1', '2', '4'))) { ?>
          <div class="_btns">
            <button onclick="sendShoutbox();"><i class="fa fa-paper-plane"></i><?php if($shoutbox->postcontentbutton == 1) { ?><span>Send</span><?php } ?></button>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
  </div>  
</div>

<div id="sesshoutbox_emoji_cnt"  style="display:none;">
<span id="sesshoutbox_emoticonsboard"  class="emoticons_box emoticons_box_closed">
  <span class="emoticons_box_arrow"></span>
  <?php $emoticonsTag = Engine_Api::_()->activity()->getEmoticons();
  foreach ($emoticonsTag as $symbol => $icon): ?>
    <span class="emoticons_box_icon" onmousedown='addEmotionShoutbox("<?php echo $this->string()->escapeJavascript($symbol)?>")'>
      <?php echo "<img src=\"" . $this->layout()->staticBaseUrl .
            "application/modules/Activity/externals/emoticons/images/$icon\" border=\"0\"/>" ?>
    </span>
  <?php endforeach; ?>
</span>
</div>

<script type="text/javascript">
    function doResizeForButton(){
        var topPositionOfParentSpan =  sesJqueryObject("#sesshoutbox_emoticons").offset().top + 34;
        topPositionOfParentSpan = topPositionOfParentSpan+'px';
        var leftPositionOfParentSpan =  sesJqueryObject("#sesshoutbox_emoticons").offset().left - 253;
        leftPositionOfParentSpan = leftPositionOfParentSpan+'px';
        sesJqueryObject('.emoticons_box_closed').css('top',topPositionOfParentSpan);
        sesJqueryObject('.emoticons_box_closed').css('left',leftPositionOfParentSpan);
    }
    window.addEvent('load',function(){
    	doResizeForButton();
    });
		sesJqueryObject(document).ready(function(){
      sesJqueryObject(sesJqueryObject("#sesshoutbox_emoji_cnt").html()).appendTo('body');
			sesJqueryObject('#sesshoutbox_emoji_cnt').remove();
			doResizeForButton();
		});
		
    var hideEmoticonsBox = false;
    function htmlunescape(content) {
      var doc = new DOMParser().parseFromString(content, "text/html");
      return doc.documentElement.textContent;
    }

    function shoutboxSetEmoticonsBoard() {
//       if (composeInstance) {
//         composeInstance.focus();
//       }

      hideEmoticonsBox = true;
      $('sesshoutbox_emoticons').toggleClass('emoticons_active');
      $('sesshoutbox_emoticons').toggleClass('');
      $('sesshoutbox_emoticonsboard').toggleClass('emoticons_box_opened');
      $('sesshoutbox_emoticonsboard').toggleClass('emoticons_box_closed');
//       if ($('sesshoutbox_emoticons').hasClass('emoticons_active')) {
//         (function() {
//           composeInstance.getMenu().setStyle('display', '');
//         }).delay(300);
//       }
    }

    function addEmotionShoutbox(iconCode) {

      //var shoutbox_contentval  = sesJqueryObject('#shoutbox_content').val()
      var content = htmlunescape(sesJqueryObject('#shoutbox_content').val());
      content = content.replace(/&nbsp;/g, ' ');
//       if( !('useContentEditable' in composeInstance.options && composeInstance.options.useContentEditable )) {
//         composeInstance.setContent(content + ' ' + iconCode);
//         return;
//       }
      var textBeforeCaret = content.substr(0, sesJqueryObject('#shoutbox_content').lastCaretPos);
      var textAfterCaret = content.substr(sesJqueryObject('#shoutbox_content').lastCaretPos);
      iconCode = content + ' ' + iconCode + ' ';
      sesJqueryObject('#shoutbox_content').val(iconCode);
    //  sesJqueryObject('#shoutbox_content').setCaretPos(textBeforeCaret.length + iconCode.length);
//       if ( sesJqueryObject('#shoutbox_content').getContent() !== '' ) {
//         (function() {
//           sesJqueryObject('#shoutbox_content').getMenu().setStyle('display', '');
//         }).delay(300);
//       }
    }

    $(document.body).addEvent('click',shoutboxHideEmoticonsBoxEvent.bind());

    function shoutboxHideEmoticonsBoxEvent() {
      if (!hideEmoticonsBox && $('sesshoutbox_emoticonsboard')) {
        $('sesshoutbox_emoticonsboard').removeClass('emoticons_box_opened').addClass('emoticons_box_closed');
      }
      hideEmoticonsBox = false;
    }

    en4.core.runonce.add(function() {
      $('sesshoutbox_emoticons').inject($('compose-container'));
    });
  </script>
<style type="text/css">
html .sessbx_msgbox{
	background-color:#<?php echo $shoutbox->background_color; ?>
}
html .sessbx_msg_item .sessbx_msg_item_body ._time,
.sessbx_msg_item ._option > i{
	color:#<?php echo $shoutbox->sh_font_color; ?>;
}
/*Viewer*/
html .sessbx_msg_item_send ._cont{
	background-color:#<?php echo $shoutbox->my_background_color; ?>;
}
html .sessbx_msg_item .sessbx_msg_item_body ._cont > div{
	color:#<?php echo $shoutbox->my_font_color; ?>;
	font-size:<?php echo $shoutbox->font_size; ?>px;
}
/*Other*/
html .sessbx_msg_item_receive .sessbx_msg_item_body ._cont{
	background-color:#<?php echo $shoutbox->other_background_color; ?>;
}
html .sessbx_msg_item_receive .sessbx_msg_item_body ._cont *{
	font-size:<?php echo $shoutbox->font_size; ?>px;
	color:#<?php echo $shoutbox->other_font_color; ?> !important;
}
html .sessbx_msg_item_receive .sessbx_msg_item_body ._cont:before{
	border-top: 10px solid #<?php echo $shoutbox->other_background_color; ?>;
}
/*Admin*/
html .sessbx_msg_item_receive._isadmin .sessbx_msg_item_body ._cont{
	background-color:#<?php echo $shoutbox->admin_background_color; ?>;
}
html .sessbx_msg_item_receive._isadmin .sessbx_msg_item_body ._cont *{
	font-size:<?php echo $shoutbox->font_size; ?>px;
	color:#<?php echo $shoutbox->admin_font_color; ?> !important;
}
html .sessbx_msg_item_receive._isadmin .sessbx_msg_item_body ._cont:before{
	border-top: 10px solid #<?php echo $shoutbox->admin_background_color; ?>;
}
</style>
<script type="text/javascript">

  function deleteMessage(content_id, shoutbox_id) {
    deleteContentShoutMessage = (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "sesshoutbox/index/deletemessage/",
      'data': {
        format: 'html',
          content_id: content_id,
          shoutbox_id: shoutbox_id,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      
        sesJqueryObject('#sessbx_msg_item_send_'+content_id).fadeOut("slow", function() {
          setTimeout(function() {
            sesJqueryObject('#sessbx_msg_item_send_'+content_id).remove();
          }, 1000);
        });
      }
    })).send();    
  }
  
	sesJqueryObject(document).on('click','._optioninner',function(){
		if(sesJqueryObject(this).hasClass('open')){
			sesJqueryObject(this).removeClass('open');
		}else{
			sesJqueryObject('._option').removeClass('open');
			sesJqueryObject(this).addClass('open');
		}
			return false;
	});
	sesJqueryObject(document).click(function(){
		sesJqueryObject('._optioninner').removeClass('open');
	});

	<?php if(in_array($shoutbox->postcontentbutton, array(3,4))) { ?>
		sesJqueryObject(document).ready(function() {
			sesJqueryObject('#shoutbox_content').keydown(function(e) {
				if(!e.shiftKey){
					if (e.which === 13) {
						sendShoutbox();
					}
				}
			});
		});
	<?php } ?>

  sesJqueryObject("#sessbx_msgbox").css('visibility', 'hidden');
  en4.core.runonce.add(function(){
		sesJqueryObject('#sessbx_msgbox_overlay').show();
    jqueryObjectOfSes("#sessbx_msgbox").mCustomScrollbar({
      theme:"minimal-dark",
      callbacks:{
        whileScrolling:function() {
          if(this.mcs.topPct == 5) {
						sesJqueryObject('#sessbx_msgbox_overlay').show();
            var lastContestID = sesJqueryObject( "#sessbx_msgbox").find('div').eq(0).find('div').eq(0).find('div').eq(0).attr('data-id');
            loadMoreShoutboxContent(lastContestID);
          }
        },
      }
    });
    jqueryObjectOfSes("#sessbx_msgbox").mCustomScrollbar("scrollTo","bottom");
		sesJqueryObject('#sessbx_msgbox_overlay').hide();
    sesJqueryObject("#sessbx_msgbox").css('visibility', 'visible');
  });
  
  var loadmorerequestsend = 0;
  function loadMoreShoutboxContent(lastContestID) {
    
    if(loadmorerequestsend == 1)
      return;
      
    loadmorerequestsend = 1;
    loadMoreShoutbox = (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "sesshoutbox/index/loadmorecontents/",
      'data': {
        format: 'html',
          contentid: lastContestID,
          shoutbox_id: '<?php echo $this->shoutbox->getIdentity(); ?>',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        sesJqueryObject('#sessbx_msgbox_overlay').hide();
        sesJqueryObject( "#sessbx_msgbox").find('div').eq(0).find('div').eq(0).prepend(responseHTML);
        loadmorerequestsend = 0;
      }
    })).send();
  }


  function sendShoutbox() {
  
    if(!sesJqueryObject('#shoutbox_content').val())
      return;
      
    var my_background_color = 'background-color:#<?php echo $shoutbox->my_background_color; ?>;';
    
    var my_font_size = 'font-size:<?php echo $shoutbox->font_size; ?>px;';
    
    var my_font_color = 'font-color:#<?php echo $shoutbox->my_font_color; ?>;';
    
    var posting_time = '<?php echo date('Y-m-d H:i:s'); ?>';
    
    var shoutbox_contentval  = sesJqueryObject('#shoutbox_content').val()
    
    var selfmsg = '<div class="sessbx_msg_item sessbx_msg_item_send"><article class="sessbx_clearfix"><div class="sessbx_msg_item_body sessbx_clearfix"><div class="sessbx_msg_item_body_inner"><div class="_cont" style="'+my_background_color+'"><div class="_body" style="'+my_font_size+my_font_color+'">'+sesJqueryObject('#shoutbox_content').val().replace(/\n/g, '<br />')+'</div></div><div class="_time sessbx_text_light">'+posting_time+'</div></div></div></article></div>';
    
    sesJqueryObject( "#sessbx_msgbox").find('div').eq(0).find('div').eq(0).append(selfmsg);
    jqueryObjectOfSes("#sessbx_msgbox").mCustomScrollbar("scrollTo","bottom");
    sesJqueryObject('#shoutbox_content').val('');
    
    en4.core.request.send(new Request.JSON({
      url: en4.core.baseUrl + 'sesshoutbox/index/create',
      data: {
        format: 'json',
        'content': shoutbox_contentval,
        'shoutbox_id' : '<?php echo $allParams['shoutbox_id']; ?>',
        'poster_id': '<?php echo $this->viewer_id; ?>',
      },
      onSuccess: function(responseJSON) {
        if(responseJSON.content_id) {
          console.log(responseJSON.content_id);
          sesJqueryObject('#mCSB_1_container').children().last().attr('data-id',responseJSON.content_id);
        }
      }
    }));
  }
  
  window.addEvent('domready', function() {
    setInterval(function() {
      shoutboxLastMessage();
    },20000);
  });
  
  function shoutboxLastMessage() {
    
    var lastContestID = sesJqueryObject('#mCSB_1_container').children().last().attr('data-id'); //sesJqueryObject( "#sessbx_msgbox").find('div').eq(0).find('div').eq(0).find('div').eq(0).attr('data-id');
    
    lastmessage = (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "sesshoutbox/index/lastmessage/",
      'data': {
        format: 'html',
          content_id: lastContestID,
          shoutbox_id: '<?php echo $allParams['shoutbox_id']; ?>',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        sesJqueryObject( "#sessbx_msgbox").find('div').eq(0).find('div').eq(0).append(responseHTML);
        jqueryObjectOfSes("#sessbx_msgbox").mCustomScrollbar("scrollTo","bottom");
      }
    })).send();
    
  }
</script>
