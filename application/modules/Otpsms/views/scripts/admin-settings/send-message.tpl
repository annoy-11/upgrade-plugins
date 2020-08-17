<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: send-message.tpl  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class='global_form_popup'> <?php echo $this->formFilter->render($this) ?> </div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<?php

$this->headScript()
->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Observer.js')
->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.js')
->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Request.js');
?>
<script type="application/javascript">
   var contentAutocomplete;
    var maxRecipients = 1;
    function removeFromToValue(id, elmentValue, element) {
      var toValues = $(elmentValue).value;
      var toValueArray = toValues.split(",");
      var toValueIndex = "";
      var checkMulti = id.search(/,/);
      // check if we are removing multiple recipients
      if (checkMulti != - 1) {
        var recipientsArray = id.split(",");
        for (var i = 0; i < recipientsArray.length; i++){
          removeToValue(recipientsArray[i], toValueArray, elmentValue);
        }
      } else {
        removeToValue(id, toValueArray, elmentValue);
      }
  
      // hide the wrapper for element if it is empty
      if ($(elmentValue).value == ""){
        $(elmentValue + '-wrapper').setStyle('height', '0');
        $(elmentValue + '-wrapper').setStyle('display', 'none');
      }
      $(element).disabled = false;
    }

    function removeToValue(id, toValueArray, elmentValue) {
      for (var i = 0; i < toValueArray.length; i++){
       if (toValueArray[i] == id) toValueIndex = i;
      }
      toValueArray.splice(toValueIndex, 1);
      $(elmentValue).value = toValueArray.join();
    }
    en4.core.runonce.add(function()
    {

    contentAutocomplete = new Autocompleter.Request.JSON('user', '<?php echo $this->url(array('module' => 'otpsms', 'controller' => 'settings', 'action' => 'users'), 'admin_default', true) ?>', {
    'postVar' : 'search',
            'minLength': 1,
            'delay' : 250,
            'selectMode': 'pick',
            'autocompleteType': 'tag',
            'className': 'autosuggest',
            'filterSubset' : true,
            'multiple' : false,
            'injectChoice': function(token){
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
             },
            onPush : function() {
              if ($(this.options.elementValues).value.split(',').length >= maxRecipients) {
                this.element.disabled = true;
              }
            }
      });
      contentAutocomplete.addEvent('onSelection', function(element, selected, value, input) {
        $('user_id').value = selected.retrieve('autocompleteChoice').id;
      });
 });
</script> 
<script type="text/javascript">
sesJqueryObject(document).on('change','#type',function(e){
  var value = sesJqueryObject(this).val();
  if(value == 'memberlevel'){
    sesJqueryObject('#sendto-wrapper').show();
    sesJqueryObject('#user-wrapper').hide();
    sesJqueryObject('#profiletype-wrapper').hide();
    sesJqueryObject('#memberlevel-wrapper').show();
    sesJqueryObject('#sendto').trigger('change');
  }else if(value == "profiletype"){
    sesJqueryObject('#memberlevel-wrapper').hide();
    sesJqueryObject('#sendto-wrapper').hide();
    sesJqueryObject('#user-wrapper').hide();
    sesJqueryObject('#profiletype-wrapper').show();
  }
});
sesJqueryObject('#type').trigger('change');
sesJqueryObject(document).on('change','#sendto',function(e){
  var value = sesJqueryObject(this).val();
  if(value == 'specific'){
    sesJqueryObject('#user-wrapper').show();
  }else{
    sesJqueryObject('#user-wrapper').hide();
  }
});
</script>