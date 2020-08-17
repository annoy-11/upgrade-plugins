//MAP CODE
//initialize default values
var map;
var infowindow;
var marker;
var mapLoad = true;
function initializeSesProductMap() {
  var mapOptions = {
    center: new google.maps.LatLng(-33.8688, 151.2195),
    zoom: 17
  };
   map = new google.maps.Map(document.getElementById('map-canvas'),
    mapOptions);

  var input = document.getElementById('locationSes');

  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.bindTo('bounds', map);

   infowindow = new google.maps.InfoWindow();
   marker = new google.maps.Marker({
    map: map,
    anchorPoint: new google.maps.Point(0, -29)
  });

  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    infowindow.close();
    marker.setVisible(false);
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);  // Why 17? Because it looks good.
    }
    marker.setIcon(/** @type {google.maps.Icon} */({
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(35, 35)
    }));
		document.getElementById('lngSes').value = place.geometry.location.lng();
		document.getElementById('latSes').value = place.geometry.location.lat();
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);

    var address = '';
    if (place.address_components) {
      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || '')
      ].join(' ');
    }
    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
    infowindow.open(map, marker);
		return false;
  });
	google.maps.event.addDomListener(window, 'load', initializeSesProductMap);
}

function editMarkerOnMapProductEdit(){
  geocoder = new google.maps.Geocoder();
  var address = trim(document.getElementById('locationSes').value);
  var lat = document.getElementById('latSes').value;
  var lng = document.getElementById('lngSes').value;
  var latlng = new google.maps.LatLng(lat, lng);
  geocoder.geocode({'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
	map.setZoom(17);
	marker = new google.maps.Marker({
	    position: latlng,
	    map: map
	});
	infowindow.setContent(results[0].formatted_address);
	infowindow.open(map, marker);
    } else {
      //console.log("Map failed to show location due to: " + status);
    }
  });
}

//list page map
function initializeSesProductMapList() {
if(mapLoad){
  var mapOptions = {
    center: new google.maps.LatLng(-33.8688, 151.2195),
    zoom: 17
  };
   map = new google.maps.Map(document.getElementById('map-canvas-list'),
    mapOptions);
}
  var input =document.getElementById('locationSesList');

  var autocomplete = new google.maps.places.Autocomplete(input);
if(mapLoad)
  autocomplete.bindTo('bounds', map);

if(mapLoad){
   infowindow = new google.maps.InfoWindow();
   marker = new google.maps.Marker({
    map: map,
    anchorPoint: new google.maps.Point(0, -29)
  });
}
  google.maps.event.addListener(autocomplete, 'place_changed', function() {

	if(mapLoad){
    infowindow.close();
    marker.setVisible(false);
	}
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }
	if(mapLoad){
    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);  // Why 17? Because it looks good.
    }
    marker.setIcon(/** @type {google.maps.Icon} */({
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(35, 35)
    }));
	}
		document.getElementById('lngSesList').value = place.geometry.location.lng();
		document.getElementById('latSesList').value = place.geometry.location.lat();
if(mapLoad){
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);
}
    var address = '';
    if (place.address_components) {
      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || '')
      ].join(' ');
    }
  if(mapLoad){
	  infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
    infowindow.open(map, marker);
		return false;
	}
	});
	if(mapLoad){
		google.maps.event.addDomListener(window, 'load', initializeSesProductMapList);
	}
}

function editSetMarkerOnMapListProduct(){
	geocoder = new google.maps.Geocoder();
if(mapLoad){
	if(document.getElementById('ses_location_data_list'))
		var address = trim(document.getElementById('ses_location_data_list').innerHTML);
}else{
	if(document.getElementById('locationSesList'))
		var address = trim(document.getElementById('locationSesList').innerHTML);
}
	var lat = document.getElementById('lngSesList').value;
	var lng = document.getElementById('latSesList').value;
  var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
          map.setCenter(results[0].geometry.location);
          marker = new google.maps.Marker({
              position: results[0].geometry.location,
              map: map
          });
          infowindow.setContent(results[0].formatted_address);
          infowindow.open(map, marker);
      } else {
        //console.log("Map failed to show location due to: " + status);
      }
    });
}
function openURLinSmoothBox(openURLsmoothbox){
	Smoothbox.open(openURLsmoothbox);
	parent.Smoothbox.close;
	return false;
}

//Like

sesJqueryObject (document).on('click', '.sesproduct_albumlike', function () {
	like_data_sesproduct(this, 'like', 'sesproduct_album');
});

sesJqueryObject (document).on('click', '.sesproduct_photolike', function () {
	like_data_sesproduct(this, 'like', 'sesproduct_photo');
});


//Favourite
sesJqueryObject (document).on('click', '.sesproduct_favourite', function () {
	favourite_data_sesproduct(this, 'favourite', 'sesproduct_photo');
});

sesJqueryObject (document).on('click', '.sesproduct_albumfavourite', function () {
	favourite_data_sesproduct(this, 'favourite', 'sesproduct_album');
});


//common function for like comment ajax
function like_data_sesproduct(element, functionName, itemType, moduleName, notificationType, classType) {
	if (!sesJqueryObject (element).attr('data-url'))
		return;
	var id = sesJqueryObject (element).attr('data-url');
	if (sesJqueryObject (element).hasClass('button_active')) {
		sesJqueryObject (element).removeClass('button_active');
	} else
		sesJqueryObject (element).addClass('button_active');
	(new Request.HTML({
		method: 'post',
		'url': en4.core.baseUrl + 'sesproduct/index/' + functionName,
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
				if(sesJqueryObject(element).hasClass('sesproduct_albumlike')){
					var elementCount = 	element;
				}
				else if(sesJqueryObject(element).hasClass('sesproduct_photolike')){
					var elementCount = 	element;
				}
				else {
					var elementCount = '.sesproduct_like_sesproduct_product_'+id;
				}
				sesJqueryObject (elementCount).find('span').html(response.count);
				if (response.condition == 'reduced') {
					if(classType == 'sesproduct_like_sesproduct_product_view') {
						sesJqueryObject('.sesproduct_like_sesproduct_product_view').html('<i class="fa fa-thumbs-up"></i><span>'+en4.core.language.translate("Like")+'</span>');
					}
					else {
						sesJqueryObject (elementCount).removeClass('button_active');
					}
				}
				else {
					if(classType == 'sesproduct_like_sesproduct_product_view') {
						sesJqueryObject('.sesproduct_like_sesproduct_product_view').html('<i class="fa fa-thumbs-down"></i><span>'+en4.core.language.translate("UnLike")+'</span>');
					}
					else {
						sesJqueryObject (elementCount).addClass('button_active');
					}
				}
			}
			return true;
		}
	})).send();
}


//common function for favourite item ajax
function favourite_data_sesproduct(element, functionName, itemType, moduleName, notificationType, classType) {
	if (!sesJqueryObject (element).attr('data-url'))
		return;
	var id = sesJqueryObject (element).attr('data-url');
	if (sesJqueryObject (element).hasClass('button_active')) {
		sesJqueryObject (element).removeClass('button_active');
	} else
		sesJqueryObject (element).addClass('button_active');
	(new Request.HTML({
		method: 'post',
		'url': en4.core.baseUrl + 'sesproduct/index/' + functionName,
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
				if(sesJqueryObject(element).hasClass('sesproduct_favourite')){
					var elementCount = 	element;
				} else if(sesJqueryObject(element).hasClass('sesproduct_albumfavourite')){
					var elementCount = 	element;
				}
				sesJqueryObject (elementCount).find('span').html(response.count);
				if (response.condition == 'reduced') {
					sesJqueryObject (elementCount).removeClass('button_active');
				} else {
					sesJqueryObject (elementCount).addClass('button_active');
				}
				sesJqueryObject ('.sesproduct_favourite_sesproduct_product_'+id).find('span').html(response.count);
				if (response.condition == 'reduced') {
					if(classType == 'sesproduct_favourite_sesproduct_product_view') {
						sesJqueryObject('.sesproduct_favourite_sesproduct_product_'+id).html('<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Favourite")+'</span>');
					}
					else {
						sesJqueryObject ('.sesproduct_favourite_sesproduct_product_'+id).removeClass('button_active');
					}
				} else {
					if(classType == 'sesproduct_favourite_sesproduct_product_view') {
						sesJqueryObject('.sesproduct_favourite_sesproduct_product_'+id).html('<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Un-Favourite")+'</span>');
					}
					else {
						sesJqueryObject ('.sesproduct_favourite_sesproduct_product_'+id).addClass('button_active');
					}
				}
			}
			return true;
		}
	})).send();
}


function showTooltip(x, y, contents, className) {
	if(sesJqueryObject('.sesbasic_notification').length > 0)
		sesJqueryObject('.sesbasic_notification').hide();
	sesJqueryObject('<div class="sesbasic_notification '+className+'">' + contents + '</div>').css( {
		display: 'block',
	}).appendTo("body").fadeOut(5000,'',function(){
		sesJqueryObject(this).remove();
	});
}

function trim(str, chr) {
  var rgxtrim = (!chr) ? new RegExp('^\\s+|\\s+$', 'g') : new RegExp('^'+chr+'+|'+chr+'+$', 'g');
  return str.replace(rgxtrim, '');
}

sesJqueryObject(document).on('click','.sesbasic_form_opn',function(e){
		 sesJqueryObject(this).parent().parent().find('form').show();
		 sesJqueryObject(this).parent().parent().find('form').focus();
		 var widget_id = sesJqueryObject(this).data('rel');
		 if(widget_id)
				eval("pinboardLayout_"+widget_id+"()");
});
//send quick share link
function sesproductsendQuickShare(url){
	if(!url)
		return;
	sesJqueryObject('.sesbasic_popup_slide_close').trigger('click');
	(new Request.HTML({
      method: 'post',
      'url': url,
      'data': {
        format: 'html',
				is_ajax : 1
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        //keep Silence
				showTooltip('10','10','<i class="fa fa-envelope"></i><span>'+(en4.core.language.translate("Product shared successfully."))+'</span>','sesbasic_message_notification');
      }
    })).send();
}

//open url in smoothbox
function opensmoothboxurl(openURLsmoothbox){
	Smoothbox.open(openURLsmoothbox);
	parent.Smoothbox.close;
	return false;
}

sesJqueryObject(document).on('click','.sesproduct_favourite_sesproduct_product',function(){
	favourite_data_sesproduct(this,'favourite','sesproduct','sesproduct', '<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("Product added as Favourite successfully"))+'</span>','<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("Product Un-Favourited successfully"))+'</span>','sesbasic_favourites_notification');
});

sesJqueryObject(document).on('click','.sesproduct_favourite_sesproduct_product_view',function(){
	favourite_data_sesproduct(this,'favourite','sesproduct','sesproduct', '', 'sesproduct_favourite_sesproduct_product_view');
});

sesJqueryObject(document).on('click','.sesproduct_like_sesproduct_product',function(){
	like_data_sesproduct(this,'like','sesproduct','sesproduct','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Product Liked successfully"))+'</span>','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Product Un-Liked successfully"))+'</span>','sesbasic_liked_notification', '');
});

sesJqueryObject(document).on('click','.sesproduct_like_sesproduct_product_view',function(){
	like_data_sesproduct(this,'like','sesproduct','sesproduct','', 'sesproduct_like_sesproduct_product_view');
});

sesJqueryObject(document).on('click', '.sesproduct_like_sesproduct_review', function () {
  like_review_data_sesproductreview(this, 'like', 'sesproductreview', 'sesproduct_like_sesproduct_review');
});

sesJqueryObject(document).on('click', '.sesproduct_like_sesproduct_review_view', function () {
  like_review_data_sesproductreview(this, 'like', 'sesproductreview', 'sesproduct_like_sesproduct_review_view');
});
sesJqueryObject(document).on('click','.sesproduct_like_sesproduct_wishlist',function(){
	like_favourite_data(this,'like','sesproduct_wishlist','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Wishlist Liked successfully"))+'</span>','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Wishlist Unliked successfully"))+'</span>','sesbasic_liked_notification');
});
sesJqueryObject(document).on('click','.sesproduct_favourite_sesproduct_wishlist',function(){
	like_favourite_data(this,'favourite','sesproduct_wishlist','<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("Wishlist added as Favourite successfully"))+'</span>','<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("Wishlist Unfavorited successfully"))+'</span>','sesbasic_favourites_notification');		
});
function like_favourite_data(element,functionName,itemType,likeNoti,unLikeNoti,className){
		if(!sesJqueryObject(element).attr('data-url'))
			return;
		if(sesJqueryObject(element).hasClass('button_active')){
				sesJqueryObject(element).removeClass('button_active');
		}else
				sesJqueryObject(element).addClass('button_active');
		 (new Request.HTML({
      method: 'post',
      'url':  en4.core.baseUrl + 'sesproduct/index/'+functionName,
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
							showTooltip(10,10,unLikeNoti)
							return true;
					}else{
							sesJqueryObject(element).addClass('button_active');
							showTooltip(10,10,likeNoti,className)
							return false;
					}
				}
      }
    })).send();
}
function like_review_data_sesproductreview(element, functionName, itemType, classType) {
  if (!sesJqueryObject (element).attr('data-url'))
  return;
  var id = sesJqueryObject (element).attr('data-url');
  if (sesJqueryObject (element).hasClass('button_active'))
  sesJqueryObject (element).removeClass('button_active');
  else
  sesJqueryObject (element).addClass('button_active');
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'sesproduct/review/' + functionName,
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
				var elementCount = '.sesproduct_like_sesproduct_review_'+id;
				sesJqueryObject (elementCount).find('span').html(response.count);
				if (response.condition == 'reduced') {
					if(classType == 'sesproduct_like_sesproduct_review_view') {
						sesJqueryObject('.sesproduct_like_sesproduct_review_view').html('<i class="fa fa-thumbs-up"></i><span>'+en4.core.language.translate("Like")+'</span>');
					}
					else {
						sesJqueryObject (elementCount).removeClass('button_active');
						showTooltipSesbasic('10','10','<i class="fa fa-thumbs-down"></i><span>'+(en4.core.language.translate("Review Un-Liked successfully"))+'</span>','sesbasic_member_likeunlike');
					}
				}
				else {
					if(classType == 'sesproduct_like_sesproduct_review_view') {
						sesJqueryObject('.sesproduct_like_sesproduct_review_view').html('<i class="fa fa-thumbs-down"></i><span>'+en4.core.language.translate("Unlike")+'</span>');
					}
					else {
						sesJqueryObject (elementCount).addClass('button_active');
						showTooltipSesbasic('10','10','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Review Liked successfully"))+'</span>','sesbasic_member_likeunlike');
					}
				}
      }
      return true;
    }
  })).send();
}

function changeSesproductManifestUrl(type) {
  window.location.href = en4.core.staticBaseUrl + productURLsesproduct + '/' + type;
}

function chnageHrefOfURL(id) {
 var welcomeHomeId = sesJqueryObject(id).attr('onclick').replace("changeSesproductManifestUrl('","" );
  welcomeHomeId = welcomeHomeId.replace("');","");
  sesJqueryObject(id).attr('href', en4.core.staticBaseUrl + productURLsesproduct + '/' + welcomeHomeId);
}
sesJqueryObject(document).ready(function() {
  var landingPageLink = sesJqueryObject('.sesproduct_landing_link');
  for(i=0; i < landingPageLink.length; i++) {
    chnageHrefOfURL(landingPageLink[i]);
  }
});


//Slideshow widget
sesJqueryObject(document).ready(function() {
  var sesproductElement = sesJqueryObject('.sesproduct_products_slideshow');
	if(sesproductElement.length > 0) {
    var sesproductElements = sesproductJqueryObject('.sesproduct_products_slideshow');
    sesproductElements.each(function(){
      sesproductJqueryObject(this).owlCarousel({
        loop:true,
        items:1,
        margin:0,
        autoHeight:true,
        autoplay:sesproductJqueryObject(this).attr('autoplay'),
        autoplayTimeout:sesproductJqueryObject(this).attr('autoplayTimeout'),
        autoplayHoverPause:true
      });
      sesproductJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
      sesproductJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
    });
	}
});

//tooltip code
var sestooltipOrigin;
sesJqueryObject(document).on('mouseover mouseout', '.sesproduct_ratings', function(event) {
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
			var data = "<div class='sesproduct_rating_info'>"+sesJqueryObject(this).parent().find('.sesproduct_rating_info').html()+"<div>";
			origin.tooltipster('content', data);
		  },
        functionComplete:function (origin) {
            sesJqueryObject('.tooltipster-content').find('.sesproduct_rating_info').find('.review_right').find('.progress_bar').each(function(){
                var width = sesJqueryObject(this).find('.animate').find('.bar_width').attr('data-percent')+"%";
                sesJqueryObject(this).find('.animate').find('.bar_width').css('width',width);
                // sesJqueryObject(this).find('.animate').find('.bar_width').animate({
                //     width:width
                // },6000);
                console.log(width);
            });
        }
	});
	sesJqueryObject(this).tooltipster('show');
});
sesJqueryObject(document).on('click','.sesproduct_wishlist',function(e){
  e.preventDefault();
  var id = sesJqueryObject(this).data('rel');
  if(id == "" || id < 1)
    return;
  opensmoothboxurl('sesproduct/wishlist/add/product_id/'+id);
});
var oldUrlSesproductVal = "";
function  zoomImageSesproduct() {

	//if(oldUrlSesproductVal != sesJqueryObject('#sesproduct_preview_image').attr('src')){
       //oldUrlSesproductVal = sesJqueryObject('#sesproduct_preview_image').attr('src');
        sesJqueryObject(".sesproduct_image_quick_view .quickviewoverlay").imageProjection(sesJqueryObject('#sesproduct_preview_image'));
	//}
}
function reviewVotesSesproduct(elem,type){
    sesJqueryObject(elem).parent().parent().find('p').first().html('<span style="color:green;font-weight:bold">Thanks for your vote!</span>');
    var element = sesJqueryObject(this);
    if (!sesJqueryObject(elem).attr('data-href'))
        return;
    var text = sesJqueryObject(elem).find('.title').html();
    var id = sesJqueryObject (elem).attr('data-href');
    (new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + 'sesproduct/index/review-votes',
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
sesJqueryObject(document).on('click', '.sesproduct_review_useful', function (e) {
    reviewVotesSesproduct(this, '1');
});
sesJqueryObject(document).on('click', '.sesproduct_review_funny', function (e) {
    reviewVotesSesproduct(this, '2');
});
sesJqueryObject(document).on('click', '.sesproduct_review_cool', function (e) {
    reviewVotesSesproduct(this, '3');
});
