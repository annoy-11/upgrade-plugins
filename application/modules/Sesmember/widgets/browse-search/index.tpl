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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/styles/styles.css'); ?>
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
<style>
  .hideE {
    display:none !important;
  }
</style>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<div class="sesmember_browse_search sesbasic_bxs sesbasic_clearfix <?php echo $this->view_type=='horizontal' ? 'sesmember_browse_search_horizontal' : 'sesmember_browse_search_vertical'; ?>"><?php echo $this->form->render($this) ?></div>
<script type="application/javascript">
  sesJqueryObject('#loadingimgsesmember-wrapper').hide();

  function showHideOptions<?php echo $this->identity; ?>(display){
    var elem = sesJqueryObject('.sesmember_widget_advsearch_hide_<?php echo $this->identity; ?>');
    if(elem.length == 0){
      sesJqueryObject('#advanced_options_search_<?php echo $this->identity; ?>').hide();	
      return;
    }
    for(var i = 0 ; i < elem.length ; i++){
      if(sesJqueryObject(elem[i]).parent().prop('tagName') == 'LI')
      {
      sesJqueryObject(elem[i]).parent().css('display',display);
      }
      else
      sesJqueryObject(elem[i]).parent().parent().css('display',display);
    }
    var hideField = sesJqueryObject('.field_toggle');
    for(i=0;i<hideField.length;i++) {
      if(sesJqueryObject('#profile_type-label').parent().css('display') == 'none') {
        if(sesJqueryObject(hideField[i]).closest('ul').hasClass('form-options-wrapper'))
          sesJqueryObject(hideField[i]).parent().parent().parent().addClass('hideE');
        else 
          sesJqueryObject(hideField[i]).closest('li').addClass('hideE');
      }
      else {
        if(sesJqueryObject(hideField[i]).closest('ul').hasClass('form-options-wrapper'))
        sesJqueryObject(hideField[i]).parent().parent().parent().removeClass('hideE');
        else 
        sesJqueryObject(hideField[i]).closest('li').removeClass('hideE');
      }
    }
    sesJqueryObject('#profile_type').closest('li').removeClass('hideE');
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
  sesJqueryObject(document).on('click','#advanced_options_search_<?php echo $this->identity; ?>',function(e){
    checkSetting<?php echo $this->identity; ?>();
  });
  en4.core.runonce.add(function () {
    sesJqueryObject('#advanced_options_search_<?php echo $this->identity; ?>').html("<i class='fa fa-plus-circle'></i><?php echo $this->translate('Show Advanced Settings') ?>");
    checkSetting<?php echo $this->identity; ?>('true');	
  })
</script>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $moduleName = $request->getModuleName();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>
<?php

$viewer = Engine_Api::_()->user()->getViewer();
$viewer_id = $viewer->getIdentity();

?>

<?php if(($controllerName == 'index' && $actionName == 'all-results') || ($controllerName == 'index' && $actionName == 'browse') || ($controllerName == 'index' && $actionName == 'profiletype') || ($controllerName == 'index' && $actionName == 'pinborad-view-members') || ($moduleName == 'sesblog' && $controllerName == 'index' && $actionName == 'contributors')) { ?>
<?php if($actionName == 'all-results'):?>
<?php $pageName = 'advancedsearch_index_sesmember';?>
<?php elseif($actionName == 'pinborad-view-members'):?>
    <?php $pageName = 'sesmember_index_pinborad-view-members';?>
  <?php elseif($actionName == 'contributors'): ?>
    <?php $pageName = 'sesblog_index_contributors';?>
  <?php elseif($actionName == 'profiletype'): ?>
    <?php
      $homepage_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('homepage_id', 0);
      $pageName = "sesmember_index_$homepage_id";
    ?>
  <?php else:?>
    <?php $pageName = 'sesmember_index_browse';?>
  <?php endif;?>
  <?php $identity = Engine_Api::_()->sesbasic()->getIdentityWidget('sesmember.browse-members','widget',$pageName); ?>
  <?php if($identity):?>
    <script type="application/javascript">
        en4.core.runonce.add(function () {
	sesJqueryObject(document).on('submit','#filter_form',function(e){
	  //if(sesJqueryObject('.user_all_members').length > 0){
	    e.preventDefault();
	    sesJqueryObject('#loadingimgsesmember-wrapper').show();
	    loadMap_<?php echo $identity;?> = true;
	    is_search_<?php echo $identity; ?> = 1;
	    if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
	      sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $identity?>').css('display', 'block');
	      isSearch = true;
	      e.preventDefault();
	      searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
	      sesJqueryObject('#loadingimgsesmember-wrapper').show();
	      paggingNumber<?php echo $identity; ?>(1);
	    }else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
	      sesJqueryObject('#browse-widget_<?php echo $identity; ?>').html('');
	      sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
	      isSearch = true;
	      e.preventDefault();
	      searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
	      page<?php echo $identity; ?> = 1;
	      sesJqueryObject('#loadingimgsesmember-wrapper').show();
	      viewMore_<?php echo $identity; ?>();
	    }
	 // }
	  return true;
	});	
      });
    </script>
  <?php endif;?>
<?php }else if($controllerName == 'index' && $actionName == 'nearest-member'){ ?>
	<?php $identity = Engine_Api::_()->sesbasic()->getIdentityWidget('sesmember.browse-members','widget','sesmember_index_nearest-member'); ?>
  <?php if($identity):?>
    <script type="application/javascript">
        en4.core.runonce.add(function () {
	sesJqueryObject('#filter_form').submit(function(e){
	  if(sesJqueryObject('.user_all_members').length > 0){
	    e.preventDefault();
	    sesJqueryObject('#loadingimgsesmember-wrapper').show();
	    loadMap_<?php echo $identity;?> = true;
	    is_search_<?php echo $identity; ?> = 1;
	    if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
	      sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $identity?>').css('display', 'block');
	      isSearch = true;
	      e.preventDefault();
	      searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
	      sesJqueryObject('#loadingimgsesmember-wrapper').show();
	      paggingNumber<?php echo $identity; ?>(1);
	    }else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
	      sesJqueryObject('#browse-widget_<?php echo $identity; ?>').html('');
	      sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
	      isSearch = true;
	      e.preventDefault();
	      searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
	      page<?php echo $identity; ?> = 1;
	      sesJqueryObject('#loadingimgsesmember-wrapper').show();
	      viewMore_<?php echo $identity; ?>();
	    }
	  }
	  return true;
	});	
      });
    </script>
  <?php endif;?>

<?php }else if($controllerName == 'index' && $actionName == 'locations'){?>
  <script type="application/javascript">
  sesJqueryObject(document).ready(function(){
    sesJqueryObject('#filter_form').submit(function(e){
      e.preventDefault();
      var error = false;
      sesJqueryObject('#loadingimgsesmember-wrapper').show();
      e.preventDefault();
      searchParams = sesJqueryObject(this).serialize();
      sesJqueryObject('#loadingimgsesmember-wrapper').show();
      callNewMarkersAjax();
      return true;
    });	
  });
  </script>
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

  en4.core.runonce.add(function () {
    mapLoad = false;
    if(sesJqueryObject('#lat-wrapper').length > 0 || sesJqueryObject('#locationSesList').length > 0){
      sesJqueryObject('#lat-wrapper').css('display' , 'none');
      sesJqueryObject('#lng-wrapper').css('display' , 'none');
      initializeSesMemberMapList();
    }
    sesJqueryObject('#loadingimgsesmember-wrapper').hide();
  });

  en4.core.runonce.add(function () {
var options = sesJqueryObject('#profile_type option');
var optionLength = options.size();
if(optionLength == 2) {
sesJqueryObject('#filter_form').find('#profile_type').parent().hide();
var value = sesJqueryObject('#filter_form').find('#profile_type option:eq(1)').attr('value');
sesJqueryObject('#filter_form').find('#profile_type').val(value);
changeFields('profile_type');
}
});
 </script>