<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventvideo
 * @package    Seseventvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<div class="sesbasic_browse_search <?php echo $this->view_type=='horizontal' ? 'sesbasic_browse_search_horizontal' : 'sesbasic_browse_search_vertical'; ?>">
  <?php echo $this->searchForm->render($this) ?>
</div>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>
<?php if($this->search_for == 'video'){ ?>
<script type="application/javascript">var SearchEventurl = "<?php echo $this->url(array('module' =>'sesevent','controller' => 'index', 'action' => 'get-event'),'default',true); ?>";</script>
<?php if($controllerName == 'index' && $actionName == 'locations'){?>
	<script type="application/javascript">var Searchurl = "<?php echo $this->url(array('module' =>'seseventvideo','controller' => 'index', 'action' => 'get-video'),'default',true); ?>";</script>
  <script type="application/javascript">
sesJqueryObject(document).ready(function(){
		sesJqueryObject('#filter_form').submit(function(e){
			e.preventDefault();
			var error = false;
			if(sesJqueryObject('#locationSesList').val() == ''){
				sesJqueryObject('#locationSesList').css('border-color','red');
				error = true;
			}else{
				sesJqueryObject('#locationSesList').css('border-color','');
			}
			if(sesJqueryObject('#miles').val() == 0){
				error = true;
				sesJqueryObject('#miles').css('border-color','red');
			}else{
				sesJqueryObject('#miles').css('border-color','');
			}
			if(map && !error){
				sesJqueryObject('#loadingimgseseventvideo-wrapper').show();
					e.preventDefault();
					searchParams = sesJqueryObject(this).serialize();
				  callNewMarkersAjax();
			}
		return true;
		});	
});
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
			var contentAutocomplete1 = new Autocompleter.Request.JSON('search_event', SearchEventurl, {
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
      contentAutocomplete1.addEvent('onSelection', function(element, selected, value, input) {
        //$('resource_id').value = selected.retrieve('autocompleteChoice').id;
      });
    });
sesJqueryObject(document).ready(function(){
mapLoad = false;
if(sesJqueryObject('#lat-wrapper').length > 0){
	sesJqueryObject('#lat-wrapper').css('display' , 'none');
	sesJqueryObject('#lng-wrapper').css('display' , 'none');
	initializeSesEventVideoMapList();
}
});
sesJqueryObject( window ).load(function() {
	if(sesJqueryObject('#lat-wrapper').length > 0){
		//initializeSesVideoMapList();
	}
});
sesJqueryObject('#loadingimgseseventvideo-wrapper').hide();
</script>