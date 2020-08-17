<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
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
<div class="eclassroom_album_search sesbasic_browse_search <?php echo $this->view_type=='horizontal' ? 'sesbasic_browse_search_horizontal' : ''; ?>">
  <?php echo $this->searchForm->render($this); ?>
</div>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName(); ?>
<?php $actionName = $request->getActionName();?>
<script>var Searchurl = "<?php echo $this->url(array('module' =>'eclassroom','controller' => 'album', 'action' => 'get-album'),'default',true); ?>";</script>
<?php if($controllerName == 'album' && $actionName == 'browse') { ?>
  <?php $identity = Engine_Api::_()->courses()->getIdentityWidget('eclassroom.browse-albums','widget','eclassroom_album_browse'); ?>
  <?php if($identity){ ?>
    <script type="application/javascript">
      sesJqueryObject(document).ready(function(){
        sesJqueryObject('#filter_form').submit(function(e){
          if(sesJqueryObject('.eclassroom_browse_album_listings').length > 0){
            sesJqueryObject('#loadingimgeclassroom-wrapper').show();
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
<script type="text/javascript">
  sesJqueryObject('#loadingimgeclassroom-wrapper').hide();
</script>
<script type='text/javascript'>
  en4.core.runonce.add(function() { 
    var contentAutocomplete = new Autocompleter.Request.JSON('search', "<?php echo $this->url(array('module' =>'eclassroom','controller' => 'album', 'action' => 'get-album'),'default',true); ?>", {
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
      var to =  selected.retrieve('autocompleteChoice');
      sesJqueryObject('#album_id').val(to.id);
    });
  });
</script>
