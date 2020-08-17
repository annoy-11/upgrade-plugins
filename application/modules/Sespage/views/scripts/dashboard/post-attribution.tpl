<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: post-attribution.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sespage', array(
	'page' => $this->page,
      ));	
?>
	<div class="sespage_dashboard_content sesbm sesbasic_clearfix">
<?php } 	
?>
<div class="sespage_dashboard_form">
  <div class="sespage_dashboard_post_attribution prelative">
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
    sesJqueryObject.post(sesJqueryObject('#sespage_attr_form').attr('href'),{value:value},function(response){
      isRequestSend = false;
        sesJqueryObject('.sesbasic_loading_cont_overlay').hide();
    });
    
  });
</script>

<?php if($this->is_ajax) die; ?>