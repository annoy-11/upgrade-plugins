<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: interests.tpl  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="headline">
  <h2>
    <?php if ($this->viewer->isSelf($this->user)):?>
      <?php echo $this->translate('Edit My Profile');?>
    <?php else:?>
      <?php echo $this->translate('%1$s\'s Profile', $this->htmlLink($this->user->getHref(), $this->user->getTitle()));?>
    <?php endif;?>
  </h2>
  <div class="tabs">
    <?php
      // Render the menu
      echo $this->navigation()
        ->menu()
        ->setContainer($this->navigation)
        ->render();
    ?>
  </div>
</div>
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
<div class='sesinterest_name settings sesbasic_popup_form'>
  <?php echo $this->form->render($this); ?>
</div>
