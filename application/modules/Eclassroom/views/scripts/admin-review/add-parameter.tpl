<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: add-parameter.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>
<style>
.global_form_popup #addmore-label{
	display:none;
}
.global_form_popup input{
	width:90% !important;
	margin-bottom:10px;
}
.global_form_popup a {
	font-weight: bold;
	margin: 5px 0;
	display: inline-block;
}
.global_form_popup a:before{
	margin-right:4px;
}
</style>
<div class='clear'>
  <div class='settings global_form_popup eclassroom_parameter_popup'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script type="application/javascript">
  var alreadyaddedParameter = sesJqueryObject('.eclassroom_added_parameter');
  if(alreadyaddedParameter.length > 0){
    for(var i=0;i<alreadyaddedParameter.length;i++){
      var id = sesJqueryObject(alreadyaddedParameter[i]).attr('id').replace('eclassroom_review_','');
      sesJqueryObject(alreadyaddedParameter[i]).parent().append('<a href="javascript:;" data-url="'+id+'" class="removeAlreadyAddedElem fa fa-trash">Remove</a>');
    }
  }
  sesJqueryObject(document).on('click','.removeAlreadyAddedElem',function(e){
    var id = sesJqueryObject(this).attr('data-url');
    var val = sesJqueryObject('#deletedIds').val();
    if(val)
    var oldVal = val+',';
    else
    var oldVal = '';
    sesJqueryObject('#deletedIds').val(oldVal+id);
    sesJqueryObject(this).parent().parent().remove();
  });
  sesJqueryObject(document).on('click','#addmoreelem',function(e){
    sesJqueryObject('<div><input type="text" name="parameters[]" value="" class="reviewparameter"><a href="javascript:;" class="removeAddedElem fa fa-trash">Remove</a></div>').insertBefore(this);
  });
  sesJqueryObject(document).on('click','.removeAddedElem',function(e){
    sesJqueryObject(this).parent().remove();
  });
</script>
