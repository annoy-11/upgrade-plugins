<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<?php include APPLICATION_PATH .  '/application/modules/Sescrowdfunding/views/scripts/dismiss_message.tpl';?>
<script type="text/javascript">
  var fetchLevelSettings =function(level_id){
    window.location.href= en4.core.baseUrl+'admin/sescrowdfunding/level/index/id/'+level_id;
  }
  
	sesJqueryObject(document).on('change','input[type=radio][name=auth_crodstyle]',function(){
    if (this.value == 1) {
      sesJqueryObject('#select_pagestyle-wrapper').show();
      sesJqueryObject('#page_style_type-wrapper').hide();
    }else{
      sesJqueryObject('#page_style_type-wrapper').show();
      sesJqueryObject('#select_pagestyle-wrapper').hide();
    }
  });
  
	sesJqueryObject(document).ready(function(){
		sesJqueryObject('input[type=radio][name=auth_crodstyle]:checked').trigger('change');
  });
</script>
<div class='settings sesbasic_admin_form'>
  <?php echo $this->form->render($this); ?>
</div>

