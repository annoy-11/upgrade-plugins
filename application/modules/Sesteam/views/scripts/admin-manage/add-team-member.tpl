<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add-team-members.tpl 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<script type="application/javascript">
window.addEvent('load', function(){
	tinymce.execCommand('mceRemoveEditor',true, 'description');
	var desVal = document.getElementById('description').value;
	document.getElementById('description').value = desVal.match(/[^<p>].*[^</p>]/g)[0];
});
</script>
<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?>
  <?php $this->headScript()->appendFile('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' . Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.mapApiKey', '')); ?>
<?php } ?>
<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<?php include APPLICATION_PATH .  '/application/modules/Sesteam/views/scripts/dismiss_message.tpl';?>

<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesteam', 'controller' => 'manage', 'action' => 'index'), $this->translate("Back to Manage Site Team"), array('class'=>'sesbasic_icon_back buttonlink')) ?>
<br class="clear" /><br />

<div class='settings sesbasic_admin_form'>
  <?php echo $this->form->render($this) ?>
</div>

<script type="text/javascript">
  en4.core.runonce.add(function() {
      <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?>
      if (document.getElementById('location')) {
        new google.maps.places.Autocomplete(document.getElementById('location'));
      }
      <?php } ?>
      
      var contentAutocomplete = new Autocompleter.Request.JSON('name', "<?php echo $this->url(array('module' => 'sesteam', 'controller' => 'manage', 'action' => 'getusers'), 'admin_default', true) ?>", {
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
