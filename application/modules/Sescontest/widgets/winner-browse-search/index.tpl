<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>
<?php if(!isset($_GET['contest_id']) && $actionName == 'entries'):?>
  <?php
  $base_url = $this->layout()->staticBaseUrl;
  $this->headScript()
  ->appendFile($base_url . 'externals/autocompleter/Observer.js')
  ->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
  ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
  ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');?>
<?php endif;?>

<div class="sesbasic_clearfix sesbasic_bxs sescontest_browse_search <?php echo $this->view_type=='horizontal' ? 'sescontest_browse_search_horizontal' : 'sescontest_browse_search_vertical'; ?>">
  <?php echo $this->form->render($this) ?>
</div>

<?php $class = '.sescontest_winners_list';?>
<?php if($actionName == 'winner'):?>
  <?php $pageName = 'sescontest_index_winner';?>
  <?php $widgetName = 'sescontest.winners-listing';?>
<?php elseif($actionName == 'entries'):?>
  <?php $pageName = 'sescontest_index_entries';?>
  <?php $widgetName = 'sescontest.browse-entries';?>
<?php endif;?>
<?php $identity = Engine_Api::_()->sesbasic()->getIdentityWidget($widgetName,'widget',$pageName); ?>

<script type="application/javascript">
  sesJqueryObject(document).ready(function(){
    sesJqueryObject('#filter_form').submit(function(e){
      e.preventDefault();
      if(sesJqueryObject('<?php echo $class;?>').length > 0){
        sesJqueryObject('#tabbed-widget_<?php echo $identity; ?>').html('');
        //sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
        sesJqueryObject('#loadingimgsescontest-wrapper').show();
        is_search_<?php echo $identity; ?> = 1;
        if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
          isSearch = true;
          e.preventDefault();
          searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
          paggingNumber<?php echo $identity; ?>(1);
        }else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
          isSearch = true;
          e.preventDefault();
          searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
          page<?php echo $identity; ?> = 1;
          viewMore_<?php echo $identity; ?>();
        }
      }
      return true;
    });	
  });
</script>

<?php if(!isset($_GET['contest_id']) && $actionName == 'entries'):?>
  <script type='text/javascript'>
    var Searchurl = "<?php echo $this->url(array('module' =>'sescontest','controller' => 'ajax', 'action' => 'get-contest'),'default',true); ?>";
    en4.core.runonce.add(function() {	 
      var contentAutocomplete = new Autocompleter.Request.JSON('search', Searchurl, {
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
      });
    });
  </script>
<?php endif;?>