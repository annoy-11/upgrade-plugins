<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
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
<?php $this->headScript()->appendFile($baseURL . 'application/modules/Courses/externals/scripts/jquery.js'); ?>
<div class="courses_browse_search <?php echo $this->view_type=='horizontal' ? 'courses_browse_search_horizontal' : 'courses_browse_search_vertical'; ?>">
  <?php echo $this->form->render($this);  ?>

</div>

<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName(); ?>
<?php $class = '.courses_listing';?>
<?php if($actionName == 'browse'):?>
  <?php $pageName = 'courses_index_browse';?>
  <?php $widgetName = 'courses.browse-courses';?>
<?php endif; ?>1234
<?php $identity = Engine_Api::_()->courses()->getIdentityWidget($widgetName,'widget',$pageName); ?>
<script type="application/javascript">
  sesJqueryObject(document).ready(function(){
     <?php if($controllerName == 'index' && $actionName == 'locations'):?>
    sesJqueryObject('#filter_form').submit(function(e){
      e.preventDefault();
      var error = false;
      sesJqueryObject('#loadingimgsesmember-wrapper').show();
      e.preventDefault();
      searchParams = sesJqueryObject(this).serialize();
      sesJqueryObject('#loadingimgsesmember-wrapper').show();
      callNewMarkersAjax();
      return true;
    });	

   <?php else:?>
  
  sesJqueryObject('#filter_form').submit(function(e){
      e.preventDefault();
      if(sesJqueryObject('<?php echo $class;?>').length > 0){
	sesJqueryObject('#tabbed-widget_<?php echo $identity; ?>').html('');
	document.getElementById("tabbed-widget_<?php echo $identity; ?>").innerHTML = "<div class='clear sesbasic_loading_container' id='loading_images_browse_<?php echo $identity; ?>'></div>";
	sesJqueryObject('#loadingimgcourses-wrapper').show();
      is_search_<?php echo $identity; ?> = 1;
      if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
        isSearch = true;
        e.preventDefault();
        searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
        paggingNumber<?php echo $identity; ?>(1);
      }else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
        isSearch = true;
        e.preventDefault();
        searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
        page<?php echo $identity; ?> = 1;
        viewMore_<?php echo $identity; ?>();
      }
    }
    return true;
    });	
    <?php endif; ?>
  });
  var Searchurl = "<?php echo $this->url(array('module' =>'ecoupon','controller' => 'index', 'action' => 'get-coupon'),'default',true); ?>";
  en4.core.runonce.add(function() {	 
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

