<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/scripts/Picker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/scripts/Picker.Attach.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/scripts/Picker.Date.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/scripts/Picker.Date.Range.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/picker-style.css'); ?>
    <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/bootstrap-datepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/datepicker.css'); ?>
<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<div class="sesbasic_browse_search <?php echo $this->view_type=='horizontal' ? 'sesbasic_browse_search_horizontal' : 'sesbasic_browse_search_vertical'; ?>">
  <?php echo $this->searchForm->render($this) ?>
</div>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>
<script type="application/javascript">var Searchurl = "<?php echo $this->url(array('module' =>'sesqa','controller' => 'index', 'action' => 'get-questions'),'default',true); ?>";</script>
<?php if($controllerName == 'index' && $actionName != 'locations'){ ?>
<?php if($actionName == 'browse'): ?>
<?php $identity = Engine_Api::_()->sesqa()->getIdentityWidget('sesqa.tabbed-widget','widget','sesqa_index_browse'); ?>
<?php elseif($actionName == 'all-results'): ?>
<?php $identity = Engine_Api::_()->sesqa()->getIdentityWidget('sesqa.tabbed-widget','widget','advancedsearch_index_sesqa_question'); ?>
<?php endif; ?>

<?php if(@$identity){ ?>
<script type="application/javascript">
    en4.core.runonce.add(function() {
		sesJqueryObject('#filter_form').submit(function(e){
			e.preventDefault();
			if(sesJqueryObject('#sesqa-tabbed-widget-<?php echo $identity; ?>').length > 0){
				sesJqueryObject('#sesqa-tabbed-widget-<?php echo $identity; ?>').html('');
				sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
				sesJqueryObject('#search').html(sesJqueryObject('#loadingimgsesqa-wrapper').html());
				if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
          document.getElementById("sesqa-tabbed-widget-<?php echo $identity; ?>").innerHTML = "<div class='clear sesbasic_loading_container' id='loading_images_browse_<?php echo $identity; ?>'></div>";
					e.preventDefault();
					searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
				  paggingNumber<?php echo $identity; ?>(1);
				}else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
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
<?php } ?>
<?php }else if($controllerName == 'index' && $actionName == 'locations'){?>
	<script type="application/javascript">var Searchurl = "<?php echo $this->url(array('module' =>'sesqa','controller' => 'index', 'action' => 'get-questions'),'default',true); ?>";</script>
  <script type="application/javascript">
sesJqueryObject(document).ready(function(){
		sesJqueryObject('#filter_form').submit(function(e){
			e.preventDefault();
			var error = false;
			if(sesJqueryObject('#locationSesList').val() == ''){
				sesJqueryObject('#locationSesList').css('border-color','red');
				error = true;
			}else{
				sesJqueryObject('#locationSesList').css('border-color','');
			}
			if(sesJqueryObject('#miles').val() == 0){
				error = true;
				sesJqueryObject('#miles').css('border-color','red');
			}else{
				sesJqueryObject('#miles').css('border-color','');
			}
			if(map && !error){
				sesJqueryObject('#search').html(sesJqueryObject('#loadingimgsesqa-wrapper').html());
					e.preventDefault();
					searchParams = sesJqueryObject(this).serialize();
				  callNewMarkersAjax();
			}
		return true;
		});	
});
</script>
<?php } ?>
<script type="text/javascript">
en4.core.runonce.add(function()
  {
		 
      var contentAutocomplete = new Autocompleter.Request.JSON('searchText', Searchurl, {
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
        //$('resource_id').value = selected.retrieve('autocompleteChoice').id;
      });
    });
	function showSubCategory(cat_id,selected) {
		var url = en4.core.baseUrl + 'sesqa/index/subcategory/category_id/' + cat_id;
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
				} else {
					if ($('subcat_id-wrapper')) {
						$('subcat_id-wrapper').style.display = "none";
						$('subcat_id').innerHTML = '';
					}
					 if ($('subsubcat_id-wrapper')) {
						$('subsubcat_id-wrapper').style.display = "none";
						$('subsubcat_id').innerHTML = '';
					}
				}
			}
		}).send(); 
	}
	function showSubSubCategory(cat_id,selected) {
		if(cat_id == 0){
			if ($('subsubcat_id-wrapper')) {
				$('subsubcat_id-wrapper').style.display = "none";
				$('subsubcat_id').innerHTML = '';
      }	
			return false;
		}
	
    var url = en4.core.baseUrl + 'sesqa/index/subsubcategory/subcategory_id/' + cat_id;
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
				
        } else {
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "none";
            $('subsubcat_id').innerHTML = '';
          }
        }
      }
    })).send();  
  }
en4.core.runonce.add(function() {
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
en4.core.runonce.add(function() {
mapLoad = false;
if(sesJqueryObject('#lat-wrapper').length > 0){
	sesJqueryObject('#lat-wrapper').css('display' , 'none');
	sesJqueryObject('#lng-wrapper').css('display' , 'none');
	initializeSesQaMapList();
}
});
en4.core.runonce.add(function() {
sesJqueryObject('#loadingimgsesqa-wrapper').hide();
});
</script>
<script>
    en4.core.runonce.add(function() {
        var inputwidth = sesJqueryObject('#show_date_field').width();
        var pickerposition = (400 - inputwidth);
        var picker = new Picker.Date.Range($('show_date_field'), {
            timePicker: false,
            columns: 2,
            positionOffset: {x: -pickerposition, y: 0}
        });
        var picker2 = new Picker.Date.Range('range_hidden', {
            toggle: $$('#range_select'),
            columns: 2,
            onSelect: function () {
                $('range_text').set('text', Array.map(arguments, function (date) {
                    return date.format('%e %B %Y');
                }).join(' - '))
            }
        });
    });
</script>
<style>
  .layout_sesqa_browse_search #searchText-element {
    width: <?php echo $this->searchboxwidth . 'px !important'; ?>
  }
  .datepicker .footer button.apply:before{content:"Search";}
  .datepicker .footer button.cancel:before{content:"Cancel";}
</style>
