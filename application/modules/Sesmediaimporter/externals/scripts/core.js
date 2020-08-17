sesJqueryObject(document).on('click','.showservicepage',function(e){
  var href = sesJqueryObject(this).data('href');
  window.location.href = href;
});
sesJqueryObject(document).on('click','.showloginpopup',function(e){
  var href = sesJqueryObject(this).data('href');
  var width = screen.width - 50;
  var height = screen.height - 50;
  authSesmediaimporterWindow =  window.open(href,'Facebook', "width="+width+",height="+height+",toolbar=0,scrollbars=0,status=0,resizable=0,location=0,menuBar=0");  
});
sesJqueryObject(document).on('click','.selectsesmediaimporter',function(e){
  sesJqueryObject(".sesmediaimportercheckbox").prop('checked', true); 
  sesJqueryObject(".unselectsesmediaimporter").show();
  sesJqueryObject(".selectsesmediaimporter").hide();
  sesJqueryObject('.sesmediaimporterimport').removeClass('isdisable');
});
sesJqueryObject(document).on('click','.unselectsesmediaimporter',function(e){
  sesJqueryObject(".sesmediaimportercheckbox").prop('checked', false); 
  sesJqueryObject(".unselectsesmediaimporter").hide();
  sesJqueryObject(".selectsesmediaimporter").show();
  sesJqueryObject('.sesmediaimporterimport').addClass('isdisable');
});

sesJqueryObject(document).on('click','.sesmediaimportercheckbox',function(){
  if(sesJqueryObject('#importsesmediaimporter input[type=checkbox]:checked').length <= 0) {
    sesJqueryObject('.sesmediaimporterimport').addClass('isdisable');
  }else{
     sesJqueryObject('.sesmediaimporterimport').removeClass('isdisable');  
  }
  
  var toalElem = sesJqueryObject('.sesmediaimportercheckbox').length;
  if(sesJqueryObject('#importsesmediaimporter input[type=checkbox]:checked').length == toalElem){
    sesJqueryObject(".unselectsesmediaimporter").show();
    sesJqueryObject(".selectsesmediaimporter").hide();
  }else{
    sesJqueryObject(".unselectsesmediaimporter").hide();
    sesJqueryObject(".selectsesmediaimporter").show();
  }
  
})
sesJqueryObject(document).on('click','.sesmediaimp_refreshbtn',function(e){
    sesJqueryObject('.sesbasic_tab_selected').find('a').trigger('click');
});
sesJqueryObject(document).on('click','.sesmediaimporterimport',function(e){
  if(sesJqueryObject('#importsesmediaimporter input[type=checkbox]:checked').length <= 0) {
   alert(en4.core.language.translate("Please select item to import."));
   return false;
  }
  Smoothbox.open("sesmediaimporter/import/index/");
	parent.Smoothbox.close;
  return;
});
function getSelectedItems(){
  var type = sesJqueryObject('ul#sesmediaimportermainmenu').find('li.active').data('type');
  var mediatype = sesJqueryObject('#importsesmediaimporter input[type=checkbox]:checked');
  if(sesJqueryObject(mediatype[0]).attr('id').indexOf("album") >= 0){
    mediaType = 'album';  
  }else
    mediaType = 'photo';
  var formData = sesJqueryObject('#importsesmediaimporter').serialize();
  if(mediaType == 'album'){
    var url = "sesmediaimporter/import/import-albums/";  
  }
}
sesJqueryObject(document).on('click','ul#sesmediaimporter_facebook_select li a',function(e){
  var parentElem = sesJqueryObject(this).parent();
  sesJqueryObject('ul#sesmediaimporter_facebook_select').find('li').removeClass('sesbasic_tab_selected');
  sesJqueryObject(parentElem).addClass('sesbasic_tab_selected');
  if(sesJqueryObject(parentElem).hasClass('sesmediaimporter_album_tab')){
    sesmediaimporter_album_tab();
    return true;
  }else if(sesJqueryObject(parentElem).hasClass('sesmediaimporter_album_yourphotos')){
      var type = 'uploaded';
   }else if(sesJqueryObject(parentElem).hasClass('sesmediaimporter_album_taggedphotos')){
      var type = 'tagged';
   }else if(sesJqueryObject(parentElem).hasClass('sesmediaimporter_google_youralbums')){
     openGoogleMedia('album');
     return true;
   }else if(sesJqueryObject(parentElem).hasClass('sesmediaimporter_google_yourphotos')){
     openGoogleMedia('photos');
     return true;
   }
   sesmediaimporter_type_tab(type,'sesmediaimporter/index/load-fb-type-photo?type='+type,'facebook_album');
});
function openGoogleMedia(type){
  if(type == 'album'){
    var url = 'sesmediaimporter/index/load-google-gallery/';
  }else if(type == 'photos'){
    var url = 'sesmediaimporter/index/load-google-photo/';  
  }
  document.getElementById("google_album").innerHTML = '<div class="sesbasic_loading_container" id="fb-spinner"></div>';
    //Makes An AJAX Request On Load which retrieves the albums
    sesJqueryObject('.hidefb').hide();
    sesJqueryObject.ajax({
      type: 'post',
      url: url,
      success: function( data ) {
        //Hide The Spinner
        sesJqueryObject('.hidefb').show();
          document.getElementById("fb-spinner").style.display = "none";
          //Put the Data in the Div
          sesJqueryObject('#google_album').html(data);
      }
    });  
}
function sesmediaimporter_flickrgallery_tab(){
  document.getElementById("flickr_album").innerHTML = '<div class="sesbasic_loading_container" id="fb-spinner"></div>';
    //Makes An AJAX Request On Load which retrieves the albums
    sesJqueryObject('.hidefb').hide();
    sesJqueryObject.ajax({
      type: 'post',
      url: 'sesmediaimporter/index/load-flickr-gallery',
      success: function( data ) {
        //Hide The Spinner
        sesJqueryObject('.hidefb').show();
          document.getElementById("fb-spinner").style.display = "none";
          //Put the Data in the Div
          sesJqueryObject('#flickr_album').html(data);
      }
    });  
}
sesJqueryObject(document).on('click','ul#sesmediaimporter_flickr_select li a',function(e){
  var parentElem = sesJqueryObject(this).parent();
  sesJqueryObject('ul#sesmediaimporter_flickr_select').find('li').removeClass('sesbasic_tab_selected');
  sesJqueryObject(parentElem).addClass('sesbasic_tab_selected');
  if(sesJqueryObject(parentElem).hasClass('sesmediaimporter_flickr_galleries')){
    sesmediaimporter_flickrgallery_tab();
    return true;
  }else if(sesJqueryObject(parentElem).hasClass('sesmediaimporter_flickr_getPhotos')){
      var type = 'getPhotos';
   }else if(sesJqueryObject(parentElem).hasClass('sesmediaimporter_flickr_sets')){
      var type = 'getSets';
   }else if(sesJqueryObject(parentElem).hasClass('sesmediaimporter_flickr_favorite')){
      var type = 'getFavourites';
   }
   sesmediaimporter_type_tab(type,'sesmediaimporter/index/load-flickr-photo?type='+type,'flickr_album');
});
sesJqueryObject(document).on('click','.sesmediaimporter_instagram_yourphotos',function(e){
    sesmediaimporter_type_tab('recent','sesmediaimporter/index/load-instagram-gallery','instagram_album');
});
function sesmediaimporter_type_tab(type,url,container){
  document.getElementById(container).innerHTML = '<div class="sesbasic_loading_container" id="fb-spinner"></div>';
    //Makes An AJAX Request On Load which retrieves the albums
    sesJqueryObject('.hidefb').hide();
    sesJqueryObject.ajax({
      type: 'post',
      url: url,
      success: function( data ) {
        //Hide The Spinner
        sesJqueryObject('.hidefb').show();
          document.getElementById("fb-spinner").style.display = "none";
          //Put the Data in the Div
          sesJqueryObject('#'+container).html(data);
      }
    });
}

function get500photos(type){
  document.getElementById("500px_album").innerHTML = '<div class="sesbasic_loading_container" id="fb-spinner"></div>';
    //Makes An AJAX Request On Load which retrieves the albums
    sesJqueryObject('.hidefb').hide();
    sesJqueryObject.ajax({
      type: 'post',
      url: 'sesmediaimporter/index/load-500px-photos/type/'+type,
      success: function( data ) {
        //Hide The Spinner
        sesJqueryObject('.hidefb').show();
          document.getElementById("fb-spinner").style.display = "none";
          //Put the Data in the Div
          sesJqueryObject('#500px_album').html(data);
      }
    });
}
sesJqueryObject(document).on('click','.500px_imp_cls',function(e){
  var data = sesJqueryObject(this).data('url');
  sesJqueryObject('.sesbasic_tab_selected').removeClass('sesbasic_tab_selected');
  sesJqueryObject(this).closest('li').addClass('sesbasic_tab_selected');
  get500photos(data);
})
function sesmediaimporter_album_tab(){
  document.getElementById("facebook_album").innerHTML = '<div class="sesbasic_loading_container" id="fb-spinner"></div>';
    //Makes An AJAX Request On Load which retrieves the albums
    sesJqueryObject('.hidefb').hide();
    sesJqueryObject.ajax({
      type: 'post',
      url: 'sesmediaimporter/index/load-fb-gallery',
      success: function( data ) {
        //Hide The Spinner
        sesJqueryObject('.hidefb').show();
          document.getElementById("fb-spinner").style.display = "none";
          //Put the Data in the Div
          sesJqueryObject('#facebook_album').html(data);
      }
    });
}
sesJqueryObject(document).on('click','.selectGooglephoto',function(e){
  var href = sesJqueryObject(this).data('href');
  ajaxRequestSesmediaimporter('fb-content-data',href,'.hidefb','google_album');
});
sesJqueryObject(document).on('click','.selectFlickrphoto',function(e){
  var href = sesJqueryObject(this).data('href');
  ajaxRequestSesmediaimporter('fb-content-data',href,'.hidefb','flickr_album');
});
sesJqueryObject(document).on('click','.selectfbphoto',function(e){
  var href = sesJqueryObject(this).data('href');
  ajaxRequestSesmediaimporter('fb-content-data',href,'.hidefb','facebook_album');
});

function ajaxRequestSesmediaimporter(id,url,hideContent,maindivid){
  sesJqueryObject(hideContent).hide();
 document.getElementById(maindivid).innerHTML = '<div class="sesbasic_loading_container" id="fb-spinner"></div>';
//Makes An AJAX Request On Load which retrieves the albums
sesJqueryObject.ajax({
      type: 'post',
      url: url,
      success: function( data ) {
        //Hide The Spinner
        sesJqueryObject(hideContent).show();
        //Put the Data in the Div
        sesJqueryObject('#'+maindivid).html(data);
      }
  });
}
