<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: show-question-form.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroup/externals/styles/styles.css'); ?>
<div class="sesgroup_add_question_popup sesbasic_bxs">
	<?php echo $this->form->render();?>
</div>

<script type='text/javascript'>
  en4.core.runonce.add(function(){
    var j = 0;
    for(var i=1;i<=5;i++) {
      if(parent.sesJqueryObject('#questitle'+i).val() != '') {
        sesJqueryObject('#quesfield'+i).val(parent.sesJqueryObject('#questitle'+i).val());
        j++;
      }
      else {
        sesJqueryObject('#quesfield'+i+'-wrapper').hide();
        sesJqueryObject('#removequesfield'+i+'-wrapper').hide();
      }
    }
    if(j == 5)
      sesJqueryObject('#createquestion-wrapper').hide();
  });
  function showMoreQuestion() {
    for(var i=1;i<=5;i++) {
      if(sesJqueryObject('#quesfield'+i+'-wrapper').css('display') == 'none') {
        sesJqueryObject('#quesfield'+i+'-wrapper').show();
        sesJqueryObject('#removequesfield'+i+'-wrapper').show();
        if(i == 5)
          sesJqueryObject('#createquestion-wrapper').hide();
        break;
      }
    }
  }
  function saveFormQuestions() {
    var canSubmit = 0;
    for(var i=1;i<=5;i++) {
      if(sesJqueryObject('#quesfield'+i).val() != '') {
        canSubmit = 1;
        if(sesJqueryObject('#quesfield'+i).val()){
          var value = sesJqueryObject('#quesfield'+i).val();  
        }else{
          var value = "";  
        }
        parent.sesJqueryObject('#questitle'+i).val(value);
      }else{
        parent.sesJqueryObject('#questitle'+i).val('');
      }
    }
    if(canSubmit == 0) {
      alert('Please Select atlease one question.');
      return;
    }
    else {
      parent.Smoothbox.close();
    }
  }
  function removeQuestion(id) {
    parent.sesJqueryObject('#questitle'+id).attr('value', '');  
    sesJqueryObject('#quesfield'+id).val('');
    sesJqueryObject('#quesfield'+id+'-wrapper').hide();
    sesJqueryObject('#removequesfield'+id+'-wrapper').hide();
    sesJqueryObject('#createquestion-wrapper').show();
  }
</script>