<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescommunityads
 * @package    Sescommunityads
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescommunityads/externals/styles/styles.css'); ?>
<div class="sescmads_report_form">
  <?php echo $this->form->render($this); ?>
</div>

<script type="application/javascript">
sesJqueryObject('#start-hour').hide();
sesJqueryObject('#start-minute').hide();
sesJqueryObject('#start-ampm').hide();
sesJqueryObject('#end-hour').hide();
sesJqueryObject('#end-minute').hide();
sesJqueryObject('#end-ampm').hide();
sesJqueryObject('#start_group').show();
sesJqueryObject('#end_group').show();
function changeType(value){
  if(value == "month"){
    sesJqueryObject('#start_group').show();
    sesJqueryObject('#end_group').show();
    sesJqueryObject('#cal_grp').hide();
  }else{
    sesJqueryObject('#cal_grp').show();
    sesJqueryObject('#start_group').hide();
    sesJqueryObject('#end_group').hide();
  }
}

function formate(value){
  if(value == "campaign"){
    sesJqueryObject('#ads-wrapper').hide();
    sesJqueryObject('#campaign-wrapper').show();
  }else{
    sesJqueryObject('#ads-wrapper').show();
    sesJqueryObject('#campaign-wrapper').hide();
  }
}
sesJqueryObject(document).ready(function(){
  changeType(sesJqueryObject('#type').val());
  formate(sesJqueryObject('#format_type').val());
  
  sesJqueryObject('#start-hour').val('1');
  sesJqueryObject('#start-minute').val('0');
  sesJqueryObject('#start-ampm').val('AM');
  sesJqueryObject('#end-hour').val('1');
  sesJqueryObject('#end-minute').val('0');
  sesJqueryObject('#end-ampm').val('AM');
})
</script>