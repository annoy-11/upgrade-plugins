<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: add-decision-maker.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/styles/styles.css'); ?>
<div class="epetition_edit_location_popup"><?php echo $this->form->render($this) ?></div>
<script type="text/javascript">
    en4.core.runonce.add(function()
    {

        // if (document.getElementById('location')) {
        //     new google.maps.places.Autocomplete(document.getElementById('location'));
        // }
        var contentAutocomplete = new Autocompleter.Request.JSON('name', "<?php echo $this->url(array('action' => 'getusers'));?>", {
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