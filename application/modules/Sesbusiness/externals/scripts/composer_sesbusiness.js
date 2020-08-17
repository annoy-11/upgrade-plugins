/* $Id:composer_buysell.js  2017-01-12 00:00:00 SocialEngineSolutions $*/
var sesbusinessContentSelected = "";
(function() { // START NAMESPACE
var $ = 'id' in document ? document.id : window.$;
Composer.Plugin.Sesbusiness = new Class({

  Extends : Composer.Plugin.Interface,

  name : 'sesbusiness',

  options : {
    title : 'Add Business',
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
    if(!sesJqueryObject('.sesact_post_business_container').length){
      var html = '<div class="sesact_post_business_container sesbasic_clearfix sesact_post_tag_cnt"><div class="sesact_post_tag_container sesbasic_clearfix sesbusiness_post_tag_cnt" style=""><span class="tag">In</span><div class="sesbusiness_post_tags_holder sesact_post_tags_holder"><div class="sesact_post_tag_input sesbusiness_post_tag_input"><input type="text" class="resetaftersubmit" placeholder="What business do you want to tag?" id="tag_business_input" autocomplete="off"></div></div></div>';
      sesJqueryObject('<input type="hidden" id="businessValues" name="tag_business" class="resetaftersubmit"></div>').insertAfter('.compose-container');
      sesJqueryObject('#sesact_business_tags').html(html);
       addBusinessTag();  
     sesJqueryObject('.sesact_post_business_container').show();
		 
    }
     sesJqueryObject('#compose-tray').hide();
    sesJqueryObject('#compose-tray').html('');
    if(sesJqueryObject('#businessValues').length && sesJqueryObject('#businessValues').val()){
       sesJqueryObject('#sesbusiness-element').html(sesbusinessContentSelected);
       sesJqueryObject('.sesbusiness_post_tag_input').hide();
    }
    sesJqueryObject('.sesact_post_business_container').show();
  },

  deactivate : function() {
    if( !this.active ) return;
    this.parent();
    
    this.request = false;
  },
});
})(); // END NAMESPACE
