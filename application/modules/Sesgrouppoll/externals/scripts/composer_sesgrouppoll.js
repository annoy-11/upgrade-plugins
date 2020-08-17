/* $Id: composer_photo.js 9930 2013-02-18 21:02:11Z jung $ */
(function() { // START NAMESPACE
var $ = 'id' in document ? document.id : window.$;


Composer.Plugin.Sesgrouppoll = new Class({
  Extends : Composer.Plugin.Interface,
  name : 'sesgrouppoll',
  options : {
    title : 'Add Poll',
    lang : {},
    requestOptions : false,
    fancyUploadEnabled : true,
    fancyUploadOptions : {}
  },
  initialize : function(options) {
    this.elements = new Hash(this.elements);
    this.params = new Hash(this.params);
    this.parent(options);
  },
  attach : function() {
    this.parent();
    this.makeActivator();
    append();
    return this;
  },
  detach : function() {
    this.parent();
    return this;
  },
  activate : function() {
    if( this.active ) return;
    this.parent();
    this.makeMenu();
    this.makeBody();
    // Generate form
    var title = '<div class="sesact_poll_composer"><div class="sesact_poll_composer_title"><input type="text"' +
      ' placeholder="'+ en4.core.language.translate("Poll Tiltle?")+'" name="title" id="title"></div>';
    var description = '<div class="sesact_poll_composer_description"><input type="text" name="description"  id="description" placeholder="'+en4.core.language.translate("description?")+'"></div><div class="error_div" style"display:none"></div>';
    var option = '<div class="sesact_poll_composer_option" ><a href="javascript: void(0);" style="display:none"' +
      ' onclick="return addAnotherOption();" id="addOptionLink">Add Another Option</a><input type="textarea"' +
      ' style="display:none"   placeholder="'+en4.core.language.translate("options?")+'"></div></div>';
    sesJqueryObject(this.elements.body).html(title+description+option);

    sesgrouppollappend();
    sesgrouppollappend();
	var totaloption = sesJqueryObject('.pollOptionInput').length;
    if(sesJqueryObject("#max").val() > totaloption){
      sesJqueryObject("#addOptionLink").css("display","block");
    }
    this.makeFormInputs();
  },
  deactivate : function() {
    if( !this.active ) return;
    this.parent();
    sesJqueryObject('#fancyalbumuploadfileids').remove();
    sesJqueryObject('#pollsesgroup').remove();
    sesJqueryObject('#messageAttachment').remove();
  },
  doRequest : function() {
    this.elements.iframe = new IFrame({
      'name' : 'composePollFrame',
      'src' : 'javascript:false;',
      'styles' : {
        'display' : 'none'
      },
      'events' : {
        'load' : function() {
          this.doProcessResponse(window._composePollResponse);
          window._composePollResponse = false;
        }.bind(this)
      }
    }).inject(this.elements.body);

    window._composePollResponse = false;
    this.elements.form.set('target', 'composePollFrame');

    // Submit and then destroy form
    this.elements.form.submit();
    this.elements.form.destroy();

    // Start loading screen
    this.makeLoading();
  },

  doProcessResponse : function(responseJSON) {

  },
  makeFormInputs : function() {
    this.ready();
    this.parent({
      'grouppoll' : '',
    });
  }

});



})(); // END NAMESPACE


