<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: contact.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'estore', array('store' => $this->store));	
?>
  <div class="estore_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
  <div class="estore_dashboard_form estore_db_overview_form"><?php echo $this->form->render() ?></div>
<?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>

<script type="application/javascript">
sesJqueryObject('#type').on('change',function(){
  var value =sesJqueryObject(this).val(); 
  if(value == 2){
      sesJqueryObject('#store_roles-wrapper').show();
  }else{
    sesJqueryObject('#store_roles-wrapper').hide();  
  }
});
sesJqueryObject('#type').trigger('change');
</script>
