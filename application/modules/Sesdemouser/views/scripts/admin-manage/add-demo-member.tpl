<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdemouser
 * @package    Sesdemouser
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add-demo-member.php 2015-10-22 00:00:00 SocialEngineSolutions $
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
<div class='settings sesbasic_admin_form'>
  <?php echo $this->form->render($this) ?>
</div>

<style type="text/css">
.global_form{margin:10px 10px 0;}
.form-label{display:none;}
.settings div.form-element input[type="text"]{
	width:90%;
}
</style>
<script type="text/javascript">
  en4.core.runonce.add(function()
  {
      var contentAutocomplete = new Autocompleter.Request.JSON('name', "<?php echo $this->url(array('module' => 'sesdemouser', 'controller' => 'manage', 'action' => 'getusers'), 'admin_default', true) ?>", {
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
        $('user_id').value = selected.retrieve('autocompleteChoice').id;
      });
    });
</script>
