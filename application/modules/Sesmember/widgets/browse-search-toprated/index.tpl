<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>

<?php
  /* Include the common user-end field switching javascript */
  echo $this->partial('_jsSwitch.tpl', 'fields', array(
    'topLevelId' => (int) @$this->topLevelId,
    'topLevelValue' => (int) @$this->topLevelValue
  ))
?>

<script type="text/javascript">
  en4.core.runonce.add(function () {
    window.addEvent('onChangeFields', function () {
      var firstSep = $$('li.browse-separator-wrapper')[0];
      var lastSep;
      var nextEl = firstSep;
      var allHidden = true;
      do {
	nextEl = nextEl.getNext();
	if (nextEl.get('class') == 'browse-separator-wrapper') {
	  lastSep = nextEl;
	  nextEl = false;
	} else {
	  allHidden = allHidden && (nextEl.getStyle('display') == 'none');
	}
      } while (nextEl);
      if (lastSep) {
	lastSep.setStyle('display', (allHidden ? 'none' : ''));
      }
    });
  });
</script>

<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<div class="sesmember_browse_toprated_search sesbasic_bxs sesbasic_clearfix <?php echo $this->view_type=='horizontal' ? 'sesmember_browse_toprated_search_horizontal' : 'sesmember_browse_toprated_search_vertical'; ?>"><?php echo $this->form->render($this) ?></div>
<script type="application/javascript">
  sesJqueryObject('#loadingimgsesmember-wrapper').hide();

  function showHideOptions<?php echo $this->identity; ?>(display){
    var elem = sesJqueryObject('.sesmember_widget_advsearch_hide_<?php echo $this->identity; ?>');
    if(elem.length == 0){
      sesJqueryObject('#advanced_options_search_<?php echo $this->identity; ?>').hide();	
      return;
    }
    for(var i = 0 ; i < elem.length ; i++){console.log(sesJqueryObject(elem[i]).parent().prop('tagName'));
      if(sesJqueryObject(elem[i]).parent().prop('tagName') == 'LI')
      {
      sesJqueryObject(elem[i]).parent().css('display',display);
      }
      else
      sesJqueryObject(elem[i]).parent().parent().css('display',display);
    }
  }
  function checkSetting<?php echo $this->identity; ?>(first){
    var hideShowOption = sesJqueryObject('#advanced_options_search_<?php echo $this->identity; ?>').hasClass('active');
    if(hideShowOption){
      showHideOptions<?php echo $this->identity; ?>('none');
      if(typeof first == 'undefined'){
	sesJqueryObject('#advanced_options_search_<?php echo $this->identity; ?>').html("<i class='fa fa-plus-circle'></i><?php echo $this->translate('Show Advanced Settings') ?>");
      }
      sesJqueryObject('#advanced_options_search_<?php echo $this->identity; ?>').removeClass('active');
    }else{
      showHideOptions<?php echo $this->identity; ?>('inline-block');
      sesJqueryObject('#advanced_options_search_<?php echo $this->identity; ?>').html("<i class='fa fa-minus-circle'></i><?php echo $this->translate('Hide Advanced Settings') ?>");
      sesJqueryObject('#advanced_options_search_<?php echo $this->identity; ?>').addClass('active');
    }	
  }
  sesJqueryObject('#advanced_options_search_<?php echo $this->identity; ?>').click(function(e){
    checkSetting<?php echo $this->identity; ?>();
  });
  sesJqueryObject(document).ready(function(e){
    sesJqueryObject('#advanced_options_search_<?php echo $this->identity; ?>').html("<i class='fa fa-plus-circle'></i><?php echo $this->translate('Show Advanced Settings') ?>");
    checkSetting<?php echo $this->identity; ?>('true');	
  })
</script>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>

<?php  if($controllerName == 'index' && $actionName == 'top-members'){ ?>
<?php $identity = Engine_Api::_()->sesbasic()->getIdentityWidget('sesmember.top-rated-members','widget','sesmember_index_top-members'); ?>
  <?php if($identity):?>
    <script type="application/javascript">
      sesJqueryObject(document).ready(function(){
	sesJqueryObject('#filter_form').submit(function(e){
	  if(sesJqueryObject('.sesmember_member_rating_block').length > 0){
	    e.preventDefault();
	     if(typeof viewMore_<?php echo $identity; ?> == 'function'){
	      sesJqueryObject('.sesmember_member_rating_block').html('');
	      sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
	      searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
	      page<?php echo $identity; ?> = 1;
	      viewMore_<?php echo $identity; ?>();
	    }else if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
	      sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $identity?>').css('display', 'block');
	      e.preventDefault();
	      searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
	      paggingNumber<?php echo $identity; ?>(1);
	    }
	  }
	  return true;
	});	
      });
    </script>
    <?php endif;?>
<?php } ?>
<script type="text/javascript">
  var Searchurl = "<?php echo $this->url(array('module' =>'sesmember','controller' => 'index', 'action' => 'get-member'),'default',true); ?>";
  en4.core.runonce.add(function() {
    var contentAutocomplete = new Autocompleter.Request.JSON('search_text', Searchurl, {
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

  sesJqueryObject(document).ready(function(){
    mapLoad = false;
    if(sesJqueryObject('#lat-wrapper').length > 0 || sesJqueryObject('#locationSesList').length > 0){
      sesJqueryObject('#lat-wrapper').css('display' , 'none');
      sesJqueryObject('#lng-wrapper').css('display' , 'none');
      initializeSesMemberMapList();
    }
  });
  sesJqueryObject('#loadingimgsesmember-wrapper').hide();
 </script>