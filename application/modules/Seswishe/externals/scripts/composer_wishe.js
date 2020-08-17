/* $Id:composer_buysell.js  2017-01-12 00:00:00 SocialEngineSolutions $*/

(function() { // START NAMESPACE
var $ = 'id' in document ? document.id : window.$;
Composer.Plugin.Wishe = new Class({
  Extends : Composer.Plugin.Interface,
  name : 'wishe',
  options : {
    title : 'Wishe',
    lang : {},
    // Options for the link preview request
    requestOptions : {},
    debug : false
  },

  initialize : function(options) {
    this.params = new Hash(this.params);
    this.parent(options);
  },

  attach : function() {
    this.parent();
    this.makeActivator();
    return this;
  },

  detach : function() {
    this.parent();
    if( this.interval ) $clear(this.interval);
    return this;
  },

  activate : function() {
    if( this.active ) return;
    this.parent();

    this.makeMenu();
    this.makeBody();
    
    var title = '';
    
    var wishe = '<div class="seswishe_wishe_composer_title"><input type="text" id="wishe-title" placeholder="'+ en4.core.language.translate("Title")+'" name="wishe-title"></div><div class="seswishe_wishe_composer_des"><textarea id="wishe-description" placeholder="'+ en4.core.language.translate("Wishe")+'" name="wishe-description"></textarea></div>';
    var source = '<div class="seswishe_wishe_composer_src"><i>&mdash; </i><span><input type="text" id="wishe-source" placeholder="'+ en4.core.language.translate("Source")+'" name="wishe-source"></span></div>';

    var category = '<div class="seswishe_wishe_composer_category"><select name="category_id" id="category_id" onchange="wisheShowSubCategory(this.value);">'+this.options.categoryOptionValues+'</select></div>';
    
    var subcategory = '<div style="display:none;" id="subcat_id-wrapper" class="seswishe_wishe_composer_category"><select name="subcat_id" id="subcat_id" onchange="wisheShowSubSubCategory(this.value);"><option value="0" selected="selected"></option></select></div>';
    
    var subsubcategory = '<div style="display:none;" id="subsubcat_id-wrapper" class="seswishe_wishe_composer_category"><select name="subsubcat_id" id="subsubcat_id"><option value="0"></option></select></div>';

    var tags = '<div class="seswishe_wishe_composer_tags"><input type="text" id="tags" placeholder="'+ en4.core.language.translate("#tags")+'" name="tags"></div>';
    
    if(iframlyEndbled) {
      var choosemediaType = '<div class="seswishe_wishe_composer_mediatype seswishe_composer_media_wrapper"><ul class="sesbasic_clearfix"><li><input onchange="showMediaType(this.value);", type="radio" id="seswishe_composer_mediatype_1" name="mediatype" value="1" checked><label for="seswishe_composer_mediatype_1">'+en4.core.language.translate("Photo")+'</label></li><li><input onchange="showMediaType(this.value);", type="radio" id="seswishe_composer_mediatype_2" name="mediatype" value="2"><label for="seswishe_composer_mediatype_2">'+en4.core.language.translate("Video")+'</label></li></ul></div>';
    } else 
      var choosemediaType = '';

    var photo = '<div id="photo-wrapper" class="seswishe_wishe_composer_photo"><input type="file" id="photo" placeholder="'+ en4.core.language.translate("photo")+'" name="photo"></div>';
    
    if(iframlyEndbled) {
      var video = '<div style="display:none;" id="video-wrapper" class="seswishe_wishe_composer_video"><input type="text" name="video" id="video" value="" placeholder="'+en4.core.language.translate("Paste the web address of the video here.")+'" onblur="sesadvfeiframelyurl();"></div>';
    } else 
      var video = '';

    sesJqueryObject(this.elements.body).html('<div class="seswishe_wishe_composer">'+title+wishe+source+category+subcategory+subsubcategory+tags+choosemediaType+photo+video+'</div>');
    
    var field = '<input type="hidden" name="attachment[type]" value="wishe">';
    if(!sesJqueryObject('.fileupload-cnt').length)
      sesJqueryObject('#activity-form').append('<div style="display:none" class="fileupload-cnt">'+field+'</div>');
    else
      sesJqueryObject('.fileupload-cnt').html(field);
  },

  deactivate : function() {
    if( !this.active ) return;
    this.parent();
    
    this.request = false;
  },
});
})(); // END NAMESPACE

function showMediaType(value) {
  if(value == 1) {
    if($('photo-wrapper'))
      $('photo-wrapper').style.display = 'block';
    if($('video-wrapper'))
      $('video-wrapper').style.display = 'none';
    if($('video'))
      $('video').value = '';
  } else if(value == 2) { 
    if($('photo-wrapper'))
      $('photo-wrapper').style.display = 'none';
    if($('video-wrapper'))
      $('video-wrapper').style.display = 'block';
  }
}

en4.core.runonce.add(function() {
  showMediaType(1);
  
  sesJqueryObject('#subcat_id-wrapper').hide();
  sesJqueryObject('#subsubcat_id-wrapper').hide();
});


function sesadvfeiframelyurl() {

  var url_element = document.getElementById("video-wrapper");
  var myElement = new Element("p");
  myElement.innerHTML = "test";
  myElement.addClass("description");
  myElement.id = "validation";
  myElement.style.display = "none";
  url_element.appendChild(myElement);

  var url = $('video').value;
  if(url == '') {
    return false;
  }
  var iframelyURL = en4.core.baseUrl + 'seswishe/index/get-iframely-information/';
  new Request.JSON({
    'url' : iframelyURL,
    'data' : {
      'format': 'json',
      'uri' : url,
    },
    'onRequest' : function() {
      $('validation').style.display = "block";
      $('validation').innerHTML = en4.core.language.translate("Checking URL...");
    },
    'onSuccess' : function(response) {
      if( response.valid ) {
        $('validation').style.display = "block";
        $('validation').innerHTML = en4.core.language.translate("Your url is valid.");
      } else {
        $('validation').style.display = "block";
        $('validation').innerHTML = en4.core.language.translate('We could not find a video there - please check the URL and try again.');
      }
    }
  }).send();
}

function wisheShowSubCategory(cat_id,selectedId) {

  var selected;
  if(selectedId != ''){
    var selected = selectedId;
  }
  var url = en4.core.baseUrl + 'seswishe/category/subcategory/category_id/'+cat_id;
  new Request.HTML({
    url: url,
    data: {
      'selected':selected
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      if (sesJqueryObject('#subcat_id-wrapper').length && responseHTML) {
        sesJqueryObject('#subcat_id-wrapper').show();
        sesJqueryObject('#subcat_id-wrapper').find('#subcat_id').html(responseHTML);
      } else {
        if (sesJqueryObject('#subcat_id-wrapper').length) {
          sesJqueryObject('#subcat_id-wrapper').hide();
          sesJqueryObject('#subcat_id-wrapper').find('#subcat_id').html( '<option value="0"></option>');
        }
      }
      if (sesJqueryObject('#subsubcat_id-wrapper').length) {
        sesJqueryObject('#subsubcat_id-wrapper').hide();
        sesJqueryObject('#subsubcat_id-wrapper').find('#subsubcat_id').html( '<option value="0"></option>');
      }
    }
  }).send(); 
}


function wisheShowSubSubCategory(cat_id,selectedId,isLoad) {

  if(cat_id == 0){
    if (sesJqueryObject('#subsubcat_id-wrapper').length) {
      sesJqueryObject('#subsubcat_id-wrapper').hide();
      sesJqueryObject('#subsubcat_id-wrapper').find('#subsubcat_id').html( '<option value="0"></option>');
    }
    return false;
  }

  var selected;
  if(selectedId != ''){
    var selected = selectedId;
  }
  
  var url = en4.core.baseUrl + 'seswishe/category/subsubcategory/subcategory_id/' + cat_id;
  (new Request.HTML({
    url: url,
    data: {
      'selected':selected
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      if (sesJqueryObject('#subsubcat_id-wrapper').length && responseHTML) {
        sesJqueryObject('#subsubcat_id-wrapper').show();
        sesJqueryObject('#subsubcat_id-wrapper').find('#subsubcat_id').html(responseHTML);
      } else {
        if (sesJqueryObject('#subsubcat_id-wrapper').length) {
          sesJqueryObject('#subsubcat_id-wrapper').hide();
          sesJqueryObject('#subsubcat_id-wrapper').find('#subsubcat_id').html( '<option value="0"></option>');
        }
      }
    }
  })).send();  
}