/* $Id:composer_buysell.js  2017-01-12 00:00:00 SocialEngineSolutions $*/
var estoreContentSelected = "";
(function() { // START NAMESPACE
var $ = 'id' in document ? document.id : window.$;
Composer.Plugin.Estore = new Class({

  Extends : Composer.Plugin.Interface,

  name : 'estore',

  options : {
    title : 'Add Store',
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
    if(!sesJqueryObject('.sesact_post_store_container').length){
      var html = '<div class="sesact_post_store_container sesbasic_clearfix sesact_post_tag_cnt"><div class="sesact_post_tag_container sesbasic_clearfix estore_post_tag_cnt" style=""><span class="tag">In</span><div class="estore_post_tags_holder sesact_post_tags_holder"><div class="sesact_post_tag_input estore_post_tag_input"><input type="text" class="resetaftersubmit" placeholder="What store do you want to tag?" id="tag_store_input" autocomplete="off"></div></div></div>';
      sesJqueryObject('<input type="hidden" id="storeValues" name="tag_store" class="resetaftersubmit"></div>').insertAfter('.compose-container');
      sesJqueryObject('#sesact_store_tags').html(html);
       addStoreTag();  
     sesJqueryObject('.sesact_post_store_container').show();
		 
    }
     sesJqueryObject('#compose-tray').hide();
    sesJqueryObject('#compose-tray').html('');
    if(sesJqueryObject('#storeValues').length && sesJqueryObject('#storeValues').val()){
       sesJqueryObject('#estore-element').html(estoreContentSelected);
       sesJqueryObject('.estore_post_tag_input').hide();
    }
    sesJqueryObject('.sesact_post_store_container').show();
  },

  deactivate : function() {
    if( !this.active ) return;
    this.parent();
    
    this.request = false;
  },
});
})(); // END NAMESPACE
