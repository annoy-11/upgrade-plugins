<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manage-notification.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'eclassroom', array(
	'classroom' => $this->classroom,
      ));	
?>
	<div class="classroom_dashboard_content sesbm sesbasic_clearfix">
<?php }	?>
  <div class="classroom_dashboard_form">
      <?php echo $this->form->render() ?>
  </div>
<?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>

<script type="application/javascript">
  sesJqueryObject('input[type=radio][name=notification_type]').change(function(){
      var value = this.value;
      if(value == "turn_off"){
        sesJqueryObject('#notifications-wrapper').hide();  
      }else{
        sesJqueryObject('#notifications-wrapper').show();  
      }
  });
 sesJqueryObject('input[type=radio][name=notification_type]:checked').trigger('change');
</script>
