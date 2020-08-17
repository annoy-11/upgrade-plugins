<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add-parameter.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>
<div class='clear'>
  <div class='settings global_form_popup sesbusinessreview_parameter_popup'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script type="application/javascript">
  var alreadyaddedParameter = sesJqueryObject('.sesbusinessreview_added_parameter');
  if(alreadyaddedParameter.length > 0){
    for(var i=0;i<alreadyaddedParameter.length;i++){
      var id = sesJqueryObject(alreadyaddedParameter[i]).attr('id').replace('sesbusinessreview_review_','');
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