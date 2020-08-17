


//initialize default values
var locationcreatedata;
var formObj;
var map_store;
var infowindow_store;
var marker_store;
var mapLoad_classroom = true;
//list store map
function initializeSesClassroomMapList() {
  if (mapLoad_classroom) {
    var mapOptions = {
      center: new google.maps.LatLng(-33.8688, 151.2195),
      zoom: 17
    };
    map_store = new google.maps.Map(document.getElementById('map-canvas-list'),
            mapOptions);
  }
  if (sesJqueryObject('#locationSes').length)
    var input = document.getElementById('locationSes');
  else
    var input = document.getElementById('locationSesList');

  var autocomplete = new google.maps.places.Autocomplete(input);
  if (mapLoad_classroom)
    autocomplete.bindTo('bounds', map);


  if (mapLoad_classroom) {
    infowindow_store = new google.maps.InfoWindow();
    marker_store = new google.maps.Marker({
      map: map_store,
      anchorPoint: new google.maps.Point(0, -29)
    });
  }
  google.maps.event.addListener(autocomplete, 'place_changed', function () {

    if (mapLoad_classroom) {
      infowindow_store.close();
      marker_store.setVisible(false);
    }
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }
    if (mapLoad_classroom) {
      // If the place has a geometry, then present it on a map.
      if (place.geometry.viewport) {
        map_store.fitBounds(place.geometry.viewport);
      } else {
        map_store.setCenter(place.geometry.location);
        map_store.setZoom(17);  // Why 17? Because it looks good.
      }
      marker_store.setIcon(/** @type {google.maps.Icon} */({
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(35, 35)
      }));
    }
    if (sesJqueryObject('#locationSes').length) {
      document.getElementById('lngSes').value = place.geometry.location.lng();
      document.getElementById('latSes').value = place.geometry.location.lat();
    } else {
      document.getElementById('lngSesList').value = place.geometry.location.lng();
      document.getElementById('latSesList').value = place.geometry.location.lat();
    }
    if (mapLoad_classroom) {
      marker_store.setPosition(place.geometry.location);
      marker_store.setVisible(true);
    }
    var address = '';
    if (place.address_components) {
      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || '')
      ].join(' ');
    }
    if (mapLoad_classroom) {
      infowindow_store.setContent('<div><strong>' + place.name + '</strong><br>' + address);
      infowindow_store.open(map_store, marker_store);
      return false;
    }
  });
  if (mapLoad_classroom) {
    google.maps.event.addDomListener(window, 'load', initializeSesClassroomMapList);
  }
}
//list classroom map
function initializeSesClassroomMapList() {
  if (sesJqueryObject('#locationSes').length)
    var input = document.getElementById('locationSes');
  else
    var input = document.getElementById('locationSesList');

  var autocomplete = new google.maps.places.Autocomplete(input);

  google.maps.event.addListener(autocomplete, 'place_changed', function () {
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }
    if (sesJqueryObject('#locationSes').length) {
      document.getElementById('lngSes').value = place.geometry.location.lng();
      document.getElementById('latSes').value = place.geometry.location.lat();
    } else {
      document.getElementById('lngSesList').value = place.geometry.location.lng();
      document.getElementById('latSesList').value = place.geometry.location.lat();
    }
    if (typeof createClassroomLoadMap == 'function')
      createClassroomLoadMap();
  });
}
sesJqueryObject(document).on('click', '#dragandrophandlereclassroomlocation', function () {
  document.getElementById('file_multi').click();
});
sesJqueryObject(document).on('click', '.delete_image_upload_classroomlocation', function (e) {
  e.preventDefault();
  sesJqueryObject(this).parent().parent().find('.classroom_upload_item_overlay').css('display', 'block');
  var sesthat = this;
  var photo_id = sesJqueryObject(this).closest('.classroom_upload_item_options').attr('data-src');
  if (photo_id) {
    request = new Request.JSON({
      'format': 'json',
      'url': classroomPhotoDeleteUrl,
      'data': {
        'locationphoto_id': photo_id
      },
      onSuccess: function (responseJSON) {
        parent.sesJqueryObject('#classroom_locationphoto_' + photo_id).remove();
        sesJqueryObject(sesthat).parent().parent().remove();
        sesJqueryObject('#classroom_location_' + photo_id).remove();
        if (sesJqueryObject('#show_photo').html() == '') {
          sesJqueryObject('#show_photo_container').removeClass('iscontent');
        }
        return false;
      }
    });
    request.send();
  } else
    return false;
});
function removeClassLcationPhoto(photoId) {
  var removePhoto = new Request.JSON({
    'format': 'json',
    'url': classroomPhotoDeleteUrl,
    'data': {
      'locationphoto_id': photoId
    },
    onSuccess: function (responseJSON) { console.log('asdfsad');
      sesJqueryObject('#classroom_locationphoto_' + photoId).remove();
    }
  });
  removePhoto.send();
}
//Ajax error show before form submit
var error = false;
var objectError ;
var counter = 0;
function validateServiceform() {
  var errorPresent = false;
  sesJqueryObject('.classroomservice_formcheck input, .classroomservice_formcheck select, .classroomservice_formcheck checkbox, .classroomservice_formcheck textarea, .classroomservice_formcheck radio').each(
    function(index){
      var input = sesJqueryObject(this);
      if(sesJqueryObject(this).closest('div').parent().css('display') != 'none' && sesJqueryObject(this).closest('div').parent().find('.form-label').find('label').first().hasClass('required') && sesJqueryObject(this).prop('type') != 'hidden' && sesJqueryObject(this).closest('div').parent().attr('class') != 'form-elements'){
      if(sesJqueryObject(this).prop('type') == 'checkbox'){
        value = '';
        if(sesJqueryObject('input[name="'+sesJqueryObject(this).attr('name')+'"]:checked').length > 0) {
          value = 1;
        };
        if(value == '')
        error = true;
        else
        error = false;
      }
      else if(sesJqueryObject(this).prop('type') == 'select-multiple'){
        if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
        error = true;
        else
        error = false;
      }
      else if(sesJqueryObject(this).prop('type') == 'select-one' || sesJqueryObject(this).prop('type') == 'select' ){
        if(sesJqueryObject(this).val() === '')
        error = true;
        else
        error = false;
      }
      else if(sesJqueryObject(this).prop('type') == 'radio'){
        if(sesJqueryObject("input[name='"+sesJqueryObject(this).attr('name').replace('[]','')+"']:checked").val() === '')
        error = true;
        else
        error = false;
      }
      else if(sesJqueryObject(this).prop('type') == 'textarea' && sesJqueryObject(this).prop('id') == 'body'){
        if(tinyMCE.get('body').getContent() === '' || tinyMCE.get('body').getContent() == null)
        error = true;
        else
        error = false;
      }
      else if(sesJqueryObject(this).prop('type') == 'textarea') {
        if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
        error = true;
        else
        error = false;
      }
      else{
        if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
        error = true;
        else
        error = false;
      }
      if(error)
        errorPresent = true;
        error = false;
      }
    }
  );
  return errorPresent ;
}
sesJqueryObject(document).on('submit', '#classroomservice_addservice', function(e) {
  e.preventDefault();
  addService(this);
});

var sestooltipOrigin;
sesJqueryObject(document).on('mouseover mouseout', '.eclassroom_grid_item', function(event) {
	sesJqueryObject(this).tooltipster({
		  interactive: true,
		  content: '',
		  contentCloning: false,
		  contentAsHTML: true,
		  animation: 'fade',
		  updateAnimation:false,
		  functionBefore: function(origin, continueTooltip) {
			//get attr
			if(typeof sesJqueryObject(origin).attr('data-rel') == 'undefined')
			  var guid = sesJqueryObject(origin).attr('data-src');
			else
			  var guid = sesJqueryObject(origin).attr('data-rel');
			  // we'll make this function asynchronous and allow the tooltip to go ahead and show the loading notification while fetching our data.
			  continueTooltip();
			var data = "<div class='grid_hover_cont'>"+sesJqueryObject(this).children().find('.grid_hover_cont').html()+"<div>";
			origin.tooltipster('content', data);
		  },
      functionComplete:function (origin) {

      }
	});
	sesJqueryObject(this).tooltipster('show');
});

sesJqueryObject(document).on('click', '.eclassroom_likefavfollow', function () {
  eclassroom_likefavourite_data(this, 'eclassroom_likefavfollow');
});

var eclassroomTriggerFollow = false;
var eclassroomTriggerLike = false;
//common function for like comment ajax
function eclassroom_likefavourite_data(element) {
  if (!sesJqueryObject(element).attr('data-type'))
    return;
  var clickType = sesJqueryObject(element).attr('data-type');
  var functionName;
  var itemType;
  var contentId;
  var classType;
  var followTrigger = false;
  var likeTrigger = false;
  if (clickType == 'eclassroom_like_view') {
    functionName = 'like';
    itemType = 'classroom';
    var contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.eclassroom_like_' + contentId;
    if (sesJqueryObject(elementId).hasClass('button_active')) {
      if(eclassroomTriggerLike == false)
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) - 1);
      else {
        eclassroomTriggerLike = false;
        return;
      }
    } else {
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) + 1);
      followTrigger = true;
      if(eclassroomTriggerLike == true) {
        sesJqueryObject(element).addClass('button_active');
        eclassroomIntegrateFollow(contentId,functionName);
        eclassroomTriggerLike = false;
        return;
      }
    }
  } else if (clickType == 'like_classroom_button_view') {
    classType = 'eclassroom_like_classroom_view';
    functionName = 'like';
    itemType = 'classroom';
    contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.eclassroom_like_view_' + contentId;
    if (sesJqueryObject(element).data('status') == 1) {
      if(eclassroomTriggerLike == false) {
        sesJqueryObject('.eclassroom_like_view_' + contentId).html('<i class="fa fa-thumbs-up"></i><span>' + en4.core.language.translate("Like") + '</span>');
        sesJqueryObject('.eclassroom_like_classroom_view').data("status",0);
      }
      else {
        eclassroomTriggerLike = false;
        return;
      }
    } else {
      sesJqueryObject('.eclassroom_like_view_' + contentId).html('<i class="fa fa-thumbs-down"></i><span>' + en4.core.language.translate("Unlike") + '</span>');
      sesJqueryObject('.eclassroom_like_classroom_view').data("status",1);
      followTrigger = true;
      if(eclassroomTriggerLike == true) {
        eclassroomIntegrateFollow(contentId,functionName);
        eclassroomTriggerLike = false;
        return;
      }
    }
  } else if (clickType == 'eclassroom_favourite_view') {
    functionName = 'favourite';
    itemType = 'classroom';
    contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.eclassroom_favourite_' + contentId;

    if (sesJqueryObject(elementId).hasClass('button_active')) {
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) - 1);
    } else {
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) + 1);
    }
  } else if (clickType == 'eclassroom_category_follow') {
    functionName = 'follow-category';
    itemType = 'eclassroom_category';
    contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.eclassroom_category_follow_'+contentId;
    if(sesJqueryObject(element).data('status') == 1) {
        sesJqueryObject(elementId).html('<i class="fa fa-check"></i><span>'+en4.core.language.translate("Follow")+'</span>');
        sesJqueryObject(elementId).data("status",0);
    }
    else {
        sesJqueryObject(elementId).html('<i class="fa fa-times"></i><span>'+en4.core.language.translate("UnFollow")+'</span>');
        sesJqueryObject(elementId).data("status",1);
    }

  } else if (clickType == 'favourite_classroom_button_view') {
    classType = 'classroom_favourite_class_view';
    functionName = 'favourite';
    itemType = 'classroom';
    contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.eclassroom_favourite_' + contentId;
    if (sesJqueryObject(element).data('status') == 1) {
      sesJqueryObject('.eclassroom_favourite_view_' + contentId).html('<i class="fa fa-heart-o"></i><span>' + en4.core.language.translate("Add to Favorite") + '</span>');
      sesJqueryObject('.eclassroom_favourite_class_view').data("status", 0);;
    } else {
      sesJqueryObject('.eclassroom_favourite_view_' + contentId).html('<i class="fa fa-heart"></i><span>' + en4.core.language.translate("Favorited") + '</span>');
      sesJqueryObject('.eclassroom_favourite_class_view').data("status", 1);
    }
  } else if (clickType == 'eclassroom_follow_view') {
    functionName = 'follow';
    itemType = 'classroom';
    contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.eclassroom_follow_' + contentId;
    if (sesJqueryObject(elementId).hasClass('button_active')) {
      if(eclassroomTriggerFollow == false)
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) - 1);
      else {
        eclassroomTriggerFollow = false;
        return;
      }
    } else {
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) + 1);
      likeTrigger = true;
      if(eclassroomTriggerFollow == true) {
        sesJqueryObject(element).addClass('button_active');
        eclassroomIntegrateFollow(contentId,functionName);
        eclassroomTriggerFollow = false;
        return;
      }
    }
  } else if (clickType == 'follow_classroom_button_view') {
    classType = 'classroom_follow_class_view';
    functionName = 'follow';
    itemType = 'classroom';
    contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.eclassroom_follow_' + contentId;
    if (sesJqueryObject(element).data('status') == 1) {
      if(eclassroomTriggerFollow == false) {
        sesJqueryObject('.eclassroom_follow_view_' + contentId).html('<i class="fa fa-check"></i><span>' + en4.core.language.translate("Follow") + '</span>');
        sesJqueryObject('.eclassroom_follow_class_view').data("status", 0);
      }
      else {
        eclassroomTriggerFollow = false;
        return;
      }
    } else {
      sesJqueryObject('.eclassroom_follow_view_' + contentId).html('<i class="fa fa-times"></i><span>' + en4.core.language.translate("UnFollow") + '</span>');
      sesJqueryObject('.eclassroom_follow_class_view').data("status", 1);
      likeTrigger = true;
      if(eclassroomTriggerFollow == true) {
        eclassroomIntegrateFollow(contentId,functionName);
        eclassroomTriggerFollow = false;
        return;
      }
    }
  }
  if (!sesJqueryObject(element).attr('data-url'))
    return;
  if(sesJqueryObject(element).hasClass('button_active')) {
    sesJqueryObject(elementId).each(function(){
      sesJqueryObject(this).removeClass('button_active');
    });
  }else{
    sesJqueryObject(elementId).each(function(){
      sesJqueryObject(this).addClass('button_active');
    });
  }
  if(classroomFollowIntegrate == 1 && followTrigger == true) {
    eclassroomTriggerFollow = true;
    if(sesJqueryObject('.eclassroom_follow_view_'+contentId).length > 0) {
      sesJqueryObject('.eclassroom_follow_view_'+contentId).trigger('click');
    }
    else if(sesJqueryObject('.eclassroom_follow_'+contentId).length > 0) {
      if(sesJqueryObject('.eclassroom_follow_'+contentId).length == 1)
        sesJqueryObject('.eclassroom_follow_'+contentId).trigger('click');
      else
        sesJqueryObject('.eclassroom_follow_'+contentId).first().trigger('click');
    }
  }
  if(classroomFollowIntegrate == 1 && likeTrigger == true) {
    eclassroomTriggerLike = true;
    if(sesJqueryObject('.eclassroom_like_view_'+contentId).length > 0) {
      if(sesJqueryObject('.eclassroom_like_view_'+contentId).length == 1) {
        sesJqueryObject('.eclassroom_like_view_'+contentId).trigger('click');
      }else
        sesJqueryObject('.eclassroom_like_view_'+contentId).first().trigger('click');
    }
    else if(sesJqueryObject('.eclassroom_like_'+contentId).length > 0) {
      if(sesJqueryObject('.eclassroom_like_view_'+contentId).length == 1) {
        sesJqueryObject('.eclassroom_like_'+contentId).trigger('click');
      }else
        sesJqueryObject('.eclassroom_like_'+contentId).first().trigger('click');
    }
  }
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'eclassroom/ajax/' + functionName,
    'data': {
      format: 'html',
      id: contentId,
      type: itemType,
    },
    onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
      var response = jQuery.parseJSON(responseHTML);
      if (response.error)
        alert(en4.core.language.translate('Something went wrong,please try again later'));
      else {
        if (response.condition == 'reduced') {
          if(functionName == 'like') {
            sesJqueryObject('.eclassroom_like_view_' + contentId).html('<i class="fa fa-thumbs-up"></i><span>' + en4.core.language.translate("Like") + '</span>');
            if(sesJqueryObject('.eclassroom_like_count_'+contentId)) {
              sesJqueryObject('.eclassroom_like_count_'+contentId).html('<i class="sesbasic_icon_like_o"></i>'+response.count);
               sesJqueryObject('.eclassroom_like_count_'+contentId).attr('title',response.title);
            }
            sesJqueryObject('.eclassroom_like_classroom_view').data("status",0);
            sesJqueryObject('.eclassroom_like_' + contentId).find('span').html(response.count);
            sesJqueryObject('.eclassroom_like_' + contentId).removeClass('button_active');
          }
          if(functionName == 'follow') {
            sesJqueryObject('.eclassroom_follow_view_' + contentId).html('<i class="fa fa-check"></i><span>' + en4.core.language.translate("Follow") + '</span>');
            sesJqueryObject('.eclassroom_follow_classroom_view').data("status",0);
            sesJqueryObject('.eclassroom_follow_' + contentId).find('span').html(response.count);
            sesJqueryObject('.eclassroom_follow_' + contentId).removeClass('button_active');
            if(sesJqueryObject('.eclassroom_follow_count_'+contentId)) {
              sesJqueryObject('.eclassroom_follow_count_'+contentId).html('<i class="sesbasic_icon_follow"></i>'+response.count);
                sesJqueryObject('.eclassroom_follow_count_'+contentId).attr('title',response.title);
            }
          }
        } else {
          if(functionName == 'like' ||  (functionName == 'follow' && classroomFollowIntegrate == 1)) {
            sesJqueryObject('.eclassroom_like_view_' + contentId).html('<i class="fa fa-thumbs-down"></i><span>' + en4.core.language.translate("Unlike") + '</span>');
            sesJqueryObject('.eclassroom_like_classroom_view').data("status",1);
            if((functionName == 'follow' && classroomFollowIntegrate == 1)){
                if(!sesJqueryObject('.eclassroom_like_' + contentId+'.sesbasic_icon_like_btn').hasClass('button_active')) {
                  var int = parseInt(sesJqueryObject('.eclassroom_like_' + contentId+'.sesbasic_icon_like_btn').find('span').html()) + 1;
                  sesJqueryObject('.eclassroom_like_' + contentId).find('span').html(int);
                }
            }else
              sesJqueryObject('.eclassroom_like_' + contentId).find('span').html(response.count);
              sesJqueryObject('.eclassroom_like_' + contentId).addClass('button_active');
          }
          if(functionName == 'follow' || (functionName == 'like' && classroomFollowIntegrate == 1)) {
            sesJqueryObject('.eclassroom_follow_view_' + contentId).html('<i class="fa fa-times"></i><span>' + en4.core.language.translate("Unfollow") + '</span>');
            sesJqueryObject('.eclassroom_follow_classroom_view').data("status",1);
            if((functionName == 'like' && classroomFollowIntegrate == 1)){
              if(!sesJqueryObject('.eclassroom_follow_' + contentId+'.sesbasic_icon_follow_btn').hasClass('button_active')) {
                var int = parseInt(sesJqueryObject('.eclassroom_follow_' + contentId+'.sesbasic_icon_follow_btn').find('span').html()) + 1;
                sesJqueryObject('.eclassroom_follow_' + contentId).find('span').html(int);
              }
            }else
              sesJqueryObject('.eclassroom_follow_' + contentId).find('span').html(response.count);
              sesJqueryObject('.eclassroom_follow_' + contentId).addClass('button_active');
          }
          if(functionName == 'like') {
            if(sesJqueryObject('.eclassroom_like_count_'+contentId)) {
              sesJqueryObject('.eclassroom_like_count_'+contentId).html('<i class="sesbasic_icon_like_o"></i>'+response.count);
                sesJqueryObject('.eclassroom_like_count_'+contentId).attr('title',response.title);
            }
          }
          if(functionName == 'follow') {
            if(sesJqueryObject('.eclassroom_follow_count_'+contentId)) {
              sesJqueryObject('.eclassroom_follow_count_'+contentId).html('<i class="sesbasic_icon_follow"></i>'+response.count);
              sesJqueryObject('.eclassroom_follow_count_'+contentId).attr('title',response.title);
            }
          }
          if(functionName == 'favourite') {
            if(sesJqueryObject('.eclassroom_favourite_count_'+contentId)) {
              sesJqueryObject('.eclassroom_favourite_count_'+contentId).html('<i class="sesbasic_icon_follow"></i>'+response.count);
                sesJqueryObject('.eclassroom_favourite_count_'+contentId).attr('title',response.title);
            }
          }
        }
      }
      return true;
    }
  })).send();
}
sesJqueryObject(document).on('click', '.eclassroom_category_follow', function () {
  eclassroom_category_follow_data(this, 'eclassroom_category_follow');
});
function eclassroom_category_follow_data(element) {
  var contentId = sesJqueryObject(element).attr('data-url');
  var elementId = '.eclassroom_category_follow_'+contentId;
  if(sesJqueryObject(element).data('status') == 1) {
    sesJqueryObject(elementId).html('<i class="fa fa-check"></i><span>'+en4.core.language.translate("Follow")+'</span>');
    sesJqueryObject(elementId).data("status",0);
  }
  else {
    sesJqueryObject(elementId).html('<i class="fa fa-times"></i><span>'+en4.core.language.translate("UnFollow")+'</span>');
    sesJqueryObject(elementId).data("status",1);
  }
  if (!sesJqueryObject(element).attr('data-url'))
      return;
  if (sesJqueryObject(element).hasClass('button_active')) {
      sesJqueryObject(element).removeClass('button_active');
  } else
    sesJqueryObject(element).addClass('button_active');
  (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'eclassroom/ajax/follow-category',
      'data': {
        format: 'html',
        id: contentId,
        type: 'eclassroom_category',
        integration:0,
      },
      onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
      }
  })).send();
}

function eclassroomIntegrateFollow(contentId,functionName) {
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'eclassroom/ajax/' + functionName,
    'data': {
      format: 'html',
      id: contentId,
      type: itemType,
    },
    onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
       var response = jQuery.parseJSON(responseHTML);
       if(functionName == 'like') {
            if(sesJqueryObject('.eclassroom_like_count_'+contentId)) {
              sesJqueryObject('.eclassroom_like_count_'+contentId).html('<i class="sesbasic_icon_like_o"></i>'+response.count);
                sesJqueryObject('.eclassroom_like_count_'+contentId).attr('title',response.title);
            }
      }
      if(functionName == 'follow') {
          if(sesJqueryObject('.eclassroom_follow_count_'+contentId)) {
            sesJqueryObject('.eclassroom_follow_count_'+contentId).html('<i class="sesbasic_icon_follow"></i>'+response.count);
              sesJqueryObject('.eclassroom_follow_count_'+contentId).attr('title',response.title);
          }
      }
    }
  })).send();
}

sesJqueryObject (document).on('click', '.eclassroom_albumlike', function () {
  like_data_classroom(this, 'like', 'eclassroom_album');
});
sesJqueryObject (document).on('click', '.eclassroom_photolike', function () {
  like_data_classroom(this, 'like', 'eclassroom_photo');
});
//common function for like comment ajax
function like_data_classroom(element, functionName, itemType) {
  if (!sesJqueryObject (element).attr('data-url'))
    return;
  var id = sesJqueryObject (element).attr('data-url');
  if (sesJqueryObject (element).hasClass('button_active')) {
    sesJqueryObject (element).removeClass('button_active');
  } else
    sesJqueryObject (element).addClass('button_active');

  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'eclassroom/ajax/' + functionName,
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
        if(sesJqueryObject(element).hasClass('eclassroom_albumlike')) {
          var elementCount = 	element;
        } else if(sesJqueryObject(element).hasClass('eclassroom_photolike')) {
          var elementCount = 	element;
        }
        sesJqueryObject (elementCount).find('span').html(response.count);
        if (response.condition == 'reduced') {
          if(sesJqueryObject(element).hasClass('eclassroom_cover_btn')) {
            sesJqueryObject (element).find('i').removeClass('fa-thumbs-up');
            sesJqueryObject (element).find('i').addClass('fa-thumbs-o-up');
          } else
            sesJqueryObject (elementCount).removeClass('button_active');
        } else {
          if(sesJqueryObject(element).hasClass('eclassroom_cover_btn')) {
            sesJqueryObject (element).find('i').addClass('fa-thumbs-up');
            sesJqueryObject (element).find('i').removeClass('fa-thumbs-o-up');
          } else
            sesJqueryObject (elementCount).addClass('button_active');
        }
        if(itemType == "eclassroom_album" && sesJqueryObject('.eclassroom_album_likes_count_'+id)) {
          sesJqueryObject('.eclassroom_album_likes_count_'+id).html('<i class="sesbasic_icon_like_o"></i>'+response.count);
          sesJqueryObject('.eclassroom_album_likes_count_'+id).attr('title',response.title);
        }
        if(itemType == "eclassroom_album" && sesJqueryObject('.eclassroom_album_cover_likes_count_'+id)) {
          sesJqueryObject('.eclassroom_album_cover_likes_count_'+id).html(response.count);
        }
        if(itemType == "eclassroom_photo" && sesJqueryObject('.eclassroom_photo_likes_count_'+id)) {
          sesJqueryObject('.eclassroom_photo_likes_count_'+id).html('<i class="sesbasic_icon_like_o"></i>'+response.count);
          sesJqueryObject('.eclassroom_photo_likes_count_'+id).attr('title',response.title);
        } 
      }
      return true;
    }
  })).send();
}
// ALBUM FAV ON ALBUM LISTINGS
sesJqueryObject(document).on('click','.eclassroom_photoFav, .eclassroom_albumFav',function(){
  var data = sesJqueryObject(this).attr('data-src');
  if (typeof data == 'undefined') {
    var data = sesJqueryObject(this).attr('data-url');
  }
  var id = data;
  var date_resource_type = sesJqueryObject(this).attr('data-resource-type');
  var data_contenttype = sesJqueryObject(this).attr('data-contenttype');
  var objectDocument = this;
  (new Request.JSON({
    url : en4.core.baseUrl + 'eclassroom/ajax/favourite',
    data : {
      format : 'json',
        type : date_resource_type,
        id : data,
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      var data = JSON.parse(responseElements);
      if(data.status == 'false') {
        if(data.error == 'Login')
          alert(en4.core.language.translate('Please login'));
        else
          alert(en4.core.language.translate('Invalid argument supplied.'));
      } else {
        if(data.condition == 'increment') {
          sesJqueryObject(objectDocument).addClass('button_active');
          sesJqueryObject(objectDocument).find('span').html(data.count);
          if(data_contenttype == 'album') {
            showTooltipSesbasic(10,10,'<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Album added as Favourite successfully")+'</span>', 'sesbasic_favourites_notification');
          } else {
            showTooltipSesbasic(10,10,'<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Photo added as Favourite successfully")+'</span>', 'sesbasic_favourites_notification');
          }
        }else{
          sesJqueryObject(objectDocument).removeClass('button_active');
          sesJqueryObject(objectDocument).find('span').html(data.count);
          if(data_contenttype == 'album') {
            showTooltipSesbasic(10,10,'<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Photo Unfavourited successfully")+'</span>');
          } else {
            showTooltipSesbasic(10,10,'<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Album Unfavourited successfully")+'</span>');
          }
        }
        if(data_contenttype == "album" && sesJqueryObject('.eclassroom_album_favs_count_'+id)) {
          sesJqueryObject('.eclassroom_album_favs_count_'+id).html('<i class="sesbasic_icon_favourite_o"></i>'+data.count);
          sesJqueryObject('.eclassroom_album_favs_count_'+id).attr('title',data.title);
        }
      }
    }
  })).send();
  return false;
});

function reviewVotesClassrooms(elem,type){
    sesJqueryObject(elem).parent().parent().find('p').first().html('<span style="color:green;font-weight:bold">Thanks for your vote!</span>');
    var element = sesJqueryObject(this);
    if (!sesJqueryObject(elem).attr('data-href'))
        return;
    var text = sesJqueryObject(elem).find('.title').html();
    var id = sesJqueryObject (elem).attr('data-href');
    (new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + 'eclassroom/index/review-votes',
        'data': {
            format: 'html',
            id: id,
            type: type,
        },
        onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
            var response = jQuery.parseJSON(responseHTML);
            if (response.error)
                alert(en4.core.language.translate('Something went wrong,please try again later'));
            else {
                //sesJqueryObject (elementCount).find('span').html(response.count);
                if (response.condition == 'reduced') {
                    sesJqueryObject (elem).removeClass('active');
                    sesJqueryObject (elem).find('span').eq(1).html(response.count);
                }else{
                    sesJqueryObject (elem).addClass('active');
                    sesJqueryObject (elem).find('span').eq(1).html(response.count);
                }
            }
            return true;
        }
    })).send();
}
//review votes js
sesJqueryObject(document).on('click', '.eclassroom_review_useful', function (e) {
    reviewVotesClassrooms(this, '1');
});
sesJqueryObject(document).on('click', '.eclassroom_review_funny', function (e) {
    reviewVotesClassrooms(this, '2');
});
sesJqueryObject(document).on('click', '.eclassroom_review_cool', function (e) {
    reviewVotesClassrooms(this, '3');
});

sesJqueryObject(document).on('change','input[type=radio][name=callactionbutton]',function(){
  sesJqueryObject('.eclassroom_firststep_btn').removeClass('disabled');
});

sesJqueryObject(document).on('click','.btn_type_options_i',function(e){
  sesJqueryObject('.btn_type_options_i').removeClass('_op_selected_');
  sesJqueryObject(this).closest('.btn_type_options_i').toggleClass("_op_selected_");
});

sesJqueryObject(document).on('click','.eclassroom_firststep_btn',function(){
  var checkedElem = sesJqueryObject("input[type=radio][name=callactionbutton]:checked");
  if(checkedElem.length > 0){
     var title = checkedElem.parent().find('label').html();
     sesJqueryObject('#eclassroom_call1_btn_').html(title);
     sesJqueryObject('.step2').show();
     sesJqueryObject('.step1').hide();
     if(!sesJqueryObject('.eclassroom_btn_finish_save').hasClass('disabled'))
      sesJqueryObject('.eclassroom_btn_finish_save').addClass('disabled');
     sesJqueryObject('#eclassroom_selected_title').html(checkedElem.attr('data-title'));
     sesJqueryObject('#eclassroom_selected_description').html(checkedElem.attr('data-description'));
     sesJqueryObject('#eclassroom_btn_val').html(title);
  }
});
sesJqueryObject(document).on('click','.eclassroom_btn_finish',function(){

   sesJqueryObject('.step2').hide();
   sesJqueryObject('.step1').show();
   sesJqueryObject('.eclassroom_conf_edit').trigger('click');
   sesJqueryObject('#eclassroom_popip_title_input').val('');
});

sesJqueryObject(document).on('click','.eclassroom_call_action_elem',function(e){
  sesJqueryObject('#eclassroom_popip_title_input').val('');
   var checkedElem = sesJqueryObject("input[type=radio][name=callactionbutton]:checked");
   if(checkedElem.length > 0){
     if(checkedElem.val() == 'sendmessage'){
          sesJqueryObject('.eclassroom_btn_finish_save').removeClass('disabled');
          sesJqueryObject('._stepsuccessmsg').show();
          sesJqueryObject('.secondmaintop').parent().hide();
          return;
     }
     var title = checkedElem.data('popuptitle');
     var desc = checkedElem.data('popupdescription');
     sesJqueryObject('#eclassroom_popip_title_input').html(desc);
     var placeholder = checkedElem.data('placeholder');
     sesJqueryObject('#eclassroom_popip_title_input').attr('placeholder',placeholder);
   }
   sesJqueryObject('.eclassroom_profile_button_action_link_popup').show();
});
sesJqueryObject(document).on('click','.eclassroom_popup_cancel_callaction',function(e){
   sesJqueryObject('.eclassroom_profile_button_action_link_popup').hide();
});
sesJqueryObject(document).on('click','.eclassroom_conf_edit',function(e){
    sesJqueryObject('.eclassroom_btn_finish_save').addClass('disabled');
    sesJqueryObject('._stepsuccessmsg').hide();
    sesJqueryObject('.secondmaintop').parent().show();
});
sesJqueryObject(document).on('click','.eclassroom_popup_save_callaction',function(e){
  var value = sesJqueryObject('#eclassroom_popip_title_input').val();
  if(!value || value == ""){
      sesJqueryObject('#eclassroom_popip_title_input').css('border','1px solid red');
      return;
  }
   var checkedElem = sesJqueryObject("input[type=radio][name=callactionbutton]:checked").val();
   if(checkedElem == "callnow"){
     if(!checkPhone()){
          sesJqueryObject('#eclassroom_popip_title_input').css('border','1px solid red');
          return false;
     }
   }else if(checkedElem == "sendemail"){
      if(!checkEmail()){
        sesJqueryObject('#eclassroom_popip_title_input').css('border','1px solid red');
        return false;
     }
   }else{
    if(!checkURL()){
      sesJqueryObject('#eclassroom_popip_title_input').css('border','1px solid red');
      return false;
    }
   }
  sesJqueryObject('#eclassroom_popip_title_input').css('border','');
  sesJqueryObject('.eclassroom_btn_finish_save').removeClass('disabled');
  sesJqueryObject('.eclassroom_profile_button_action_link_popup').hide();
  sesJqueryObject('._stepsuccessmsg').show();
  sesJqueryObject('.secondmaintop').parent().hide();
});
sesJqueryObject(document).on('click','.eclassroom_btn_finish_save',function(e){
  if(!sesJqueryObject(this).hasClass('disabled')){
   saveCallActionBtn();
   return true;
  }
  return false;
});

sesJqueryObject(document).on('change','input[type=radio][name=callactionbutton]',function(){
  sesJqueryObject('.eclassroom_firststep_btn').removeClass('disabled');
});

var defaultButtonTextEclassroom = "";
sesJqueryObject(document).on({
  mouseenter: function(){
    defaultButtonTextEclassroom = sesJqueryObject('#eclassroom_call_btn_').html();
    sesJqueryObject('#eclassroom_call_btn_').html(sesJqueryObject(this).html());
  },
  mouseleave: function(){
    sesJqueryObject('#eclassroom_call_btn_').html(defaultButtonTextEclassroom);
  }
}, '.eclassroom_callaction_label');
sesJqueryObject(document).on('click','.eclassroomcallaction',function(){
  eclassroomCallBackActionBtn();
});

sesJqueryObject(document).on('click','#sesLikeUnlikeButton',function(){
  var dataid = sesJqueryObject(this).attr('data-id');
  if(!sesJqueryObject('#sesadvancedcomment_like_actionrec_'+dataid).length){
    sesJqueryObject('#comments .comments_options').find("a:eq(1)").trigger('click');
  }else{
    if(sesJqueryObject('#sesadvancedcomment_like_actionrec_'+dataid).hasClass('sesadvancedcommentlike')){
      sesJqueryObject(this).addClass(' button_active');
    }else{
      sesJqueryObject(this).removeClass('button_active');
    }
    sesJqueryObject('#sesadvancedcomment_like_actionrec_'+dataid).trigger('click');
  }
  return false;
});
sesJqueryObject(document).on('click','.composer_crosspost_toggle',function(e){
  if(sesJqueryObject(this).hasClass('composer_crosspost_toggle_active')){
    sesJqueryObject(this).removeClass('composer_crosspost_toggle_active');
    sesJqueryObject('#crosspostVal').val('');
  }else{
    sesJqueryObject(this).addClass('composer_crosspost_toggle_active') ;
    sesJqueryObject('#crosspostVal').val(1);
  }
});
sesJqueryObject(document).on('click','.sesact_chooser_btn',function(){
  if(sesJqueryObject(this).hasClass('active')) {
    sesJqueryObject(this).removeClass('active');
    sesJqueryObject('.sesact_content_pulldown').hide();
  }else{
    sesJqueryObject('.sesact_content_pulldown').show();
    sesJqueryObject(this).addClass('active') ;
  }
})
sesJqueryObject(document).on('click','#eclassroom_call_action_remove',function(){
  removeCallActionBtn();
});
function changeStoreCommentUser(action_id){
  var elem = sesJqueryObject('.eclassroom_feed_change_option_a');
  for(i=0;i<elem.length;i++){
    var imageItem = sesJqueryObject(elem[i]).attr('data-src');
    sesJqueryObject(elem[i]).closest('.comment-feed').find('.comment_usr_img').find('img').attr('src',imageItem);
  }
}
sesJqueryObject(document).on('submit', '#eclassroom_contact_owner',function(e) {
  var titleFieldValue = sesJqueryObject('#title').val();
  var messageFieldValue = sesJqueryObject('#body').val();
  var error = false;
  if(!titleFieldValue){
    sesJqueryObject('#title').css('border','1px solid red');
    error = true;
  }else{
    sesJqueryObject('#title').css('border','');
  }
  if(!messageFieldValue){
    sesJqueryObject('#body').css('border','1px solid red');
    error = true;
  }else{
    sesJqueryObject('#body').css('border','');
  }
  if(error){
    return false;
  }
  e.preventDefault();
  var formData = new FormData(this);
  var jqXHR=sesJqueryObject.ajax({
    url: en4.core.baseUrl +"eclassroom/index/contact",
    type: "POST",
    contentType:false,
    processData: false,
    data: formData,
    success: function(response){
      response = sesJqueryObject.parseJSON(response);
      if(response.status == 'true') {
			sesJqueryObject('#sessmoothbox_container').html("<div id='eclassroom_contact_message' class='eclassroom_contact_popup sesbasic_bxs'><div class='sesbasic_tip clearfix'><img src='application/modules/Eclassroom/externals/images/success.png' alt=''><span>Message sent successfully</span></div></div>");
      	sesJqueryObject('.sessmoothbox_overlay').fadeOut(1000, function(){sessmoothboxclose();});


//        sesJqueryObject('#eclassroom_sent_meesage').show();
//        sesJqueryObject('#eclassroom_contact_popup').append('<div id="eclassroom_sent_meesage">Bharat Work</div>');
//        window.setTimeout(function() {sesJqueryObject('#eclassroom_sent_meesage').remove()}, 30000);
//				sessmoothboxclose();
      }
    }
  });
  return false;
});

sesJqueryObject(document).on('submit', '#eclassroom_add_announcement',function(e) {
  var titleFieldValue = sesJqueryObject('#title').val();
  var messageFieldValue = tinyMCE.get('body').getContent();
  var error = false;
  if(!titleFieldValue){
    sesJqueryObject('#title').css('border','1px solid red');
    error = true;
  }else{
    sesJqueryObject('#title').css('border','');
  }
  if(!messageFieldValue){
    sesJqueryObject('#body-element').css('border','1px solid red');
    error = true;
  }else{
    sesJqueryObject('#body-element').css('border','');
  }
  if(error){
    return false;
  }
});

function changeEclassroomManifestUrl(type) {
  window.location.href = en4.core.staticBaseUrl + classroomURLeclassroom + '/' + type;
}

sesJqueryObject(document).on('submit', '#eclassroominviteform',function(e) {
  if(sesJqueryObject('.selectmember:checked').length == 0) {
   alert('Please select atleast one member.');
   return;
  }
  e.preventDefault();
  var formData = new FormData(this);
  var jqXHR=sesJqueryObject.ajax({
    url: en4.core.baseUrl +"eclassroom/member/invite/classroom_id/"+sesJqueryObject(this).attr('data-src'),
    type: "POST",
    contentType:false,
    processData: false,
    data: formData,
    success: function(response){
      response = sesJqueryObject.parseJSON(response);
      if(response.status == 'true') {
			sesJqueryObject('#sessmoothbox_container').html("<div id='eclassroom_contact_message' class='eclassroom_contact_popup sesbasic_bxs'><div class='sesbasic_tip clearfix'><img src='application/modules/Eclassroom/externals/images/success.png' alt=''><span>Members Invited Successfully</span></div></div>");
      	sesJqueryObject('.sessmoothbox_overlay').fadeOut(1000, function(){sessmoothboxclose();});
      }
    }
  });
  return false;
});
sesJqueryObject(document).on('click','#eclassroom_currency_coverter',function(){
	var url = "eclassroom/index/currency-converter";
	openURLinSmoothBox(url);
	return false;
});

