<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _poll.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div id="addpolloptions-wrapper" class="form-wrapper">
  <div class="form-label" id="addpolloptions-label">&nbsp;</div>
  <div id="addpolloptions-element" class="form-element">
    <button type="button" class="addpolloptions">Add Poll</button>
  </div>
</div>
<div class="sesqa_poll_main_container" style="display:none;">
<?php if( Engine_Api::_()->getApi('settings', 'core')->getSetting('qanda.polltype.questions',1) ){ ?>
  <div id="multi-wrapper" class="form-wrapper">
    <div class="form-label" id="multi-label">&nbsp;</div>
    <div id="multi-element" class="form-element">
      <input type="hidden" name="multi" value="">
      <input type="checkbox" name="multi" id="multi" value="1">
      <label for="multi" class="optional"><?php echo $this->translate('Allow members to select multiple options'); ?></label>
    </div>
  </div>
<?php }else{ ?> 
  <div style="display:none;"></div>
<?php } ?>
  <div id="answer0-wrapper" class="form-wrapper">
    <div id="answer0-label" class="form-label">
      <label for="answer0" class="optional"><?php echo $this->translate("Option 1"); ?></label>
    </div>
     <div class="imgs"> <a class="question_move_down" href="javascript:;"><i class="fa fa-caret-down"></i></a> <a class="question_move_up disable" href="javascript:;"><i class="fa fa-caret-up"></i></a> <a class="question_remove disable" href="javascript:;"><i class="fa fa-times"></i></a> </div>
    <div id="answer0-element" class="answer-box form-element">
      <input type="text" name="optionsArray[]" id="answer0" value="">
    </div>
  </div>
  <div id="answer1-wrapper" class="form-wrapper">
    <div id="answer1-label" class="form-label">
      <label for="answer1" class="optional">Option 2</label>
    </div>
   <div class="imgs"> <a class="question_move_down disable" href="javascript:;"><i class="fa fa-caret-down"></i></a> <a class="question_move_up" href="javascript:;"><i class="fa fa-caret-up"></i></a> <a class="question_remove disable"  href="javascript:;"><i class="fa fa-times"></i></a> </div>
    <div id="answer1-element" class="answer-box form-element">
      <input type="text" name="optionsArray[]" id="answer1" value="">
    </div>
  </div>
  <div id="addAnswer-wrapper" class="form-wrapper">
    <div id="addAnswer-label" class="form-label">&nbsp;</div>
    <div id="addAnswer-element" class="form-element">
      <button name="addAnswer" id="addAnswer" type="button"><?php echo $this->translate("Add Options"); ?></button>
    </div>
  </div>
</div>
<script type="application/javascript">
  var maxOptions = <?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.maxoptions', 15); ?>;
  sesJqueryObject(document).on('click','.question_move_down',function(){
     if(sesJqueryObject(this).hasClass('disable'))
      return;
     var totalElements = sesJqueryObject('.sesqa_poll_main_container').find('.form-wrapper');
     var index = sesJqueryObject(this).closest('.form-wrapper').index();
          
     var currentIndex = parseInt(sesJqueryObject(this).closest('.form-wrapper').attr('id').replace ( /[^\d.]/g, '' ));
     var nextIndex = parseInt(sesJqueryObject(totalElements[index+1]).attr('id').replace ( /[^\d.]/g, '' ));;
     var currentIndexValue = sesJqueryObject('#answer'+currentIndex).val();
     var nextIndexValue = sesJqueryObject('#answer'+nextIndex).val();
     sesJqueryObject('#answer'+currentIndex).val(nextIndexValue);
     sesJqueryObject('#answer'+nextIndex).val(currentIndexValue);
  })
   sesJqueryObject(document).on('click','.question_move_up',function(){
      if(sesJqueryObject(this).hasClass('disable'))
        return;
     var totalElements = sesJqueryObject('.sesqa_poll_main_container').find('.form-wrapper');
     var index = sesJqueryObject(this).closest('.form-wrapper').index();
          
     var currentIndex = parseInt(sesJqueryObject(this).closest('.form-wrapper').attr('id').replace ( /[^\d.]/g, '' ));
     var nextIndex = parseInt(sesJqueryObject(totalElements[index-1]).attr('id').replace ( /[^\d.]/g, '' ));;
     var currentIndexValue = sesJqueryObject('#answer'+currentIndex).val();
     var nextIndexValue = sesJqueryObject('#answer'+nextIndex).val();
     sesJqueryObject('#answer'+currentIndex).val(nextIndexValue);
     sesJqueryObject('#answer'+nextIndex).val(currentIndexValue);
  })
   sesJqueryObject(document).on('click','.question_remove',function(){
      if(sesJqueryObject(this).hasClass('disable'))
        return;
      sesJqueryObject(this).closest('.form-wrapper').remove();
      updatePollData();
  })
  function updatePollData(){
     var elem = sesJqueryObject('.sesqa_poll_main_container').find('.form-wrapper:not(#addAnswer-wrapper, #multi-wrapper)');
     sesJqueryObject('.question_move_down').removeClass('disable');
     sesJqueryObject('.question_move_up').removeClass('disable');
     sesJqueryObject('.question_remove').removeClass('disable');
     sesJqueryObject(elem[0]).find('.imgs').find('.question_move_up').addClass('disable');
     if(elem.length <=2){
      sesJqueryObject(elem[0]).find('.imgs').find('.question_remove').addClass('disable');
      sesJqueryObject(elem[1]).find('.imgs').find('.question_remove').addClass('disable');
     }
     sesJqueryObject(elem[elem.length-1]).find('.imgs').find('.question_move_down').addClass('disable');
     var stringName = "<?php echo $this->translate('SESOption'); ?>";
     for(i=0;i<elem.length;i++){
        sesJqueryObject(elem[i]).find('.form-label').find('label').html(stringName+" "+(i+1));
     }
  }
  var countersesqa = 0;
  sesJqueryObject(document).on('click','#addAnswer',function(){
     var totalOptions = sesJqueryObject('.sesqa_poll_main_container').children().length - 2;
     if(totalOptions == maxOptions){       
        sesJqueryObject('#addAnswer-wrapper').hide(); 
        return; 
     }
     var parentDiv = sesJqueryObject(this).closest('#addAnswer-wrapper').prev("div");
     countersesqa =  parseInt(sesJqueryObject(parentDiv).attr('id').replace ( /[^\d.]/g, '' )) + 1;
     var html = '<div id="answer'+countersesqa+'-wrapper" class="form-wrapper"><div id="answer'+countersesqa+'-label" class="form-label"><label for="answer'+countersesqa+'" class="optional"><?php echo $this->translate("SESOption"); ?> '+(countersesqa + 1)+'</label></div><div class="imgs">  <a class="question_move_down disable" href="javascript:;"><i class="fa fa-caret-down"></i></a> <a class="question_move_up" href="javascript:;"><i class="fa fa-caret-up"></i></a> <a class="question_remove disable"  href="javascript:;"><i class="fa fa-times"></i></a> </div><div id="answer'+countersesqa+'-element" class="form-element"><input type="text" name="optionsArray[]" id="answer'+countersesqa+'" value=""></div></div>';
    sesJqueryObject( sesJqueryObject(this).closest('#addAnswer-wrapper') ).before( html );
    updatePollData();
  });
  sesJqueryObject(document).ready(function(){
     var totalOptions = sesJqueryObject('.sesqa_poll_main_container').children().length - 2;
     if(totalOptions == maxOptions){       
        sesJqueryObject('#addAnswer-wrapper').hide(); 
        return; 
     }  
  })
  sesJqueryObject(document).on('click','.addpolloptions',function(){
    if(sesJqueryObject(this).hasClass('active')){
      sesJqueryObject(this).removeClass('active');
      sesJqueryObject('.sesqa_poll_main_container').hide(); 
      sesJqueryObject('#is_poll').val(0); 
    }else{
      sesJqueryObject(this).addClass('active');
      sesJqueryObject('#is_poll').val(1); 
      sesJqueryObject('.sesqa_poll_main_container').show();   
    }
  });
</script>