<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: signupinterest.tpl  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php
//   if (APPLICATION_ENV == 'production')
//     $this->headScript()
//       ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.min.js');
//   else
//     $this->headScript()
//       ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Observer.js')
//       ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.js')
//       ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Local.js')
//       ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Request.js');
?>

<script type="text/javascript">
//   en4.core.runonce.add(function()
//   {
//     new Autocompleter.Request.JSON('custom_interests', '<?php //echo $this->url(array('module' => 'sesinterest', 'controller' => 'index', 'action' => 'suggest'), 'default', true) ?>', {
//       'postVar' : 'text',
//       'customChoices' : true,
//       'minLength': 1,
//       'selectMode': 'pick',
//       'autocompleteType': 'tag',
//       'className': 'tag-autosuggest',
//       'filterSubset' : true,
//       'multiple' : true,
//       'injectChoice': function(token){
//         var choice = new Element('li', {'class': 'autocompleter-choices', 'value':token.label, 'id':token.id});
//         new Element('div', {'html': this.markQueryValue(token.label),'class': 'autocompleter-choice'}).inject(choice);
//         choice.inputValue = token;
//         this.addChoiceEvents(choice).inject(this.choices);
//         choice.store('autocompleteChoice', token);
//       }
//     });
//   });
</script>
<?php echo $this->form->render($this); ?>
<script type="text/javascript">
  var minimumInterest = "<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesinterest.minchoint', 3) ?>";
  var interestMessage = "<?php echo $this->translate('You must choose minimum %s interests.', Engine_Api::_()->getApi('settings', 'core')->getSetting('sesinterest.minchoint', 3)); ?>";
  en4.core.runonce.add(function() {
    sesJqueryObject(document).on('submit','.sesinterest_name',function(e) {
        e.preventDefault();
        var elements = sesJqueryObject('#interests input[type=checkbox]');
        
        var valid = 0;
        for(i=0;i<elements.length;i++){
          if(sesJqueryObject(elements[i]).is(':checked') == true) {
            valid = valid++;
          }
        }
        checked = sesJqueryObject("input[type=checkbox]:checked").length;

        if(minimumInterest > checked) {
          alert(interestMessage);
          return false;
        } else {
          $('SignupForm').submit();
        }
    });
    
    sesJqueryObject(document).on('button','#skiplink',function(e) {
        e.preventDefault();
        var elements = sesJqueryObject('#interests input[type=checkbox]');
        
        var valid = 0;
        for(i=0;i<elements.length;i++){
          if(sesJqueryObject(elements[i]).is(':checked') == true) {
            valid = valid++;
          }
        }
        checked = sesJqueryObject("input[type=checkbox]:checked").length;
  
        if(minimumInterest >= checked) {
          alert(interestMessage);
          return false;
        }
    });
  });
</script>

