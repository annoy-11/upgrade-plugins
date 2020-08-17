<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2018-11-22 00:00:00 SocialEngineSolutions $
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
<?php include APPLICATION_PATH .  '/application/modules/Sesautoaction/views/scripts/dismiss_message.tpl';?>
<div class="sesbasic_search_reasult">
	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesautoaction', 'controller' => 'botmanageaction', 'action' => 'index'), $this->translate("Back to Manage Bot Auto Actions") , array('class'=>'sesbasic_icon_back buttonlink')); ?>
</div>
<div class='clear'>
  <div class='settings sesbasic_admin_form sesautoaction_botmanageaction_create'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

  en4.core.runonce.add(function(){
    if($('member_levels-wrapper'))
      $('member_levels-wrapper').style.display = 'none';

    formObj = sesJqueryObject('#form-auto-action').find('div').find('div').find('div');
  });
    
  function chooseoptions(value) {
    if(value == 1) {
      if($('name-wrapper'))
        $('name-wrapper').style.display = 'block';
      if($('member_levels-wrapper'))
        $('member_levels-wrapper').style.display = 'none';
    } else { 
      if($('member_levels-wrapper'))
        $('member_levels-wrapper').style.display = 'block';
      if($('name-wrapper'))
        $('name-wrapper').style.display = 'none';
    }
  }

  en4.core.runonce.add(function() {
      var contentAutocomplete = new Autocompleter.Request.JSON('name', "<?php echo $this->url(array('module' => 'sesautoaction', 'controller' => 'botmanageaction', 'action' => 'getusers'), 'admin_default', true) ?>", {
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
        $('resource_id').value = selected.retrieve('autocompleteChoice').id;
      });
    });
</script>
