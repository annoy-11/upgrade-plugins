/* $Id: composer_event.js 9930 2013-02-18 21:02:11Z jung $ */
(function() { // START NAMESPACE
var $ = 'id' in document ? document.id : window.$;
Composer.Plugin.Elivestreaming = new Class({

  Extends : Composer.Plugin.Interface,

  name : 'elivestreaming',

  options : {
    title : 'Live Video',
		url:'',
    lang : {}
  },

  initialize : function(options) {
    this.elements = new Hash(this.elements);
    this.params = new Hash(this.params);
    this.parent(options);
  },

  attach : function() {
    this.parent();
    this.makeActivator();
	sesJqueryObject('#compose-elivestreaming-activator').addClass('elivestreaming_a').attr('href','javascript:;');
    return this;
  },

  detach : function() {
    this.parent();
    return this;
  },

  activate : function() {
    if( this.active ) return;
    this.parent();
		this.getComposer().getMenu().getElements('.compose-activator').each(function(element) {
      element.setStyle('display', '');
    });
  },
	deactivate: function() {
      if (!this.active)
        return;
      this.parent();
    }
});



})(); // END NAMESPACE
