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
<?php if( $this->form ): ?>
  <div class="sesbasic_browse_search">
    <?php echo $this->form->render($this) ?>
  </div>
<?php endif; ?>

<script type="text/javascript">
var title_name = document.getElementById("title_name");
title_name.addEventListener("keydown", function (e) {
    if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
        this.form.submit();
    }
});
</script>
<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<?php $identity = Engine_Api::_()->courses()->getIdentityWidget('courses.browse-wishlists','widget','courses_wishlist_browse'); ?>
<script type="text/javascript">
  
  //Take refrences from "/application/modules/Blog/views/scripts/index/create.tpl"
  en4.core.runonce.add(function() {
    var searchAutocomplete = new Autocompleter.Request.JSON('title_name', "<?php echo $this->url(array('module' => 'courses', 'controller' => 'index', 'action' => 'search', 'actonType' => 'browse','search_type'=>'courses_wishlist'), 'default', true) ?>", {
      'postVar': 'text',
      'delay' : 250,      
      'minLength': 1,
      'selectMode': 'pick',
      'autocompleteType': 'tag',
      'customChoices': true,
      'filterSubset': true,
      'multiple': false,
      'className': 'sesbasic-autosuggest',
      'injectChoice': function(token) {
        var choice = new Element('li', {'class': 'autocompleter-choices', 'html': token.photo, 'id': token.label});
        new Element('div', {'html': this.markQueryValue(token.label), 'class': 'autocompleter-choice'}).inject(choice);
        choice.inputValue = token;
        this.addChoiceEvents(choice).inject(this.choices);
        choice.store('autocompleteChoice', token);
      }
    });
    contentAutocomplete.addEvent('onSelection', function(element, selected, value, input) {
      document.getElementById('album_id').value = selected.retrieve('autocompleteChoice').id;
    });
  });
</script>
<script type="application/javascript">
  sesJqueryObject(document).ready(function(){
    sesJqueryObject('#filter_form').submit(function(e){ 
      e.preventDefault();
        isSearch = true;
         e.preventDefault();
        searchParams = sesJqueryObject(this).serialize();
    });	
  });
  
  sesJqueryObject('#filter_form').submit(function(e){
    e.preventDefault();
    if(sesJqueryObject('.courses_browse_wishlist').length > 0){
      sesJqueryObject('#browse-wishlist-widget_<?php echo $identity; ?>').html('');
      document.getElementById("browse-wishlist-widget_<?php echo $identity; ?>").innerHTML = "<div class='clear sesbasic_loading_container' id='loading_images_browse_<?php echo $identity; ?>'></div>";
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
</script>
