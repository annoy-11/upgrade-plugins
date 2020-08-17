//MAP CODE
//initialize default values
var map;
var infowindow;
var marker;
var mapLoad = true;
function initializeEPetitionMap() {
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

    google.maps.event.addListener(autocomplete, 'place_changed', function () {
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
    google.maps.event.addDomListener(window, 'load', initializeEpetitionMap);
}

function editMarkerOnMapPetitionEdit() {
    geocoder = new google.maps.Geocoder();
    var address = trim(document.getElementById('locationSes').value);
    var lat = document.getElementById('latSes').value;
    var lng = document.getElementById('lngSes').value;
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'address': address}, function (results, status) {
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
function initializeEpetitionMapList() {
    if (mapLoad) {
        var mapOptions = {
            center: new google.maps.LatLng(-33.8688, 151.2195),
            zoom: 17
        };
        map = new google.maps.Map(document.getElementById('map-canvas-list'),
            mapOptions);
    }
    var input = document.getElementById('locationSesList');

    var autocomplete = new google.maps.places.Autocomplete(input);
    if (mapLoad)
        autocomplete.bindTo('bounds', map);

    if (mapLoad) {
        infowindow = new google.maps.InfoWindow();
        marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });
    }
    google.maps.event.addListener(autocomplete, 'place_changed', function () {

        if (mapLoad) {
            infowindow.close();
            marker.setVisible(false);
        }
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }
        if (mapLoad) {
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
        if (mapLoad) {
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
        if (mapLoad) {
            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
            infowindow.open(map, marker);
            return false;
        }
    });
    if (mapLoad) {
        google.maps.event.addDomListener(window, 'load', initializeEPetitionMapList);
    }
}

function openURLinSmoothBox(openURLsmoothbox) {
    Smoothbox.open(openURLsmoothbox);
    parent.Smoothbox.close;
    return false;
}

sesJqueryObject(document).on('click', '.epetition_button_toggle', function () {
    if (sesJqueryObject(this).hasClass('open')) {
        sesJqueryObject(this).removeClass('open');
    } else {
        sesJqueryObject('.epetition_button_toggle').removeClass('open');
        sesJqueryObject(this).addClass('open');
    }
    return false;
});
sesJqueryObject(document).click(function () {
    sesJqueryObject('.epetition_button_toggle').removeClass('open');
});

//Like

sesJqueryObject(document).on('click', '.epetition_albumlike', function () {
    like_data_epetition(this, 'like', 'epetition_album');
});

sesJqueryObject(document).on('click', '.epetition_photolike', function () {
    like_data_epetition(this, 'like', 'epetition_photo');
});


//Favourite
sesJqueryObject(document).on('click', '.epetition_favourite', function () {
    favourite_data_epetition(this, 'favourite', 'epetition_photo');
});

sesJqueryObject(document).on('click', '.epetition_albumfavourite', function () {
    favourite_data_epetition(this, 'favourite', 'epetition_album');
});


//common function for like comment ajax
function like_data_epetition(element, functionName, itemType, moduleName, notificationType, classType) {
    if (!sesJqueryObject(element).attr('data-url'))
        return;
    var id = sesJqueryObject(element).attr('data-url');
    if (sesJqueryObject(element).hasClass('button_active')) {
        sesJqueryObject(element).removeClass('button_active');
    } else
        sesJqueryObject(element).addClass('button_active');
    (new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + 'epetition/index/' + functionName,
        'data': {
            format: 'html',
            id: sesJqueryObject(element).attr('data-url'),
            type: itemType,
        },
        onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
            var response = jQuery.parseJSON(responseHTML);
            if (response.error)
             {  alert(en4.core.language.translate('Something went wrong,please try again later')); }
            else {
                var elementCount;
                if (sesJqueryObject(element).hasClass('epetition_albumlike')) {
                    elementCount = element;
                } else if (sesJqueryObject(element).hasClass('epetition_photolike')) {
                    elementCount = element;
                } else {
                     elementCount = '.epetition_like_epetition_' + id;
                }

                sesJqueryObject(elementCount).find('span').text(response.count);
                if(sesJqueryObject('.epetition_like_count_' + id)){
                  sesJqueryObject('.epetition_like_count_' + id).each(function(){
                    sesJqueryObject(this).html('<i class="sesbasic_icon_like_o sesbasic_text_light"></i>'+response.count);
                  });
                }
                if (response.condition == 'reduced') {
                    if (classType == 'epetition_like_epetition_view') {
                        sesJqueryObject('.epetition_like_epetition_view').html('<i class="fa fa-thumbs-up"></i><span>' + en4.core.language.translate("Like") + '</span>');
                    } else {
                        sesJqueryObject(elementCount).removeClass('button_active');
                    }
                } else {
                    if (classType == 'epetition_like_epetition_view') {
                        sesJqueryObject('.epetition_like_epetition_view').html('<i class="fa fa-thumbs-down"></i><span>' + en4.core.language.translate("UnLike") + '</span>');
                    } else {
                        sesJqueryObject(elementCount).addClass('button_active');
                    }
                }
            }
            return true;
        }
    })).send();
}


//common function for favourite item ajax
function favourite_data_epetition(element, functionName, itemType, moduleName, notificationType, classType) {
    if (!sesJqueryObject(element).attr('data-url'))
        return;
    var id = sesJqueryObject(element).attr('data-url');
    if (sesJqueryObject(element).hasClass('button_active')) {
        sesJqueryObject(element).removeClass('button_active');
    } else
        sesJqueryObject(element).addClass('button_active');
    (new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + 'epetition/index/' + functionName,
        'data': {
            format: 'html',
            id: sesJqueryObject(element).attr('data-url'),
            type: itemType,
        },
        onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
            var response = jQuery.parseJSON(responseHTML);
            if (response.error)
                alert(en4.core.language.translate('Something went wrong,please try again later'));
            else {
                if (sesJqueryObject(element).hasClass('epetition_favourite')) {
                    var elementCount = element;
                } else if (sesJqueryObject(element).hasClass('epetition_albumfavourite')) {
                    var elementCount = element;
                }
                sesJqueryObject(elementCount).find('span').html(response.count);
                if (response.condition == 'reduced') {
                    sesJqueryObject(elementCount).removeClass('button_active');
                } else {
                    sesJqueryObject(elementCount).addClass('button_active');
                }
                sesJqueryObject('.epetition_favourite_epetition_' + id).find('span').html(response.count);
                if(sesJqueryObject('.epetition_favourite_count_' + id)){
                  sesJqueryObject('.epetition_favourite_count_' + id).each(function(){
                    sesJqueryObject(this).html('<i class="sesbasic_icon_favourite_o sesbasic_text_light"></i>'+response.count);
                  });
                }
                if (response.condition == 'reduced') {
                    if (classType == 'epetition_favourite_epetition_view') {
                        sesJqueryObject('.epetition_favourite_epetition_' + id).html('<i class="fa fa-heart"></i><span>' + en4.core.language.translate("Favourite") + '</span>');
                    } else {
                        sesJqueryObject('.epetition_favourite_epetition_' + id).removeClass('button_active');
                    }
                } else {
                    if (classType == 'epetition_favourite_epetition_view') {
                        sesJqueryObject('.epetition_favourite_epetition_' + id).html('<i class="fa fa-heart"></i><span>' + en4.core.language.translate("Un-Favourite") + '</span>');
                    } else {
                        sesJqueryObject('.epetition_favourite_epetition_' + id).addClass('button_active');
                    }
                }
            }
            return true;
        }
    })).send();
}


function showTooltip(x, y, contents, className) {
    if (sesJqueryObject('.sesbasic_notification').length > 0)
        sesJqueryObject('.sesbasic_notification').hide();
    sesJqueryObject('<div class="sesbasic_notification ' + className + '">' + contents + '</div>').css({
        display: 'block',
    }).appendTo("body").fadeOut(5000, '', function () {
        sesJqueryObject(this).remove();
    });
}

function trim(str, chr) {
    var rgxtrim = (!chr) ? new RegExp('^\\s+|\\s+$', 'g') : new RegExp('^' + chr + '+|' + chr + '+$', 'g');
    return str.replace(rgxtrim, '');
}

sesJqueryObject(document).on('click', '.sesbasic_form_opn', function (e) {
    sesJqueryObject(this).parent().parent().find('form').show();
    sesJqueryObject(this).parent().parent().find('form').focus();
    var widget_id = sesJqueryObject(this).data('rel');
    if (widget_id)
        eval("pinboardLayout_" + widget_id + "()");
});

//send quick share link
function epetitionsendQuickShare(url) {
    if (!url)
        return;
    sesJqueryObject('.sesbasic_popup_slide_close').trigger('click');
    (new Request.HTML({
        method: 'post',
        'url': url,
        'data': {
            format: 'html',
            is_ajax: 1
        },
        onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
            //keep Silence
            showTooltip('10', '10', '<i class="fa fa-envelope"></i><span>' + (en4.core.language.translate("Petition shared successfully.")) + '</span>', 'sesbasic_message_notification');
        }
    })).send();
}

//open url in smoothbox
function opensmoothboxurl(openURLsmoothbox) {
    Smoothbox.open(openURLsmoothbox);
    parent.Smoothbox.close;
    return false;
}

sesJqueryObject(document).on('click', '.epetition_favourite_epetition', function () {
    favourite_data_epetition(this, 'favourite', 'epetition', 'epetition', '<i class="fa fa-heart"></i><span>' + (en4.core.language.translate("Petition added as Favourite successfully")) + '</span>', '<i class="fa fa-heart"></i><span>' + (en4.core.language.translate("Petition Un-Favourited successfully")) + '</span>', 'sesbasic_favourites_notification');
});

sesJqueryObject(document).on('click', '.epetition_favourite_epetition_view', function () {
    favourite_data_epetition(this, 'favourite', 'epetition', 'epetition', '', 'epetition_favourite_epetition_view');
});

sesJqueryObject(document).on('click', '.epetition_like_epetition', function () {
    like_data_epetition(this, 'like', 'epetition', 'epetition', '<i class="fa fa-thumbs-up"></i><span>' + (en4.core.language.translate("Petition Liked successfully")) + '</span>', '<i class="fa fa-thumbs-up"></i><span>' + (en4.core.language.translate("Petition Un-Liked successfully")) + '</span>', 'sesbasic_liked_notification', '');
});

sesJqueryObject(document).on('click', '.epetition_like_epetition_view', function () {
    like_data_epetition(this, 'like', 'epetition', 'epetition', '', 'epetition_like_epetition_view');
});

sesJqueryObject(document).on('click', '.epetition_like_epetition_signature', function () {
    like_signature_data_epetitionsignature(this, 'like', 'epetition_signature', 'epetition_like_epetition_signature');
});

sesJqueryObject(document).on('click', '.epetition_like_epetition_signature_view', function () {
    like_signature_data_epetitionsignature(this, 'like', 'epetition_signature', 'epetition_like_epetition_signature_view');
});

function like_signature_data_epetitionsignature(element, functionName, itemType, classType) {
    if (!sesJqueryObject(element).attr('data-url'))
        return;
    var id = sesJqueryObject(element).attr('data-url');
    if (sesJqueryObject(element).hasClass('button_active'))
        sesJqueryObject(element).removeClass('button_active');
    else
        sesJqueryObject(element).addClass('button_active');
    (new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + 'epetition/signature/' + functionName,
        'data': {
            format: 'html',
            id: sesJqueryObject(element).attr('data-url'),
            type: itemType,
        },
        onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
            var response = jQuery.parseJSON(responseHTML);
            if (response.error)
                alert(en4.core.language.translate('Something went wrong,please try again later'));
            else {
                var elementCount = '.epetition_like_epetition_signature_' + id;
                sesJqueryObject(elementCount).find('span').html(response.count);
                if (response.condition == 'reduced') {
                    if (classType == 'epetition_like_epetition_signature_view') {
                        sesJqueryObject('.epetition_like_epetition_signature_view').html('<i class="fa fa-thumbs-up"></i><span>' + en4.core.language.translate("Like") + '</span>');
                    } else {
                        sesJqueryObject(elementCount).removeClass('button_active');
                        showTooltipSesbasic('10', '10', '<i class="fa fa-thumbs-down"></i><span>' + (en4.core.language.translate("Signature Un-Liked successfully")) + '</span>', 'sesbasic_member_likeunlike');
                    }
                } else {
                    if (classType == 'epetition_like_epetition_signature_view') {
                        sesJqueryObject('.epetition_like_epetition_signature_view').html('<i class="fa fa-thumbs-down"></i><span>' + en4.core.language.translate("Unlike") + '</span>');
                    } else {
                        sesJqueryObject(elementCount).addClass('button_active');
                        showTooltipSesbasic('10', '10', '<i class="fa fa-thumbs-up"></i><span>' + (en4.core.language.translate("Signature Liked successfully")) + '</span>', 'sesbasic_member_likeunlike');
                    }
                }
            }
            return true;
        }
    })).send();
}

function changeEpetitionManifestUrl(type) {
    window.location.href = en4.core.staticBaseUrl + petitionURLepetition + '/' + type;
}

function chnageEpetitionHrefOfURL(id) {
    var welcomeHomeId = sesJqueryObject(id).attr('onclick').replace("changeEpetitionManifestUrl('", "");
    welcomeHomeId = welcomeHomeId.replace("');", "");
    sesJqueryObject(id).attr('href', en4.core.staticBaseUrl + petitionURLepetition + '/' + welcomeHomeId);
}

sesJqueryObject(document).ready(function () {
    var landingPageLink = sesJqueryObject('.epetition_landing_link');
    for (i = 0; i < landingPageLink.length; i++) {
        chnageEpetitionHrefOfURL(landingPageLink[i]);
    }
});


//Slideshow widget
sesJqueryObject(document).ready(function () {
    var epetitionElement = sesJqueryObject('.epetition_slideshow');
    if (epetitionElement.length > 0) {
        var epetitionElements = epetitionJqueryObject('.epetition_slideshow');
        epetitionElements.each(function () {
            epetitionJqueryObject(this).owlCarousel({
                loop: true,
                items: 1,
                margin: 0,
                autoHeight: true,
                autoplay: epetitionJqueryObject(this).attr('autoplay'),
                autoplayTimeout: epetitionJqueryObject(this).attr('autoplayTimeout'),
                autoplayHoverPause: true
            });
            epetitionJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
            epetitionJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
        });
    }
});

//for signature form submit by ajax
function signturecreatebyajax(url, that) {
     var messageDescription = tinyMCE.get('announcement_description').getContent();
    sesJqueryObject.ajax({
        url: url,
        type: "POST",
         data: {announcement_description:messageDescription,announcement_title:sesJqueryObject(that).find('#announcement_title').val()},
        success: function (html) {
            sesJqueryObject('.all_form_smoothbox').remove();
            sesJqueryObject(".sessmoothbox_container").append(html);
            var loc = document.getElementsByName('epetition_location');
            for (i = 0; i < loc.length; i++) {
                new google.maps.places.Autocomplete(loc[i]);
            }
        }
    });
}

// for create petition popup
function petitioncreatebyajax(url, allvalue) {
    sesJqueryObject.ajax({
        url: url,
        type: "POST",
        data: allvalue,
        success: function (html) {
            sesJqueryObject('.epetition_create').remove();
            sesJqueryObject(".sessmoothbox_container").append(html);
            var loc = document.getElementsByName('epetition_location');
            for (i = 0; i < loc.length; i++) {
                new google.maps.places.Autocomplete(loc[i]);
            }
        }
    });
}

// update for signture and signture percent line
function Updatesign(jsonarray) {
    sesJqueryObject.ajax({
        url: sesJqueryObject(this).attr('action'),
        type: "POST",
        data: {ids: jsonarray},
        dataType: "json",
        success: function (html) {
            if (html['status']) {
                for (var i = 0; i < html['lenght']; i++) {
                    sesJqueryObject(".per" + html[i]['id']).css("width", html[i]['percent']);
                    sesJqueryObject(".acv" + html[i]['id']).text(html[i]['signpet']);
                }
            }
        }
    });
}

// update view page for signature and signature percent line
function ajaxcallforupdate() {
    var url = en4.core.baseUrl + "epetition/index/ajaxcallforupdate";
    var menuId = '<?php echo $this->epetition_id; ?>';
    sesJqueryObject.ajax({
        url: url,
        type: "POST",
        data: {id: menuId},
        dataType: "json",
        success: function (html) {
            if (html['status']) {
                sesJqueryObject("#epetition_singpet").text(html['signpet']);
                sesJqueryObject("#epetition-lineasign").attr('style', 'widht:' + html['pecent'] + '%');
                sesJqueryObject("#epetition_singgoal").text(html['goal']);
            }
        }
    });
}

// for number validate
function allowOnlyNumbers(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 37 && charCode != 39 && charCode > 31 && (charCode < 48 || charCode > 57)) // for only numbers and forward, backward arrows
    {
        return false;
    }
    return true;
}

function initializeEpetitionMapList() {
    if (mapLoad) {
        var mapOptions = {
            center: new google.maps.LatLng(-33.8688, 151.2195),
            zoom: 17
        };
        map = new google.maps.Map(document.getElementById('map-canvas-list'),
            mapOptions);
    }
    var input = document.getElementById('locationSesList');

    var autocomplete = new google.maps.places.Autocomplete(input);
    if (mapLoad)
        autocomplete.bindTo('bounds', map);

    if (mapLoad) {
        infowindow = new google.maps.InfoWindow();
        marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });
    }
    google.maps.event.addListener(autocomplete, 'place_changed', function () {

        if (mapLoad) {
            infowindow.close();
            marker.setVisible(false);
        }
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }
        if (mapLoad) {
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
        if (mapLoad) {
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
        if (mapLoad) {
            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
            infowindow.open(map, marker);
            return false;
        }
    });
    if (mapLoad) {
        google.maps.event.addDomListener(window, 'load', initializeEpetitionMapList);
    }
}

function editSetMarkerOnMapListPetition() {
    geocoder = new google.maps.Geocoder();
    if (mapLoad) {
        if (document.getElementById('ses_location_data_list'))
            var address = trim(document.getElementById('ses_location_data_list').innerHTML);
    } else {
        if (document.getElementById('locationSesList'))
            var address = trim(document.getElementById('locationSesList').innerHTML);
    }
    var lat = document.getElementById('lngSesList').value;
    var lng = document.getElementById('latSesList').value;
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'address': address}, function (results, status) {
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


    function selectCat(id) {
           sesJqueryObject("#displaycategory").remove();
           sesJqueryObject("#displayform").show();
           sesJqueryObject("#category_id").val(id);
           showSubCategory(id);
    }



