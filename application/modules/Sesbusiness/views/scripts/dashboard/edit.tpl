<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<style>.tag img{float:left;height:25px;width:25px;}</style>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Observer.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.Local.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.Request.js'); ?>
<?php if(!$this->is_ajax){ ?>
<?php echo $this->partial('dashboard/left-bar.tpl', 'sesbusiness', array('business' => $this->business));?>
	<div class="sesbusiness_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
    <div class="sesbusiness_dashboard_form <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.create.form', 1)):?>sesbusiness_create_form<?php endif;?>">
      <?php echo $this->form->render() ?>
    </div>
		<?php if(!$this->is_ajax){ ?>
	</div>
</div>
</div>
<?php  } ?>
<script type="text/javascript">
  
  sesJqueryObject(document).on('change','input[type=radio][name=can_join]',function(){
    if (this.value == 1) {
      sesJqueryObject('#approval-wrapper').show();
      sesJqueryObject('#member_title_singular-wrapper').show();
      sesJqueryObject('#member_title_plural-wrapper').show();
    }
    else {
      sesJqueryObject('#approval-wrapper').hide();
      sesJqueryObject('#member_title_singular-wrapper').hide();
      sesJqueryObject('#member_title_plural-wrapper').hide();
    }
  });
  
  if(document.getElementById('business_password-wrapper') && sesJqueryObject('#enable_lock').val() == 0){
    document.getElementById('business_password-wrapper').style.display = 'none';	
    sesJqueryObject('#business_password').val('');
  }
  else if(document.getElementById('business_password-wrapper')){
    document.getElementById('business_password-wrapper').style.display = 'block';	
    sesJqueryObject('#business_password').val('<?php echo $this->business->business_password; ?>');
  }
  //trim last -
  function removeLastMinus (myUrl){
    if (myUrl.substring(myUrl.length-1) == "-"){
      myUrl = myUrl.substring(0, myUrl.length-1);
    }
    return myUrl;
  }
  //function ckeck url availability
  sesJqueryObject("#custom_url").blur(function(){
    validUrl = false;
    sesJqueryObject('#check_custom_url_availability').trigger('click');
  });
  jqueryObjectOfSes('#check_custom_url_availability').click(function(){
    var custom_url_value = jqueryObjectOfSes('#custom_url').val();
    sesJqueryObject(this).find('#sesbusiness_custom_url_loading').css('display','inline-block');
    if(!custom_url_value)return;
    var obj = this;
    jqueryObjectOfSes.post('<?php echo $this->url(array('controller' => 'ajax','module'=>'sesbusiness', 'action' => 'custom-url-check'), 'default', true) ?>',{value:custom_url_value,business_id:<?php echo $this->business->business_id ?>},function(response){
      sesJqueryObject('#sesbusiness_custom_url_loading').hide();
      response = jqueryObjectOfSes.parseJSON(response);
      if(response.error){
         jqueryObjectOfSes('#custom_url').css('border-color','red');
         sesJqueryObject(obj).find('#sesbusiness_custom_url_correct').hide();
         jqueryObjectOfSes(obj).find('#sesbusiness_custom_url_wrong').css('display','inline-block');
      }else{
         jqueryObjectOfSes('#custom_url').css('border-color','green');
         jqueryObjectOfSes(obj).find('#sesbusiness_custom_url_wrong').hide();
         jqueryObjectOfSes(obj).find('#sesbusiness_custom_url_correct').css('display','inline-block');
      }
   });
  });
  //tags
  en4.core.runonce.add(function(){
    new Autocompleter.Request.JSON('tags', '<?php echo $this->url(array('controller' => 'tag', 'action' => 'suggest'), 'default', true) ?>', {
      'postVar' : 'text',
      'minLength': 1,
      'selectMode': 'pick',
      'autocompleteType': 'tag',
      'className': 'tag-autosuggest',
      'filterSubset' : true,
      'multiple' : true,
      'injectChoice': function(token){
        var choice = new Element('li', {'class': 'autocompleter-choices', 'value':token.label, 'id':token.id});
        new Element('div', {'html': this.markQueryValue(token.label),'class': 'autocompleter-choice'}).inject(choice);
        choice.inputValue = token;
        this.addChoiceBusinesses(choice).inject(this.choices);
        choice.store('autocompleteChoice', token);
      }
    });
  });
  jqueryObjectOfSes(document).ready(function(){
    jqueryObjectOfSes('#subcat_id-wrapper').css('display' , 'none');
    jqueryObjectOfSes('#subsubcat_id-wrapper').css('display' , 'none');
      //map
    mapLoad_business = false;
    if(jqueryObjectOfSes('#lat-wrapper').length > 0){
      jqueryObjectOfSes('#lat-wrapper').css('display' , 'none');
      jqueryObjectOfSes('#lng-wrapper').css('display' , 'none');
      initializeSesBusinessMapList();
    }
  });
</script>
<script type="text/javascript">
  function showSubCategory(cat_id,selectedId,isLoad) {
    var selected;
    if(selectedId != ''){
      var selected = selectedId;
    }
    var url = en4.core.baseUrl + 'sesbusiness/ajax/subcategory/category_id/' + cat_id;
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
    if(cat_id == 0){
      if ($('subsubcat_id-wrapper')) {
        $('subsubcat_id-wrapper').style.display = "none";
        $('subsubcat_id').innerHTML = '';				
      }
      return false;
    }
    var selected;
    if(selectedId != ''){
      var selected = selectedId;
    }
    var url = en4.core.baseUrl + 'sesbusiness/ajax/subsubcategory/subcategory_id/' + cat_id;
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
	<?php if(isset($this->category_id) && $this->category_id != 0){ ?>
      <?php if(isset($this->subcat_id)){$catId = $this->subcat_id;}else $catId = ''; ?>
      showSubCategory('<?php echo $this->category_id; ?>','<?php echo $catId; ?>','yes');
    <?php  }else{ ?>
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
    var valueStyle = sesJqueryObject('input[name=enable_lock]:checked').val();
    if(valueStyle == 1) 
    sesJqueryObject('#business_password-wrapper').show();
    else 
    sesJqueryObject('#business_password-wrapper').hide();
    var valueStyle = sesJqueryObject('input[name=can_join]:checked').val();
    if(valueStyle == 1) {
      sesJqueryObject('#approval-wrapper').show();
      sesJqueryObject('#member_title_singular-wrapper').show();
      sesJqueryObject('#member_title_plural-wrapper').show();
    }
    else { 
      sesJqueryObject('#approval-wrapper').hide();
      sesJqueryObject('#member_title_singular-wrapper').hide();
      sesJqueryObject('#member_title_plural-wrapper').hide();
    }
  });
  //validate form
  //Ajax error show before form submit
  var error = false;
  var objectError ;
  var counter = 0;
  function validateForm(){
    var errorPresent = false;
    sesJqueryObject('#sesbusiness_create_form input, #sesbusiness_create_form select,#sesbusiness_create_form checkbox,#sesbusiness_create_form textarea,#sesbusiness_create_form radio').each(
	function(index){
      var input = sesJqueryObject(this);
      if(sesJqueryObject(this).closest('div').parent().css('display') != 'none' && sesJqueryObject(this).closest('div').parent().find('.form-label').find('label').first().hasClass('required') && sesJqueryObject(this).prop('type') != 'hidden' && sesJqueryObject(this).closest('div').parent().attr('class') != 'form-elements'){	
        if(sesJqueryObject(this).prop('type') == 'checkbox'){
          value = '';
          if(sesJqueryObject('input[name="'+sesJqueryObject(this).attr('name')+'"]:checked').length > 0) { 
            value = 1;
          };
          if(value == '')
          error = true;
          else
          error = false;
        }else if(sesJqueryObject(this).prop('type') == 'select-multiple'){
          if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
          error = true;
          else
          error = false;
        }else if(sesJqueryObject(this).prop('type') == 'select-one' || sesJqueryObject(this).prop('type') == 'select' ){
          if(sesJqueryObject(this).val() === '')
          error = true;
          else
          error = false;
        }else if(sesJqueryObject(this).prop('type') == 'radio'){
          if(sesJqueryObject("input[name='"+sesJqueryObject(this).attr('name').replace('[]','')+"']:checked").val() === '')
          error = true;
          else
          error = false;
        }else if(sesJqueryObject(this).prop('type') == 'textarea'){
          if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
          error = true;
          else
          error = false;
        }else{
          if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
          error = true;
          else
          error = false;
        }
        if(error){
         if(counter == 0){
          objectError = this;
         }
         counter++
        }else{}
        if(error)
        errorPresent = true;
        error = false;
      }
	});	
    return errorPresent ;
  }
  sesJqueryObject('#sesbusiness_create_form').submit(function(e){
    var validationFm = validateForm();
    if(validationFm){
      alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
      if(typeof objectError != 'undefined'){
       var errorFirstObject = sesJqueryObject(objectError).parent().parent();
       sesJqueryObject('html, body').animate({
          scrollTop: errorFirstObject.offset().top
       }, 2000);
      }
	  return false;	
    }else{
      sesJqueryObject('#submit').attr('disabled',true);
      sesJqueryObject('#submit').html('<?php echo $this->translate("Saving Form ...") ; ?>');
      return true;
    }			
  });
</script>
