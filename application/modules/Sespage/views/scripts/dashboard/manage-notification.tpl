<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-notification.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sespage', array(
	'page' => $this->page,
      ));	
?>
	<div class="sespage_dashboard_content sesbm sesbasic_clearfix">
<?php }	?>
  <div class="sespage_dashboard_form">
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