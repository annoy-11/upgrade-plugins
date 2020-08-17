//MAP CODE 
//initialize default values
var mapSesqa;
var infowindowSesqa;
var markerSesqa;
function initializeSesQaMap() {
  var mapOptions = {
    center: new google.maps.LatLng(-33.8688, 151.2195),
    zoom: 17
  };
   mapSesqa = new google.maps.Map(document.getElementById('map-canvas'),
    mapOptions);

  var input = document.getElementById('locationSesList');

  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.bindTo('bounds', mapSesqa);

   infowindowSesqa = new google.maps.InfoWindow();
   markerSesqa = new google.maps.Marker({
    map: mapSesqa,
    anchorPoint: new google.maps.Point(0, -29)
  });

  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    infowindowSesqa.close();
    markerSesqa.setVisible(false);
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      mapSesqa.fitBounds(place.geometry.viewport);
    } else {
      mapSesqa.setCenter(place.geometry.location);
      mapSesqa.setZoom(17);  // Why 17? Because it looks good.
    }
    markerSesqa.setIcon(/** @type {google.maps.Icon} */({
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(35, 35)
    }));
		document.getElementById('lngSesList').value = place.geometry.location.lng();
		document.getElementById('latSesList').value = place.geometry.location.lat();
    markerSesqa.setPosition(place.geometry.location);
    markerSesqa.setVisible(true);

    var address = '';
    if (place.address_components) {
      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || '')
      ].join(' ');
    }
    infowindowSesqa.setContent('<div><strong>' + place.name + '</strong><br>' + address);
    infowindowSesqa.open(mapSesqa, markerSesqa);
		return false;
  }); 
	google.maps.event.addDomListener(window, 'load', initializeSesQaMap);
}

sesJqueryObject(document).on('click','.sesqa_share_button_toggle',function(){
	if(sesJqueryObject(this).hasClass('open')){
		sesJqueryObject(this).removeClass('open');
	}else{
		sesJqueryObject('.sesqa_share_button_toggle').removeClass('open');
		sesJqueryObject(this).addClass('open');
	}
		return false;
});
sesJqueryObject(document).click(function(){
	sesJqueryObject('.sesqa_share_button_toggle').removeClass('open');
});

//list page map 
function initializeSesQaMapList() {
  var input =document.getElementById('locationSesList');  
  var autocomplete = new google.maps.places.Autocomplete(input);
  google.maps.event.addListener(autocomplete, 'place_changed', function() {    
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }
    document.getElementById('lngSesList').value = place.geometry.location.lng();
    document.getElementById('latSesList').value = place.geometry.location.lat();
  }); 
}
function editMarkerOnMapSesqaEdit(){
  geocoder = new google.maps.Geocoder();
	var address = trim(document.getElementById('locationSesList').value);
	var lat = document.getElementById('latSesList').value;
	var lng = document.getElementById('lngSesList').value;
 
  var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
          mapSesqa.setZoom(17);
          markerSesqa = new google.maps.Marker({
              position: latlng,
              map: mapSesqa
          });
          markerSesqa.setVisible(true);
          infowindowSesqa.setContent(results[0].formatted_address);
          infowindowSesqa.open(mapSesqa, markerSesqa);
      } else {
        console.log("Map failed to show location due to: " + status);
      }
    });  
}
(function() { // START NAMESPACE
var $ = 'id' in document ? document.id : window.$;

en4.question = {

  urls : {
    vote : 'sesqa/index/vote/',
    login : 'login'
  },

  data : {},

  addPollDataSesqa : function(identity, data) {
    if( $type(data) != 'object' ) {
      data = {};
    }
    data = $H(data);
    this.data[identity] = data;
    return this;
  },

  getPollDatumSesqa : function(identity, key, defaultValue) {
    if( !defaultValue ) {
      defaultValue = false;
    }
    if( !(identity in this.data) ) {
      return defaultValue;
    }
    if( !(key in this.data[identity]) ) {
      return defaultValue;
    }
    return this.data[identity][key];
  },

  toggleResultsSesqa : function(identity) {
    var pollContainer = $('question_form_' + identity);
    if( 'none' == pollContainer.getElement('.question_options div.question_has_voted').getStyle('display') ) {
      pollContainer.getElements('.question_options div.question_has_voted').show();
      pollContainer.getElements('.question_options div.question_not_voted').hide();
      pollContainer.getElement('.question_toggleResultsLink').set('text', en4.core.language.translate('Show Questions'));
    } else {
      pollContainer.getElements('.question_options div.question_has_voted').hide();
      pollContainer.getElements('.question_options div.question_not_voted').show();
      pollContainer.getElement('.question_toggleResultsLink').set('text', en4.core.language.translate('Show Results'));
    }
  },

  renderResultsSesqa : function(identity, answers, votes) {
    if( !answers || 'array' != $type(answers) ) {
      return;
    }
    var pollContainer = $('question_form_' + identity);
    answers.each(function(option) {
      var div = $('question-answer-' + option.poll_option_id);
      var pct = votes > 0
              ? Math.floor(100*(option.votes / votes))
              : 1;
      if (pct < 1)
          pct = 1;
      // set width to 70% of actual width to fit text on same line
      div.style.width = (.7*pct)+'%';
      div.getNext('div.question_answer_total')
         .set('text',  option.votesTranslated + ' (' + en4.core.language.translate('%1$s%%', (option.votes ? pct : '0')) + ')');
             
      if( !this.getPollDatumSesqa(identity, 'canVote') || (!this.getPollDatumSesqa(identity, 'canChangeVote')) ||
          this.getPollDatumSesqa(identity, 'isClosed') ) {
        sesJqueryObject('#question_form_' + identity).find('.question_radio input').attr('disabled', 'disabled');
      }
    }.bind(this));
  },

  voteSesqa: function(identity, option) {
    if( !en4.user.viewer.id ) {
      window.location.href = this.urls.login + '?return_url=' + encodeURIComponent(window.location.href);
      return;
    }
    
    if( $type(option) != 'element' )
      return;

    option = $(option);
    var pollContainer = $('question_form_' + identity);
    var value = option.value;

    $('question_radio_' + option.value).toggleClass('question_radio_loading');
    var token = this.data[identity].csrfToken;
    var self = this;
    var request = new Request.JSON({
      url: this.urls.vote + '/' + identity,
      method: 'post',
      data : {
        'format' : 'json',
        'question_id' : identity,
        'option_id' : value,
        'token': token
      },
      onComplete: function(responseJSON) {
        $('question_radio_' + option.value).toggleClass('question_radio_loading');
        if( $type(responseJSON) == 'object' && responseJSON.error ) {
          Smoothbox.open(new Element('div', {
            'html' : responseJSON.error
              + '<br /><br /><button onclick="parent.Smoothbox.close()">'
              + en4.core.language.translate('Close')
              + '</button>'
          }));
        } else {
          pollContainer.getElement('.question_vote_total')
            .set('text', en4.core.language.translate(['%1$s vote', '%1$s votes', responseJSON.votes_total], responseJSON.votes_total));
          this.renderResultsSesqa(identity, responseJSON.questionOptions, responseJSON.votes_total);
          this.toggleResultsSesqa(identity);
          self.data[identity].csrfToken = responseJSON.token;
        }
        if( !this.getPollDatumSesqa(identity, 'canChangeVote')){
            sesJqueryObject('#question_form_' + identity).find('.question_radio input').attr('disabled', 'disabled');
        }
      }.bind(this)
    });
    request.send()
  }
};
})(); // END NAMESPACE


sesJqueryObject(document).on('click','.sesqa_upvote_btn_a',function(){
  if(sesJqueryObject(this).hasClass('_disabled'))
    return;
  if(sesJqueryObject(this).closest('.sesqa_vote').hasClass('active'))
    return;
  sesJqueryObject(this).closest('.sesqa_vote').addClass('active');
  var itemguid  = sesJqueryObject(this).data('itemguid');
  var that = this;
  var userguid  = sesJqueryObject(this).data('userguid');
  var url  = en4.core.baseUrl + 'sesqa/index/voteup';
  new Request.HTML({
      'url' : url,
      'data' : {
        'format' : 'html',
        'itemguid' : itemguid,
        'userguid':userguid,
        'type':'upvote',
      },
      'onComplete' : function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if( responseHTML ) {
          sesJqueryObject(that).closest('.sesqa_vote').replaceWith(responseHTML);
        }
        sesJqueryObject(that).closest('.sesqa_vote').removeClass('active');
      }
    }).send();  
});
sesJqueryObject(document).on('click','.sesqa_downvote_btn_a',function(){
  if(sesJqueryObject(this).hasClass('_disabled'))
    return;
  if(sesJqueryObject(this).closest('.sesqa_vote').hasClass('active'))
    return;
  sesJqueryObject(this).closest('.sesqa_vote').addClass('active');
  var itemguid  = sesJqueryObject(this).data('itemguid');
  var that = this;
  var userguid  = sesJqueryObject(this).data('userguid');
  var url  = en4.core.baseUrl + 'sesqa/index/voteup';
  new Request.HTML({
      'url' : url,
      'data' : {
        'format' : 'html',
        'itemguid' : itemguid,
        'userguid':userguid,
        'type':'downvote',
      },
      'onComplete' : function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if( responseHTML ) {
          sesJqueryObject(that).closest('.sesqa_vote').replaceWith(responseHTML);
        }
        sesJqueryObject(that).closest('.sesqa_vote').removeClass('active');
      }
    }).send();  
})

//common function for like comment ajax
function like_favourite_data_sesqa(element,functionName,itemType,likeNoti,unLikeNoti,className){
		if(!sesJqueryObject(element).attr('data-url'))
			return;
		if(sesJqueryObject(element).hasClass('button_active')){
				sesJqueryObject(element).removeClass('button_active');
		}else
				sesJqueryObject(element).addClass('button_active');
		 (new Request.HTML({
      method: 'post',
      'url':  en4.core.baseUrl + 'sesqa/index/'+functionName,
      'data': {
        format: 'html',
        id: sesJqueryObject(element).attr('data-url'),
				type:itemType,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        var response =jQuery.parseJSON( responseHTML );
				if(response.error)
					alert(en4.core.language.translate('Something went wrong,please try again later'));
				else{
					sesJqueryObject(element).find('span').html(response.count);
					if(response.condition == 'reduced'){
							sesJqueryObject(element).removeClass('button_active');
              sesJqueryObject(element).find('span').html(response.count);
							showTooltipqa(10,10,unLikeNoti);
              if(functionName == "like"){
                //sesJqueryObject(element).find('i').removeClass('fa-thumbs-down');
                //sesJqueryObject(element).find('i').addClass('fa-thumbs-up');  
              }
							return true;
					}else{
							sesJqueryObject(element).addClass('button_active');
              sesJqueryObject(element).find('span').html(response.count);
							showTooltipqa(10,10,likeNoti,className)
              if(functionName == "like"){
                 //sesJqueryObject(element).find('i').addClass('fa-thumbs-down');
                //sesJqueryObject(element).find('i').removeClass('fa-thumbs-up');  
              }
							return false;
					}
				}
      }
    })).send();
}
function showTooltipqa(x, y, contents, className) {
	if(sesJqueryObject('.sesbasic_notification').length > 0)
		sesJqueryObject('.sesbasic_notification').hide();
	sesJqueryObject('<div class="sesbasic_notification '+className+'">' + contents + '</div>').css( {
		display: 'block',
	}).appendTo("body").fadeOut(5000,'',function(){
		sesJqueryObject(this).remove();	
	});
}
sesJqueryObject(document).on('click','.sesqa_favourite_question',function(){
	like_favourite_data_sesqa(this,'favourite','sesqa_question','<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("Question added as Favourite successfully"))+'</span>','<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("Question Unfavourited successfully"))+'</span>','sesbasic_favourites_notification');
});
sesJqueryObject(document).on('click','.sesqa_like_question',function(){
	like_favourite_data_sesqa(this,'like','sesqa_question','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Question Liked successfully"))+'</span>','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Question Unliked successfully"))+'</span>','sesbasic_liked_notification');
});

sesJqueryObject(document).on('click', '.sesqa_follow_question', function () {
	var element = sesJqueryObject(this);
  if (!sesJqueryObject (element).attr('data-url'))
  return;
  var id = sesJqueryObject (element).attr('data-url');
  if (sesJqueryObject (element).find('i').hasClass('fa-check')){
  	sesJqueryObject (element).find('i').removeClass('fa-check').addClass('fa-times');
		sesJqueryObject (element).find('span').html(en4.core.language.translate('Unfollow'));
	}
  else{
  	sesJqueryObject (element).find('i').removeClass('fa-times').addClass('fa-check');
		sesJqueryObject (element).find('span').html(en4.core.language.translate('Follow'));
	}
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'sesqa/index/follow',
    'data': {
      format: 'html',
      id: sesJqueryObject (element).attr('data-url'),
      type: itemType,
    },
    onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
      var response = jQuery.parseJSON(responseHTML);
      if (response.error)
      	alert(en4.core.language.translate('Something went wrong,please try again later'));
      else {
					var elementCount = '.sesqa_follow_question_'+id;
					//sesJqueryObject (elementCount).find('span').html(response.count);
					if (response.condition == 'reduced') {
            sesJqueryObject (elementCount).removeClass('button_active');
						sesJqueryObject (elementCount).find('i').removeClass('fa-times').addClass('fa-check');
						sesJqueryObject (elementCount).find('i').attr('title',en4.core.language.translate('Follow'));
						showTooltipSesbasic('10','10','<i class="fa fa-times"></i><span>'+(en4.core.language.translate("Question unfollow successfully"))+'</span>','sesbasic_unfollow_notification');
					}
					else {
            sesJqueryObject (elementCount).addClass('button_active');
						sesJqueryObject (elementCount).find('i').attr('title',en4.core.language.translate('Unfollow'));
						sesJqueryObject (elementCount).find('i').removeClass('fa-check').addClass('fa-times');
						showTooltipSesbasic('10','10','<i class="fa fa-check"></i><span>'+(en4.core.language.translate("Question follow successfully"))+'</span>','sesbasic_follow_notification');
					}
      }
      return true;
    }
  })).send();
});

sesJqueryObject(document).on('click','.editanswersesqa',function(){
    var id = sesJqueryObject(this).data('id');
    if(!id)
      return;
    var elem = sesJqueryObject(this).closest('.sesqa_view_ans_item').find('.question_description');
    sesJqueryObject(elem).find('.sesquestion_description').hide();
    sesJqueryObject(elem).find('.edit_cnt').show();
    sesJqueryObject(elem).find('.sesqa_social').hide();
    sesJqueryObject(elem).find('.cancel_cnt').show();
    sesJqueryObject(elem).find('.edit_cnt').html('<textarea class="sesqa_answer_editor" id="sesqa_answer_editor"></textarea>');
    sesJqueryObject('.sesqa_answer_editor').html(sesJqueryObject(elem).find('.sesquestion_description').html());
    if(tinymceEnableAnswer == 1){
    tinymce.init({
			mode: "specific_textareas",
			plugins: "table,fullscreen,media,preview,paste,code,image,textcolor,jbimages,link",
			theme: "modern",
			menubar: false,
			statusbar: false,
			toolbar1:  "undo,redo,removeformat,pastetext,|,code,media,image,jbimages,link,fullscreen,preview",
			toolbar2: "fontselect,fontsizeselect,bold,italic,underline,strikethrough,forecolor,backcolor,|,alignleft,aligncenter,alignright,alignjustify,|,bullist,numlist,|,outdent,indent,blockquote",
			toolbar3: "",
			element_format: "html",
			height: "225px",
      content_css: "bbcode.css",
      entity_encoding: "raw",
      add_unload_trigger: "0",
      remove_linebreaks: false,
			convert_urls: false,
			language: sesqa_language,
			directionality: sesqa_direction,
			upload_url: sesqa_upload_url,
			editor_selector: "sesqa_answer_editor"
		});
    }
});

sesJqueryObject(document).on('click','.cancelanswersesqa',function(){
     var id = sesJqueryObject(this).data('id');
     if(!id)
      return;
     var elem = sesJqueryObject(this).closest('.cancel_cnt').parent();
      sesJqueryObject(elem).find('.sesquestion_description').show();
      sesJqueryObject(elem).find('.edit_cnt').hide();
      sesJqueryObject(elem).find('.sesqa_social').show();
      sesJqueryObject(elem).find('.cancel_cnt').hide();
      sesJqueryObject(elem).find('.edit_cnt').html('');
});
sesJqueryObject(document).on('click','.saveanswersesqa',function(){
     var id = sesJqueryObject(this).data('id');
     if(!id)
      return;
     var elem = sesJqueryObject(this).closest('.cancel_cnt').parent();
     if(tinymceEnableAnswer == 1){
      var content = tinyMCE.get('sesqa_answer_editor').getContent();
     }else{
      var content =   sesJqueryObject('#sesqa_answer_editor').val();
     }
     if(!content)
      return;
     sesJqueryObject(elem).find('.sesquestion_description').html(content);
     sesJqueryObject(elem).find('.sesquestion_description').show();
     sesJqueryObject(elem).find('.edit_cnt').hide();
     sesJqueryObject(elem).find('.sesqa_social').show();
     sesJqueryObject(elem).find('.cancel_cnt').hide();
     sesJqueryObject(elem).find('.edit_cnt').html('');
     (new Request.HTML({
      method: 'post',
      'url':en4.core.baseUrl + 'sesqa/index/edit-answer',
      'data': {
        format: 'html',
        id: id,
        data:content,
      },
      onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
        var response = jQuery.parseJSON(responseHTML);
        if (response.error)
          alert(en4.core.language.translate('Something went wrong,please try again later'));
        else {
          console.log(sesJqueryObject(elem));
           sesJqueryObject(elem).find('.sesquestion_description').html(content);
        }
        return true;
      }
    })).send();
});

sesJqueryObject(document).on('click','.sesqa_comment_a',function(){
  var elem = sesJqueryObject(this).parent();
  sesJqueryObject(elem).find('.sesqa_comment_a').hide();
  sesJqueryObject(elem).find('.sesqa_cmt').show();  
})
sesJqueryObject(document).on('click','.markbestsesqa',function(){
  var id = sesJqueryObject(this).data('id');
  if(sesJqueryObject(this).hasClass('active'))
    return;
    var elem = sesJqueryObject(this);
  sesJqueryObject(this).addClass('active');
  (new Request.HTML({
      method: 'post',
      'url':en4.core.baseUrl + 'sesqa/index/mark-best',
      'data': {
        format: 'html',
        id: id,
      },
      onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
        sesJqueryObject(elem).removeClass('active')
        var response = jQuery.parseJSON(responseHTML);
        if (response.error)
          alert(en4.core.language.translate('Something went wrong,please try again later'));
        else {
           sesJqueryObject('.sesqa_vote_btn').removeClass('vote_checked');
           if(response.ismark == 1){
              sesJqueryObject(elem).addClass('vote_checked');
           }
           //sesJqueryObject(elem).find('.sesquestion_description').html(content);
        }
        return true;
      }
    })).send();
});
function removeAnswerDiv(){
  sesJqueryObject(parentClickElementA).closest('.sesqa_view_ans_item').remove();  
}
var parentClickElementA = '';
sesJqueryObject(document).on('click','.deleteanswersesqa',function(){
  var id = sesJqueryObject(this).data('id');
  parentClickElementA = sesJqueryObject(this);
  openSmoothBoxInUrl(en4.core.baseUrl + 'sesqa/index/delete-answer/answer_id/'+id);
});
function getLikeDataQA(value,title){
	if(value){
		url = en4.core.staticBaseUrl+'sesqa/index/like-question/question_id/'+value+'/title/'+title;
		openURLinSmoothBox(url);	
		return;
	}
}
function getFollowDataQA(value,title){
	if(value){
		url = en4.core.staticBaseUrl+'sesqa/index/follow-question/question_id/'+value+'/title/'+title;
		openURLinSmoothBox(url);	
		return;
	}
}
function getFavouriteDataQA(value,title){
	if(value){
		url = en4.core.staticBaseUrl+'sesqa/index/fav-question/question_id/'+value+'/title/'+title;
		openURLinSmoothBox(url);	
		return;
	}
}