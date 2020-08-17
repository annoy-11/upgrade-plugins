var m_MouseDown = false;
var m_MouseDrag = false;
var isTouchFromSestweetContainer = false;
document.onmousedown = function (e) {
    m_MouseDown = true;
    if ( sesJqueryObject(e.target).parents("#sestweet_twilighter_div").length == 1 || sesJqueryObject(e.target).hasClass('.sumo_highlighter_desktop')) { 
       // YES, the child element is inside the parent
      isTouchFromSestweetContainer = true;
    } else {
       // NO, it is not inside
      isTouchFromSestweetContainer = false;
    }
};
var tweetx = null;
var tweety = null;
document.onmouseup = function (e) {
    m_MouseDown = false;
    if(m_MouseDrag && !isTouchFromSestweetContainer){
      var selectedstring =  getSelectionInfo();
      if(selectedstring != '' && typeof selectedstring != 'undefined' && selectedstring.length != 0){
        var twitterHandler = ' @'+sestweet_twitter_handler;
        var twitterHandlerLength = twitterHandler.length;        
        if(selectedstring.length > 140) {
          if(sestweet_twitter_handler) { 
            var maxLength = 140 - (twitterHandlerLength+3);
            var trimmedString = selectedstring.substr(0, maxLength);
            selectedstring = trimmedString + '... @'+sestweet_twitter_handler;
          } else {
            var maxLength = 140 - 3;
            var trimmedString = selectedstring.substr(0, maxLength);
            selectedstring = trimmedString + '...';
          }
        } else {
          if(sestweet_twitter_handler)
            selectedstring = selectedstring + twitterHandler;
          else
            selectedstring = selectedstring;
        }
        sesJqueryObject('#sestweet_twilighter_input').val(selectedstring);
        sesJqueryObject('#sestweet_twilighter_div').show();  
        updateCountdown();
        sesJqueryObject('#sestweet_twilighter_div').css('top', tweety).css('left', tweetx);
      }else{
         sesJqueryObject('#sestweet_twilighter_div').hide(); 
         sesJqueryObject('#sestweet_twilighter_textarea').val('');
      }
    }
    m_MouseDrag = false;
};

document.onmousemove = function(e) {
    m_MouseDrag = true;
    tweetx = e.pageX - 10;
    tweety = e.pageY + 10;
}
String.prototype.trimString = function() {
    return this.replace(/^\s+|\s+$/g, "");
};
function getSelectionInfo() {
    var selected = "";
    if (typeof window.getSelection != "undefined") {
        var sel = window.getSelection();
        if (sel.rangeCount) {
            for (var i = 0, len = sel.rangeCount; i < len; ++i) {
                var range = sel.getRangeAt(i);
                var txt = document.createElement('div');
                txt.appendChild(range.cloneContents());
                //selected = range.startContainer.parentNode.id + ':' + range.startOffset + '-' + range.endOffset + ' "' + txt.innerHTML + '"';
                selected = txt.textContent || txt.innerText || "";
                selected = selected.trimString();
            }
        }
    }
    return selected;
}
sesJqueryObject(document).on('click','.socialSharingPopUpTweet',function(){
  var type = sesJqueryObject(this).attr('data-type');
  var textareavalue = sesJqueryObject('#sestweet_twilighter_input').val();
  if(type == 'twitter') {
    var url = 'https://twitter.com/intent/tweet?text='+escape(textareavalue);
    window.open(url, "Twitter" ,'height=500,width=500');
  } else if(type == 'fb') {
    var url = 'https://www.facebook.com/share.php?u=' + sesencodeCurrentUrl+'&t='+escape(textareavalue); 
    window.open(url, "Facebook" ,'height=500,width=500');
  }
	return false;
});
sesJqueryObject(document).ready(function($) {
    updateCountdown();
});
var sesTweetBoxElem = sesJqueryObject('.sestweet_twilighter_textarea');
sesJqueryObject(document).on("propertychange change click keyup input paste",'.sestweet_twilighter_textarea', function(event){
  updateCountdown(true);
});
function updateCountdown(isChange) {
  // 140 is the max message length
  var string = sesJqueryObject('#sestweet_twilighter_input').val();
  if(!string || (string.length < 0 && typeof isChange == "undefined"))
    return;
  if(string.length > 140 && typeof isChange == "undefined"){
      string =  string.substr(0, 140);
  }
  sesJqueryObject('.sestweet_twilighter_textarea').val(string);
  var remaining = 140 - string.length;
  sesJqueryObject('.sestweet_twilighter_remaining').text(remaining);
}
function closeSestweetBox(){
    sesJqueryObject('#sestweet_twilighter_div').hide();
    sesJqueryObject('#sestweet_twilighter_textarea').val('');
}


function showHideTwitterHandler() {
  var textAreaChecked = sesJqueryObject('#twitter_handler:checkbox:checked').length > 0;
  var tweet_textarea_value = sesJqueryObject('#sestweet_twilighter_input').val();  
  var string = tweet_textarea_value;  
  var twitterHandler = '@'+sestweet_twitter_handler;
  idx = tweet_textarea_value.indexOf('@');

  if (idx > 0) {
    var via = tweet_textarea_value.lastIndexOf("@");   
    lastidx = tweet_textarea_value.lastIndexOf(' ');
    if(textAreaChecked == false) {
      var twitterHandler = '';
    }
    if(!twitterHandler) {
      var lastidxstr = tweet_textarea_value.substr(tweet_textarea_value.length - 1, tweet_textarea_value.length);
      lastidxstr = lastidxstr.replace(' ', '');
      if(via > lastidx) {
        string = string.replaceBetween(via, string.length, twitterHandler);
      } else {  
        string = string.replaceBetween(via, lastidx, twitterHandler);
      }
    } else {
      string = string + twitterHandler;
    }
  } else {
      string = string + twitterHandler;
  }
  sesJqueryObject('#sestweet_twilighter_input').val(string); 
    updateCountdown();
  return;
  var twitterHandler = ' @'+sestweet_twitter_handler;
  if(textAreaChecked == true) {
    
    sesJqueryObject('#sestweet_twilighter_input').val(tweet_textarea_value + twitterHandler);
    updateCountdown();
  } else {
    var myNewString = tweet_textarea_value.replace(twitterHandler, "");
    sesJqueryObject('#sestweet_twilighter_input').val(myNewString); 
    updateCountdown();
  }

}

String.prototype.replaceBetween = function(start, end, what) { 
  return this.substring(0, start) + what + this.substring(end);
  
};