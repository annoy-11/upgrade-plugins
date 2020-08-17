<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add-admin-speaker.tpl 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seseventspeaker/externals/styles/styles.css'); ?>
<div class="seseventspeaker_add_popup sesbasic_bxs">
	<?php echo $this->form->render($this) ?>
</div>
<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<?php if($this->type == 'admin'): ?>
<?php $URL = $this->url(array('module' => 'seseventspeaker', 'controller' => 'index', 'action' => 'getadminspeakers', 'event_id' => $this->event_id, 'type' => 'admin'), 'default', true); ?>
<?php elseif($this->type == 'sitemember'): ?>
<?php $URL = $this->url(array('module' => 'seseventspeaker', 'controller' => 'index', 'action' => 'getadminspeakers', 'event_id' => $this->event_id, 'type' => 'sitemember'), 'default', true) ?>
<?php elseif($this->type == 'eventspeaker'): ?>
<?php $URL = $this->url(array('module' => 'seseventspeaker', 'controller' => 'index', 'action' => 'getadminspeakers', 'event_id' => $this->event_id, 'type' => 'eventspeaker'), 'default', true) ?>
<?php endif; ?>
<script type="text/javascript">
  en4.core.runonce.add(function()
  {
      var contentAutocomplete = new Autocompleter.Request.JSON('name', "<?php echo $URL ?>", {
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
        $('speaker_id').value = selected.retrieve('autocompleteChoice').id;
      });
    });
</script>