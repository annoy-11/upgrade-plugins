<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/ses-scripts/jquery.min.js'); ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesfaq/views/scripts/dismiss_message.tpl';?>
<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesfaq', 'controller' => 'manage', 'action' => 'index'), $this->translate("Back to Add & Manage FAQs"), array('class'=>'sesfaq_icon_back buttonlink')) ?>
<br class="clear" /><br />

<script type="text/javascript">
  en4.core.runonce.add(function()
  {
    new Autocompleter.Request.JSON('tags', '<?php echo $this->url(array('controller' => 'tag', 'action' => 'suggest'), 'default', true) ?>', {
      'postVar' : 'text',
      'customChoices' : true,
      'minLength': 1,
      'selectMode': 'pick',
      'autocompleteType': 'tag',
      'className': 'sesfaq-autosuggest',
      'filterSubset' : true,
      'multiple' : true,
      'injectChoice': function(token){
        var choice = new Element('li', {'class': 'autocompleter-choices', 'value':token.label, 'id':token.id});
        new Element('div', {'html': this.markQueryValue(token.label),'class': 'autocompleter-choice'}).inject(choice);
        choice.inputValue = token;
        this.addChoiceEvents(choice).inject(this.choices);
        choice.store('autocompleteChoice', token);
      }
    });
  });
</script>
<div class='clear'>
  <div class='settings sesfaq_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>
jqueryObjectOfSes(document).ready(function(){
	jqueryObjectOfSes('#subcat_id-wrapper').css('display' , 'none');
	jqueryObjectOfSes('#subsubcat_id-wrapper').css('display' , 'none');
});
</script>

<script type="text/javascript">

  var getProfileType = function(category_id) {
    var mapping = <?php echo Zend_Json_Encoder::encode(Engine_Api::_()->getDbTable('categories', 'sesfaq')->getMapping(array('category_id', 'profile_type'))); ?>;
		  for (i = 0; i < mapping.length; i++) {	
      	if (mapping[i].category_id == category_id)
        return mapping[i].profile_type;
    	}
    return 0;
  }
  
  function showSubCategory(cat_id,selectedId,isLoad) {
		var selected;
		if(selectedId != ''){
			var selected = selectedId;
		}
    var url = en4.core.baseUrl + 'sesfaq/index/subcategory/category_id/' + cat_id;
    new Request.HTML({
      url: url,
      data: {
				'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subcat_id') && responseHTML) {
          if ($('subcat_id-wrapper')) {
            $('subcat_id-wrapper').style.display = "block";
          }
          $('subcat_id').innerHTML = responseHTML;
        } else {
          if ($('subcat_id-wrapper')) {
            $('subcat_id-wrapper').style.display = "none";
            $('subcat_id').innerHTML = '<option value="0"></option>';
          }
        }
			  if ($('subsubcat_id-wrapper')) {
					$('subsubcat_id-wrapper').style.display = "none";
					$('subsubcat_id').innerHTML = '<option value="0"></option>';
				}
      }
    }).send(); 
  }
  
	function showSubSubCategory(cat_id,selectedId,isLoad) {
		var categoryId = getProfileType($('category_id').value);
		if(cat_id == 0){
			if ($('subsubcat_id-wrapper')) {
				$('subsubcat_id-wrapper').style.display = "none";
				$('subsubcat_id').innerHTML = '';
				document.getElementsByName("0_0_1")[0].value=categoryId;				
      }
 			return false;
 		}

		var selected;
		if(selectedId != ''){
			var selected = selectedId;
		}
    var url = en4.core.baseUrl + 'sesfaq/index/subsubcategory/subcategory_id/' + cat_id;
    (new Request.HTML({
      url: url,
      data: {
				'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subsubcat_id') && responseHTML) {
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "block";
						 $('subsubcat_id').innerHTML = responseHTML;
          }
       }else{
					// get category id value
					if ($('subsubcat_id-wrapper')) {
						$('subsubcat_id-wrapper').style.display = "none";
						$('subsubcat_id').innerHTML = '<option value="0"></option>';
					} 
				}
			}
    })).send();  
  }

  window.addEvent('domready', function() {
    var sesdevelopment = 1;
    <?php if(isset($this->category_id) && $this->category_id != 0) { ?>
      <?php if(isset($this->subcat_id)){
        $catId = $this->subcat_id;
      } else $catId = ''; ?>
      showSubCategory('<?php echo $this->category_id; ?>','<?php echo $catId; ?>','yes');
    <?php  } else { ?>
      $('subcat_id-wrapper').style.display = "none";
    <?php } ?>
    <?php if(isset($this->subsubcat_id)) { ?>
      if (<?php echo isset($this->subcat_id) && intval($this->subcat_id)>0 ? $this->subcat_id : 'sesdevelopment' ?> == 0) {
      $('subsubcat_id-wrapper').style.display = "none";
      } else {
      <?php if(isset($this->subsubcat_id)){$subsubcat_id = $this->subsubcat_id;}else $subsubcat_id = ''; ?>
      showSubSubCategory('<?php echo $this->subcat_id; ?>','<?php echo $this->subsubcat_id; ?>','yes');
      }
    <?php } else { ?>
    $('subsubcat_id-wrapper').style.display = "none";
    <?php } ?>
  });
</script>
<style type="text/css">
.sesfaq-autosuggest {
	position:absolute;
	padding:0px;
	width:300px;
	list-style:none;
	z-index:50;
	border:1px solid #d0d1d5;
	margin:0px;
	list-style:none;
	cursor:pointer;
	white-space:nowrap;
	background:#fff;
}
.sesfaq-autosuggest > li {
	padding:3px;
	margin:0 !important;
	overflow:hidden;
}
.sesfaq-autosuggest > li + li {
	border-top:1px solid #d0d1d5;
}
.sesfaq-autosuggest > li img {
	max-width:25px;
	max-height:25px;
	display:block;
	float:left;
	margin-right:5px;
}
.sesfaq-autosuggest > li.autocompleter-selected {
	background:#eee;
	color:#555;
}
.sesfaq-autosuggest > li.autocompleter-choices {
	font-size:.8em;
}
.sesfaq-autosuggest > li.autocompleter-choices .autocompleter-choice {
	line-height:25px;
}
.sesfaq-autosuggest > li:hover {
	background:#eee;
	color:#555;
}
.sesfaq-autosuggest > li span.autocompleter-queried {
	font-weight:bold;
}
ul.sesfaq-autosuggest .search-working {
	background-image:none;
}
.autocompleter-choice {
	cursor:pointer;
}
.autocompleter-choice:hover {
	color:#5ba1cd;
}
</style>