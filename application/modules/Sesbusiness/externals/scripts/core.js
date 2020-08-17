/* $Id: core.js  2016-03-17 00:00:000 SocialEngineSolutions $ */


//Ajax error show before form submit
var error = false;
var objectError ;
var counter = 0;

function validateServiceform() {

  var errorPresent = false; 
  sesJqueryObject('.sesbusinesseservice_formcheck input, .sesbusinesseservice_formcheck select, .sesbusinesseservice_formcheck checkbox, .sesbusinesseservice_formcheck textarea, .sesbusinesseservice_formcheck radio').each(
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
//         if(error){
//           if(counter == 0){
//             objectError = this;
//           }
//           counter++
//         }
//         else{
//           if(sesJqueryObject('#tabs_form_blogcreate-wrapper').length && sesJqueryObject('.sesblog_upload_item_photo').length == 0){
//             <?php //if($required):?>
//               objectError = sesJqueryObject('.sesblog_create_form_tabs');
//               error = true;
//             <?php //endif;?>
//           }		
//         }
      if(error)
        errorPresent = true;
        error = false;
      }
    }
  );
  return errorPresent ;
}

sesJqueryObject(document).on('submit', '#sesbusinesseservice_addservice', function(e) {
  e.preventDefault();
  addService(this);
});

//initialize default values
var locationcreatedata;
var formObj;
var map_business;
var infowindow_business;
var marker_business;
var mapLoad_business = true;
//list business map 
function initializeSesBusinessMapList() {
  if (mapLoad_business) {
    var mapOptions = {
      center: new google.maps.LatLng(-33.8688, 151.2195),
      zoom: 17
    };
    map_business = new google.maps.Map(document.getElementById('map-canvas-list'),
            mapOptions);
  }
  if (sesJqueryObject('#locationSes').length)
    var input = document.getElementById('locationSes');
  else
    var input = document.getElementById('locationSesList');

  var autocomplete = new google.maps.places.Autocomplete(input);
  if (mapLoad_business)
    autocomplete.bindTo('bounds', map);


  if (mapLoad_business) {
    infowindow_business = new google.maps.InfoWindow();
    marker_business = new google.maps.Marker({
      map: map_business,
      anchorPoint: new google.maps.Point(0, -29)
    });
  }
  google.maps.event.addListener(autocomplete, 'place_changed', function () {

    if (mapLoad_business) {
      infowindow_business.close();
      marker_business.setVisible(false);
    }
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }
    if (mapLoad_business) {
      // If the place has a geometry, then present it on a map.
      if (place.geometry.viewport) {
        map_business.fitBounds(place.geometry.viewport);
      } else {
        map_business.setCenter(place.geometry.location);
        map_business.setZoom(17);  // Why 17? Because it looks good.
      }
      marker_business.setIcon(/** @type {google.maps.Icon} */({
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
    if (mapLoad_business) {
      marker_business.setPosition(place.geometry.location);
      marker_business.setVisible(true);
    }
    var address = '';
    if (place.address_components) {
      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || '')
      ].join(' ');
    }
    if (mapLoad_business) {
      infowindow_business.setContent('<div><strong>' + place.name + '</strong><br>' + address);
      infowindow_business.open(map_business, marker_business);
      return false;
    }
  });
  if (mapLoad_business) {
    google.maps.event.addDomListener(window, 'load', initializeSesBusinessMapList);
  }
}
//list business map 
function initializeSesBusinessMapList() {
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
    if (typeof createBusinessLoadMap == 'function')
      createBusinessLoadMap();
  });
}
//open popup in smoothbox
function openURLinSmoothBox(openURLsmoothbox) {
  Smoothbox.open(openURLsmoothbox);
  parent.Smoothbox.close;
  return false;
}
sesJqueryObject(document).on('click','.sesbusiness_button_toggle',function(){
	if(sesJqueryObject(this).hasClass('open')){
		sesJqueryObject(this).removeClass('open');
	}else{
		sesJqueryObject('.sesbusiness_button_toggle').removeClass('open');
		sesJqueryObject(this).addClass('open');
	}
		return false;
});
sesJqueryObject(document).click(function(){
	sesJqueryObject('.sesbusiness_button_toggle').removeClass('open');
});

sesJqueryObject(document).ready(function () {
  var obj = sesJqueryObject('#dragandrophandlersesbusinesslocation');
  obj.on('dragenter', function (e) {
    e.stopPropagation();
    e.preventDefault();
    sesJqueryObject(this).addClass("sesbd");
  });
  obj.on('dragover', function (e) {
    e.stopPropagation();
    e.preventDefault();
  });
  obj.on('drop', function (e) {
    sesJqueryObject(this).removeClass("sesbd");
    sesJqueryObject(this).addClass("sesbm");
    e.preventDefault();
    var files = e.originalEvent.dataTransfer.files;
    //We need to send dropped files to Server
    handleFileUploadsesbuysell(files, obj);
  });
  sesJqueryObject(document).on('dragenter', function (e) {
    e.stopPropagation();
    e.preventDefault();
  });
  sesJqueryObject(document).on('dragover', function (e) {
    e.stopPropagation();
    e.preventDefault();
  });
  sesJqueryObject(document).on('drop', function (e) {
    e.stopPropagation();
    e.preventDefault();
  });
});
sesJqueryObject(document).on('click', 'div[id^="abortPhotobusinesslocation_"]', function () {
  var id = sesJqueryObject(this).attr('id').match(/\d+/)[0];
  if (typeof jqXHRbuysell[id] != 'undefined') {
    jqXHRbuysell[id].abort();
    delete filesArray[id];
    execute = true;
    sesJqueryObject(this).parent().remove();
    executeuploadsesbuysell();
  } else {
    delete filesArray[id];
    sesJqueryObject(this).parent().remove();
  }
});
sesJqueryObject(document).on('click', '#dragandrophandlersesbusinesslocation', function () {
  document.getElementById('file_multi').click();
});
sesJqueryObject(document).on('click', '.delete_image_upload_sesbusinesslocation', function (e) {
  e.preventDefault();
  sesJqueryObject(this).parent().parent().find('.sesbusiness_upload_item_overlay').css('display', 'block');
  var sesthat = this;
  var photo_id = sesJqueryObject(this).closest('.sesbusiness_upload_item_options').attr('data-src');
  if (photo_id) {
    request = new Request.JSON({
      'format': 'json',
      'url': businessPhotoDeleteUrl,
      'data': {
        'locationphoto_id': photo_id
      },
      'onSuccess': function (responseJSON) {
        parent.sesJqueryObject('#sesbusiness_locationphoto_' + photo_id).remove();
        sesJqueryObject(sesthat).parent().parent().remove();
        sesJqueryObject('#sesbusiness_location_' + photo_id).remove();
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

function removeLcationPhoto(photoId) {
  var removePhoto = new Request.JSON({
    'format': 'json',
    'url': businessPhotoDeleteUrl,
    'data': {
      'locationphoto_id': photoId
    },
    'onSuccess': function (responseJSON) {
      sesJqueryObject('#sesbusiness_locationphoto_' + photoId).remove();
    }
  });
  removePhoto.send();
}

sesJqueryObject(document).on('click', '.sesbusiness_category_follow', function () {
  sesbusiness_category_follow_data(this, 'sesbusiness_category_follow');
});

function sesbusiness_category_follow_data(element) {
  var contentId = sesJqueryObject(element).attr('data-url');
  var elementId = '.sesbusiness_category_follow_'+contentId;
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
      'url': en4.core.baseUrl + 'sesbusiness/ajax/follow-category',
      'data': {
        format: 'html',
        id: contentId,
        type: 'sesbusiness_category',
        integration:0,
      },
      onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
      }
  })).send();
}

sesJqueryObject(document).on('click', '.sesbusiness_likefavfollow', function () {
  sesbusiness_likefavourite_data(this, 'sesbusiness_likefavfollow');
});

var sesbusinessTriggerFollow = false;
var sesbusinessTriggerLike = false;
//common function for like comment ajax
function sesbusiness_likefavourite_data(element) {
  if (!sesJqueryObject(element).attr('data-type'))
    return;
  var clickType = sesJqueryObject(element).attr('data-type');
  var functionName;
  var itemType;
  var contentId;
  var classType;
  var followTrigger = false;
  var likeTrigger = false;
  if (clickType == 'like_view') {
    functionName = 'like';
    itemType = 'businesses';
    if(sesJqueryObject(element).attr('data-contenttype')) {
        itemType = sesJqueryObject(element).attr('data-contenttype');
    }
    var contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.sesbusiness_like_' + contentId;
    if (sesJqueryObject(elementId).hasClass('button_active')) {
      if(sesbusinessTriggerLike == false) 
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) - 1);
      else {
        sesbusinessTriggerLike = false;
        return;
      }
    } else {
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) + 1);
      followTrigger = true;
      if(sesbusinessTriggerLike == true) {
        sesJqueryObject(element).addClass('button_active');
        sesbusinessIntegrateFollow(contentId,functionName);
        sesbusinessTriggerLike = false;
        return;
      }
    }
  } else if (clickType == 'like_business_button_view') {
    classType = 'sesbusiness_like_business_view';
    functionName = 'like';
    itemType = 'businesses';
    contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.sesbusiness_like_' + contentId;
    if (sesJqueryObject(element).data('status') == 1) {
      if(sesbusinessTriggerLike == false) {
        sesJqueryObject('.sesbusiness_like_view_' + contentId).html('<i class="fa fa-thumbs-up"></i><span>' + en4.core.language.translate("Like") + '</span>');
        sesJqueryObject('.sebusiness_like_business_view').data("status",0);
      }
      else {
        sesbusinessTriggerLike = false;
        return;
      }
    } else {
      sesJqueryObject('.sesbusiness_like_view_' + contentId).html('<i class="fa fa-thumbs-down"></i><span>' + en4.core.language.translate("Unlike") + '</span>');
      sesJqueryObject('.sebusiness_like_business_view').data("status",1);
      followTrigger = true;
      if(sesbusinessTriggerLike == true) {
        sesbusinessIntegrateFollow(contentId,functionName);
        sesbusinessTriggerLike = false;
        return;
      }
    }
  } else if (clickType == 'favourite_view') {
    functionName = 'favourite';
    itemType = 'businesses';
    if(sesJqueryObject(element).attr('data-contenttype')) {
      itemType = sesJqueryObject(element).attr('data-contenttype');
    }
    contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.sesbusiness_favourite_' + contentId;

    if (sesJqueryObject(elementId).hasClass('button_active')) {
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) - 1);
    } else {
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) + 1);
    }
  } else if (clickType == 'favourite_business_button_view') {
    classType = 'sesbusiness_favourite_business_view';
    functionName = 'favourite';
    itemType = 'businesses';
    contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.sesbusiness_favourite_' + contentId;
    if (sesJqueryObject(element).data('status') == 1) {
      sesJqueryObject('.sesbusiness_favourite_view_' + contentId).html('<i class="fa fa-heart-o"></i><span>' + en4.core.language.translate("Add to Favorite") + '</span>');
      sesJqueryObject('.sesbusiness_favourite_business_view').data("status", 0);;
    } else {
      sesJqueryObject('.sesbusiness_favourite_view_' + contentId).html('<i class="fa fa-heart"></i><span>' + en4.core.language.translate("Favorited") + '</span>');
      sesJqueryObject('.sesbusiness_favourite_business_view').data("status", 1);
    }
  } else if (clickType == 'follow_view') {
    functionName = 'follow';
    itemType = 'businesses';
    if(sesJqueryObject(element).attr('data-contenttype')) {
      itemType = sesJqueryObject(element).attr('data-contenttype');
    }
    contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.sesbusiness_follow_' + contentId;
    if (sesJqueryObject(elementId).hasClass('button_active')) {
      if(sesbusinessTriggerFollow == false) 
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) - 1);
      else {
        sesbusinessTriggerFollow = false;
        return;
      }
    } else {
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) + 1);
      likeTrigger = true;
      if(sesbusinessTriggerFollow == true) {
        sesJqueryObject(element).addClass('button_active');
        sesbusinessIntegrateFollow(contentId,functionName);
        sesbusinessTriggerFollow = false;
        return;
      }
    }
  } else if (clickType == 'follow_business_button_view') {
    classType = 'sebusiness_follow_business_view';
    functionName = 'follow';
    itemType = 'businesses';
    contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.sesbusiness_follow_' + contentId;
    if (sesJqueryObject(element).data('status') == 1) {
      if(sesbusinessTriggerFollow == false) {
        sesJqueryObject('.sesbusiness_follow_view_' + contentId).html('<i class="fa fa-check"></i><span>' + en4.core.language.translate("Follow") + '</span>');
        sesJqueryObject('.sesbusiness_follow_business_view').data("status", 0);
      }
      else {
        sesbusinessTriggerFollow = false;
        return;
      }
    } else {
      sesJqueryObject('.sesbusiness_follow_view_' + contentId).html('<i class="fa fa-times"></i><span>' + en4.core.language.translate("UnFollow") + '</span>');
      sesJqueryObject('.sesbusiness_follow_business_view').data("status", 1);
      likeTrigger = true;
      if(sesbusinessTriggerFollow == true) {
        sesbusinessIntegrateFollow(contentId,functionName);
        sesbusinessTriggerFollow = false;
        return;
      }
    }
  }
  if (!sesJqueryObject(element).attr('data-url'))
    return;

  if (sesJqueryObject(element).hasClass('button_active')) {
    sesJqueryObject(element).removeClass('button_active');
  } else
    sesJqueryObject(element).addClass('button_active');
  if(sesbusinessFollowIntegrate == 1 && followTrigger == true) {
    sesbusinessTriggerFollow = true;
    if(sesJqueryObject('.sesbusiness_follow_view_'+contentId).length > 0) {
      sesJqueryObject('.sesbusiness_follow_view_'+contentId).trigger('click');
    }
    else if(sesJqueryObject('.sesbusiness_follow_'+contentId).length > 0) {
      if(sesJqueryObject('.sesbusiness_follow_'+contentId).length == 1)
        sesJqueryObject('.sesbusiness_follow_'+contentId).trigger('click');
      else
        sesJqueryObject('.sesbusiness_follow_'+contentId).first().trigger('click');
    }
  }
  if(sesbusinessFollowIntegrate == 1 && likeTrigger == true) {
    sesbusinessTriggerLike = true;
    if(sesJqueryObject('.sesbusiness_like_view_'+contentId).length > 0) {
      if(sesJqueryObject('.sesbusiness_like_view_'+contentId).length == 1) {
        sesJqueryObject('.sesbusiness_like_view_'+contentId).trigger('click');
      }else
        sesJqueryObject('.sesbusiness_like_view_'+contentId).first().trigger('click');
    }
    else if(sesJqueryObject('.sesbusiness_like_'+contentId).length > 0) {
      if(sesJqueryObject('.sesbusiness_like_view_'+contentId).length == 1) {
        sesJqueryObject('.sesbusiness_like_'+contentId).trigger('click');
      }else
        sesJqueryObject('.sesbusiness_like_'+contentId).first().trigger('click');
    }
  }
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'sesbusiness/ajax/' + functionName,
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
          sesJqueryObject('.sesbusiness_like_view_' + contentId).html('<i class="fa fa-thumbs-up"></i><span>' + en4.core.language.translate("Like") + '</span>');
          sesJqueryObject('.sebusiness_like_business_view').data("status",0);
          sesJqueryObject('.sesbusiness_like_' + contentId).find('span').html(response.count);
          sesJqueryObject('.sesbusiness_like_' + contentId).removeClass('button_active');
          }
          if(functionName == 'follow') {
            sesJqueryObject('.sesbusiness_follow_view_' + contentId).html('<i class="fa fa-check"></i><span>' + en4.core.language.translate("Follow") + '</span>');
            sesJqueryObject('.sebusiness_follow_business_view').data("status",0);
            sesJqueryObject('.sesbusiness_follow_' + contentId).find('span').html(response.count);
            sesJqueryObject('.sesbusiness_follow_' + contentId).removeClass('button_active');
          }
//          if(functionName == 'favourite') {
//            sesJqueryObject('.sesbusiness_favourite_view_' + contentId).html('<i class="fa fa-heart"></i><span>' + en4.core.language.translate("Add to Favourite") + '</span>');
//            sesJqueryObject('.sebusiness_favourite_business_view').data("status",0);
//            sesJqueryObject('.sesbusiness_favourite_' + contentId).find('span').html(response.count);
//            sesJqueryObject('.sesbusiness_favourite_' + contentId).removeClass('button_active');
//          }
        } else {
          if(functionName == 'like' ||  (functionName == 'follow' && sesbusinessFollowIntegrate == 1)) {
            sesJqueryObject('.sesbusiness_like_view_' + contentId).html('<i class="fa fa-thumbs-down"></i><span>' + en4.core.language.translate("Unlike") + '</span>');
            sesJqueryObject('.sebusiness_like_business_view').data("status",1);
            if((functionName == 'follow' && sesbusinessFollowIntegrate == 1)){
              if(!sesJqueryObject('.sesbusiness_like_' + contentId+'.sesbasic_icon_like_btn').hasClass('button_active')) {
              var int = parseInt(sesJqueryObject('.sesbusiness_like_' + contentId+'.sesbasic_icon_like_btn').find('span').html()) + 1;
              sesJqueryObject('.sesbusiness_like_' + contentId).find('span').html(int);
            }
          }
            else
              sesJqueryObject('.sesbusiness_like_' + contentId).find('span').html(response.count);
           
            sesJqueryObject('.sesbusiness_like_' + contentId).addClass('button_active');
          }
          if(functionName == 'follow' || (functionName == 'like' && sesbusinessFollowIntegrate == 1)) {
            sesJqueryObject('.sesbusiness_follow_view_' + contentId).html('<i class="fa fa-times"></i><span>' + en4.core.language.translate("Unfollow") + '</span>');
            sesJqueryObject('.sebusiness_follow_business_view').data("status",1);
            if((functionName == 'like' && sesbusinessFollowIntegrate == 1)){
              if(!sesJqueryObject('.sesbusiness_follow_' + contentId+'.sesbasic_icon_follow_btn').hasClass('button_active')) {
              var int = parseInt(sesJqueryObject('.sesbusiness_follow_' + contentId+'.sesbasic_icon_follow_btn').find('span').html()) + 1;
              sesJqueryObject('.sesbusiness_follow_' + contentId).find('span').html(int);
            }
          }
            else
              sesJqueryObject('.sesbusiness_follow_' + contentId).find('span').html(response.count);
            sesJqueryObject('.sesbusiness_follow_' + contentId).addClass('button_active');
          }
//          if(functionName == 'favourite') {
//            sesJqueryObject('.sesbusiness_favourite_view_' + contentId).html('<i class="fa fa-heart"></i><span>' + en4.core.language.translate("Favourited") + '</span>');
//            sesJqueryObject('.sebusiness_favourite_business_view').data("status",1);
//            sesJqueryObject('.sesbusiness_favourite_' + contentId).find('span').html(response.count);
//            sesJqueryObject('.sesbusiness_favourite_' + contentId).addClass('button_active');
//          }
        }
      }
      return true;
    }
  })).send();
}
function sesbusinessIntegrateFollow(contentId,functionName) {
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'sesbusiness/ajax/' + functionName,
    'data': {
      format: 'html',
      id: contentId,
      type: business,
    },
    onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
        
    }
  })).send();
}
sesJqueryObject(document).on('click','.btn_type_options_i',function(e){
  sesJqueryObject('.btn_type_options_i').removeClass('_op_selected_');
  sesJqueryObject(this).closest('.btn_type_options_i').toggleClass("_op_selected_");
});

sesJqueryObject(document).on('click','.sesbusiness_firststep_btn',function(){
  var checkedElem = sesJqueryObject("input[type=radio][name=callactionbutton]:checked");
  if(checkedElem.length > 0){
     var title = checkedElem.parent().find('label').html();
     sesJqueryObject('#sesbusiness_call1_btn_').html(title);
     sesJqueryObject('.step2').show();
     sesJqueryObject('.step1').hide();
     if(!sesJqueryObject('.sesbusiness_btn_finish_save').hasClass('disabled'))
      sesJqueryObject('.sesbusiness_btn_finish_save').addClass('disabled');
     sesJqueryObject('#sesbusiness_selected_title').html(checkedElem.attr('data-title'));
     sesJqueryObject('#sesbusiness_selected_description').html(checkedElem.attr('data-description'));
     sesJqueryObject('#sesbusiness_btn_val').html(title);     
  }  
});
sesJqueryObject(document).on('click','.sesbusiness_btn_finish',function(){ 
  
   sesJqueryObject('.step2').hide();
   sesJqueryObject('.step1').show();
   sesJqueryObject('.sesbusiness_conf_edit').trigger('click');
   sesJqueryObject('#sesbusiness_popip_title_input').val('');
});

sesJqueryObject(document).on('click','.sesbusiness_call_action_elem',function(e){
  sesJqueryObject('#sesbusiness_popip_title_input').val('');
   var checkedElem = sesJqueryObject("input[type=radio][name=callactionbutton]:checked");
   if(checkedElem.length > 0){
     if(checkedElem.val() == 'sendmessage'){
          sesJqueryObject('.sesbusiness_btn_finish_save').removeClass('disabled'); 
          sesJqueryObject('._stepsuccessmsg').show();
          sesJqueryObject('.secondmaintop').parent().hide();
          return;
     }
     var title = checkedElem.data('popuptitle');
     var desc = checkedElem.data('popupdescription');
     sesJqueryObject('#sesbusiness_popip_title_input').html(desc);
     var placeholder = checkedElem.data('placeholder');
     sesJqueryObject('#sesbusiness_popip_title_input').attr('placeholder',placeholder);
   }
   sesJqueryObject('.sesbusiness_profile_button_action_link_popup').show();   
});
sesJqueryObject(document).on('click','.sesbusiness_popup_cancel_callaction',function(e){
   sesJqueryObject('.sesbusiness_profile_button_action_link_popup').hide();
});
sesJqueryObject(document).on('click','.sesbusiness_conf_edit',function(e){
    sesJqueryObject('.sesbusiness_btn_finish_save').addClass('disabled'); 
    sesJqueryObject('._stepsuccessmsg').hide();
    sesJqueryObject('.secondmaintop').parent().show();
});
sesJqueryObject(document).on('click','.sesbusiness_popup_save_callaction',function(e){
  var value = sesJqueryObject('#sesbusiness_popip_title_input').val();
  if(!value || value == ""){
      sesJqueryObject('#sesbusiness_popip_title_input').css('border','1px solid red');
      return;
  }
   var checkedElem = sesJqueryObject("input[type=radio][name=callactionbutton]:checked").val();
   if(checkedElem == "callnow"){
     if(!checkPhone()){
          sesJqueryObject('#sesbusiness_popip_title_input').css('border','1px solid red');
          return false;
     }
   }else if(checkedElem == "sendemail"){
      if(!checkEmail()){
        sesJqueryObject('#sesbusiness_popip_title_input').css('border','1px solid red');
        return false;
     }
   }else{
    if(!checkURL()){
      sesJqueryObject('#sesbusiness_popip_title_input').css('border','1px solid red');
      return false;
    }
   }
  sesJqueryObject('#sesbusiness_popip_title_input').css('border','');
  sesJqueryObject('.sesbusiness_btn_finish_save').removeClass('disabled');
  sesJqueryObject('.sesbusiness_profile_button_action_link_popup').hide();
  sesJqueryObject('._stepsuccessmsg').show();
  sesJqueryObject('.secondmaintop').parent().hide();
});
sesJqueryObject(document).on('click','.sesbusiness_btn_finish_save',function(e){
  if(!sesJqueryObject(this).hasClass('disabled')){
   saveCallActionBtn();
   return true;
  }
  return false;
});

sesJqueryObject(document).on('change','input[type=radio][name=callactionbutton]',function(){
  sesJqueryObject('.sesbusiness_firststep_btn').removeClass('disabled'); 
});
var defaultButtonTextSesbusiness = "";
sesJqueryObject(document).on({
  mouseenter: function(){
    defaultButtonTextSesbusiness = sesJqueryObject('#sesbusiness_call_btn_').html();
    sesJqueryObject('#sesbusiness_call_btn_').html(sesJqueryObject(this).html());
  },
  mouseleave: function(){
    sesJqueryObject('#sesbusiness_call_btn_').html(defaultButtonTextSesbusiness);
  }
}, '.sesbusiness_callaction_label');
sesJqueryObject(document).on('click','.sesbusinesscallaction',function(){
  sesbusinessCallBackActionBtn();
});

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
	sesJqueryObject(obj).removeClass('.sesbusiness_business_carousel');
}
function makeSesbusinessSlidesObject() {
 var elm = sesJqueryObject('.sesbusiness_business_carousel');
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
 makeSesbusinessSlidesObject();
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
  var elm = sesJqueryObject('.sesbusiness_category_slideshow');
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
sesJqueryObject (document).on('click', '.sesbusiness_albumlike', function () {
  like_data_sesbusiness(this, 'like', 'sesbusiness_album');
});
sesJqueryObject (document).on('click', '.sesbusiness_photolike', function () {
  like_data_sesbusiness(this, 'like', 'sesbusiness_photo');
});
//common function for like comment ajax
function like_data_sesbusiness(element, functionName, itemType) {
  
  if (!sesJqueryObject (element).attr('data-url'))
    return;
  
  var id = sesJqueryObject (element).attr('data-url');
  if (sesJqueryObject (element).hasClass('button_active')) {
    sesJqueryObject (element).removeClass('button_active');
  } else
    sesJqueryObject (element).addClass('button_active');
  
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'sesbusiness/ajax/' + functionName,
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
        if(sesJqueryObject(element).hasClass('sesbusiness_albumlike')) {
          var elementCount = 	element;
        } else if(sesJqueryObject(element).hasClass('sesbusiness_photolike')) {
          var elementCount = 	element;
        }      
        sesJqueryObject (elementCount).find('span').html(response.count);
        if (response.condition == 'reduced') {
          if(sesJqueryObject(element).hasClass('sesbusiness_cover_btn')) {
            sesJqueryObject (element).find('i').removeClass('fa-thumbs-up');
            sesJqueryObject (element).find('i').addClass('fa-thumbs-o-up');
          } else
            sesJqueryObject (elementCount).removeClass('button_active');
        } else {
          if(sesJqueryObject(element).hasClass('sesbusiness_cover_btn')) {
            sesJqueryObject (element).find('i').addClass('fa-thumbs-up');
            sesJqueryObject (element).find('i').removeClass('fa-thumbs-o-up');
          } else
            sesJqueryObject (elementCount).addClass('button_active');
        }
      }
      return true;
    }
  })).send();
}
// ALBUM FAV ON ALBUM LISTINGS
sesJqueryObject(document).on('click','.sesbusiness_photoFav, .sesbusiness_albumFav',function(){
  var data = sesJqueryObject(this).attr('data-src');
  if (typeof data == 'undefined') {
    var data = sesJqueryObject(this).attr('data-url');
  }
  var date_resource_type = sesJqueryObject(this).attr('data-resource-type');
  var data_contenttype = sesJqueryObject(this).attr('data-contenttype');
  var objectDocument = this;
  (new Request.JSON({
    url : en4.core.baseUrl + 'sesbusiness/ajax/favourite',
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
      }
    }
  })).send();
  return false;
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
sesJqueryObject(document).on('click','#sesbusiness_call_action_remove',function(){
  removeCallActionBtn();
});
function changeBusinessCommentUser(action_id){
  var elem = sesJqueryObject('.sesbusiness_feed_change_option_a');
  for(i=0;i<elem.length;i++){
    var imageItem = sesJqueryObject(elem[i]).attr('data-src');
    sesJqueryObject(elem[i]).closest('.comment-feed').find('.comment_usr_img').find('img').attr('src',imageItem);  
  }
}
sesJqueryObject(document).on('submit', '#sesbusiness_contact_owner',function(e) {
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
    url: en4.core.baseUrl +"sesbusiness/index/contact",
    type: "POST",
    contentType:false,
    processData: false,
    data: formData,
    success: function(response){
      response = sesJqueryObject.parseJSON(response);
      if(response.status == 'true') {
			sesJqueryObject('#sessmoothbox_container').html("<div id='sesbusiness_contact_message' class='sesbusiness_contact_popup sesbasic_bxs'><div class='sesbasic_tip clearfix'><img src='application/modules/Sesbusiness/externals/images/success.png' alt=''><span>Message sent successfully</span></div></div>");
      	sesJqueryObject('.sessmoothbox_overlay').fadeOut(1000, function(){sessmoothboxclose();});
      
					
//        sesJqueryObject('#sesbusiness_sent_meesage').show();
//        sesJqueryObject('#sesbusiness_contact_popup').append('<div id="sesbusiness_sent_meesage">Bharat Work</div>');
//        window.setTimeout(function() {sesJqueryObject('#sesbusiness_sent_meesage').remove()}, 30000);
//				sessmoothboxclose();
      }
    }
  });
  return false;
});

sesJqueryObject(document).on('submit', '#sesbusiness_add_announcement',function(e) {
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

function changeSesbusinessManifestUrl(type) {
  window.location.href = en4.core.staticBaseUrl + businessURLsesbusiness + '/' + type;
}

sesJqueryObject(document).on('submit', '#sesbusinessinviteform',function(e) {
  if(sesJqueryObject('.selectmember:checked').length == 0) {
   alert('Please select atleast one member.');
   return;
  }
  e.preventDefault();
  var formData = new FormData(this);
  var jqXHR=sesJqueryObject.ajax({
    url: en4.core.baseUrl +"sesbusiness/member/invite/business_id/"+sesJqueryObject(this).attr('data-src'),
    type: "POST",
    contentType:false,
    processData: false,
    data: formData,
    success: function(response){
      response = sesJqueryObject.parseJSON(response);
      if(response.status == 'true') {
			sesJqueryObject('#sessmoothbox_container').html("<div id='sesbusiness_contact_message' class='sesbusiness_contact_popup sesbasic_bxs'><div class='sesbasic_tip clearfix'><img src='application/modules/Sesbusiness/externals/images/success.png' alt=''><span>Members Invited Successfully</span></div></div>");
      	sesJqueryObject('.sessmoothbox_overlay').fadeOut(1000, function(){sessmoothboxclose();});
      }
    }
  });
  return false;
});