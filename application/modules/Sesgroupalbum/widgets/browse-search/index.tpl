<?php

?>
<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<div class="sesbasic_browse_search <?php echo $this->view_type=='horizontal' ? 'sesbasic_browse_search_horizontal' : ''; ?>">
  <?php echo $this->searchForm->render($this) ?>
</div>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>
<?php if($this->search_for == 'album'){ ?>
<script>var Searchurl = "<?php echo $this->url(array('module' =>'sesgroupalbum','controller' => 'album', 'action' => 'get-album'),'default',true); ?>";</script>
<?php if($controllerName == 'index' && $actionName == 'browse'){ ?>
<?php $identity = Engine_Api::_()->sesgroupalbum()->getIdentityWidget('sesgroupalbum.browse-albums','widget','sesgroupalbum_index_browse'); ?>
<?php if($identity){ ?>
<script type="application/javascript">
sesJqueryObject(document).ready(function(){
		sesJqueryObject('#filter_form').submit(function(e){
			if(sesJqueryObject('.sesgroupalbum_browse_album_listings').length > 0){
				sesJqueryObject('#loadingimgsesgroupalbum-wrapper').show();
				if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
					e.preventDefault();
					searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
				  paggingNumber<?php echo $identity; ?>(1);
				}else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
					e.preventDefault();
					searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
					page<?php echo $identity; ?> = 1;
				  viewMore_<?php echo $identity; ?>();
				}
			}
		return true;
		});	
});
</script>
<?php } ?>
<?php } ?>
<?php }else{ ?>
<script>var Searchurl = "<?php echo $this->url(array('module' =>'sesgroupalbum','controller' => 'photo', 'action' => 'get-photo'),'default',true); ?>";</script>
<?php if($controllerName == 'index' && $actionName == 'browse-photo'){ ?>
<?php $identity = Engine_Api::_()->sesgroupalbum()->getIdentityWidget('sesgroupalbum.tabbed-widget','widget','sesgroupalbum_index_browse-photo'); ?>
<?php if($identity){ ?>
<script type="application/javascript">
sesJqueryObject(document).ready(function(){
		sesJqueryObject('#filter_form').submit(function(e){
			e.preventDefault();
			if(sesJqueryObject('.sesgroupalbum_tabbed_listings').length > 0){
				sesJqueryObject('#loadingimgsesgroupalbum-wrapper').show();
				if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
					e.preventDefault();
					searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
				  paggingNumber<?php echo $identity; ?>(1);
				}else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
					e.preventDefault();
					searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
					page<?php echo $identity; ?> = 1;
				  viewMore_<?php echo $identity; ?>();
				}
			}
		return true;
		});	
});
<?php } ?>
</script>
<?php } ?>
<?php } ?>
<script type="text/javascript">
en4.core.runonce.add(function()
  {
		 
      var contentAutocomplete = new Autocompleter.Request.JSON('search', Searchurl, {
        'postVar': 'text',
        'minLength': 1,
        'selectMode': 'pick',
        'autocompleteType': 'tag',
        'customChoices': true,
        'filterSubset': true,
        'multiple': false,
        'className': 'sesbasic-autosuggest',
        'injectChoice': function(token) {
          var choice = new Element('li', {
            'class': 'autocompleter-choices', 
            'html': token.photo, 
            'id':token.label
          });
          new Element('div', {
            'html': this.markQueryValue(token.label),
            'class': 'autocompleter-choice'
          }).inject(choice);
          this.addChoiceEvents(choice).inject(this.choices);
          choice.store('autocompleteChoice', token);
        }
      });
      contentAutocomplete.addEvent('onSelection', function(element, selected, value, input) {
        //$('resource_id').value = selected.retrieve('autocompleteChoice').id;
      });
    });
	

sesJqueryObject(document).ready(function(){
mapLoad = false;
if(sesJqueryObject('#lat-wrapper').length > 0){
	sesJqueryObject('#lat-wrapper').css('display' , 'none');
	sesJqueryObject('#lng-wrapper').css('display' , 'none');
	initializeSesGroupAlbumMapList();
}
});
sesJqueryObject( window ).load(function() {
	if(sesJqueryObject('#lat-wrapper').length > 0){
		editGroupSetMarkerOnMapList();
	}
});
sesJqueryObject('#loadingimgsesgroupalbum-wrapper').hide();
</script>