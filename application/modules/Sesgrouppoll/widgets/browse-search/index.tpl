<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<script type="text/javascript">
 
</script>

<?php if( $this->form ): ?>
  <?php echo $this->form->render($this) ?>
<?php endif ?>

<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>

<script type="application/javascript">
 var searchGroupUrl = "<?php echo $this->url(array('module' =>'sesgrouppoll','controller' => 'index', 'action' => 'get-group'),'default',true); ?>";
  en4.core.runonce.add(function()
  {
    var contentAutocomplete = new Autocompleter.Request.JSON('searchgroup', searchGroupUrl, {
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
var Searchurl = "<?php echo $this->url(array('module' =>'sesgrouppoll','controller' => 'index', 'action' => 'get-poll'),'default',true); ?>";</script>

<?php if($controllerName == 'index' && $actionName == 'browse'){ ?>
	<?php $identity = Engine_Api::_()->sesgroup()->getIdentityWidget('sesgrouppoll.browse-polls','widget','sesgrouppoll_index_browse'); ?>
	  <?php if(@$identity) { ?>
      <script type="application/javascript">
      sesJqueryObject(document).ready(function(){
	 
        sesJqueryObject('#filter_form').submit(function(e){
          e.preventDefault();
          if(sesJqueryObject('.sesgrouppoll_poll_listing').length > 0){
            sesJqueryObject('#tabbed-widget_<?php echo $identity; ?>').html('');
            document.getElementById("tabbed-widget_<?php echo $identity; ?>").innerHTML = "<div class='clear sesbasic_loading_container' id='loading_images_browse_<?php echo $identity; ?>'></div>";
            sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
            sesJqueryObject('#loadingimgsesgrouppoll-wrapper').show();
            if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
              e.preventDefault();
              searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
              paggingNumber<?php echo $identity; ?>(1);
			  sesJqueryObject('#loading_image_<?php echo $identity; ?>').hide();
            }else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
              e.preventDefault();
              searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
              page<?php echo $identity; ?> = 1;
              viewMore_<?php echo $identity; ?>();
			  sesJqueryObject('#loading_image_<?php echo $identity; ?>').hide();
            }
          }
          return true;
        });
      });
      </script>
    <?php } ?>
	
<?php } ?>
