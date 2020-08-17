<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesrecipe/externals/styles/styles.css'); ?>
<?php
  $base_url = $this->layout()->staticBaseUrl;
  $this->headScript()
  ->appendFile($base_url . 'externals/autocompleter/Observer.js')
  ->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
  ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
  ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<div class="sesrecipe_banner sesbasic_bxs" style="height:<?php echo $this->allParams['height'];?>px;">
 <div <?php if($this->allParams['showfullwidth'] == 'full'): ?> class="sesrecipe_banner_full" <?php endif; ?> style="height:<?php echo $this->allParams['height'];?>px;">
  <div class="sesrecipe_form_banner" style="background-image:url(<?php echo $this->allParams['backgroundimage']; ?>);">
   <div class="sesrecipe_form_overlay">
    <?php if( $this->form ): ?>
    <div>
    <?php if($this->allParams['bannertext']) { ?>
     <div class="sesrecipe_search_banner_heading">
      <h2><span><?php echo $this->allParams['bannertext']; ?></span></h2>
     </div>
     <?php } ?>
     <?php if($this->allParams['description']) { ?>
     <div class="sesrecipe_search_banner_des">
      <p><?php echo $this->allParams['description']; ?></p>
     </div>
     <?php } ?>
     <div class="sesrecipe_global_search"> <?php echo $this->form->render($this) ?> </div>
     <?php endif ?>
    </div>
   </div>
  </div>
 </div>
</div>
<script type="text/javascript">
  en4.core.runonce.add(function() {
    var searchAutocomplete = new Autocompleter.Request.JSON('title', "<?php echo $this->url(array('module' => 'sesrecipe', 'controller' => 'index', 'action' => 'search'), 'default', true) ?>", {
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
        var choice = new Element('li', {
          'class': 'autocompleter-choices',
          'html': token.photo,
          'id': token.label
        });
        new Element('div', {
          'html': this.markQueryValue(token.label),
          'class': 'autocompleter-choice'
        }).inject(choice);
        choice.inputValue = token;
        this.addChoiceEvents(choice).inject(this.choices);
        choice.store('autocompleteChoice', token);
      }
    });
    searchAutocomplete.addEvent('onSelection', function(element, selected, value, input) {
      var url = selected.retrieve('autocompleteChoice').url;
      window.location.href = url;
    });
  });
</script> 
<script type="text/javascript">
  sesJqueryObject(document).ready(function(){
    sesJqueryObject('#global_content').css('padding-top',0);
    sesJqueryObject('#global_wrapper').css('padding-top',0);	
  });
</script>