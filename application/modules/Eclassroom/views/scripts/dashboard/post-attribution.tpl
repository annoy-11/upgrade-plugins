<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: post-attribution.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'eclassroom', array(
	'classroom' => $this->classroom,
      ));	
?>
	<div class="classroom_dashboard_content sesbm sesbasic_clearfix">
<?php } 	
?>
<div class="classroom_dashboard_form">
  <div class="classroom_dashboard_post_attribution prelative">
    <?php echo $this->form->render() ?>
    <div class="sesbasic_loading_cont_overlay" style="display:none;"></div>
  </div>
</div>
<?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
<?php  } ?>

<script type="application/javascript">
var isRequestSend = false;
  sesJqueryObject('input[type=radio][name=attribution]').change(function() {
    var value = this.value;
    if(isRequestSend){
      return;  
    }
    sesJqueryObject('.sesbasic_loading_cont_overlay').show();
    isRequestSend = true;
    sesJqueryObject.post(sesJqueryObject('#classroom_attr_form').attr('href'),{value:value},function(response){
      isRequestSend = false;
        sesJqueryObject('.sesbasic_loading_cont_overlay').hide();
    });
    
  });
</script>

<?php if($this->is_ajax) die; ?>
