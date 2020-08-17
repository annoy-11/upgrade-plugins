<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create-settings.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesqa/views/scripts/dismiss_message.tpl';?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<div class='clear'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script type="application/javascript">
  sesJqueryObject('input[name=qanda_allow_category]').on('change',function(){
      var value = sesJqueryObject('input[name=qanda_allow_category]:checked').val();
      if(value == 1){
        sesJqueryObject('#qanda_category_mandatory-wrapper').show();
      }else{
        sesJqueryObject('#qanda_category_mandatory-wrapper').hide();  
      }
  })
  sesJqueryObject('input[name=qanda_allow_category]:checked').trigger('change');
  
  sesJqueryObject('input[name=qanda_enable_poll]').on('change',function(){
      var value = sesJqueryObject('input[name=qanda_enable_poll]:checked').val();
      if(value == 1){
        sesJqueryObject('#qanda_polltype_questions-wrapper').show();
      }else{
        sesJqueryObject('#qanda_polltype_questions-wrapper').hide();  
      }
  })
  sesJqueryObject('input[name=qanda_enable_poll]:checked').trigger('change');
</script>