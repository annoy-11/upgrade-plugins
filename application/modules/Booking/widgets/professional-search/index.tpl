<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Booking
 * @package    Booking
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-19 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Booking/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
<?php $randonNumber = 1; ?>
<div class="sesapmt_search_form sesbasic_bxs<?php echo $this->view_type=='horizontal' ? 'sespage_browse_search_horizontal' : 'sespage_browse_search_vertical'; ?>">
	<?php echo $this->form->render($this);?>
</div>
<style type="text/css">
    #professional_start_date{
        display: block !important;
    }
</style>
<script>
en4.core.runonce.add(function() {
mapLoad = false;
  initializeSesBookingMapList();
});
</script>
<script type="text/javascript">
en4.core.runonce.add(function() {
    var sesstartCalanderDate = new Date('<?php echo date("m/d/Y");  ?>');
    sesJqueryObject('#professional_start_date').datepicker({
        format: 'm/d/yyyy',
        weekStart: 1,
        autoclose: true,
        startDate: sesstartCalanderDate,
        todayHighlight:true,
        todayBtn:true
	})
});
  function showSubCategory(cat_id,selectedId) {
    var selected;
    if(selectedId != ''){
            var selected = selectedId;
    }
    var url = en4.core.baseUrl + 'booking/ajax/subcategory/category_id/' + cat_id;
    new Request.HTML({
      url: url,
      data: {
        'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if (formObj.find('#subcat_id-wrapper').length && responseHTML) {
          formObj.find('#subcat_id-wrapper').show();
          formObj.find('#subcat_id-wrapper').find('#subcat_id-element').find('#subcat_id').html(responseHTML);
        } else {
          if (formObj.find('#subcat_id-wrapper').length) {
            formObj.find('#subcat_id-wrapper').hide();
            formObj.find('#subcat_id-wrapper').find('#subcat_id-element').find('#subcat_id').html( '<option value="0"></option>');
          }
        }
        if(selectedId == ''){
            if (formObj.find('#subsubcat_id-wrapper').length) {
              formObj.find('#subsubcat_id-wrapper').hide();
              formObj.find('#subsubcat_id-wrapper').find('#subsubcat_id-element').find('#subsubcat_id').html( '<option value="0"></option>');
          }
        }
      }
    }).send(); 
  }
function showSubSubCategory(cat_id,selectedId,isLoad) {
        if(cat_id == 0){
            if (formObj.find('#subsubcat_id-wrapper').length) {
        formObj.find('#subsubcat_id-wrapper').hide();
        formObj.find('#subsubcat_id-wrapper').find('#subsubcat_id-element').find('#subsubcat_id').html( '<option value="0"></option>');
        }
            return false;
        }
        var selected;
        if(selectedId != ''){
                var selected = selectedId;
        }
        var url = en4.core.baseUrl + 'booking/ajax/subsubcategory/subcategory_id/' + cat_id;
        (new Request.HTML({
          url: url,
          data: {
            'selected':selected
          },
          onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
            if (formObj.find('#subsubcat_id-wrapper').length && responseHTML) {
              formObj.find('#subsubcat_id-wrapper').show();
              formObj.find('#subsubcat_id-wrapper').find('#subsubcat_id-element').find('#subsubcat_id').html(responseHTML);

            } else {
              if (formObj.find('#subsubcat_id-wrapper').length) {
                formObj.find('#subsubcat_id-wrapper').hide();
                formObj.find('#subsubcat_id-wrapper').find('#subsubcat_id-element').find('#subsubcat_id').html( '<option value="0"></option>');
              }
            }				
        }
    })).send();  
  }
   en4.core.runonce.add(function(){
    formObj = sesJqueryObject('#booking_form_professionalsearch').find('div').find('div').find('div');
    var sesdevelopment = 1;
    <?php if(isset($this->category_id) && $this->category_id != 0){ ?>
                    <?php if(isset($this->subcat_id)){$catId = $this->subcat_id;}else $catId = ''; ?>
                    showSubCategory('<?php echo $this->category_id; ?>','<?php echo $catId; ?>','yes');
     <?php  }else{ ?>
            formObj.find('#subcat_id-wrapper').hide();
     <?php } ?>
     <?php if(isset($this->subsubcat_id) && $this->subsubcat_id != 0){ ?>
            if (<?php echo isset($this->subcat_id) && intval($this->subcat_id) > 0 ? $this->subcat_id : 'sesdevelopment' ?> == 0) {
             formObj.find('#subsubcat_id-wrapper').hide();
            } else {
                    <?php if(isset($this->subsubcat_id)){$subsubcat_id = $this->subsubcat_id;}else $subsubcat_id = ''; ?>
                    showSubSubCategory('<?php echo $this->subcat_id; ?>','<?php echo $this->subsubcat_id; ?>','yes');
            }
     <?php }else{ ?>
                     formObj.find('#subsubcat_id-wrapper').hide();
     <?php } ?>
  });
  
</script>

