sesJqueryObject(document).on('click','.sescontest_likefavfollow',function(){
	sescontest_likefavourite_data(this,'sescontest_likefavfollow');
});
sesJqueryObject(document).on('click','.selectvoting',function(){
   var elem = sesJqueryObject(this);
   var parent = sesJqueryObject(this).parent();
   var value = parent.attr('rel'); 
   sesJqueryObject(parent).find('._votebtn').show();
   sesJqueryObject('#submitdatavalue').val(sesJqueryObject('#submitdatavalue').val() + value+' ');
});
sesJqueryObject(document).on('click','.deselectvoting',function(){
   var elem = sesJqueryObject(this);
   var parent = sesJqueryObject(this).parent();
   var value = parent.attr('rel');
   sesJqueryObject(elem).hide();
   sesJqueryObject('#submitdatavalue').val(sesJqueryObject('#submitdatavalue').val().replace(value+' ',''));
});
//common function for like comment ajax
function sescontest_likefavourite_data(element) {
    if (!sesJqueryObject(element).attr('data-type'))
		return;
    var clickType = sesJqueryObject(element).attr('data-type');
    var functionName;
    var itemType;
    var contentId;
    var classType;
    var canIntegrate = 0;
    if(clickType == 'like_entry_view') {
      canIntegrate = sesJqueryObject(element).attr('data-integrate');
      functionName = 'like';
      itemType = 'participant';
      var contentId = sesJqueryObject(element).attr('data-url');
      var elementId = '.sescontest_entry_like_'+contentId;
      if(sesJqueryObject(elementId).hasClass('button_active')) {
        sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html())-1);
      }
      else {
        sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html())+1);
      }
    }
    else if(clickType == 'favourite_entry_view') {
      functionName = 'favourite';
      itemType = 'participant';
      var contentId = sesJqueryObject(element).attr('data-url');
      var elementId = '.sescontest_entry_favourite_'+contentId;
      if(sesJqueryObject(elementId).hasClass('button_active')) {
        sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html())-1);
      }
      else {
        sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html())+1);
      }
    }
    else if(clickType == 'like_view') {
      functionName = 'like';
      itemType = 'contest';
      var contentId = sesJqueryObject(element).attr('data-url');
      var elementId = '.sescontest_like_'+contentId;
      if(sesJqueryObject(elementId).hasClass('button_active')) {
        sesJqueryObject(elementId).attr('title','Like');
        sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html())-1);
      }
      else {
        sesJqueryObject(elementId).attr('title','Unlike');
        sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html())+1);
      }
    }
    else if(clickType == 'like_contest_button_view') {
      classType = 'secontest_like_contest_view';
      functionName = 'like';
      itemType = 'contest';
      contentId = sesJqueryObject(element).attr('data-url');
      var elementId = '.sescontest_like_'+contentId;
      if (sesJqueryObject(element).data('status') == 1) {
        sesJqueryObject('.sescontest_like_view_'+contentId).html('<i class="fa fa-thumbs-up"></i><span>'+en4.core.language.translate("Like")+'</span>');
        sesJqueryObject('.sescontest_like_contest_view').data("status",0);
      }
      else {
        sesJqueryObject('.sescontest_like_view_'+contentId).html('<i class="fa fa-thumbs-down"></i><span>'+en4.core.language.translate("Unlike")+'</span>');
        sesJqueryObject('.sescontest_like_contest_view').data("status",1);
      }
    }
    else if(clickType == 'favourite_view') {
      functionName = 'favourite';
      itemType = 'contest';
      contentId = sesJqueryObject(element).attr('data-url');
      var elementId = '.sescontest_favourite_'+contentId;

      if(sesJqueryObject(elementId).hasClass('button_active')) {
        sesJqueryObject(elementId).attr('title','Add to Favourite');
        sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html())-1);
      }
      else {
        sesJqueryObject(elementId).attr('title','Remove as Favourite');
        sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html())+1);
      }
    }
    else if(clickType == 'favourite_contest_button_view') {
      classType = 'secontest_favourite_contest_view';
      functionName = 'favourite';
      itemType = 'contest';
      contentId = sesJqueryObject(element).attr('data-url');
      var elementId = '.sescontest_favourite_'+contentId;
      if(sesJqueryObject(element).data('status') == 1) {
        sesJqueryObject('.sescontest_favourite_view_'+contentId).html('<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Add to Favorites")+'</span>');
        sesJqueryObject('.secontest_favourite_contest_view').data("status",0);
      }
      else {
        sesJqueryObject('.sescontest_favourite_view_'+contentId).html('<i class="fa fa-heart-o"></i><span>'+en4.core.language.translate("Favorited")+'</span>');
        sesJqueryObject('.secontest_favourite_contest_view').data("status",1);
      }
    }
    else if(clickType == 'follow_view') {
      functionName = 'follow';
      itemType = 'contest';
      contentId = sesJqueryObject(element).attr('data-url');
      var elementId = '.sescontest_follow_'+contentId;

      if(sesJqueryObject(elementId).hasClass('button_active')) {
        sesJqueryObject(elementId).attr('title','Follow');
        sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html())-1);
      }
      else {
        sesJqueryObject(elementId).attr('title','Unfollow');
        sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html())+1);
      }
    }
    else if(clickType == 'follow_contest_button_view') {
      classType = 'secontest_follow_contest_view';
      functionName = 'follow';
      itemType = 'contest';
      contentId = sesJqueryObject(element).attr('data-url');
      var elementId = '.sescontest_follow_'+contentId;
      if(sesJqueryObject(element).data('status') == 1) {
        sesJqueryObject('.sescontest_follow_view_'+contentId).html('<i class="fa fa-check"></i><span>'+en4.core.language.translate("Follow")+'</span>');
        sesJqueryObject('.sescontest_follow_contest_view').data("status",0);
      }
      else {
        sesJqueryObject('.sescontest_follow_view_'+contentId).html('<i class="fa fa-times"></i><span>'+en4.core.language.translate("UnFollow")+'</span>');
        sesJqueryObject('.sescontest_follow_contest_view').data("status",1);
      }
    }
	if (!sesJqueryObject(element).attr('data-url'))
		return;
    
	if (sesJqueryObject(element).hasClass('button_active')) {
		sesJqueryObject(element).removeClass('button_active');
	} else
		sesJqueryObject(element).addClass('button_active');
	(new Request.HTML({
		method: 'post',
		'url': en4.core.baseUrl + 'sescontest/ajax/' + functionName,
		'data': {
          format: 'html',
          id: contentId,
          type: itemType,
          integration:canIntegrate,
		},
		onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
			var response = jQuery.parseJSON(responseHTML);
			if (response.error)
				alert(en4.core.language.translate('Something went wrong,please try again later'));
			else {
              sesJqueryObject(elementId).find('span').html(response.count);
              if (response.condition == 'reduced') {
                sesJqueryObject(elementId).removeClass('button_active');
              } 
              else {
                sesJqueryObject (elementId).addClass('button_active');
              }
			}
            if(canIntegrate == 1 && response.vote_status) {
              sesJqueryObject('#sescontest_vote_button_'+contentId).html('<i class="fa fa-hand-o-up"></i><span>Voted</span>');
              sesJqueryObject('#sescontest_vote_button_'+contentId).addClass('disable');
            }
		  return true;
		}
	})).send();
}

(function(){
  var serverOffset = 0;

  Date.setServerOffset = function(ts){
    var server = new Date(ts);
    var client = new Date();
    serverOffset = server - client;
  };

  Date.getServerOffset = function() {
    return serverOffset;
  };
  
  Date.implement({
     getISODay : function()
    {
      var day = this.get('day') - 1;
      if( day < 0 ) day += 7;
      return day;
    },

    getISOWeek : function()
    {
      var compare = this.clone().set({
        month : 1,
        date : 4
      });
      var startOfWeekYear = compare.get('dayofyear') - compare.getISODay() - 1;
      return ( (this.get('dayofyear') - startOfWeekYear) / 7 ).ceil();
    },
    getFluentTimeSinceContest : function(now)
    {
      var ref = this;
      var val;
      if( !now ) now = new Date();
      var deltaNormal = (ref - now - serverOffset) / 1000;
      //var deltaNormal = (now - ref + serverOffset) / 1000;
      var delta = Math.abs(deltaNormal);
      var isPlus = (deltaNormal > 0);
      
      var distance = new Date(this).getTime() - now.getTime();
      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      return [days,hours,minutes,seconds];
    },
    getFluentTimeSinceContestMiddle : function(now)
    {
      var ref = this;
      var val;
      if( !now ) now = new Date();
      var deltaNormal = (ref - now - serverOffset) / 1000;
      //var deltaNormal = (now - ref + serverOffset) / 1000;
      var delta = Math.abs(deltaNormal);
      var isPlus = (deltaNormal > 0);
      
      var distance = new Date(this).getTime() - now.getTime();
      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      if(days <=0 && hours <=0 && minutes <=0 && seconds <=0) {
        return "false";
      }
      return [days,hours,minutes,seconds];
    }
  });
   window.addEvent('load', function()
  {
    (function(){
      var now = new Date();
      $$('.sescontest-timestamp-middle').each(function(element){
        var ref = new Date(element.title);
        var newStamp = ref.getFluentTimeSinceContestMiddle(now);
        if(typeof newStamp == "string"){
          sesJqueryObject(element).parent().parent().parent().parent().hide();
        }else{
          sesJqueryObject(element).parent().parent().parent().show();
          var obj = sesJqueryObject(element).parent().parent().find('.time_circles');
          obj.find('.textDiv_Days').find('span').html(newStamp[0]);
          obj.find('.textDiv_Hours').find('span').html(newStamp[1]);
          obj.find('.textDiv_Minutes').find('span').html(newStamp[2]);
          obj.find('.textDiv_Seconds').find('span').html(newStamp[3]);
        }
      });
    }).periodical(1000);
  });
  window.addEvent('load', function()
  {
    (function(){
      var now = new Date();
      $$('.sescontest-timestamp-update').each(function(element){
        var ref = new Date(element.title);
        var newStamp = ref.getFluentTimeSinceContest(now);
        var obj = sesJqueryObject(element).closest('.countdown-contest');
        
        if(newStamp[0] <= 0 && newStamp[1] <= 0 && newStamp[2] <= 0 && newStamp[3] <= 0) {
          var obj = sesJqueryObject(element).closest('.sescontest_countdown_mini');
          if(obj.length <= 0) {
            obj = sesJqueryObject(element).closest('.sescontest_countdown_view');
          }
          obj.find('.countdown-contest').hide();
          obj.find('.finish-message').show();
        }
        obj.find('.day').html(newStamp[0]);
        obj.find('.hour').html(newStamp[1]);
        obj.find('.minute').html(newStamp[2]);
        obj.find('.second').html(newStamp[3]);
      });
    }).periodical(1000);
  });
  })();
  function categorySlider(autoplay, obj, arow, centerMode,infinite) {
    sesBasicAutoScroll(obj).slick({
      infinite: infinite,
      autoplay:autoplay,
      arrows: arow,
      dots: true,
      slidesToShow: 1,
      variableWidth: true,
      slidesToScroll: 1,
      dots:false,
      centerMode: centerMode,
    });
    sesJqueryObject(obj).removeClass('contest_carousel');
  }
  function makeSlidesObject() {
   var elm = sesJqueryObject('.contest_carousel');
    for(i=0; i<elm.length;i++) {
      var autoPlay  = false;
      var infinite  = false;
      var arow = false;
      var centerMode = false;
      var width = sesJqueryObject(elm[i]).data('width');
     if(sesJqueryObject(elm[i]).attr('rel')*width > sesJqueryObject(elm[i]).width()) {
       autoPlay = false;
       arow = true;
       centerMode = true;
       infinite  = true;
     }
     categorySlider(autoPlay, sesJqueryObject(elm[i]),arow, centerMode,infinite);
    }   
  }
  sesJqueryObject(document).on('ready', function() {
   makeSlidesObject();
  });
	
	// Category Slideshow
	function categorySlidshow(autoplay, obj, arow, centerMode) {
    sesBasicAutoScroll(obj).slick({
      infinite: false,
	  centerPadding:'0px',
      autoplay:false,
      arrows: arow,
      dots: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      dots:false,
    })
  }
  sesJqueryObject(document).on('ready', function() {
    var elm = sesJqueryObject('.sescontest_category_slideshow');
    for(i=0; i<elm.length;i++) {
      var autoPlay  = false;
      var arow = false;
      var centerMode = false;
	  var width = sesJqueryObject(elm[i]).data('width');
      if(sesJqueryObject(elm[i]).attr('rel') > 1) {
        autoPlay = true;
        arow = true;
      }
      categorySlidshow(autoPlay, sesJqueryObject(elm[i]),arow, centerMode);
    }
  });
	
//open sidebar share buttons
sesJqueryObject(document).on('click','.sescontest_sidebar_option_btn',function(){
	if(sesJqueryObject(this).hasClass('open')){
		sesJqueryObject(this).removeClass('open');
	}else{
		sesJqueryObject('.sescontest_sidebar_option_btn').removeClass('open');
		sesJqueryObject(this).addClass('open');
	}
		return false;
});
sesJqueryObject(document).click(function(){
	sesJqueryObject('.sescontest_sidebar_option_btn').removeClass('open');
});

function openURLinSmoothBox(openURLsmoothbox){
  Smoothbox.open(openURLsmoothbox);
  parent.Smoothbox.close;
  return false;
}

