<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-14 00:00:00 SocialEngineSolutions $
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
<div class="sesbasic_clearfix sesbasic_bxs sespage_browse_search <?php echo $this->view_type=='horizontal' ? 'sespage_browse_search_horizontal' : 'sespage_browse_search_vertical'; ?>">
    <?php echo $this->form->render($this) ?>
  </div>
  <?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
  <?php $controllerName = $request->getControllerName();?>
  <?php $actionName = $request->getActionName(); ?>
  <?php $class = '.sespagenote_notes_listing';?>
  <?php $pageName = 'sespagenote_index_browse';?>
  <?php $widgetName = 'sespagenote.browse-notes';?>

  <?php $identity = Engine_Api::_()->sesbasic()->getIdentityWidget($widgetName,'widget',$pageName); ?>
  
<script type="application/javascript">
  
  function submitForm<?php echo $this->identity; ?>(obj){
      if(sesJqueryObject('<?php echo $class;?>').length > 0){
          sesJqueryObject('#tabbed-widget_<?php echo $identity; ?>').html('');
          sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
          sesJqueryObject('#loadingimgsespage-wrapper').show();
          is_search_<?php echo $identity; ?> = 1;
          if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
              isSearch = true;
              searchParams<?php echo $identity; ?> = sesJqueryObject(obj).serialize();
              paggingNumber<?php echo $identity; ?>(1);
          }else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
              isSearch = true;
              searchParams<?php echo $identity; ?> = sesJqueryObject(obj).serialize();
              page<?php echo $identity; ?> = 1;
              viewMore_<?php echo $identity; ?>();
          }
      }
  }
  en4.core.runonce.add(function() {
    sesJqueryObject(document).on('submit','#filter_form',function(e){
      e.preventDefault();
      submitForm<?php echo $this->identity; ?>(this);
      return true;
    });	
  });
  
  var Searchurl = "<?php echo $this->url(array('module' =>'sespage','controller' => 'ajax', 'action' => 'get-page'),'default',true); ?>";
  en4.core.runonce.add(function() {
    formObj = sesJqueryObject('#filter_form').find('div').find('div').find('div');
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
    });
  });
</script>
