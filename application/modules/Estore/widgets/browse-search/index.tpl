<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php
$enableglocation = Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1);
$optionsenableglotion = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('optionsenableglotion','a:6:{i:0;s:7:"country";i:1;s:5:"state";i:2;s:4:"city";i:3;s:3:"zip";i:4;s:3:"lat";i:5;s:3:"lng";}'));

$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
    ->appendFile($base_url . 'externals/autocompleter/Observer.js')
    ->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
    ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
    ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<div class="sesbasic_clearfix sesbasic_bxs estore_browse_search <?php echo $this->view_type=='horizontal' ? 'estore_browse_search_horizontal' : 'estore_browse_search_vertical'; ?>">
  <?php echo $this->form->render($this) ?>
</div>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName(); ?>
<?php $class = '.estore_store_listing';?>
<?php if($actionName == 'manage'):?>
  <?php $storeName = 'estore_index_manage';?>
  <?php $widgetName = 'estore.manage-stores';?>
<?php elseif($actionName == 'pinboard'):?>
  <?php $storeName = 'estore_index_pinboard';?>
  <?php $widgetName = 'estore.browse-stores';?>
<?php elseif($actionName == 'featured'):?>
  <?php $storeName = 'estore_index_featured';?>
  <?php $widgetName = 'estore.browse-stores';?>
<?php elseif($actionName == 'sponsored'):?>
  <?php $storeName = 'estore_index_sponsored';?>
  <?php $widgetName = 'estore.browse-stores';?>
<?php elseif($actionName == 'verified'):?>
  <?php $storeName = 'estore_index_verified';?>
  <?php $widgetName = 'estore.browse-stores';?>
<?php elseif($actionName == 'browse-locations'):?>
   <?php $storeName = 'estore_index_browse-locations';?>
  <?php $widgetName = 'estore.browse-locations-stores';?>
<?php else:?>
   <?php $storeName = 'estore_index_browse';?>
  <?php $widgetName = 'estore.browse-stores';?>
<?php endif;?>
<?php $identity = Engine_Api::_()->sesbasic()->getIdentityWidget($widgetName,'widget',$storeName); ?>
<?php $defaultProfileFieldId = "0_0_$this->defaultProfileId";$profile_type = 2;?>
<?php echo $this->partial('_customFields.tpl', 'sesbasic', array()); ?>
<script type="application/javascript">
  function showHideOptions<?php echo $this->identity; ?>(display){
    var elem = sesJqueryObject('.estore_widget_advsearch_hide_<?php echo $this->identity; ?>');
    if(elem.length == 0){
        sesJqueryObject('#advanced_options_search_<?php echo $this->identity; ?>').hide();	
        return;
    }
    for(var i = 0 ; i < elem.length ; i++){
      if(sesJqueryObject(elem[i]).attr('id') == 'subcat_id' && sesJqueryObject('#subcat_id option').length	< 2 && display == 'inline-block'){
        continue;
      }else if(sesJqueryObject(elem[i]).attr('id') == 'subsubcat_id' && sesJqueryObject('#subsubcat_id option').length	< 2 && display == 'inline-block'){
        continue;	
      }
      sesJqueryObject(elem[i]).parent().parent().css('display',display);
    }
    hideShowLocationOptions();
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
  sesJqueryObject(document).ready(function(){
    sesJqueryObject('#advanced_options_search_<?php echo $this->identity; ?>').html("<i class='fa fa-plus-circle'></i><?php echo $this->translate('Show Advanced Settings') ?>");
    checkSetting<?php echo $this->identity; ?>('true');	
    sesJqueryObject('#filter_form').submit(function(e){
      e.preventDefault();
      if(sesJqueryObject('<?php echo $class;?>').length > 0){
        sesJqueryObject('#tabbed-widget_<?php echo $identity; ?>').html('');
        sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
        sesJqueryObject('#loadingimgestore-wrapper').show();
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
  var Searchurl = "<?php echo $this->url(array('module' =>'estore','controller' => 'ajax', 'action' => 'get-store'),'default',true); ?>";
  en4.core.runonce.add(function() {
    formObj = sesJqueryObject('#filter_form').find('div').find('div').find('div');
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
  
  function showSubCategory(cat_id,selected) {
    var url = en4.core.baseUrl + 'estore/ajax/subcategory/category_id/' + cat_id + '/type/'+ 'search';
    new Request.HTML({
      url: url,
      data: {
	'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
	if ($('subcat_id') && responseHTML) {
	  if ($('subcat_id-wrapper')) {
	    $('subcat_id-wrapper').style.display = "inline-block";
	  }
	  $('subcat_id').innerHTML = responseHTML;
	} 
	else {
	  if ($('subcat_id-wrapper')) {
	    $('subcat_id-wrapper').style.display = "none";
	    $('subcat_id').innerHTML = '';
	  }
	  if ($('subsubcat_id-wrapper')) {
	    $('subsubcat_id-wrapper').style.display = "none";
	    $('subsubcat_id').innerHTML = '';
	  }
	}
    showFields(cat_id,1);
      }
    }).send(); 
  }
  
  var defaultProfileFieldId = '<?php echo $defaultProfileFieldId ?>';
  var profile_type = '<?php echo $profile_type ?>';
  var previous_mapped_level = 0;
  function showFields(cat_value, cat_level,typed,isLoad) {
    var categoryId = getProfileType(formObj.find('#category_id-wrapper').find('#category_id-element').find('#category_id').val());
    var subcatId = getProfileType(formObj.find('#subcat_id-wrapper').find('#subcat_id-element').find('#subcat_id').val());
    var subsubcatId = getProfileType(formObj.find('#subsubcat_id-wrapper').find('#subsubcat_id-element').find('#subsubcat_id').val());
    var type = categoryId+','+subcatId+','+subsubcatId;
    if (cat_level == 1 || (previous_mapped_level >= cat_level && previous_mapped_level != 1) || (profile_type == null || profile_type == '' || profile_type == 0)) {
      profile_type = getProfileType(cat_value);
      if (profile_type == 0) {
        profile_type = '';
      } else {
        previous_mapped_level = cat_level;
      }
      if($(defaultProfileFieldId))
      $(defaultProfileFieldId).value = profile_type;
      changeFields($(defaultProfileFieldId),null,isLoad,type);
    }
  }
  var getProfileType = function(category_id) {
    var mapping = <?php echo Zend_Json_Encoder::encode(Engine_Api::_()->getDbTable('categories', 'estore')->getMapping(array('category_id', 'profile_type'))); ?>;
    for (i = 0; i < mapping.length; i++) {	
      if (mapping[i].category_id == category_id)
      return mapping[i].profile_type;
    }
    return 0;
  }
  en4.core.runonce.add(function() {
    var defaultProfileId = '<?php echo '0_0_' . $this->defaultProfileId ?>' + '-wrapper';
     if ($type($(defaultProfileId)) && typeof $(defaultProfileId) != 'undefined') {
      $(defaultProfileId).setStyle('display', 'none');
    }
  });
  function showSubSubCategory(cat_id,selected) {
    var categoryId = getProfileType($('category_id').value);
    if(cat_id == 0){
      if ($('subsubcat_id-wrapper')) {
        $('subsubcat_id-wrapper').style.display = "none";
        $('subsubcat_id').innerHTML = '';
      }
      showFields(cat_id,1,categoryId);
      return false;
    }
    showFields(cat_id,1,categoryId);
    var url = en4.core.baseUrl + 'estore/ajax/subsubcategory/subcategory_id/' + cat_id + '/type/'+ 'search';;
    (new Request.HTML({
      url: url,
      data: {
	'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
	if ($('subsubcat_id') && responseHTML) {
	  if ($('subsubcat_id-wrapper')) {
	    $('subsubcat_id-wrapper').style.display = "inline-block";
	  }
	  $('subsubcat_id').innerHTML = responseHTML;
	} 
	else {
	  if ($('subsubcat_id-wrapper')) {
	    $('subsubcat_id-wrapper').style.display = "none";
	    $('subsubcat_id').innerHTML = '';
	  }
	}
      }
    })).send();  
  }
  function showCustomOnLoad(value,isLoad){
    showFields(value,1,'',isLoad);
  }
  en4.core.runonce.add(function(){
    showCustomOnLoad('','no');
  });
  window.addEvent('domready', function() {
    if($('category_id')){
      var catAssign = 1;
      <?php if(isset($_GET['category_id']) && $_GET['category_id'] != 0){ ?>
      <?php if(isset($_GET['subcat_id'])){$catId = $_GET['subcat_id'];}else $catId = ''; ?>
      showSubCategory('<?php echo $_GET['category_id']; ?>','<?php echo $catId; ?>');
      <?php if(isset($_GET['subsubcat_id'])){ ?>
        <?php if(isset($_GET['subsubcat_id'])){$subsubcat_id = $_GET['subsubcat_id'];}else $subsubcat_id = ''; ?>
        showSubSubCategory("<?php echo $_GET['subcat_id']; ?>","<?php echo $_GET['subsubcat_id']; ?>");
      <?php }else{?>
        $('subsubcat_id-wrapper').style.display = "none";
      <?php } ?>
    <?php  }else{?>
    $('subcat_id-wrapper').style.display = "none";
    $('subsubcat_id-wrapper').style.display = "none";
      <?php } ?>
    }
  });
  sesJqueryObject(document).ready(function(){
    mapLoad = false;
    if(sesJqueryObject('#lat-wrapper').length > 0){
      sesJqueryObject('#lat-wrapper').css('display' , 'none');
      sesJqueryObject('#lng-wrapper').css('display' , 'none');
      <?php if($enableglocation) { ?>
      initializeSesStoreMapList();
      <?php } ?>
    }
    hideShowLocationOptions();
  });
  function hideShowLocationOptions() {
    <?php if(!$enableglocation) { ?>
      sesJqueryObject('#miles-wrapper').hide();
      <?php if(!in_array('country',$optionsenableglotion)) { ?>
        sesJqueryObject('#country-wrapper').hide();
      <?php } ?>
      <?php if(!in_array('state',$optionsenableglotion)) { ?>
        sesJqueryObject('#state-wrapper').hide();
      <?php } ?>
      <?php if(!in_array('city',$optionsenableglotion)) { ?>
        sesJqueryObject('#city-wrapper').hide();
      <?php } ?>
      <?php if(!in_array('zip',$optionsenableglotion)) { ?>
        sesJqueryObject('#zip-wrapper').hide();
      <?php } ?>
    <?php } ?>
  }
</script>
