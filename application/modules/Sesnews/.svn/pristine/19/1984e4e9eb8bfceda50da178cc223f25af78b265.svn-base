<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesnews
 * @package    Sesnews
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2019-02-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
  <?php
    if (APPLICATION_ENV == 'production')
      $this->headScript()
        ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.min.js');
    else
      $this->headScript()
        ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Observer.js')
        ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.js')
        ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Local.js')
        ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Request.js');
  ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesnews/externals/styles/styles.css'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>
  
<?php if (($this->current_count >= $this->quota) && !empty($this->quota)):?>
  <div class="tip">
    <span>
      <?php echo $this->translate('You have already created the maximum number of entries allowed.');?>
      <?php echo $this->translate('If you would like to create a new rss, please <a href="%1$s">delete</a> an old one first.', $this->url(array('action' => 'manage'), 'sesnews_generalrss'));?>
    </span>
  </div>
  <br/>
<?php else:?>
  <?php echo $this->form->render($this);?>
<?php endif; ?>
<script type="text/javascript">
  $$('.core_main_sesnews').getParent().addClass('active');
</script>
<?php $required = false; ?>
<script type="text/javascript">
  
  function checkURLValid(urlsubmit) { 
    
    if(urlsubmit == '') 
      return;
    sesJqueryObject('#sesnews_custom_url_wrong').hide();
    sesJqueryObject('#sesnews_custom_url_correct').hide();
    sesJqueryObject('#custom_url_news-wrapper').show();
    sesJqueryObject('#sesnews_custom_url_loading').css('display','inline-block');
    var url = en4.core.baseUrl + 'sesnews/rss/checkurl/';
    new Request.JSON({
      format : 'json',
      url: url,
      data: {'urlsubmit':urlsubmit},
      onSuccess: function(responseJSON) {
        if(responseJSON.status == 'true') {
          sesJqueryObject('#sesnews_custom_url_loading').hide();
          sesJqueryObject('#sesnews_custom_url_wrong').hide();
          sesJqueryObject('#sesnews_custom_url_correct').css('display','inline-block');
          sesJqueryObject('#title').val(responseJSON.title);
          sesJqueryObject('#body').val(responseJSON.description);
          sesJqueryObject('#submit-wrapper').show();
        } else {
          sesJqueryObject('#sesnews_custom_url_loading').hide();
          sesJqueryObject('#sesnews_custom_url_wrong').css('display','inline-block')
          sesJqueryObject('#sesnews_custom_url_correct').hide();
          sesJqueryObject('#submit-wrapper').hide();
        }
      }
    }).send(); 
    
  }
  
  function showSubCategory(cat_id,selectedId) {
    var selected;
    if(selectedId != '')
    var selected = selectedId;
    var url = en4.core.baseUrl + 'sesnews/index/subcategory/category_id/' + cat_id;
    new Request.HTML({
      url: url,
      data: {'selected':selected},
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
    if(cat_id == 0){
      if ($('subsubcat_id-wrapper')) {
        $('subsubcat_id-wrapper').style.display = "none";
        $('subsubcat_id').innerHTML = '';				
      }
      return false;
    }

    var selected;
    if(selectedId != '')
    var selected = selectedId;
    var url = en4.core.baseUrl + 'sesnews/index/subsubcategory/subcategory_id/' + cat_id;
    (new Request.HTML({
      url: url,
      data: {'selected':selected},
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {

        if ($('subsubcat_id') && responseHTML) {
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "block";
          }
          $('subsubcat_id').innerHTML = responseHTML;
        } else {
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "none";
            $('subsubcat_id').innerHTML = '<option value="0"></option>';
          }
        }
      }
    })).send();  
  }
    
  function showStartDate(value) {
    if(value == '1')
    jqueryObjectOfSes('#event_start_time-wrapper').hide();
    else
    jqueryObjectOfSes('#event_start_time-wrapper').show();
  }
  
  en4.core.runonce.add(function() {
    
    sesJqueryObject('#custom_url_news-wrapper').hide();
    
    if(jqueryObjectOfSes('#show_start_time') && jqueryObjectOfSes('input[name="show_start_time"]:checked').val() == '1')
    sesJqueryObject('#event_start_time-wrapper').hide();
    
    jqueryObjectOfSes('#submit_check-wrapper').hide();
    
    var sesdevelopment = 1;
    <?php if(isset($this->category_id) && $this->category_id != 0){ ?>
        <?php if(isset($this->subcat_id)){$catId = $this->subcat_id;}else $catId = ''; ?>
        showSubCategory('<?php echo $this->category_id; ?>','<?php echo $catId; ?>','yes');
     <?php  }else{ ?>
      if($('subcat_id-wrapper'))
        $('subcat_id-wrapper').style.display = "none";
     <?php } ?>
   
     <?php if(isset($this->subsubcat_id)){ ?>
      if (<?php echo isset($this->subcat_id) && intval($this->subcat_id)>0 ? $this->subcat_id : 'sesdevelopment' ?> == 0) {
       $('subsubcat_id-wrapper').style.display = "none";
      } else {
        <?php if(isset($this->subsubcat_id)){$subsubcat_id = $this->subsubcat_id;}else $subsubcat_id = ''; ?>
        showSubSubCategory('<?php echo $this->subcat_id; ?>','<?php echo $this->subsubcat_id; ?>','yes');
      }
     <?php }else{ ?>
         $('subsubcat_id-wrapper').style.display = "none";
     <?php } ?>
  });
  
  //prevent form submit on enter
  jqueryObjectOfSes("#sesnews_create_rss").bind("keypress", function (e) {
    if (e.keyCode == 13 && jqueryObjectOfSes('#'+e.target.id).prop('tagName') != 'TEXTAREA') {
      e.preventDefault();
    }else{
      return true;	
    }
  });
  
  //Ajax error show before form submit
  var error = false;
  var objectError ;
  var counter = 0;
  function validateForm() {
    var errorPresent = false; 
    jqueryObjectOfSes('#sesnews_create_rss input, #sesnews_create_rss select,#sesnews_create_rss checkbox,#sesnews_create_rss textarea,#sesnews_create_rss radio').each(
      function(index){
	var input = jqueryObjectOfSes(this);
	if(jqueryObjectOfSes(this).closest('div').parent().css('display') != 'none' && jqueryObjectOfSes(this).closest('div').parent().find('.form-label').find('label').first().hasClass('required') && jqueryObjectOfSes(this).prop('type') != 'hidden' && jqueryObjectOfSes(this).closest('div').parent().attr('class') != 'form-elements'){	
	  if(jqueryObjectOfSes(this).prop('type') == 'checkbox'){
	    value = '';
	    if(jqueryObjectOfSes('input[name="'+jqueryObjectOfSes(this).attr('name')+'"]:checked').length > 0) { 
	      value = 1;
	    };
	    if(value == '')
	    error = true;
	    else
	    error = false;
	  }
	  else if(jqueryObjectOfSes(this).prop('type') == 'select-multiple'){
	    if(jqueryObjectOfSes(this).val() === '' || jqueryObjectOfSes(this).val() == null)
	    error = true;
	    else
	    error = false;
	  }
	  else if(jqueryObjectOfSes(this).prop('type') == 'select-one' || jqueryObjectOfSes(this).prop('type') == 'select' ){
	    if(jqueryObjectOfSes(this).val() === '')
	    error = true;
	    else
	    error = false;
	  }
	  else if(jqueryObjectOfSes(this).prop('type') == 'radio'){
	    if(jqueryObjectOfSes("input[name='"+jqueryObjectOfSes(this).attr('name').replace('[]','')+"']:checked").val() === '')
	    error = true;
	    else
	    error = false;
	  }
	  else if(jqueryObjectOfSes(this).prop('type') == 'textarea' && jqueryObjectOfSes(this).prop('id') == 'body'){
	   
	  }
	  else if(jqueryObjectOfSes(this).prop('type') == 'textarea') {
	    if(jqueryObjectOfSes(this).val() === '' || jqueryObjectOfSes(this).val() == null)
	    error = true;
	    else
	    error = false;
	  }
	  else{
	    if(jqueryObjectOfSes(this).val() === '' || jqueryObjectOfSes(this).val() == null)
	    error = true;
	    else
	    error = false;
	  }
	  if(error){
	    if(counter == 0){
	      objectError = this;
	    }
	    counter++
	  }
	  else{
			if(sesJqueryObject('#tabs_form_newscreate-wrapper').length && sesJqueryObject('.sesnews_upload_item_photo').length == 0){
				<?php if($required):?>
					objectError = sesJqueryObject('.sesnews_create_rss_form_tabs');
					error = true;
				<?php endif;?>
			}		
	  }
	  if(error)
			errorPresent = true;
			error = false;
		}
      }
    );
    return errorPresent ;
  }
  
en4.core.runonce.add(function() {
  jqueryObjectOfSes('#sesnews_create_rss').submit(function(e) {
    var validationFm = validateForm();
    if(!validationFm) {
			var lastTwoDigitStart = sesJqueryObject('#sesnews_schedule_time').val().slice('-2');
			var startDate = new Date(sesJqueryObject('#sesnews_schedule_date').val()+' '+sesJqueryObject('#sesnews_schedule_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
			var error = checkDateTime(startDate);
			if(error != ''){
				sesJqueryObject('#event_error_time-wrapper').show();
				sesJqueryObject('#sesnews_schedule_error_time-element').text(error);
			 var errorFirstObject = sesJqueryObject('#event_start_time-label').parent().parent();
			 sesJqueryObject('html, body').animate({
				scrollTop: errorFirstObject.offset().top
			 }, 2000);
				return false;
			}else{
				sesJqueryObject('#event_error_time-wrapper').hide();
			}	
			
		}
    if(validationFm) {
      alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
      if(typeof objectError != 'undefined'){
				var errorFirstObject = jqueryObjectOfSes(objectError).parent().parent();
				jqueryObjectOfSes('html, body').animate({
				scrollTop: errorFirstObject.offset().top
				}, 2000);
      }
      return false;	
    }else if(sesJqueryObject('.sesnews_upload_item_abort').length){
				alert('<?php echo $this->translate("Please wait till all photos uploaded."); ?>');
				var errorFirstObject = jqueryObjectOfSes('#uploadFileContainer-wrapper');
				jqueryObjectOfSes('html, body').animate({
					scrollTop: errorFirstObject.offset().top
				}, 2000);
				return false;
		}
//     else{
//       var avacheckAvailsbility = checkAvailsbility('true');
//       return false;
//     }
  });
});
</script>
