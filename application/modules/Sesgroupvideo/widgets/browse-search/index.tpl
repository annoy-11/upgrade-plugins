<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupvideo
 * @package    Sesgroupvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-16 00:00:00 SocialEngineSolutions $
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
  <script type="application/javascript">var Searchurl = "<?php echo $this->url(array('module' =>'sesgroupvideo','controller' => 'index', 'action' => 'get-video'),'default',true); ?>";</script>
  <?php if($controllerName == 'index' && $actionName != 'locations'){ ?>

    <?php if($actionName == 'browse'): ?>
      <?php $identity = Engine_Api::_()->sesgroup()->getIdentityWidget('sesgroupvideo.browse-video','widget','sesgroupvideo_index_browse'); ?>
    <?php endif; ?>

    <?php if(@$identity) { ?>
      <script type="application/javascript">
      sesJqueryObject(document).ready(function(){
        sesJqueryObject('#filter_form').submit(function(e){
          e.preventDefault();
          if(sesJqueryObject('.sesgroupvideo_video_listing').length > 0){
            sesJqueryObject('#tabbed-widget_<?php echo $identity; ?>').html('');
            document.getElementById("tabbed-widget_<?php echo $identity; ?>").innerHTML = "<div class='clear sesbasic_loading_container' id='loading_images_browse_<?php echo $identity; ?>'></div>";
            sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
            sesJqueryObject('#loadingimgsesgroupvideo-wrapper').show();
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
<?php } ?>

<script type="text/javascript">
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
    //$('resource_id').value = selected.retrieve('autocompleteChoice').id;
  });
});

sesJqueryObject(document).ready(function(){
mapLoad = false;
if(sesJqueryObject('#lat-wrapper').length > 0){
  sesJqueryObject('#lat-wrapper').css('display' , 'none');
  sesJqueryObject('#lng-wrapper').css('display' , 'none');
  initializeSesGroupVideoMapList();
}
});
sesJqueryObject( window ).load(function() {
  if(sesJqueryObject('#lat-wrapper').length > 0){
    //initializeSesGroupVideoMapList();
  }
});
sesJqueryObject('#loadingimgsesgroupvideo-wrapper').hide();
</script>