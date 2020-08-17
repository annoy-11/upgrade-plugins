<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php if( $this->form ): ?>
  <div class="sesbasic_browse_search <?php echo $this->viewType=='horizontal' ? 'sesbasic_browse_search_horizontal' : ''; ?>">
    <?php echo $this->form->render($this) ?>
  </div>
<?php endif ?>
<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<script type="text/javascript">
    en4.core.runonce.add(function() {
        var title = document.getElementById("sesteam_title");
        title.addEventListener("keydown", function (e) {
            if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
                this.form.submit();
            }
        });
    });
  //Take refrences from "/application/modules/Blog/views/scripts/index/create.tpl"
  en4.core.runonce.add(function() {
    var searchAutocomplete = new Autocompleter.Request.JSON('sesteam_title', "<?php echo $this->url(array('module' => 'sesteam', 'controller' => 'index', 'action' => 'search', 'commonsearch' => $this->sesteamType), 'default', true) ?>", {
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
  });
</script>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $actionName = $request->getActionName();?>
<?php if($actionName == 'browse' || $actionName == 'all-results') { ?>
  <script type="application/javascript">
  en4.core.runonce.add(function() {
    sesJqueryObject(document).on('submit','#filter_form',function(e) {
        e.preventDefault();
        searchParams = sesJqueryObject(this).serialize();
        page = 1;
        viewMore();
      return true;
    });
  });
  </script>
<?php } ?>
