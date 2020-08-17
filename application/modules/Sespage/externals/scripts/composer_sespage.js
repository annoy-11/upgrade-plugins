/* $Id:composer_buysell.js  2017-01-12 00:00:00 SocialEngineSolutions $*/
var sespageContentSelected = "";
(function() { // START NAMESPACE
var $ = 'id' in document ? document.id : window.$;
Composer.Plugin.Sespage = new Class({

  Extends : Composer.Plugin.Interface,

  name : 'sespage',

  options : {
    title : 'Add Page',
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
    if(!sesJqueryObject('.sesact_post_page_container').length){
      var html = '<div class="sesact_post_page_container sesbasic_clearfix sesact_post_tag_cnt"><div class="sesact_post_tag_container sesbasic_clearfix sespage_post_tag_cnt" style=""><span class="tag">In</span><div class="sespage_post_tags_holder sesact_post_tags_holder"><div class="sesact_post_tag_input sespage_post_tag_input"><input type="text" class="resetaftersubmit" placeholder="What page do you want to tag?" id="tag_page_input" autocomplete="off"></div></div></div>';
      sesJqueryObject('<input type="hidden" id="pageValues" name="tag_page" class="resetaftersubmit"></div>').insertAfter('.compose-container');
      sesJqueryObject('#sesact_page_tags').html(html);
       addPageTag();  
     sesJqueryObject('.sesact_post_page_container').show();
		 
    }
     sesJqueryObject('#compose-tray').hide();
    sesJqueryObject('#compose-tray').html('');
    if(sesJqueryObject('#pageValues').length && sesJqueryObject('#pageValues').val()){
       sesJqueryObject('#sespage-element').html(sespageContentSelected);
       sesJqueryObject('.sespage_post_tag_input').hide();
    }
    sesJqueryObject('.sesact_post_page_container').show();
  },

  deactivate : function() {
    if( !this.active ) return;
    this.parent();
    
    this.request = false;
  },
});
})(); // END NAMESPACE
