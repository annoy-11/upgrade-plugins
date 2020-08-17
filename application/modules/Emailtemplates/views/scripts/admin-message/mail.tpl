<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: mail.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script type="application/javascript">
  window.addEvent('load', function(){
    choosemember(1);
    tinymce.execCommand('mceRemoveEditor',true, 'external_emails');
    var external_emails = document.getElementById('external_emails').value;
    document.getElementById('external_emails').value = external_emails.match(/[^<p>].*[^</p>]/g)[0];
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
<?php include APPLICATION_PATH .  '/application/modules/Emailtemplates/views/scripts/dismiss_message.tpl';?>
<?php if( $this->form ): ?>

  <div class="settings">
    <?php echo $this->form->render($this) ?>
  </div>
  <script>
    function choosemember (value) {
      if(value == 1) {
        $('member_levels-wrapper').style.display = 'none';
        $('networks-wrapper').style.display = 'none';
        $('profile_types-wrapper').style.display = 'none';
        $('external_emails-wrapper').style.display = 'none';
        $('member_name-wrapper').style.display = 'block';
      } else if(value == 2) {
        $('member_levels-wrapper').style.display = 'none';
        $('networks-wrapper').style.display = 'none';
        $('profile_types-wrapper').style.display = 'none';
        $('external_emails-wrapper').style.display = 'none';
        $('member_name-wrapper').style.display = 'none';
      } else if(value == 3) {
        $('member_levels-wrapper').style.display = 'none';
        $('networks-wrapper').style.display = 'none';
        $('profile_types-wrapper').style.display = 'none';
        $('external_emails-wrapper').style.display = 'none';
        $('member_name-wrapper').style.display = 'none';
      } else if(value == 4) {
        $('member_levels-wrapper').style.display = 'block';
        $('networks-wrapper').style.display = 'block';
        $('profile_types-wrapper').style.display = 'block';
        $('external_emails-wrapper').style.display = 'none';
        $('member_name-wrapper').style.display = 'none';
      } else if(value == 5) {
        $('member_levels-wrapper').style.display = 'none';
        $('networks-wrapper').style.display = 'none';
        $('profile_types-wrapper').style.display = 'none';
        $('external_emails-wrapper').style.display = 'block';
        $('member_name-wrapper').style.display = 'none';
      }
    }

    en4.core.runonce.add(function() {
        
        var contentAutocomplete = new Autocompleter.Request.JSON('member_name', "<?php echo $this->url(array('module' => 'emailtemplates', 'controller' => 'message', 'action' => 'getusers'), 'admin_default', true) ?>", {
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

<?php else: ?>
  <div class="tip advanced">
    <span>Your message has been queued for sending.</span>
  </div>
  <script type="text/javascript">
	setTimeout(function(){
   window.location.href = window.location.href;
}, 10000);
    
  </script>

<?php endif; ?>
