/* $Id:composer_buysell.js  2017-01-12 00:00:00 SocialEngineSolutions $*/
var sesgroupContentSelected = "";
(function() { // START NAMESPACE
var $ = 'id' in document ? document.id : window.$;
Composer.Plugin.Sesgroup = new Class({

  Extends : Composer.Plugin.Interface,

  name : 'sesgroup',

  options : {
    title : 'Add Group',
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
    if(!sesJqueryObject('.sesact_post_group_container').length){
      var html = '<div class="sesact_post_group_container sesbasic_clearfix sesact_post_tag_cnt"><div class="sesact_post_tag_container sesbasic_clearfix sesgroup_post_tag_cnt" style=""><span class="tag">In</span><div class="sesgroup_post_tags_holder sesact_post_tags_holder"><div class="sesact_post_tag_input sesgroup_post_tag_input"><input type="text" class="resetaftersubmit" placeholder="What group do you want to tag?" id="tag_group_input" autocomplete="off"></div></div></div>';
      sesJqueryObject('<input type="hidden" id="groupValues" name="tag_group" class="resetaftersubmit"></div>').insertAfter('.compose-container');
      sesJqueryObject('#sesact_group_tags').html(html);
       addGroupTag();  
     sesJqueryObject('.sesact_post_group_container').show();
		 
    }
     sesJqueryObject('#compose-tray').hide();
    sesJqueryObject('#compose-tray').html('');
    if(sesJqueryObject('#groupValues').length && sesJqueryObject('#groupValues').val()){
       sesJqueryObject('#sesgroup-element').html(sesgroupContentSelected);
       sesJqueryObject('.sesgroup_post_tag_input').hide();
    }
    sesJqueryObject('.sesact_post_group_container').show();
  },

  deactivate : function() {
    if( !this.active ) return;
    this.parent();
    
    this.request = false;
  },
});
})(); // END NAMESPACE
